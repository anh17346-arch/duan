<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class ConsoleSchedule extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Gửi thông báo khuyến mãi mỗi giờ
        $schedule->command('promotions:scheduled-notifications')
                ->hourly()
                ->withoutOverlapping()
                ->runInBackground();

        // Gửi thông báo khuyến mãi mới mỗi ngày
        $schedule->command('promotions:send-notifications')
                ->dailyAt('09:00')
                ->withoutOverlapping()
                ->runInBackground();

        // Cập nhật trạng thái khuyến mãi mỗi phút
        $schedule->command('promotions:update-status')
                ->everyMinute()
                ->withoutOverlapping()
                ->runInBackground();

        // Gửi nhắc nhở đánh giá mỗi ngày
        $schedule->command('reviews:send-reminders')
                ->dailyAt('14:00')
                ->withoutOverlapping()
                ->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
