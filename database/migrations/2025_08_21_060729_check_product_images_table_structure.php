<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kiểm tra và đảm bảo bảng product_images có cấu trúc đúng
        if (Schema::hasTable('product_images')) {
            Schema::table('product_images', function (Blueprint $table) {
                // Đảm bảo các cột cần thiết tồn tại
                if (!Schema::hasColumn('product_images', 'image_path')) {
                    $table->string('image_path');
                }
                if (!Schema::hasColumn('product_images', 'alt_text')) {
                    $table->string('alt_text')->nullable();
                }
                if (!Schema::hasColumn('product_images', 'sort_order')) {
                    $table->integer('sort_order')->default(0);
                }
                if (!Schema::hasColumn('product_images', 'is_primary')) {
                    $table->boolean('is_primary')->default(false);
                }
                
                // Đảm bảo có index cho performance
                if (!$this->hasIndex('product_images', 'product_images_product_id_index')) {
                    $table->index('product_id');
                }
                if (!$this->hasIndex('product_images', 'product_images_is_primary_index')) {
                    $table->index('is_primary');
                }
                if (!$this->hasIndex('product_images', 'product_images_sort_order_index')) {
                    $table->index('sort_order');
                }
            });
        } else {
            // Tạo bảng nếu chưa tồn tại
            Schema::create('product_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('image_path');
                $table->string('alt_text')->nullable();
                $table->integer('sort_order')->default(0);
                $table->boolean('is_primary')->default(false);
                $table->timestamps();
                
                // Indexes
                $table->index('product_id');
                $table->index('is_primary');
                $table->index('sort_order');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Không làm gì trong down() để tránh mất dữ liệu
    }

    /**
     * Check if an index exists on a table
     */
    private function hasIndex(string $table, string $index): bool
    {
        try {
            $indexes = Schema::getConnection()->getDoctrineSchemaManager()
                ->listTableIndexes($table);
            return array_key_exists($index, $indexes);
        } catch (\Exception $e) {
            return false;
        }
    }
};