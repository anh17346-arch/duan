<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $cartItems = auth()->user()->cart()->with('product.category')->get();
        
        // Load active promotions for cart items
        $activePromotions = \App\Models\Promotion::with('product')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
        
        // Check which cart items have promotions and calculate totals
        $originalTotal = 0;
        $discountedTotal = 0;
        $totalSavings = 0;
        
        $cartItemsWithPromotions = $cartItems->map(function ($item) use ($activePromotions, &$originalTotal, &$discountedTotal, &$totalSavings) {
            $item->has_promotion = $activePromotions->contains('product_id', $item->product_id);
            $item->promotion = $activePromotions->where('product_id', $item->product_id)->first();
            
            // Add promotion quantity info
            if ($item->has_promotion && $item->promotion) {
                $item->promotion_remaining = $item->promotion->getRemainingQuantityAttribute();
                $item->promotion_sold = $item->promotion->sold_quantity;
                $item->promotion_total = $item->promotion->quantity;
            }
            
            // Calculate totals
            $itemOriginalPrice = $item->product->price * $item->quantity;
            $originalTotal += $itemOriginalPrice;
            
            if ($item->has_promotion && $item->promotion) {
                $discountRate = $item->promotion->discount_percentage / 100;
                $itemDiscountedPrice = $itemOriginalPrice * (1 - $discountRate);
                $discountedTotal += $itemDiscountedPrice;
                $totalSavings += ($itemOriginalPrice - $itemDiscountedPrice);
            } else {
                $discountedTotal += $itemOriginalPrice;
            }
            
            return $item;
        });
        
        return view('cart.index', compact('cartItems', 'activePromotions', 'originalTotal', 'discountedTotal', 'totalSavings'));
    }

    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Kiểm tra tồn kho
        if (!$product->hasStock($request->quantity)) {
            return back()->with('error', 'Sản phẩm không đủ số lượng trong kho!');
        }

        // Kiểm tra khuyến mãi và số lượng khuyến mãi
        $activePromotion = $product->promotions()->active()->first();
        if ($activePromotion && $activePromotion->quantity > 0) {
            $remainingPromotionQuantity = $activePromotion->getRemainingQuantityAttribute();
            
            // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
            $existingCart = auth()->user()->cart()->where('product_id', $request->product_id)->first();
            $currentCartQuantity = $existingCart ? $existingCart->quantity : 0;
            $requestedQuantity = $request->quantity;
            
            // Tính tổng số lượng muốn thêm
            $totalRequestedQuantity = $currentCartQuantity + $requestedQuantity;
            
            // Kiểm tra xem có vượt quá số lượng khuyến mãi không
            if ($totalRequestedQuantity > $remainingPromotionQuantity) {
                $availableQuantity = max(0, $remainingPromotionQuantity - $currentCartQuantity);
                if ($availableQuantity <= 0) {
                    return back()->with('error', 'Khuyến mãi đã hết số lượng! Chỉ còn ' . $remainingPromotionQuantity . ' sản phẩm được khuyến mãi.');
                }
                return back()->with('error', 'Số lượng vượt quá giới hạn khuyến mãi! Bạn chỉ có thể thêm tối đa ' . $availableQuantity . ' sản phẩm nữa.');
            }
        }

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $existingCart = auth()->user()->cart()->where('product_id', $request->product_id)->first();
        
        if ($existingCart) {
            // Cập nhật số lượng
            $newQuantity = $existingCart->quantity + $request->quantity;
            if (!$product->hasStock($newQuantity)) {
                return back()->with('error', 'Số lượng vượt quá tồn kho!');
            }
            $existingCart->update(['quantity' => $newQuantity]);
            $message = 'Đã cập nhật số lượng sản phẩm trong giỏ hàng!';
        } else {
            // Thêm mới vào giỏ hàng
            auth()->user()->cart()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
            $message = __('app.product_added_to_cart');
        }

        return back()->with('success', $message);
    }

    public function update(Request $request, Cart $cart): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Kiểm tra quyền sở hữu
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        // Kiểm tra tồn kho
        if (!$cart->product->hasStock($request->quantity)) {
            return back()->with('error', 'Số lượng vượt quá tồn kho!');
        }

        // Kiểm tra khuyến mãi và số lượng khuyến mãi
        $activePromotion = $cart->product->promotions()->active()->first();
        if ($activePromotion && $activePromotion->quantity > 0) {
            $remainingPromotionQuantity = $activePromotion->getRemainingQuantityAttribute();
            
            // Kiểm tra xem có vượt quá số lượng khuyến mãi không
            if ($request->quantity > $remainingPromotionQuantity) {
                return back()->with('error', 'Số lượng vượt quá giới hạn khuyến mãi! Chỉ còn ' . $remainingPromotionQuantity . ' sản phẩm được khuyến mãi.');
            }
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Đã cập nhật số lượng!');
    }

    public function remove(Cart $cart): RedirectResponse
    {
        // Kiểm tra quyền sở hữu
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function clear(): RedirectResponse
    {
        auth()->user()->clearCart();

        return back()->with('success', 'Đã xóa tất cả sản phẩm trong giỏ hàng!');
    }

    public function increaseQuantity(Cart $cart): RedirectResponse
    {
        // Kiểm tra quyền sở hữu
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        // Kiểm tra khuyến mãi và số lượng khuyến mãi
        $activePromotion = $cart->product->promotions()->active()->first();
        if ($activePromotion && $activePromotion->quantity > 0) {
            $remainingPromotionQuantity = $activePromotion->getRemainingQuantityAttribute();
            
            // Kiểm tra xem có vượt quá số lượng khuyến mãi không
            if ($cart->quantity >= $remainingPromotionQuantity) {
                return back()->with('error', 'Không thể tăng số lượng! Chỉ còn ' . $remainingPromotionQuantity . ' sản phẩm được khuyến mãi.');
            }
        }

        if ($cart->increaseQuantity()) {
            return back()->with('success', 'Đã tăng số lượng!');
        }

        return back()->with('error', 'Không thể tăng số lượng!');
    }

    public function decreaseQuantity(Cart $cart): RedirectResponse
    {
        // Kiểm tra quyền sở hữu
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        if ($cart->decreaseQuantity()) {
            return back()->with('success', 'Đã giảm số lượng!');
        }

        return back()->with('error', 'Không thể giảm số lượng!');
    }
}
