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
        
        return view('cart.index', compact('cartItems'));
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
            $message = 'Đã thêm sản phẩm vào giỏ hàng!';
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
