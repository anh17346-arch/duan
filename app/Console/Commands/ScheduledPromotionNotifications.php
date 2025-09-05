<?php

namespace App\Console\Commands;

use App\Models\Promotion;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ScheduledPromotionNotifications extends Command
{
    protected $signature = 'promotions:scheduled-notifications';
    protected $description = 'Gửi thông báo khuyến mãi theo lịch trình';

    public function handle()
    {
        $this->info("=== GỬI THÔNG BÁO KHUYẾN MÃI THEO LỊCH TRÌNH ===");
        
        $notificationService = app(NotificationService::class);
        
        // 1. Gửi thông báo cho khuyến mãi sắp bắt đầu (trong 1 giờ tới)
        $this->sendUpcomingPromotionNotifications($notificationService);
        
        // 2. Gửi thông báo cho khuyến mãi flash sale (giảm giá cao)
        $this->sendFlashSaleNotifications($notificationService);
        
        // 3. Gửi thông báo cho khuyến mãi sắp kết thúc (trong 24h tới)
        $this->sendEndingPromotionNotifications($notificationService);
        
        return Command::SUCCESS;
    }

    /**
     * Gửi thông báo cho khuyến mãi sắp bắt đầu
     */
    private function sendUpcomingPromotionNotifications(NotificationService $notificationService)
    {
        $this->info("Kiểm tra khuyến mãi sắp bắt đầu...");
        
        $upcomingPromotions = Promotion::where('start_date', '>', Carbon::now())
            ->where('start_date', '<=', Carbon::now()->addHour())
            ->with('product')
            ->get();

        foreach ($upcomingPromotions as $promotion) {
            $notificationKey = "upcoming_promotion_{$promotion->id}";
            
            if (!cache()->has($notificationKey)) {
                $notificationService->createPromotionNotification($promotion, 'flash_sale');
                cache()->put($notificationKey, true, Carbon::now()->addDay());
                
                $this->line("✅ Thông báo khuyến mãi sắp bắt đầu: {$promotion->product->name}");
            }
        }
    }

    /**
     * Gửi thông báo cho khuyến mãi flash sale (giảm giá >= 30%)
     */
    private function sendFlashSaleNotifications(NotificationService $notificationService)
    {
        $this->info("Kiểm tra flash sale...");
        
        $flashSales = Promotion::where('discount_percentage', '>=', 30)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->with('product')
            ->get();

        foreach ($flashSales as $promotion) {
            $notificationKey = "flash_sale_{$promotion->id}";
            
            if (!cache()->has($notificationKey)) {
                $notificationService->createPromotionNotification($promotion, 'flash_sale');
                cache()->put($notificationKey, true, Carbon::now()->addHours(6)); // Gửi lại sau 6h
                
                $this->line("🔥 Flash Sale: {$promotion->product->name} - Giảm {$promotion->discount_percentage}%");
            }
        }
    }

    /**
     * Gửi thông báo cho khuyến mãi sắp kết thúc
     */
    private function sendEndingPromotionNotifications(NotificationService $notificationService)
    {
        $this->info("Kiểm tra khuyến mãi sắp kết thúc...");
        
        $endingPromotions = Promotion::where('end_date', '>', Carbon::now())
            ->where('end_date', '<=', Carbon::now()->addDay())
            ->with('product')
            ->get();

        foreach ($endingPromotions as $promotion) {
            $notificationKey = "ending_promotion_{$promotion->id}";
            
            if (!cache()->has($notificationKey)) {
                // Tạo thông báo đặc biệt cho khuyến mãi sắp kết thúc
                $this->createEndingPromotionNotification($promotion, $notificationService);
                cache()->put($notificationKey, true, Carbon::now()->addHours(12));
                
                $this->line("⏰ Khuyến mãi sắp kết thúc: {$promotion->product->name}");
            }
        }
    }

    /**
     * Tạo thông báo đặc biệt cho khuyến mãi sắp kết thúc
     */
    private function createEndingPromotionNotification(Promotion $promotion, NotificationService $notificationService)
    {
        $hoursLeft = Carbon::now()->diffInHours($promotion->end_date);
        
        $notificationData = [
            'type' => 'customer',
            'category' => 'promotion',
            'title' => 'Khuyến mãi sắp kết thúc!',
            'message' => "Khuyến mãi {$promotion->product->name} giảm {$promotion->discount_percentage}% sẽ kết thúc trong {$hoursLeft} giờ!",
            'icon' => 'clock',
            'color' => 'red',
            'action_url' => route('products.show', $promotion->product),
            'action_text' => 'Mua ngay',
            'data' => [
                'promotion_id' => $promotion->id,
                'product_id' => $promotion->product->id,
                'hours_left' => $hoursLeft,
            ],
            'is_important' => true,
        ];

        $notification = $notificationService->createNotification($notificationData);
        $notificationService->sendToAllCustomers($notification);
    }
}
