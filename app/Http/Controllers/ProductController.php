<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Services\PromotionService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['categories'])->active()->latest();
        
        // Sử dụng tìm kiếm nâng cao
        $filters = $request->only(['q', 'category', 'gender', 'brand', 'min_price', 'max_price', 'on_sale', 'featured', 'new', 'best_seller']);
        $query->advancedSearch($filters);
        
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        
        // Lấy danh sách thương hiệu duy nhất để hiển thị trong filter
        $brands = Product::active()->distinct()->pluck('brand')->filter()->sort()->values();
        
        $promotionService = new PromotionService();
        return view('products.index', compact('products', 'categories', 'brands', 'promotionService'));
    }

    public function show(Product $product, Request $request): View
    {
        $product->load(['categories', 'images']);
        
        // Increment view count
        $product->incrementViewCount();
        
        // Sản phẩm liên quan
        $relatedProducts = Product::active()
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
        
        // Khởi tạo service khuyến mãi
        $promotionService = new PromotionService();
        
        // Lấy đánh giá cho sản phẩm với filter và sorting
        $reviewsQuery = Review::where('product_id', $product->id)
            ->where('is_approved', true)
            ->with(['user', 'images']);
        
        // Filter by rating
        if ($request->filled('rating')) {
            $reviewsQuery->where('rating', $request->rating);
        }
        
        // Filter by has images
        if ($request->filled('has_images')) {
            $reviewsQuery->whereHas('images');
        }
        
        // Sort reviews
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $reviewsQuery->orderBy('created_at', 'asc');
                break;
            case 'rating_high':
                $reviewsQuery->orderBy('rating', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'rating_low':
                $reviewsQuery->orderBy('rating', 'asc')->orderBy('created_at', 'desc');
                break;
            default: // newest
                $reviewsQuery->orderBy('created_at', 'desc');
                break;
        }
        
        $reviews = $reviewsQuery->paginate(10)->withQueryString();
        
        return view('products.show', compact('product', 'relatedProducts', 'promotionService', 'reviews'));
    }

    public function category(Category $category, Request $request): View
    {
        $query = $category->products()->active()->latest();
        
        // Tìm kiếm trong danh mục
        if ($request->filled('q')) {
            $query->search($request->get('q'));
        }
        
        $products = $query->paginate(12)->withQueryString();
        
        $promotionService = new PromotionService();
        return view('products.category', compact('category', 'products', 'promotionService'));
    }
}
