<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PromotionController extends Controller
{
    /**
     * Get current active promotions
     */
    public function current(): JsonResponse
    {
        try {
            $promotions = Promotion::with('product')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->get()
                ->map(function ($promotion) {
                    return [
                        'id' => $promotion->id,
                        'product_id' => $promotion->product_id,
                        'category_ids' => $promotion->product->categories->pluck('id')->toArray(),
                        'product_name' => $promotion->product->name,
                        'discount_percentage' => $promotion->discount_percentage,
                        'start_date' => $promotion->start_date,
                        'end_date' => $promotion->end_date,
                    ];
                });

            return response()->json([
                'success' => true,
                'promotions' => $promotions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'promotions' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Apply promotion to cart
     */
    public function apply(Request $request): JsonResponse
    {
        try {
            $promotionId = $request->input('promotion_id');
            $promotion = Promotion::findOrFail($promotionId);

            // Check if promotion is active
            if ($promotion->start_date > now() || $promotion->end_date < now()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Khuyến mãi không còn hiệu lực'
                ], 400);
            }

            // Calculate discount
            $cartItems = auth()->user()->cart()->with('product')->get();
            $totalDiscount = 0;

            foreach ($cartItems as $item) {
                if ($item->product_id == $promotion->product_id) {
                    $discount = ($item->product->price * $promotion->discount_percentage / 100) * $item->quantity;
                    $totalDiscount += $discount;
                }
            }

            return response()->json([
                'success' => true,
                'total_discount' => $totalDiscount,
                'promotion' => [
                    'id' => $promotion->id,
                    'discount_percentage' => $promotion->discount_percentage,
                    'product_name' => $promotion->product->name
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi áp dụng khuyến mãi'
            ], 500);
        }
    }

    /**
     * Remove promotion from cart
     */
    public function remove(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'total_discount' => 0
        ]);
    }
}
