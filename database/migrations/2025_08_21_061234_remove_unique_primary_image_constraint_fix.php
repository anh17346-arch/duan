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
        // Xóa constraint unique có vấn đề
        try {
            // Kiểm tra và xóa unique constraint nếu tồn tại
            $indexExists = collect(DB::select("SHOW INDEX FROM product_images WHERE Key_name = 'unique_primary_image'"))->isNotEmpty();
            
            if ($indexExists) {
                DB::statement('ALTER TABLE product_images DROP INDEX unique_primary_image');
                echo "Removed unique_primary_image constraint\n";
            }
            
            // Kiểm tra các constraint khác có thể gây xung đột
            $constraints = DB::select("SHOW INDEX FROM product_images");
            foreach ($constraints as $constraint) {
                if (strpos($constraint->Key_name, 'unique') !== false && 
                    strpos($constraint->Column_name, 'is_primary') !== false) {
                    DB::statement("ALTER TABLE product_images DROP INDEX {$constraint->Key_name}");
                    echo "Removed constraint: {$constraint->Key_name}\n";
                }
            }
            
        } catch (\Exception $e) {
            // Log error nhưng không fail migration
            \Log::warning('Could not remove unique constraint: ' . $e->getMessage());
        }
        
        // Đảm bảo chỉ có 1 ảnh primary per product bằng cách programmatic
        // Không dùng database constraint mà xử lý trong code
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Không làm gì trong down để tránh tái tạo constraint có vấn đề
    }
};