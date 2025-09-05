<?php

namespace App\Console\Commands;

use App\Models\Promotion;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendPromotionNotifications extends Command
{
    protected $signature = 'promotions:send-notifications {--type=all} {--promotion-id=}';
    protected $description = 'Gửi thông báo khuyến mãi cho khách hàng';

    public function handle()
    {
        $type = $this->option('type');
        $promotionId = $this->option('promotion-id');
        
        $notificationService = app(NotificationService::class);

        if ($promotionId) {
            // Gửi thông báo cho một khuyến mãi cụ thể
            $promotion = Promotion::find($promotionId);
            if (!$promotion) {
                $this->error("Không tìm thấy khuyến mãi với ID: {$promotionId}");
                return Command::FAILURE;
            }
            
            $this->sendNotificationForPromotion($promotion, $notificationService);
        } else {
            // Gửi thông báo cho tất cả khuyến mãi mới
            $this->sendNotificationsForNewPromotions($notificationService, $type);
        }

        return Command::SUCCESS;
    }

    /**
     * Gửi thông báo cho khuyến mãi mới
     */
    private function sendNotificationsForNewPromotions(NotificationService $notificationService, string $type = 'all')
    {
        $this->info("=== GỬI THÔNG BÁO KHUYẾN MÃI ===");

        // Lấy các khuyến mãi mới được tạo trong 24h qua
        $newPromotions = Promotion::where('created_at', '>=', Carbon::now()->subDay())
            ->with('product')
            ->get();

        if ($newPromotions->isEmpty()) {
            $this->info("Không có khuyến mãi mới nào trong 24h qua.");
            return;
        }

        $this->info("Tìm thấy {$newPromotions->count()} khuyến mãi mới:");

        foreach ($newPromotions as $promotion) {
            $this->sendNotificationForPromotion($promotion, $notificationService);
        }
    }

    /**
     * Gửi thông báo cho một khuyến mãi cụ thể
     */
    private function sendNotificationForPromotion(Promotion $promotion, NotificationService $notificationService)
    {
        $product = $promotion->product;
        
        $this->line("• {$product->name} - Giảm {$promotion->discount_percentage}%");
        
        // Kiểm tra xem đã gửi thông báo cho khuyến mãi này chưa
        $notificationKey = "promotion_notification_sent_{$promotion->id}";
        if (cache()->has($notificationKey)) {
            $this->line("  ⚠️  Đã gửi thông báo trước đó");
            return;
        }

        // Gửi thông báo cho tất cả khách hàng
        $customerCount = User::where('role', 'customer')->count();
        
        if ($customerCount > 0) {
            $notificationService->createPromotionNotification($promotion, 'new_promotion');
            
            // Đánh dấu đã gửi thông báo
            cache()->put($notificationKey, true, Carbon::now()->addDays(7));
            
            $this->line("  ✅ Đã gửi thông báo cho {$customerCount} khách hàng");
        } else {
            $this->line("  ⚠️  Không có khách hàng nào để gửi thông báo");
        }
    }
}
