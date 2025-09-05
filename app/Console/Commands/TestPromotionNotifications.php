<?php

namespace App\Console\Commands;

use App\Models\Promotion;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class TestPromotionNotifications extends Command
{
    protected $signature = 'test:promotion-notifications {--user-id=} {--promotion-id=}';
    protected $description = 'Test hệ thống thông báo khuyến mãi';

    public function handle()
    {
        $this->info("=== TEST HỆ THỐNG THÔNG BÁO KHUYẾN MÃI ===");
        
        $userId = $this->option('user-id');
        $promotionId = $this->option('promotion-id');
        
        $notificationService = app(NotificationService::class);

        // Test 1: Kiểm tra khuyến mãi đang hoạt động
        $this->testActivePromotions();
        
        // Test 2: Test gửi thông báo cho user cụ thể
        if ($userId) {
            $this->testUserNotification($userId, $notificationService);
        }
        
        // Test 3: Test gửi thông báo cho khuyến mãi cụ thể
        if ($promotionId) {
            $this->testPromotionNotification($promotionId, $notificationService);
        }
        
        // Test 4: Test gửi thông báo cho tất cả khách hàng
        $this->testAllCustomersNotification($notificationService);
        
        $this->info("✅ Test hoàn tất!");
        
        return Command::SUCCESS;
    }

    /**
     * Test khuyến mãi đang hoạt động
     */
    private function testActivePromotions()
    {
        $this->info("\n1. Kiểm tra khuyến mãi đang hoạt động:");
        
        $activePromotions = Promotion::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with('product')
            ->get();
            
        if ($activePromotions->count() > 0) {
            $this->info("   Tìm thấy {$activePromotions->count()} khuyến mãi đang hoạt động:");
            
            foreach ($activePromotions as $promotion) {
                $this->line("   • {$promotion->product->name} - Giảm {$promotion->discount_percentage}%");
            }
        } else {
            $this->warn("   Không có khuyến mãi nào đang hoạt động.");
        }
    }

    /**
     * Test gửi thông báo cho user cụ thể
     */
    private function testUserNotification($userId, NotificationService $notificationService)
    {
        $this->info("\n2. Test gửi thông báo cho user ID: {$userId}");
        
        $user = User::find($userId);
        if (!$user) {
            $this->error("   Không tìm thấy user với ID: {$userId}");
            return;
        }
        
        $promotion = Promotion::with('product')->first();
        if (!$promotion) {
            $this->error("   Không có khuyến mãi nào để test");
            return;
        }
        
        try {
            $notificationService->createPromotionNotification($promotion, 'new_promotion');
            $this->info("   ✅ Đã gửi thông báo cho user: {$user->name}");
        } catch (\Exception $e) {
            $this->error("   ❌ Lỗi: " . $e->getMessage());
        }
    }

    /**
     * Test gửi thông báo cho khuyến mãi cụ thể
     */
    private function testPromotionNotification($promotionId, NotificationService $notificationService)
    {
        $this->info("\n3. Test gửi thông báo cho khuyến mãi ID: {$promotionId}");
        
        $promotion = Promotion::with('product')->find($promotionId);
        if (!$promotion) {
            $this->error("   Không tìm thấy khuyến mãi với ID: {$promotionId}");
            return;
        }
        
        try {
            $notificationService->createPromotionNotification($promotion, 'flash_sale');
            $this->info("   ✅ Đã gửi thông báo flash sale cho: {$promotion->product->name}");
        } catch (\Exception $e) {
            $this->error("   ❌ Lỗi: " . $e->getMessage());
        }
    }

    /**
     * Test gửi thông báo cho tất cả khách hàng
     */
    private function testAllCustomersNotification(NotificationService $notificationService)
    {
        $this->info("\n4. Test gửi thông báo cho tất cả khách hàng:");
        
        $customerCount = User::where('role', 'customer')->count();
        $this->info("   Tổng số khách hàng: {$customerCount}");
        
        if ($customerCount == 0) {
            $this->warn("   Không có khách hàng nào để gửi thông báo");
            return;
        }
        
        $promotion = Promotion::with('product')->first();
        if (!$promotion) {
            $this->error("   Không có khuyến mãi nào để test");
            return;
        }
        
        try {
            $notificationService->createPromotionNotification($promotion, 'new_promotion');
            $this->info("   ✅ Đã gửi thông báo cho {$customerCount} khách hàng");
        } catch (\Exception $e) {
            $this->error("   ❌ Lỗi: " . $e->getMessage());
        }
    }
}
