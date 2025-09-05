<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\PromotionService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['categories'])
            ->featured()
            ->active()
            ->inStock()
            ->limit(8)
            ->get();

        // Sử dụng PromotionService để lấy sản phẩm có khuyến mãi
        $promotionService = new PromotionService();
        $onSaleProducts = $promotionService->getProductsWithActivePromotions()
            ->with(['categories'])
            ->active()
            ->limit(6)
            ->get();

        $bestSellerProducts = Product::with(['categories'])
            ->bestSeller()
            ->active()
            ->limit(6)
            ->get();

        $newProducts = Product::with(['categories'])
            ->new(30) // Sản phẩm trong 30 ngày gần đây
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Lấy danh sách danh mục để hiển thị trong navigation
        $categories = Category::active()->withCount('products')->orderBy('name')->get();

        return view('categories.index', compact(
            'featuredProducts',
            'onSaleProducts', 
            'bestSellerProducts',
            'newProducts',
            'categories',
            'promotionService'
        ));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|min:2|max:100'
        ]);
        
        Category::create($data);

        return redirect()->route('categories.index')
            ->with('success', 'Tạo danh mục thành công!');
    }

    public function show(Category $category, Request $request): View
    {
        // Load products count cho category
        $category->loadCount('products');
        
        // Xử lý đặc biệt cho danh mục "Đang giảm giá"
        if ($category->name === 'Đang giảm giá' || $category->name_en === 'On Sale') {
            $promotionService = new PromotionService();
            $query = $promotionService->getProductsWithActivePromotions()
                ->with(['categories'])
                ->active()
                ->orderBy('products.created_at', 'desc');
        } else {
            $query = $category->products()->with(['categories'])->active()->orderBy('products.created_at', 'desc');
        }
        
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
        
        $products = $query->paginate(12)->withQueryString();
        
        // Lấy danh sách thương hiệu trong danh mục này
        if ($category->name === 'Đang giảm giá' || $category->name_en === 'On Sale') {
            $brands = $products->pluck('brand')->filter()->sort()->values();
        } else {
            $brands = $category->products()->active()->distinct()->pluck('brand')->filter()->sort()->values();
        }
        
        // Lấy các sản phẩm theo loại cho trang danh mục
        $promotionService = new PromotionService();
        
        // Chỉ hiển thị sản phẩm theo đúng danh mục được chọn
        // Không hiển thị các section khác nhau
        $maleProducts = collect();
        $femaleProducts = collect();
        $unisexProducts = collect();
        $newProducts = collect();
        
        return view('categories.show', compact(
            'category', 
            'products', 
            'brands', 
            'promotionService',
            'maleProducts',
            'femaleProducts', 
            'unisexProducts',
            'newProducts'
        ));
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|min:2|max:100'
        ]);
        
        $category->update($data);

        return back()->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'Đã xoá danh mục!');
    }
}