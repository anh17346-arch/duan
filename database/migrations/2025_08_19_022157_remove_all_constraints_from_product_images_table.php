<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kiểm tra và xóa tất cả constraints có thể gây vấn đề
        try {
            // Xóa unique constraint nếu còn tồn tại
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('product_images');
            
            if (isset($indexes['unique_primary_image'])) {
                DB::statement('ALTER TABLE `product_images` DROP INDEX `unique_primary_image`');
            }
            
            // Xóa foreign key constraint nếu cần
            $foreignKeys = $sm->listTableForeignKeys('product_images');
            foreach ($foreignKeys as $fk) {
                if ($fk->getName() === 'product_images_product_id_foreign') {
                    DB::statement('ALTER TABLE `product_images` DROP FOREIGN KEY `product_images_product_id_foreign`');
                    break;
                }
            }
            
            // Thêm lại foreign key constraint (cần thiết cho referential integrity)
            DB::statement('ALTER TABLE `product_images` ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE');
            
        } catch (\Throwable $e) {
            // Log lỗi nhưng không dừng migration
            \Log::warning('Error in remove_all_constraints_from_product_images_table: ' . $e->getMessage());
        }
    }

    public function down(): void
    {
        // Không cần rollback vì đây là migration sửa lỗi
    }
};
