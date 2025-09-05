<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Promotion;
use Carbon\Carbon;

class UpdatePromotionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotions:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update promotion status based on current time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        
        $this->info('Updating promotion status...');
        
        // Lấy tất cả khuyến mãi
        $promotions = Promotion::all();
        
        foreach ($promotions as $promotion) {
            $status = $this->getPromotionStatus($promotion, $now);
            $this->info("Promotion ID {$promotion->id} ({$promotion->product->name}): {$status}");
        }
        
        $this->info('Promotion status update completed!');
        
        return 0;
    }
    
    /**
     * Get promotion status
     */
    private function getPromotionStatus(Promotion $promotion, Carbon $now): string
    {
        if ($promotion->start_date <= $now && $promotion->end_date >= $now) {
            return 'Active';
        } elseif ($promotion->start_date > $now) {
            return 'Upcoming';
        } else {
            return 'Expired';
        }
    }
}
