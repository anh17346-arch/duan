<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $t) {
            if (!Schema::hasColumn('products','slug')) {
                $t->string('slug')->unique()->after('name');
            }
            if (!Schema::hasColumn('products','brand')) {
                $t->string('brand')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('products','gender')) {
                $t->enum('gender', ['male','female','unisex'])->default('unisex')->after('brand');
            }
            if (!Schema::hasColumn('products','volume_ml')) {
                $t->unsignedSmallInteger('volume_ml')->default(50)->after('gender');
            }
            if (!Schema::hasColumn('products','price')) {
                $t->unsignedInteger('price')->default(0)->after('volume_ml');
            }
            if (!Schema::hasColumn('products','sale_price')) {
                $t->unsignedInteger('sale_price')->nullable()->after('price');
            }
            if (!Schema::hasColumn('products','stock')) {
                $t->unsignedInteger('stock')->default(0)->after('sale_price');
            }
            if (!Schema::hasColumn('products','status')) {
                $t->boolean('status')->default(true)->after('stock');
            }
            if (!Schema::hasColumn('products','main_image')) {
                $t->string('main_image')->nullable()->after('status');
            }
            if (!Schema::hasColumn('products','short_desc')) {
                $t->text('short_desc')->nullable()->after('main_image');
            }
            if (!Schema::hasColumn('products','description')) {
                $t->longText('description')->nullable()->after('short_desc');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $t) {
            foreach ([
                'description','short_desc','main_image','status','stock',
                'sale_price','price','volume_ml','gender','brand','slug'
            ] as $col) {
                if (Schema::hasColumn('products', $col)) {
                    $t->dropColumn($col);
                }
            }
        });
    }
};
