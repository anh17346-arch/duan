<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    private const PRODUCTS_PER_PAGE = 12;
    private const IMAGE_DISK = 'public';
    private const IMAGE_PATH = 'products';

    public function index(Request $request): View
    {
        $q = trim($request->get('q', ''));
        $query = $this->buildSearchQuery($request);
        $products = $query->paginate(self::PRODUCTS_PER_PAGE)->withQueryString();

        return view('admin.products.index', compact('products', 'q'));
    }

    public function create(): View
    {
        $product = new Product();
        $categories = $this->getCategories();

        return view('admin.products.create', compact('product', 'categories'));
    }

    public function store(ProductRequest $request)
    {
        try {
            $data = $request->validated();
        
        // Tạo slug từ tên sản phẩm
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        
        // Xử lý các trường boolean
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_on_sale'] = $request->boolean('is_on_sale');
        $data['is_best_seller'] = $request->boolean('is_best_seller');
        $data['is_new'] = $request->boolean('is_new');
        
        // Debug logging
        \Log::info('ProductController@store - Request data:', [
            'has_file' => $request->hasFile('main_image'),
            'has_gallery_files' => $request->hasFile('gallery_images'),
            'gallery_files_count' => $request->hasFile('gallery_images') ? count($request->file('gallery_images')) : 0,
            'files' => $request->allFiles(),
            'data_keys' => array_keys($data),
            'slug' => $data['slug'],
            'all_request_data' => $request->all(),
            'content_type' => $request->header('Content-Type')
        ]);
        
        // Xử lý ảnh chính
        if ($request->hasFile('main_image')) {
            try {
                $file = $request->file('main_image');
                \Log::info('ProductController@store - File info:', [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'error' => $file->getError()
                ]);
                
                $path = $file->store('products', 'public');
                $data['main_image'] = $path;
                
                \Log::info('ProductController@store - Image stored:', ['path' => $path]);
            } catch (\Exception $e) {
                \Log::error('ProductController@store - Image upload error:', ['error' => $e->getMessage()]);
            }
        } else {
            \Log::info('ProductController@store - No file uploaded');
        }
        
        $product = Product::create($data);
        
        \Log::info('ProductController@store - Product created:', [
            'id' => $product->id,
            'main_image' => $product->main_image
        ]);

        // Xử lý gallery images
        if ($request->hasFile('gallery_images')) {
            \Log::info('ProductController@store - Processing gallery images:', [
                'count' => count($request->file('gallery_images')),
                'files_info' => array_map(function($file) {
                    return [
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType(),
                        'error' => $file->getError()
                    ];
                }, $request->file('gallery_images'))
            ]);
            
            foreach ($request->file('gallery_images') as $index => $file) {
                try {
                    $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('products/gallery', $fileName, 'public');
                    
                    $newImage = $product->images()->create([
                        'image_path' => $path,
                        'is_primary' => false
                    ]);
                    
                    \Log::info('ProductController@store - Gallery image saved:', [
                        'file' => $fileName,
                        'path' => $path,
                        'image_id' => $newImage->id,
                        'storage_exists' => \Illuminate\Support\Facades\Storage::disk('public')->exists($path)
                    ]);
                } catch (\Exception $e) {
                    \Log::error('ProductController@store - Gallery image error:', [
                        'file' => $file->getClientOriginalName(),
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
        } else {
            \Log::info('ProductController@store - No gallery images found in request');
        }

        // Check if this is an AJAX request (for image upload flow)
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được tạo thành công!',
                'product_id' => $product->id,
                'redirect_url' => route('admin.products.edit', $product)
            ]);
        }

        // Redirect to edit page instead of index for better UX
        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Đã tạo sản phẩm thành công.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('ProductController@store - Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi tạo sản phẩm: ' . $e->getMessage()
                ], 500);
            }
            throw $e;
        }
    }

    public function edit(Product $product): View
    {
        $categories = $this->getCategories();
        
        // Eager load images relationship
        $product->load('images');
        
        // Debug log
        \Log::info('ProductController@edit - Product loaded:', [
            'product_id' => $product->id,
            'images_count' => $product->images->count(),
            'images' => $product->images->map(function($img) {
                return [
                    'id' => $img->id,
                    'path' => $img->image_path,
                    'is_primary' => $img->is_primary
                ];
            })
        ]);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        
        // Xử lý các trường boolean
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_on_sale'] = $request->boolean('is_on_sale');
        $data['is_best_seller'] = $request->boolean('is_best_seller');
        $data['is_new'] = $request->boolean('is_new');
        
        // Debug logging
        \Log::info('ProductController@update - Request data:', [
            'product_id' => $product->id,
            'has_file' => $request->hasFile('main_image'),
            'has_gallery_files' => $request->hasFile('gallery_images'),
            'gallery_files_count' => $request->hasFile('gallery_images') ? count($request->file('gallery_images')) : 0,
            'current_main_image' => $product->main_image,
            'files' => $request->allFiles()
        ]);
        
        // Xử lý ảnh chính
        if ($request->hasFile('main_image')) {
            try {
                $file = $request->file('main_image');
                \Log::info('ProductController@update - File info:', [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'error' => $file->getError()
                ]);
                
                // Xóa ảnh cũ nếu có
                if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                    Storage::disk('public')->delete($product->main_image);
                    \Log::info('ProductController@update - Deleted old image:', ['path' => $product->main_image]);
                }
                
                $path = $file->store('products', 'public');
                $data['main_image'] = $path;
                
                \Log::info('ProductController@update - Image stored:', ['path' => $path]);
            } catch (\Exception $e) {
                \Log::error('ProductController@update - Image upload error:', ['error' => $e->getMessage()]);
            }
        } else {
            \Log::info('ProductController@update - No file uploaded');
        }
        
        $product->update($data);
        
        \Log::info('ProductController@update - Product updated:', [
            'id' => $product->id,
            'main_image' => $product->fresh()->main_image
        ]);

        // Xử lý gallery images
        if ($request->hasFile('gallery_images')) {
            \Log::info('ProductController@update - Processing gallery images:', [
                'count' => count($request->file('gallery_images')),
                'files' => array_map(function($file) {
                    return [
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType()
                    ];
                }, $request->file('gallery_images'))
            ]);
            
            foreach ($request->file('gallery_images') as $index => $file) {
                try {
                    $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('products/gallery', $fileName, 'public');
                    
                    $newImage = $product->images()->create([
                        'image_path' => $path,
                        'is_primary' => false
                    ]);
                    
                    \Log::info('ProductController@update - Gallery image saved:', [
                        'file' => $fileName,
                        'path' => $path,
                        'image_id' => $newImage->id,
                        'image_url' => $newImage->image_url,
                        'storage_exists' => Storage::disk('public')->exists($path)
                    ]);
                } catch (\Exception $e) {
                    \Log::error('ProductController@update - Gallery image error:', [
                        'file' => $file->getClientOriginalName(),
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
        } else {
            \Log::info('ProductController@update - No gallery images found in request');
        }

        // Stay on edit page for better UX
        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Đã cập nhật sản phẩm thành công.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->deleteOldImage($product->main_image);
        $product->delete();

        return back()->with('success', 'Đã xoá sản phẩm thành công.');
    }

    private function buildSearchQuery(Request $request)
    {
        $query = Product::with('category')->latest();
        
        $q = trim($request->get('q', ''));
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%");
            });
        }
        
        return $query;
    }

    private function getCategories()
    {
        return Category::orderBy('name')->pluck('name', 'id');
    }

    private function prepareProductData(ProductRequest $request): array
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        
        return $data;
    }

    private function storeImage($file): string
    {
        return $file->store(self::IMAGE_PATH, self::IMAGE_DISK);
    }

    private function deleteOldImage(?string $imagePath): void
    {
        if ($imagePath && Storage::disk(self::IMAGE_DISK)->exists($imagePath)) {
            Storage::disk(self::IMAGE_DISK)->delete($imagePath);
        }
    }
}
