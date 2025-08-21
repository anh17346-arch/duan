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
        Schema::table('products', function (Blueprint $table) {
            // Add missing fields safely
            if (!Schema::hasColumn('products', 'name_en')) {
                $table->string('name_en')->nullable()->after('name');
            }
            if (!Schema::hasColumn('products', 'slug')) {
                $table->string('slug')->nullable()->after('name_en');
            }
            if (!Schema::hasColumn('products', 'short_desc')) {
                $table->text('short_desc')->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'description_en')) {
                $table->text('description_en')->nullable()->after('short_desc');
            }
            if (!Schema::hasColumn('products', 'main_image')) {
                $table->string('main_image')->nullable()->after('description_en');
            }
            if (!Schema::hasColumn('products', 'sale_price')) {
                $table->decimal('sale_price', 10, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('products', 'volume_ml')) {
                $table->integer('volume_ml')->default(50)->after('sale_price');
            }
            if (!Schema::hasColumn('products', 'brand')) {
                $table->string('brand')->nullable()->after('volume_ml');
            }
            if (!Schema::hasColumn('products', 'gender')) {
                $table->enum('gender', ['male', 'female', 'unisex'])->default('unisex')->after('brand');
            }
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('gender');
            }
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->nullable()->after('stock');
            }
            if (!Schema::hasColumn('products', 'status')) {
                $table->boolean('status')->default(true)->after('sku');
            }
            if (!Schema::hasColumn('products', 'origin')) {
                $table->string('origin')->nullable()->after('status');
            }
            if (!Schema::hasColumn('products', 'concentration')) {
                $table->enum('concentration', ['EDC', 'EDT', 'EDP', 'Parfum', 'Extrait'])->default('EDT')->after('origin');
            }
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('concentration');
            }
            if (!Schema::hasColumn('products', 'is_on_sale')) {
                $table->boolean('is_on_sale')->default(false)->after('is_featured');
            }
            if (!Schema::hasColumn('products', 'is_best_seller')) {
                $table->boolean('is_best_seller')->default(false)->after('is_on_sale');
            }
            if (!Schema::hasColumn('products', 'is_new')) {
                $table->boolean('is_new')->default(false)->after('is_best_seller');
            }
            if (!Schema::hasColumn('products', 'sale_start_date')) {
                $table->timestamp('sale_start_date')->nullable()->after('is_new');
            }
            if (!Schema::hasColumn('products', 'sale_end_date')) {
                $table->timestamp('sale_end_date')->nullable()->after('sale_start_date');
            }
            if (!Schema::hasColumn('products', 'views_count')) {
                $table->integer('views_count')->default(0)->after('sale_end_date');
            }
            if (!Schema::hasColumn('products', 'sold_count')) {
                $table->integer('sold_count')->default(0)->after('views_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove added fields safely
            $columnsToDrop = [
                'name_en', 'slug', 'short_desc', 'description_en', 'main_image',
                'sale_price', 'volume_ml', 'brand', 'gender', 'stock', 'sku',
                'status', 'origin', 'concentration', 'is_featured', 'is_on_sale',
                'is_best_seller', 'is_new', 'sale_start_date', 'sale_end_date',
                'views_count', 'sold_count'
            ];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
