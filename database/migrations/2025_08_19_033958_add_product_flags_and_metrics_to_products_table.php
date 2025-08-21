<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('status');
            $table->boolean('is_on_sale')->default(false)->after('is_featured');
            $table->boolean('is_best_seller')->default(false)->after('is_on_sale');
            $table->boolean('is_new')->default(false)->after('is_best_seller');
            $table->timestamp('sale_start_date')->nullable()->after('is_new');
            $table->timestamp('sale_end_date')->nullable()->after('sale_start_date');
            $table->unsignedInteger('views_count')->default(0)->after('sale_end_date');
            $table->unsignedInteger('sold_count')->default(0)->after('views_count');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_featured',
                'is_on_sale', 
                'is_best_seller',
                'is_new',
                'sale_start_date',
                'sale_end_date',
                'views_count',
                'sold_count'
            ]);
        });
    }
};
