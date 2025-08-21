<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thêm dữ liệu mẫu cho views_count và sold_count
        $products = DB::table('products')->get();
        
        foreach ($products as $product) {
            // Generate realistic sample data
            $baseViews = rand(50, 500);
            $baseSold = rand(5, 50);
            
            // Featured products get more views/sales
            if ($product->is_featured) {
                $baseViews = rand(500, 2000);
                $baseSold = rand(50, 200);
            }
            
            // On sale products get more activity
            if ($product->is_on_sale) {
                $baseViews = (int)($baseViews * 1.5);
                $baseSold = (int)($baseSold * 1.3);
            }
            
            // Best sellers get high sales numbers
            if ($product->is_best_seller) {
                $baseSold = rand(100, 500);
                $baseViews = (int)($baseSold * rand(3, 8)); // Views typically higher than sales
            }
            
            DB::table('products')
                ->where('id', $product->id)
                ->update([
                    'views_count' => $baseViews,
                    'sold_count' => $baseSold,
                    'updated_at' => now()
                ]);
        }
        
        echo "Updated " . $products->count() . " products with sample views and sales data.\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset views and sales to 0
        DB::table('products')->update([
            'views_count' => 0,
            'sold_count' => 0
        ]);
    }
};