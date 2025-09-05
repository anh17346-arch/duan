<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Promotion;
use Carbon\Carbon;

class PromotionService
{
    /**
     * Lấy khuyến mãi đang hoạt động cho sản phẩm
     */
    public function getActivePromotion(Product $product): ?Promotion
    {
        return Promotion::where('product_id', $product->id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where(function($query) {
                $query->where('quantity', 0) // Không giới hạn số lượng
                      ->orWhereRaw('sold_quantity < quantity'); // Còn số lượng
            })
            ->first();
    }

    /**
     * Lấy khuyến mãi sắp diễn ra cho sản phẩm
     */
    public function getUpcomingPromotion(Product $product): ?Promotion
    {
        return Promotion::where('product_id', $product->id)
            ->where('start_date', '>', now())
            ->first();
    }

    /**
     * Kiểm tra sản phẩm có khuyến mãi đang hoạt động không
     */
    public function isProductOnSale(Product $product): bool
    {
        $activePromotion = $this->getActivePromotion($product);
        if ($activePromotion) {
            return true;
        }
        
        // Fallback về sale_price cũ
        return $product->sale_price && $product->sale_price < $product->price;
    }

    /**
     * Tính giá cuối cùng sau khi áp dụng khuyến mãi
     */
    public function getFinalPrice(Product $product): float
    {
        $activePromotion = $this->getActivePromotion($product);
        if ($activePromotion) {
            $discountAmount = ($product->price * $activePromotion->discount_percentage) / 100;
            return $product->price - $discountAmount;
        }
        
        // Fallback về sale_price cũ
        if ($product->sale_price && $product->sale_price > 0) {
            return $product->sale_price;
        }
        
        return $product->price;
    }

    /**
     * Lấy phần trăm giảm giá
     */
    public function getDiscountPercentage(Product $product): int
    {
        $activePromotion = $this->getActivePromotion($product);
        if ($activePromotion) {
            return (int) $activePromotion->discount_percentage;
        }
        
        // Fallback về sale_price cũ
        if ($product->sale_price && $product->sale_price > 0) {
            return round((($product->price - $product->sale_price) / $product->price) * 100);
        }
        
        return 0;
    }

    /**
     * Lấy thông tin khuyến mãi sắp diễn ra
     */
    public function getUpcomingPromotionInfo(Product $product): ?array
    {
        $upcomingPromotion = $this->getUpcomingPromotion($product);
        if ($upcomingPromotion) {
            return [
                'id' => $upcomingPromotion->id,
                'discount_percentage' => $upcomingPromotion->discount_percentage,
                'start_date' => $upcomingPromotion->start_date,
                'end_date' => $upcomingPromotion->end_date,
                'formatted_start_date' => $upcomingPromotion->formatted_start_date,
                'formatted_end_date' => $upcomingPromotion->formatted_end_date,
            ];
        }
        return null;
    }

    /**
     * Lấy tất cả sản phẩm có khuyến mãi đang hoạt động
     */
    public function getProductsWithActivePromotions()
    {
        $promotionProductIds = Promotion::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where(function($query) {
                $query->where('quantity', 0) // Không giới hạn số lượng
                      ->orWhereRaw('sold_quantity < quantity'); // Còn số lượng
            })
            ->pluck('product_id');

        return Product::whereIn('id', $promotionProductIds)
            ->orWhere(function($query) {
                $query->where('sale_price', '>', 0)
                      ->where('sale_price', '<', \DB::raw('price'))
                      ->where(function($q) {
                          $q->whereNull('sale_end_date')
                            ->orWhere('sale_end_date', '>=', now());
                      });
            });
    }

    /**
     * Tăng số lượng đã bán cho khuyến mãi
     */
    public function incrementSoldQuantity(Product $product, int $amount = 1): bool
    {
        $activePromotion = $this->getActivePromotion($product);
        if ($activePromotion) {
            return $activePromotion->incrementSoldQuantity($amount);
        }
        return false;
    }

    /**
     * Lấy thông tin số lượng khuyến mãi
     */
    public function getPromotionQuantityInfo(Product $product): ?array
    {
        $activePromotion = $this->getActivePromotion($product);
        if ($activePromotion) {
            return [
                'quantity' => $activePromotion->quantity,
                'sold_quantity' => $activePromotion->sold_quantity,
                'remaining_quantity' => $activePromotion->remaining_quantity,
                'has_limit' => $activePromotion->quantity > 0,
                'is_unlimited' => $activePromotion->quantity == 0,
            ];
        }
        return null;
    }

    /**
     * Kiểm tra real-time xem khuyến mãi có còn hoạt động không
     */
    public function checkPromotionStatusRealTime(Product $product): array
    {
        $activePromotion = $this->getActivePromotion($product);
        
        if ($activePromotion) {
            return [
                'is_on_sale' => true,
                'discount_percentage' => (int) $activePromotion->discount_percentage,
                'final_price' => $this->getFinalPrice($product),
                'original_price' => $product->price,
                'quantity_info' => $this->getPromotionQuantityInfo($product),
                'promotion_id' => $activePromotion->id,
            ];
        }
        
        return [
            'is_on_sale' => false,
            'discount_percentage' => 0,
            'final_price' => $product->price,
            'original_price' => $product->price,
            'quantity_info' => null,
            'promotion_id' => null,
        ];
    }
}
