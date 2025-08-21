<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        try {
            DB::statement('ALTER TABLE `product_images` DROP INDEX `unique_primary_image`');
        } catch (\Throwable $e) {
            // ignore if index does not exist
        }
    }

    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE `product_images` ADD UNIQUE KEY `unique_primary_image` (`product_id`, `is_primary`)');
        } catch (\Throwable $e) {
            // ignore
        }
    }
};


