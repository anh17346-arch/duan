<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    private const IMAGE_DISK = 'public';
    private const IMAGE_PATH = 'products';

    public function searchProducts(string $term = '', array $filters = [])
    {
        $query = Product::with('category')->latest();

        if ($term) {
            $query->search($term);
        }

        // Apply filters
        if (isset($filters['category_id'])) {
            $query->byCategory($filters['category_id']);
        }

        if (isset($filters['gender'])) {
            $query->byGender($filters['gender']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        return $query;
    }

    public function createProduct(array $data, ?UploadedFile $image = null): Product
    {
        $data['slug'] = $this->generateUniqueSlug($data['name']);

        if ($image) {
            $data['main_image'] = $this->storeImage($image);
        }

        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data, ?UploadedFile $image = null): bool
    {
        if (isset($data['name']) && $data['name'] !== $product->name) {
            $data['slug'] = $this->generateUniqueSlug($data['name'], $product->id);
        }

        if ($image) {
            $this->deleteOldImage($product->main_image);
            $data['main_image'] = $this->storeImage($image);
        }

        return $product->update($data);
    }

    public function deleteProduct(Product $product): bool
    {
        $this->deleteOldImage($product->main_image);
        return $product->delete();
    }

    public function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while ($this->slugExists($slug, $excludeId)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $query = Product::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    private function storeImage(UploadedFile $file): string
    {
        return $file->store(self::IMAGE_PATH, self::IMAGE_DISK);
    }

    private function deleteOldImage(?string $imagePath): void
    {
        if ($imagePath && Storage::disk(self::IMAGE_DISK)->exists($imagePath)) {
            Storage::disk(self::IMAGE_DISK)->delete($imagePath);
        }
    }

    public function getProductStats(): array
    {
        return [
            'total' => Product::count(),
            'active' => Product::active()->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'on_sale' => Product::onSale()->count(),
            'low_stock' => Product::where('stock', '<=', 10)->where('stock', '>', 0)->count(),
        ];
    }
}
