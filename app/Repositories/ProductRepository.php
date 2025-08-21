<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->with('category')->get();
    }

    public function find(int $id): ?Product
    {
        return $this->model->with('category')->find($id);
    }

    public function findBySlug(string $slug): ?Product
    {
        return $this->model->with('category')->where('slug', $slug)->first();
    }

    public function create(array $data): Product
    {
        return $this->model->create($data);
    }

    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function search(string $term, array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = $this->model->with('category')->latest();

        if ($term) {
            $query->search($term);
        }

        $this->applyFilters($query, $filters);

        return $query->paginate($perPage)->withQueryString();
    }

    public function getActiveProducts(int $perPage = 12): LengthAwarePaginator
    {
        return $this->model->active()
            ->with('category')
            ->latest()
            ->paginate($perPage);
    }

    public function getProductsByCategory(int $categoryId, int $perPage = 12): LengthAwarePaginator
    {
        return $this->model->byCategory($categoryId)
            ->active()
            ->with('category')
            ->latest()
            ->paginate($perPage);
    }

    public function getOnSaleProducts(int $perPage = 12): LengthAwarePaginator
    {
        return $this->model->onSale()
            ->active()
            ->with('category')
            ->latest()
            ->paginate($perPage);
    }

    public function getLowStockProducts(int $threshold = 10): Collection
    {
        return $this->model->where('stock', '<=', $threshold)
            ->where('stock', '>', 0)
            ->with('category')
            ->get();
    }

    public function getOutOfStockProducts(): Collection
    {
        return $this->model->where('stock', 0)
            ->with('category')
            ->get();
    }

    public function getProductStats(): array
    {
        return [
            'total' => $this->model->count(),
            'active' => $this->model->active()->count(),
            'out_of_stock' => $this->model->where('stock', 0)->count(),
            'on_sale' => $this->model->onSale()->count(),
            'low_stock' => $this->model->where('stock', '<=', 10)->where('stock', '>', 0)->count(),
        ];
    }

    private function applyFilters($query, array $filters): void
    {
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

        if (isset($filters['in_stock']) && $filters['in_stock']) {
            $query->inStock();
        }
    }
}
