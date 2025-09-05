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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // customer, admin
            $table->string('category'); // order, payment, promotion, system, marketing, security
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable(); // bell, shopping-cart, credit-card, gift, alert, etc.
            $table->string('color')->default('blue'); // blue, green, red, yellow, purple, etc.
            $table->json('data')->nullable(); // Additional data like order_id, amount, etc.
            $table->string('action_url')->nullable(); // URL to redirect when clicked
            $table->string('action_text')->nullable(); // Text for action button
            $table->boolean('is_read')->default(false);
            $table->boolean('is_important')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamp('expires_at')->nullable(); // For time-sensitive notifications
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['type', 'is_read']);
            $table->index(['category', 'is_read']);
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
