<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Remove the unique constraint if it exists
        try {
            DB::statement('ALTER TABLE `product_images` DROP INDEX `unique_primary_image`');
            echo "Successfully removed unique_primary_image constraint\n";
        } catch (\Exception $e) {
            echo "Constraint unique_primary_image does not exist or already removed\n";
        }
    }

    public function down(): void
    {
        // Re-add the constraint if needed
        try {
            DB::statement('ALTER TABLE `product_images` ADD UNIQUE KEY `unique_primary_image` (`product_id`, `is_primary`)');
            echo "Successfully re-added unique_primary_image constraint\n";
        } catch (\Exception $e) {
            echo "Could not re-add constraint: " . $e->getMessage() . "\n";
        }
    }
};
