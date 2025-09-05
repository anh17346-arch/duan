<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show checkout page for cart items
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $cartItems = [];
        $total = 0;

        if ($user) {
            // Get cart items for authenticated user
            $cartItems = $user->cart()->with('product')->get();
            $total = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->final_price;
            });
        } else {
            // Handle guest checkout if needed
            return redirect()->route('login')->with('message', 'Vui lòng đăng nhập để thanh toán');
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
        }

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Show buy now page for GET requests
     */
    public function showBuyNow(Request $request, Product $product)
    {
        // Get quantity from URL parameter or default to 1
        $quantity = max(1, min((int) $request->get('quantity', 1), $product->stock));
        
        // Use PromotionService to get correct price
        $promotionService = new \App\Services\PromotionService();
        $finalPrice = $promotionService->getFinalPrice($product);
        $total = $quantity * $finalPrice;

        // Create a temporary cart item for buy now
        $cartItem = (object) [
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $total
        ];

        return view('checkout.buy-now', compact('cartItem', 'total', 'product', 'promotionService'));
    }

    /**
     * Show checkout page for direct product purchase (POST from form)
     */
    public function buyNow(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ]);

        $quantity = $request->input('quantity', 1);
        
        // Use PromotionService to get correct price
        $promotionService = new \App\Services\PromotionService();
        $finalPrice = $promotionService->getFinalPrice($product);
        $total = $quantity * $finalPrice;

        // Create a temporary cart item for buy now
        $cartItem = (object) [
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $total
        ];

        return view('checkout.buy-now', compact('cartItem', 'total', 'product', 'promotionService'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:momo,zalopay,bank_transfer,cod',
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_district' => 'required|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        // Store checkout data in session for potential back navigation
        session()->put('checkout_data', [
            'payment_method' => $request->payment_method,
            'shipping_name' => $request->shipping_name,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_district' => $request->shipping_district,
            'notes' => $request->notes,
            'buy_now_product_id' => $request->buy_now_product_id,
            'buy_now_quantity' => $request->buy_now_quantity,
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $orderNumber = 'ORD-' . strtoupper(Str::random(8));
            $orderCode = 'DH' . date('Ymd') . '-' . str_pad(Order::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'customer_name' => $request->shipping_name,
                'customer_phone' => $request->shipping_phone,
                'customer_email' => $user->email,
                'order_number' => $orderNumber,
                'order_code' => $orderCode,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_district' => $request->shipping_district,
                'notes' => $request->notes,
                'subtotal' => 0,
                'discount_amount' => 0,
                'shipping_fee' => 30000, // 30k shipping fee
                'total' => 0,
            ]);

            $subtotal = 0;

            // Handle buy now or cart checkout
            if ($request->has('buy_now_product_id')) {
                // Buy now checkout
                $product = Product::findOrFail($request->buy_now_product_id);
                $quantity = $request->input('buy_now_quantity', 1);
                
                // Use PromotionService to get correct price
                $promotionService = new \App\Services\PromotionService();
                $finalPrice = $promotionService->getFinalPrice($product);
                
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $finalPrice,
                    'total' => $quantity * $finalPrice,
                ]);

                $subtotal = $quantity * $finalPrice;

                // Update product stock
                $product->decrement('stock', $quantity);
                $product->incrementSoldCount($quantity);
                
                // Update promotion sold_quantity if product is on sale
                if ($promotionService->isProductOnSale($product)) {
                    $promotionService->incrementSoldQuantity($product, $quantity);
                }
            } else {
                // Cart checkout
                $cartItems = $user->cart()->with('product')->get();
                $promotionService = new \App\Services\PromotionService();
                
                foreach ($cartItems as $cartItem) {
                    // Use PromotionService to get correct price
                    $finalPrice = $promotionService->getFinalPrice($cartItem->product);
                    
                    $order->items()->create([
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $finalPrice,
                        'total' => $cartItem->quantity * $finalPrice,
                    ]);

                    $subtotal += $cartItem->quantity * $finalPrice;

                    // Update product stock
                    $cartItem->product->decrement('stock', $cartItem->quantity);
                    $cartItem->product->incrementSoldCount($cartItem->quantity);
                    
                    // Update promotion sold_quantity if product is on sale
                    if ($promotionService->isProductOnSale($cartItem->product)) {
                        $promotionService->incrementSoldQuantity($cartItem->product, $cartItem->quantity);
                    }
                }

                // Clear cart
                $user->cart()->delete();
            }

            // Update order totals
            $order->update([
                'subtotal' => $subtotal,
                'total' => $subtotal + $order->shipping_fee,
            ]);

            DB::commit();

            // Create notification for new order
            $notificationService = new \App\Services\NotificationService();
            $notificationService->createOrderNotification($order, 'new');

            // Redirect to payment gateway or success page based on payment method
            return $this->handlePayment($order, $request->payment_method);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Có lỗi xảy ra trong quá trình xử lý đơn hàng: ' . $e->getMessage());
        }
    }

    /**
     * Handle different payment methods
     */
    private function handlePayment(Order $order, $paymentMethod)
    {
        switch ($paymentMethod) {
            case 'momo':
            case 'zalopay':
            case 'bank_transfer':
                // Redirect to payment page for online payment methods
                return redirect()->route('payment.process', $order->id)
                    ->with('payment_method', $paymentMethod);
            case 'cod':
                return $this->processCOD($order);
            default:
                return redirect()->route('checkout.success', $order);
        }
    }

    /**
     * Process COD
     */
    private function processCOD(Order $order)
    {
        $order->update(['status' => 'processing', 'payment_method' => 'cod']);
        
        // Clear checkout data from session after successful order
        session()->forget('checkout_data');
        
        return redirect()->route('checkout.success', $order)
            ->with('success', 'Đơn hàng đã được tạo thành công! Bạn sẽ thanh toán khi nhận hàng.');
    }

    /**
     * Show success page
     */
    public function success(Order $order)
    {
        // Make sure user can only see their own orders
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        $order->load(['items.product']);
        
        return view('checkout.success', compact('order'));
    }

    /**
     * Go back to checkout with saved data
     */
    public function backToCheckout(Request $request)
    {
        $checkoutData = session()->get('checkout_data');
        
        $user = Auth::user();
        $cartItems = [];
        $total = 0;

        if ($user) {
            // Get cart items for authenticated user
            $cartItems = $user->cart()->with('product')->get();
            $total = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->final_price;
            });
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
        }

        return view('checkout.index', compact('cartItems', 'total', 'checkoutData'));
    }

    /**
     * Go back to buy now checkout with saved data
     */
    public function backToBuyNowCheckout(Request $request)
    {
        $checkoutData = session()->get('checkout_data');
        
        // If no checkout data or no buy_now_product_id, redirect to cart
        if (!$checkoutData || !isset($checkoutData['buy_now_product_id'])) {
            return redirect()->route('cart.index')->with('error', 'Không tìm thấy thông tin đặt hàng');
        }

        $product = Product::findOrFail($checkoutData['buy_now_product_id']);
        $quantity = $checkoutData['buy_now_quantity'] ?? 1;
        $total = $quantity * $product->final_price;

        // Create a temporary cart item for buy now
        $cartItem = (object) [
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $total
        ];

        // Use PromotionService to get correct price
        $promotionService = new \App\Services\PromotionService();
        $finalPrice = $promotionService->getFinalPrice($product);
        $total = $cartItem->quantity * $finalPrice;
        
        return view('checkout.buy-now', compact('cartItem', 'total', 'product', 'checkoutData', 'promotionService'));
    }
}