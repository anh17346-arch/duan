<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text',
        'sort_order',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getImageUrlAttribute(): string
    {
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            return Storage::url($this->image_path);
        }
        return asset('images/product-placeholder.png');
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            // Tạo thumbnail path
            $pathInfo = pathinfo($this->image_path);
            $thumbnailPath = $pathInfo['dirname'] . '/thumbnails/' . $pathInfo['basename'];
            
            if (Storage::disk('public')->exists($thumbnailPath)) {
                return Storage::url($thumbnailPath);
            }
            return Storage::url($this->image_path);
        }
        return asset('images/product-placeholder.png');
    }

    // Scopes
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    // Helper methods
    public function makePrimary(): bool
    {
        try {
            // Bỏ primary của tất cả ảnh khác của sản phẩm này
            $this->product->images()->where('id', '!=', $this->id)->update(['is_primary' => false]);
            
            // Đặt ảnh này làm primary
            $this->is_primary = true;
            return $this->save();
        } catch (\Exception $e) {
            \Log::error('Error setting primary image:', [
                'image_id' => $this->id,
                'product_id' => $this->product_id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function deleteImage(): bool
    {
        // Xóa file ảnh
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            Storage::disk('public')->delete($this->image_path);
        }

        // Xóa thumbnail nếu có
        $pathInfo = pathinfo($this->image_path);
        $thumbnailPath = $pathInfo['dirname'] . '/thumbnails/' . $pathInfo['basename'];
        if (Storage::disk('public')->exists($thumbnailPath)) {
            Storage::disk('public')->delete($thumbnailPath);
        }

        return $this->delete();
    }
}
