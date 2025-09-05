<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\PromotionService;
use Illuminate\Console\Command;

class UpdatePromotionSoldQuantity extends Command
{
    protected $signature = 'promotions:update-sold-quantity';
    protected $description = 'Cập nhật số lượng đã bán cho các khuyến mãi dựa trên đơn hàng';

    public function handle()
    {
        $this->info('Bắt đầu cập nhật số lượng đã bán cho khuyến mãi...');

        $promotionService = new PromotionService();
        $updatedCount = 0;

        // Lấy tất cả đơn hàng đã hoàn thành
        $orders = Order::where('status', 'delivered')->get();

        foreach ($orders as $order) {
            $orderItems = OrderItem::where('order_id', $order->id)->get();

            foreach ($orderItems as $item) {
                $product = $item->product;
                
                // Kiểm tra xem sản phẩm có khuyến mãi đang hoạt động không
                if ($promotionService->isProductOnSale($product)) {
                    $activePromotion = $promotionService->getActivePromotion($product);
                    
                    if ($activePromotion) {
                        // Tăng số lượng đã bán
                        if ($activePromotion->incrementSoldQuantity($item->quantity)) {
                            $updatedCount++;
                            $this->line("✓ Cập nhật khuyến mãi cho sản phẩm '{$product->name}': +{$item->quantity}");
                        }
                    }
                }
            }
        }

        $this->info("Hoàn thành! Đã cập nhật {$updatedCount} khuyến mãi.");

        return Command::SUCCESS;
    }
}
