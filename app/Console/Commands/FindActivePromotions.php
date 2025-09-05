<?php

namespace App\Console\Commands;

use App\Models\Promotion;
use Illuminate\Console\Command;

class FindActivePromotions extends Command
{
    protected $signature = 'promotions:find-active';
    protected $description = 'Tìm các khuyến mãi đang hoạt động';

    public function handle()
    {
        $this->info("=== TÌM KHUYẾN MÃI ĐANG HOẠT ĐỘNG ===");
        
        $activePromotions = Promotion::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with('product')
            ->get();
            
        if ($activePromotions->count() > 0) {
            $this->info("Tìm thấy {$activePromotions->count()} khuyến mãi đang hoạt động:");
            
            foreach ($activePromotions as $promotion) {
                $this->line("• {$promotion->product->name} (ID: {$promotion->product_id}) - Giảm {$promotion->discount_percentage}%");
            }
        } else {
            $this->info("Không có khuyến mãi nào đang hoạt động.");
        }
        
        return Command::SUCCESS;
    }
}
