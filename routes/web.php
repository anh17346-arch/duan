<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\Admin\PromotionController as AdminPromotionController;
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
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category}/products', [ProductController::class, 'category'])->name('products.category');

// Product reviews (public access)
Route::get('/products/{product}/reviews', [App\Http\Controllers\ReviewController::class, 'getProductReviews'])->name('products.reviews');

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
            // 'category_id' => 1, // Removed - now using many-to-many relationship
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

    // Promotion routes
    // Route::prefix('promotions')->name('promotions.')->group(function () {
    Route::get('/promotions/current', [PromotionController::class, 'current'])->name('promotions.current');
Route::post('/promotions/apply', [PromotionController::class, 'apply'])->name('promotions.apply');
Route::delete('/promotions/remove', [PromotionController::class, 'remove'])->name('promotions.remove');
    // });

    // Checkout routes
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [App\Http\Controllers\CheckoutController::class, 'index'])->name('index');
        Route::get('/buy-now/{product}', [App\Http\Controllers\CheckoutController::class, 'showBuyNow'])->name('buy-now.show');
        Route::post('/buy-now/{product}', [App\Http\Controllers\CheckoutController::class, 'buyNow'])->name('buy-now');
        Route::post('/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('process');
        Route::get('/success/{order}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('success');
        Route::get('/back', [App\Http\Controllers\CheckoutController::class, 'backToCheckout'])->name('back');
        Route::get('/back-buy-now', [App\Http\Controllers\CheckoutController::class, 'backToBuyNowCheckout'])->name('back-buy-now');
    });

    // Payment routes
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/process/{order}', [App\Http\Controllers\PaymentController::class, 'process'])->name('process');
        Route::post('/confirm/{order}', [App\Http\Controllers\PaymentController::class, 'confirm'])->name('confirm');
        Route::post('/cancel/{order}', [App\Http\Controllers\PaymentController::class, 'cancel'])->name('cancel');
        Route::get('/qr-code/{order}', [App\Http\Controllers\PaymentController::class, 'generateQRCode'])->name('qr-code');
        Route::get('/status/{order}', [App\Http\Controllers\PaymentController::class, 'checkStatus'])->name('status');
    });

    // Order management routes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [App\Http\Controllers\OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('show');
        Route::patch('/{order}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('cancel');
        Route::post('/{order}/reorder', [App\Http\Controllers\OrderController::class, 'reorder'])->name('reorder');
        Route::get('/{order}/invoice', [App\Http\Controllers\OrderController::class, 'invoice'])->name('invoice');
    });
    
    // Profile management
    Route::prefix('tai-khoan')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Notification routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [App\Http\Controllers\NotificationController::class, 'index'])->name('index');
        Route::get('/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('unread-count');
        Route::get('/recent', [App\Http\Controllers\NotificationController::class, 'getRecentNotifications'])->name('recent');
        Route::post('/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/', [App\Http\Controllers\NotificationController::class, 'clearAll'])->name('clear-all');
    });

    // Review routes
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [App\Http\Controllers\ReviewController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\ReviewController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\ReviewController::class, 'store'])->name('store');
        Route::get('/{review}/edit', [App\Http\Controllers\ReviewController::class, 'edit'])->name('edit');
        Route::put('/{review}', [App\Http\Controllers\ReviewController::class, 'update'])->name('update');
        Route::delete('/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('destroy');
        Route::delete('/{review}/image', [App\Http\Controllers\ReviewController::class, 'deleteImage'])->name('delete-image');
    });
});

/*
|--------------------------------------------------------------------------
| Payment Webhook Routes (No Auth Required)
|--------------------------------------------------------------------------
*/
Route::prefix('webhooks')->name('webhooks.')->group(function () {
    Route::post('/momo', [App\Http\Controllers\PaymentController::class, 'webhook'])->name('momo');
    Route::post('/zalopay', [App\Http\Controllers\PaymentController::class, 'webhook'])->name('zalopay');
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
        Route::get('/products/list', [AdminProductController::class, 'list'])->name('products.list');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        
        // Product Images management
        Route::post('/products/{product}/images', [ProductImageController::class, 'store'])->name('product-images.store');
        Route::put('/product-images/{image}', [ProductImageController::class, 'update'])->name('product-images.update');
        Route::delete('/product-images/{image}', [ProductImageController::class, 'destroy'])->name('product-images.destroy');
        
        // Orders Management
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::put('/orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
        Route::post('/orders/bulk-update-status', [AdminOrderController::class, 'bulkUpdateStatus'])->name('orders.bulk-update-status');
        Route::get('/orders/export', [AdminOrderController::class, 'export'])->name('orders.export');
        Route::get('/orders/stats', [AdminOrderController::class, 'getStats'])->name('orders.stats');
        Route::post('/products/{product}/images/reorder', [ProductImageController::class, 'reorder'])->name('product-images.reorder');
        Route::post('/product-images/{image}/primary', [ProductImageController::class, 'setPrimary'])->name('product-images.primary');
        
        // Promotions management
        Route::get('/promotions', [AdminPromotionController::class, 'index'])->name('promotions.index');
        Route::get('/promotions/create', [AdminPromotionController::class, 'create'])->name('promotions.create');
        Route::post('/promotions', [AdminPromotionController::class, 'store'])->name('promotions.store');
        Route::get('/promotions/{promotion}/edit', [AdminPromotionController::class, 'edit'])->name('promotions.edit');
        Route::put('/promotions/{promotion}', [AdminPromotionController::class, 'update'])->name('promotions.update');
        Route::delete('/promotions/{promotion}', [AdminPromotionController::class, 'destroy'])->name('promotions.destroy');

        // Analytics & Reports
        Route::get('/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('/analytics/export-options', [App\Http\Controllers\Admin\AnalyticsController::class, 'showExportOptions'])->name('analytics.export-options');
        Route::get('/analytics/export', [App\Http\Controllers\Admin\AnalyticsController::class, 'export'])->name('analytics.export');

        // Notifications management
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\NotificationController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('store');
            Route::get('/{notification}', [App\Http\Controllers\Admin\NotificationController::class, 'show'])->name('show');
            Route::get('/{notification}/edit', [App\Http\Controllers\Admin\NotificationController::class, 'edit'])->name('edit');
            Route::put('/{notification}', [App\Http\Controllers\Admin\NotificationController::class, 'update'])->name('update');
            Route::delete('/{notification}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('destroy');
            Route::get('/unread-count', [App\Http\Controllers\Admin\NotificationController::class, 'getUnreadCount'])->name('unread-count');
            Route::get('/recent', [App\Http\Controllers\Admin\NotificationController::class, 'getRecentNotifications'])->name('recent');
            Route::post('/mark-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('mark-read');
            Route::post('/mark-all-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        });

        // Reviews management
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('index');
            Route::get('/statistics', [App\Http\Controllers\Admin\ReviewController::class, 'statistics'])->name('statistics');
            Route::post('/bulk-action', [App\Http\Controllers\Admin\ReviewController::class, 'bulkAction'])->name('bulk-action');
            
            // Test route for debugging
            Route::get('/test-statistics', function() {
                try {
                    $totalReviews = \App\Models\Review::count();
                    return response()->json([
                        'success' => true,
                        'total_reviews' => $totalReviews,
                        'message' => 'Statistics test successful'
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'error' => $e->getMessage()
                    ]);
                }
            })->name('test-statistics');
            
            // Simple test route
            Route::get('/test-simple', function() {
                return response()->json([
                    'success' => true,
                    'message' => 'Simple test route works!'
                ]);
            })->name('test-simple');
            
            // Individual review routes (must be last to avoid conflicts)
            Route::get('/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'show'])->name('show');
            Route::patch('/{review}/approve', [App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('approve');
            Route::patch('/{review}/reject', [App\Http\Controllers\Admin\ReviewController::class, 'reject'])->name('reject');
            Route::delete('/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('destroy');
        });
        
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

// API Routes for real-time promotion status
Route::get('/api/promotion-status/{product}', function (App\Models\Product $product) {
    $promotionService = new App\Services\PromotionService();
    return response()->json($promotionService->checkPromotionStatusRealTime($product));
})->name('api.promotion.status');

// Test route for dark mode select dropdowns


// Payment Settings routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/payment-settings', [App\Http\Controllers\Admin\PaymentSettingsController::class, 'index'])->name('payment-settings.index');
    Route::get('/payment-settings/methods', [App\Http\Controllers\Admin\PaymentSettingsController::class, 'paymentMethods'])->name('payment-settings.methods');
    Route::put('/payment-settings', [App\Http\Controllers\Admin\PaymentSettingsController::class, 'update'])->name('payment-settings.update');
    Route::delete('/payment-settings/qr-logo', [App\Http\Controllers\Admin\PaymentSettingsController::class, 'deleteQrLogo'])->name('payment-settings.delete-qr-logo');
    Route::post('/payment-settings/test-api', [App\Http\Controllers\Admin\PaymentSettingsController::class, 'testApiConnection'])->name('payment-settings.test-api');
    
    // Customer Management routes
    Route::resource('customers', App\Http\Controllers\Admin\CustomerController::class);
    Route::patch('/customers/{customer}/toggle-status', [App\Http\Controllers\Admin\CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
    Route::get('/customers-statistics', [App\Http\Controllers\Admin\CustomerController::class, 'statistics'])->name('customers.statistics');
    Route::get('/customers/{customer}/orders', [App\Http\Controllers\Admin\CustomerController::class, 'orders'])->name('customers.orders');
    

});