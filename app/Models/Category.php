<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'name_en', 'slug', 'description', 'description_en', 'status'];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $appends = [
        'products_count'
    ];

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Accessors
    public function getProductsCountAttribute(): int
    {
        return $this->products()->count();
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeWithProducts(Builder $query): Builder
    {
        return $query->withCount('products');
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where('name', 'like', "%{$term}%")
                    ->orWhere('slug', 'like', "%{$term}%");
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $value ?: Str::slug($this->name);
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
    public function hasProducts(): bool
    {
        return $this->products()->exists();
    }

    public function getActiveProducts()
    {
        return $this->products()->active()->get();
    }
}