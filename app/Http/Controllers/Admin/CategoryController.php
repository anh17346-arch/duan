<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('products');
        
        // Search functionality
        if ($request->filled('kw')) {
            $query->where('name', 'like', '%' . $request->kw . '%');
        }
        
        $categories = $query->orderBy('id', 'desc')->paginate(10);
        
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'name_en' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_en' => 'nullable|string',
            'status' => 'required|in:0,1'
        ]);

        $data = $request->all();
        $data['status'] = (bool) $data['status'];

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', __('app.category_created_successfully'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'name_en' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_en' => 'nullable|string',
            'status' => 'required|in:0,1'
        ]);

        $data = $request->all();
        $data['status'] = (bool) $data['status'];

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', __('app.category_updated_successfully'));
    }

    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return back()->with('error', __('app.cannot_delete_category_with_products'));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', __('app.category_deleted_successfully'));
    }
}
