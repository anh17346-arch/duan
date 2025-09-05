<?php

namespace App\Observers;

use App\Models\Promotion;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class PromotionObserver
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the Promotion "created" event.
     */
    public function created(Promotion $promotion): void
    {
        Log::info("Promotion created: {$promotion->id} for product {$promotion->product->name}");
        
        // Gửi thông báo cho tất cả khách hàng về khuyến mãi mới
        try {
            $this->notificationService->createPromotionNotification($promotion, 'new_promotion');
            Log::info("Promotion notification sent successfully for promotion {$promotion->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send promotion notification: " . $e->getMessage());
        }
    }

    /**
     * Handle the Promotion "updated" event.
     */
    public function updated(Promotion $promotion): void
    {
        // Nếu khuyến mãi vừa bắt đầu hoạt động, gửi thông báo flash sale
        if ($promotion->wasChanged('start_date') && $promotion->isActive()) {
            try {
                $this->notificationService->createPromotionNotification($promotion, 'flash_sale');
                Log::info("Flash sale notification sent for promotion {$promotion->id}");
            } catch (\Exception $e) {
                Log::error("Failed to send flash sale notification: " . $e->getMessage());
            }
        }
    }

    /**
     * Handle the Promotion "deleted" event.
     */
    public function deleted(Promotion $promotion): void
    {
        Log::info("Promotion deleted: {$promotion->id}");
    }

    /**
     * Handle the Promotion "restored" event.
     */
    public function restored(Promotion $promotion): void
    {
        Log::info("Promotion restored: {$promotion->id}");
    }

    /**
     * Handle the Promotion "force deleted" event.
     */
    public function forceDeleted(Promotion $promotion): void
    {
        Log::info("Promotion force deleted: {$promotion->id}");
    }
}
