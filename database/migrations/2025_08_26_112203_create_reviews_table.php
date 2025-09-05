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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->decimal('rating', 2, 1)->comment('0.5-5.0 stars');
            $table->text('comment')->nullable();
            $table->boolean('is_verified')->default(false)->comment('Verified purchase');
            $table->boolean('is_approved')->default(true)->comment('Admin approval');
            $table->boolean('is_edited')->default(false)->comment('Has been edited');
            $table->timestamp('edited_at')->nullable();
            $table->timestamps();
            
            // Ensure one review per user per product per order
            $table->unique(['user_id', 'product_id', 'order_id'], 'unique_user_product_order_review');
            
            // Indexes for performance
            $table->index(['product_id', 'rating']);
            $table->index(['user_id', 'created_at']);
            $table->index(['is_approved', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
