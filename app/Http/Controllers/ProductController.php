<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category'])->active()->latest();
        
        // Sử dụng tìm kiếm nâng cao
        $filters = $request->only(['q', 'category', 'gender', 'brand', 'min_price', 'max_price', 'on_sale', 'featured', 'new', 'best_seller']);
        $query->advancedSearch($filters);
        
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        
        // Lấy danh sách thương hiệu duy nhất để hiển thị trong filter
        $brands = Product::active()->distinct()->pluck('brand')->filter()->sort()->values();
        
        return view('products.index', compact('products', 'categories', 'brands'));
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'images']);
        
        // Increment view count
        $product->incrementViewCount();
        
        // Sản phẩm liên quan
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
            
        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function category(Category $category, Request $request): View
    {
        $query = $category->products()->active()->latest();
        
        // Tìm kiếm trong danh mục
        if ($request->filled('q')) {
            $query->search($request->get('q'));
        }
        
        $products = $query->paginate(12)->withQueryString();
        
        return view('products.category', compact('category', 'products'));
    }
}
