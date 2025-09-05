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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('discount_percentage', 5, 2); // Ví dụ: 10.50 cho 10.5%
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->timestamps();
            
            // Validation constraints will be handled in the model
            
            // Indexes for better performance
            $table->index(['start_date', 'end_date']);
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
