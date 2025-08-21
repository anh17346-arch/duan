<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LanguageController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Language switching route
Route::get('/language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

// Trang chủ mới - Trực tiếp đến categories/products (không yêu cầu đăng nhập)
Route::get('/', [CategoryController::class, 'index'])->name('home');

// Trang danh mục (giữ để tương thích)
Route::get('/trangchu', [CategoryController::class, 'index'])->name('trangchu');

// Giữ tương thích tên route cũ
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Xem chi tiết danh mục (public)
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Routes cho sản phẩm (public access)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category}/products', [ProductController::class, 'category'])->name('products.category');

// Routes tìm kiếm công khai
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search/quick', [SearchController::class, 'quickSearch'])->name('search.quick');
Route::get('/search/brand/{brand}', [SearchController::class, 'byBrand'])->name('search.brand');
Route::get('/search/category/{category:slug}', [SearchController::class, 'byCategory'])->name('search.category');
Route::get('/sale', [SearchController::class, 'onSale'])->name('search.on-sale');

// Debug route để kiểm tra vấn đề upload ảnh
Route::get('/debug-image-issue', function() {
    $products = App\Models\Product::all(['id', 'name', 'main_image']);
    $result = [];
    
    foreach($products as $product) {
        $hasMainImage = !empty($product->main_image);
        $mainImageExists = $hasMainImage && Storage::disk('public')->exists($product->main_image);
        $imageCount = $product->images()->count();
        
        $result[] = [
            'id' => $product->id,
            'name' => $product->name,
            'main_image' => $product->main_image ?: 'NULL',
            'has_main_image' => $hasMainImage,
            'main_image_file_exists' => $mainImageExists,
            'gallery_images_count' => $imageCount,
            'main_image_url' => $product->main_image_url
        ];
    }
    
    return response()->json($result, 200, [], JSON_PRETTY_PRINT);
});

// Debug route để kiểm tra admin user
Route::get('/debug-admin', function() {
    $adminUser = App\Models\User::where('email', 'admin@example.com')->first();
    
    if (!$adminUser) {
        return response()->json(['error' => 'Admin user not found']);
    }
    
    return response()->json([
        'admin_user' => [
            'id' => $adminUser->id,
            'email' => $adminUser->email,
            'name' => $adminUser->name,
            'role' => $adminUser->role,
            'created_at' => $adminUser->created_at
        ],
        'auth_check' => auth()->check(),
        'current_user' => auth()->user() ? [
            'id' => auth()->user()->id,
            'email' => auth()->user()->email,
            'role' => auth()->user()->role
        ] : null
    ]);
});

// Debug route để test gallery upload
Route::post('/debug-gallery-upload', function(\Illuminate\Http\Request $request) {
    \Log::info('Debug gallery upload - Request received:', [
        'all_data' => $request->all(),
        'all_files' => $request->allFiles(),
        'has_gallery' => $request->hasFile('gallery_images'),
        'gallery_count' => $request->hasFile('gallery_images') ? count($request->file('gallery_images')) : 0,
        'content_type' => $request->header('Content-Type'),
        'method' => $request->method()
    ]);
    
    if ($request->hasFile('gallery_images')) {
        $files = $request->file('gallery_images');
        $uploadedFiles = [];
        
        foreach ($files as $index => $file) {
            try {
                $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('products/gallery', $fileName, 'public');
                
                $uploadedFiles[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'stored_name' => $fileName,
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType()
                ];
                
                \Log::info('Debug gallery upload - File saved:', [
                    'file' => $fileName,
                    'path' => $path
                ]);
            } catch (\Exception $e) {
                \Log::error('Debug gallery upload - File error:', [
                    'file' => $file->getClientOriginalName(),
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Files uploaded successfully',
            'uploaded_files' => $uploadedFiles
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'No gallery files found',
        'request_data' => $request->all()
    ]);
});

// Test form đơn giản để debug gallery upload
Route::get('/test-gallery-form', function() {
    return view('test-gallery-form');
});

// Test route để kiểm tra product images
Route::get('/test-product-images/{id}', function($id) {
    $product = \App\Models\Product::with('images')->find($id);
    if (!$product) {
        return response()->json(['error' => 'Product not found']);
    }
    
    return response()->json([
        'product_id' => $product->id,
        'product_name' => $product->name,
        'images_count' => $product->images->count(),
        'images' => $product->images->map(function($img) {
            return [
                'id' => $img->id,
                'path' => $img->image_path,
                'url' => $img->image_url,
                'is_primary' => $img->is_primary
            ];
        })
    ]);
});

// Test route để kiểm tra database
Route::get('/test-db', function() {
    try {
        // Kiểm tra products
        $productsCount = \App\Models\Product::count();
        $productsWithImages = \App\Models\Product::with('images')->get()->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'images_count' => $product->images->count(),
                'has_main_image' => !empty($product->main_image)
            ];
        });
        
        // Kiểm tra product_images
        $imagesCount = \App\Models\ProductImage::count();
        $images = \App\Models\ProductImage::with('product')->get()->map(function($img) {
            return [
                'id' => $img->id,
                'product_id' => $img->product_id,
                'product_name' => $img->product->name ?? 'N/A',
                'path' => $img->image_path,
                'is_primary' => $img->is_primary
            ];
        });
        
        return response()->json([
            'success' => true,
            'products_count' => $productsCount,
            'images_count' => $imagesCount,
            'products' => $productsWithImages,
            'images' => $images
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});

// Test route để tạo sản phẩm với gallery
Route::post('/test-create-product', function(\Illuminate\Http\Request $request) {
    try {
        // Tạo sản phẩm test
        $product = \App\Models\Product::create([
            'name' => 'Test Product ' . time(),
            'slug' => 'test-product-' . time(),
            'description' => 'Test description',
            'price' => 100000,
            'stock' => 10,
            'sku' => 'TEST-' . time(),
            'category_id' => 1,
            'gender' => 'unisex',
            'volume_ml' => 50,
            'concentration' => 'EDT',
            'status' => 1
        ]);
        
        // Xử lý gallery images nếu có
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $file) {
                $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('products/gallery', $fileName, 'public');
                
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => false
                ]);
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product_id' => $product->id,
            'images_count' => $product->images()->count()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});



/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard redirect về trang chủ
    Route::get('/dashboard', fn () => redirect()->route('home'))->name('dashboard');
    
    // Cart routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::put('/{cart}', [CartController::class, 'update'])->name('update');
        Route::delete('/{cart}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/', [CartController::class, 'clear'])->name('clear');
        Route::post('/{cart}/increase', [CartController::class, 'increaseQuantity'])->name('increase');
        Route::post('/{cart}/decrease', [CartController::class, 'decreaseQuantity'])->name('decrease');
    });
    
    // Profile management
    Route::prefix('tai-khoan')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Translation API Routes  
|--------------------------------------------------------------------------
*/
Route::prefix('api/translation')->name('api.translation.')->group(function () {
    Route::post('/to-english', [App\Http\Controllers\Api\TranslationController::class, 'translateToEnglish'])->name('to-english');
    Route::post('/to-vietnamese', [App\Http\Controllers\Api\TranslationController::class, 'translateToVietnamese'])->name('to-vietnamese');
    Route::post('/auto-translate', [App\Http\Controllers\Api\TranslationController::class, 'autoTranslate'])->name('auto-translate');
    Route::post('/detect-language', [App\Http\Controllers\Api\TranslationController::class, 'detectLanguage'])->name('detect-language');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Admin Dashboard
        Route::get('/', function() {
            return view('admin.dashboard');
        })->name('dashboard');
        
        // Categories CRUD (admin only)
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
        
        // Products CRUD (admin only) - Định nghĩa rõ ràng từng route
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        
        // Product Images management
        Route::post('/products/{product}/images', [ProductImageController::class, 'store'])->name('product-images.store');
        Route::put('/product-images/{image}', [ProductImageController::class, 'update'])->name('product-images.update');
        Route::delete('/product-images/{image}', [ProductImageController::class, 'destroy'])->name('product-images.destroy');
        Route::post('/products/{product}/images/reorder', [ProductImageController::class, 'reorder'])->name('product-images.reorder');
        Route::post('/product-images/{image}/primary', [ProductImageController::class, 'setPrimary'])->name('product-images.primary');
        
        // Test route for debugging gallery upload
        Route::post('/test-gallery-upload', function (Request $request) {
            \Log::info('Test gallery upload:', [
                'all_data' => $request->all(),
                'all_files' => $request->allFiles(),
                'has_gallery' => $request->hasFile('gallery_images'),
                'gallery_count' => $request->hasFile('gallery_images') ? count($request->file('gallery_images')) : 0
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Test successful',
                'data' => [
                    'has_gallery' => $request->hasFile('gallery_images'),
                    'gallery_count' => $request->hasFile('gallery_images') ? count($request->file('gallery_images')) : 0,
                    'files' => $request->allFiles()
                ]
            ]);
        })->name('test.gallery.upload');
        
        // Test route to check product images
        Route::get('/test-product-images/{id}', function ($id) {
            $product = \App\Models\Product::with('images')->find($id);
            if (!$product) {
                return response()->json(['error' => 'Product not found']);
            }
            
            return response()->json([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'images_count' => $product->images->count(),
                'images' => $product->images->map(function($img) {
                    return [
                        'id' => $img->id,
                        'path' => $img->image_path,
                        'url' => $img->image_url,
                        'is_primary' => $img->is_primary
                    ];
                })
            ]);
        })->name('test.product.images');
        
        // Test route to check database constraints
        Route::get('/test-db-constraints', function () {
            try {
                $constraints = \DB::select("SHOW INDEX FROM product_images WHERE Key_name = 'unique_primary_image'");
                $tableStructure = \DB::select("DESCRIBE product_images");
                
                return response()->json([
                    'constraints_found' => count($constraints),
                    'constraints' => $constraints,
                    'table_structure' => $tableStructure
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ]);
            }
        })->name('test.db.constraints');
    });