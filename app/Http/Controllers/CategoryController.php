<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['category'])
            ->featured()
            ->active()
            ->inStock()
            ->limit(8)
            ->get();

        $onSaleProducts = Product::with(['category'])
            ->onSale()
            ->active()
            ->limit(6)
            ->get();

        $bestSellerProducts = Product::with(['category'])
            ->bestSeller()
            ->active()
            ->limit(6)
            ->get();

        $newProducts = Product::with(['category'])
            ->new(30) // Sản phẩm trong 30 ngày gần đây
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('categories.index', compact(
            'featuredProducts',
            'onSaleProducts', 
            'bestSellerProducts',
            'newProducts'
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
        $query = $category->products()->with(['category'])->active()->latest();
        
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
        $brands = $category->products()->active()->distinct()->pluck('brand')->filter()->sort()->values();
        
        return view('categories.show', compact('category', 'products', 'brands'));
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