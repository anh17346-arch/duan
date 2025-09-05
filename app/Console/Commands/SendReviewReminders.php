<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Review;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendReviewReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reviews:send-reminders {--days=3 : Number of days after delivery to send reminder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send review reminder notifications for delivered orders';

    /**
     * Execute the console command.
     */
    public function handle(NotificationService $notificationService)
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Sending review reminders for orders delivered before {$cutoffDate->format('Y-m-d H:i:s')}...");

        // Get delivered orders that haven't been reviewed
        $orders = Order::where('status', 'delivered')
            ->where('updated_at', '<=', $cutoffDate)
            ->whereDoesntHave('reviews')
            ->with(['user', 'items.product'])
            ->get();

        $count = 0;
        foreach ($orders as $order) {
            // Check if any items in the order haven't been reviewed
            $unreviewedItems = $order->items->filter(function ($item) {
                return !Review::where('user_id', $order->user_id)
                    ->where('product_id', $item->product_id)
                    ->where('order_id', $order->id)
                    ->exists();
            });

            if ($unreviewedItems->count() > 0) {
                $notificationService->createReviewReminderNotification($order);
                $count++;
                
                $this->line("Sent reminder for order #{$order->order_number} to {$order->user->name}");
            }
        }

        $this->info("Sent {$count} review reminder notifications.");
        
        return Command::SUCCESS;
    }
}
