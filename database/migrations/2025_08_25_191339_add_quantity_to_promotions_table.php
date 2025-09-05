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
        Schema::table('promotions', function (Blueprint $table) {
            $table->integer('quantity')->default(0)->after('discount_percentage')->comment('Số lượng sản phẩm được khuyến mãi');
            $table->integer('sold_quantity')->default(0)->after('quantity')->comment('Số lượng đã bán trong khuyến mãi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'sold_quantity']);
        });
    }
};
