<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_en',          // Tên tiếng Anh
        'slug',
        'description',
        'description_en',   // Mô tả tiếng Anh
        'short_desc',
        'main_image',       // Ảnh chính từ form upload
        'price',
        'sale_price',
        'volume_ml',
        'brand',
        'gender',
        'stock',
        'sku',              // Mã sản phẩm
        'status',
        'category_id',
        'origin',
        'concentration',    // Nồng độ
        'is_featured',      // Sản phẩm nổi bật
        'is_on_sale',       // Đang giảm giá
        'is_best_seller',   // Bán chạy
        'is_new',           // Hàng mới
        'sale_start_date',  // Ngày bắt đầu giảm giá
        'sale_end_date',    // Ngày kết thúc giảm giá
        'views_count',      // Số lượt xem
        'sold_count',       // Số lượng đã bán
        'created_at',       // Ngày tạo (để xác định hàng mới)
    ];

    protected $casts = [
        'price' => 'decimal:0',
        'sale_price' => 'decimal:0',
        'stock' => 'integer',
        'status' => 'boolean',
        'is_featured' => 'boolean',
        'is_on_sale' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_new' => 'boolean',
        'sale_start_date' => 'datetime',
        'sale_end_date' => 'datetime',
        'views_count' => 'integer',
        'sold_count' => 'integer',
    ];

    protected $appends = [
        'main_image_url',
        'is_on_sale',
        'final_price',
        'discount_percentage'
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->ordered();
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->primary();
    }

    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->primary();
    }

    // Accessors
    public function getMainImageUrlAttribute(): string
    {
        // Ưu tiên 1: main_image từ form upload (ảnh chính)
        if ($this->main_image && Storage::disk('public')->exists($this->main_image)) {
            return Storage::url($this->main_image);
        }
        
        // Ưu tiên 2: ảnh gallery primary
        $primaryImage = $this->images()->where('is_primary', true)->first();
        if ($primaryImage && $primaryImage->image_path && Storage::disk('public')->exists($primaryImage->image_path)) {
            return Storage::url($primaryImage->image_path);
        }
        
        // Ưu tiên 3: ảnh đầu tiên trong gallery
        $firstImage = $this->images()->first();
        if ($firstImage && $firstImage->image_path && Storage::disk('public')->exists($firstImage->image_path)) {
            return Storage::url($firstImage->image_path);
        }
        
        // Fallback cuối cùng là placeholder
        return asset('images/product-placeholder.png');
    }

    public function getGalleryImagesAttribute()
    {
        return $this->images()->get();
    }

    public function getHasGalleryAttribute(): bool
    {
        return $this->images()->exists();
    }

    public function getIsOnSaleAttribute(): bool
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    /** Giá cuối cùng (sau khi giảm giá) */
    public function getFinalPriceAttribute(): float
    {
        if ($this->is_on_sale && $this->sale_price && $this->sale_price > 0) {
            return $this->sale_price;
        }
        return $this->price;
    }

    /** Phần trăm giảm giá */
    public function getDiscountPercentageAttribute(): int
    {
        if ($this->is_on_sale && $this->sale_price && $this->sale_price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOnSale($query)
    {
        return $query->where('sale_price', '>', 0)
                    ->where('sale_price', '<', DB::raw('price'))
                    ->where(function($q) {
                        $q->whereNull('sale_end_date')
                          ->orWhere('sale_end_date', '>=', now());
                    });
    }

    public function scopeBestSeller($query)
    {
        return $query->where('is_best_seller', true)
                    ->orderBy('sold_count', 'desc');
    }

    public function scopeNew($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    public function scopeTrending($query)
    {
        return $query->orderBy('sold_count', 'desc');
    }

    /**
     * Tìm kiếm thông minh theo tên sản phẩm, thương hiệu và danh mục
     */
    public function scopeSearch($query, $searchTerm)
    {
        $searchTerm = trim($searchTerm);
        
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where(function($q) use ($searchTerm) {
            // Tìm kiếm theo tên sản phẩm (chính xác hoặc chứa từ khóa)
            $q->where('name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('name', 'LIKE', "{$searchTerm}%")
              ->orWhere('name', 'LIKE', "%{$searchTerm}")
              ->orWhere('name', '=', $searchTerm);
            
            // Tìm kiếm theo thương hiệu (chính xác hoặc chứa từ khóa)
            $q->orWhere('brand', 'LIKE', "%{$searchTerm}%")
              ->orWhere('brand', 'LIKE', "{$searchTerm}%")
              ->orWhere('brand', 'LIKE', "%{$searchTerm}")
              ->orWhere('brand', '=', $searchTerm);
            
            // Tìm kiếm theo slug sản phẩm
            $q->orWhere('slug', 'LIKE', "%{$searchTerm}%")
              ->orWhere('slug', 'LIKE', "{$searchTerm}%")
              ->orWhere('slug', 'LIKE', "%{$searchTerm}")
              ->orWhere('slug', '=', $searchTerm);
            
            // Tìm kiếm theo danh mục (thông qua relationship)
            $q->orWhereHas('category', function($categoryQuery) use ($searchTerm) {
                $categoryQuery->where('name', 'LIKE', "%{$searchTerm}%")
                             ->orWhere('name', 'LIKE', "{$searchTerm}%")
                             ->orWhere('name', 'LIKE', "%{$searchTerm}")
                             ->orWhere('name', '=', $searchTerm);
            });
        });
    }

    /**
     * Tìm kiếm nâng cao với nhiều tiêu chí
     */
    public function scopeAdvancedSearch($query, $filters)
    {
        // Tìm kiếm cơ bản
        if (!empty($filters['q'])) {
            $query->search($filters['q']);
        }
        
        // Lọc theo danh mục
        if (!empty($filters['category'])) {
            $query->byCategory($filters['category']);
        }
        
        // Lọc theo giới tính
        if (!empty($filters['gender'])) {
            $query->byGender($filters['gender']);
        }
        
        // Lọc theo thương hiệu
        if (!empty($filters['brand'])) {
            $query->where('brand', 'LIKE', "%{$filters['brand']}%");
        }
        
        // Lọc theo giá
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }
        
        // Lọc theo trạng thái giảm giá
        if (isset($filters['on_sale']) && $filters['on_sale']) {
            $query->onSale();
        }
        
        // Lọc theo sản phẩm nổi bật
        if (isset($filters['featured']) && $filters['featured']) {
            $query->featured();
        }
        
        // Lọc theo sản phẩm mới
        if (isset($filters['new']) && $filters['new']) {
            $query->new();
        }
        
        // Lọc theo sản phẩm bán chạy
        if (isset($filters['best_seller']) && $filters['best_seller']) {
            $query->bestSeller();
        }
        
        return $query;
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeByGender(Builder $query, string $gender): Builder
    {
        return $query->where('gender', $gender);
    }

    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $value ?: \Str::slug($this->name);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = (bool) $value;
    }

    // Multilingual Accessors
    public function getDisplayNameAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && $this->name_en) {
            return $this->name_en;
        }
        return $this->name;
    }

    public function getDisplayDescriptionAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && $this->description_en) {
            return $this->description_en;
        }
        return $this->description ?? '';
    }

    // Helper methods
    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }

    public function hasStock(int $quantity = 1): bool
    {
        return $this->stock >= $quantity;
    }

    public function decreaseStock(int $quantity = 1): bool
    {
        if ($this->hasStock($quantity)) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    /**
     * Increase view count
     */
    public function incrementViewCount(): void
    {
        $this->increment('views_count');
    }

    /**
     * Increase sold count when order is completed
     */
    public function incrementSoldCount(int $quantity = 1): void
    {
        $this->increment('sold_count', $quantity);
    }

    /**
     * Get formatted view count
     */
    public function getFormattedViewsAttribute(): string
    {
        $views = $this->views_count ?? 0;
        
        if ($views >= 1000000) {
            return number_format($views / 1000000, 1) . 'M';
        } elseif ($views >= 1000) {
            return number_format($views / 1000, 1) . 'K';
        }
        
        return number_format($views);
    }

    /**
     * Get formatted sold count
     */
    public function getFormattedSoldAttribute(): string
    {
        $sold = $this->sold_count ?? 0;
        
        if ($sold >= 1000000) {
            return number_format($sold / 1000000, 1) . 'M';
        } elseif ($sold >= 1000) {
            return number_format($sold / 1000, 1) . 'K';
        }
        
        return number_format($sold);
    }
}
