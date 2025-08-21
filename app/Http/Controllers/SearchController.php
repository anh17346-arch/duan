<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Hiển thị trang tìm kiếm nâng cao
     */
    public function index(Request $request): View
    {
        $query = Product::with(['category'])->active()->latest();
        
        // Sử dụng tìm kiếm nâng cao
        $filters = $request->only(['q', 'category', 'gender', 'brand', 'min_price', 'max_price', 'on_sale', 'featured', 'new', 'best_seller']);
        $query->advancedSearch($filters);
        
        $products = $query->paginate(16)->withQueryString();
        $categories = Category::orderBy('name')->get();
        
        // Lấy danh sách thương hiệu duy nhất
        $brands = Product::active()->distinct()->pluck('brand')->filter()->sort()->values();
        
        // Thống kê kết quả tìm kiếm
        $searchStats = [
            'total' => $products->total(),
            'query' => $request->get('q'),
            'filters_applied' => count(array_filter($filters))
        ];
        
        return view('search.index', compact('products', 'categories', 'brands', 'searchStats'));
    }

    /**
     * Tìm kiếm nhanh (AJAX) - trả về JSON
     */
    public function quickSearch(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json(['suggestions' => []]);
        }
        
        $suggestions = Product::active()
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('brand', 'LIKE', "%{$query}%")
                  ->orWhere('slug', 'LIKE', "%{$query}%");
            })
            ->with('category')
            ->limit(5)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand,
                    'category' => $product->category->name,
                    'image' => $product->main_image_url,
                    'price' => $product->final_price,
                    'url' => route('products.show', $product)
                ];
            });
        
        return response()->json(['suggestions' => $suggestions]);
    }

    /**
     * Tìm kiếm theo thương hiệu
     */
    public function byBrand(Request $request, string $brand): View
    {
        $query = Product::with(['category'])
            ->active()
            ->where('brand', 'LIKE', "%{$brand}%")
            ->latest();
        
        // Áp dụng các filter khác
        if ($request->filled('category')) {
            $query->byCategory($request->get('category'));
        }
        
        if ($request->filled('gender')) {
            $query->byGender($request->get('gender'));
        }
        
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->get('min_price'));
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }
        
        $products = $query->paginate(16)->withQueryString();
        $categories = Category::orderBy('name')->get();
        
        return view('search.brand', compact('products', 'categories', 'brand'));
    }

    /**
     * Tìm kiếm theo danh mục
     */
    public function byCategory(Request $request, Category $category): View
    {
        $query = $category->products()
            ->with(['category'])
            ->active()
            ->latest();
        
        // Tìm kiếm trong danh mục
        if ($request->filled('q')) {
            $query->search($request->get('q'));
        }
        
        // Lọc theo giới tính
        if ($request->filled('gender')) {
            $query->byGender($request->get('gender'));
        }
        
        // Lọc theo thương hiệu
        if ($request->filled('brand')) {
            $query->where('brand', 'LIKE', "%{$request->get('brand')}%");
        }
        
        // Lọc theo giá
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->get('min_price'));
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }
        
        $products = $query->paginate(16)->withQueryString();
        
        // Lấy danh sách thương hiệu trong danh mục này
        $brands = $category->products()->active()->distinct()->pluck('brand')->filter()->sort()->values();
        
        return view('search.category', compact('category', 'products', 'brands'));
    }

    /**
     * Hiển thị sản phẩm đang giảm giá
     */
    public function onSale(Request $request): View
    {
        $products = Product::with(['category'])
            ->onSale()
            ->active()
            ->latest()
            ->paginate(16);
        
        // Thống kê
        $stats = [
            'total' => $products->total(),
            'total_products' => Product::active()->count(),
            'sale_percentage' => $products->total() > 0 ? round(($products->total() / Product::active()->count()) * 100, 1) : 0
        ];
        
        return view('search.on-sale', compact('products', 'stats'));
    }
}
