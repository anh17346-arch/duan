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
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('notification_id')->constrained()->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->boolean('is_sent_email')->default(false);
            $table->timestamp('email_sent_at')->nullable();
            $table->boolean('is_sent_sms')->default(false);
            $table->timestamp('sms_sent_at')->nullable();
            $table->timestamps();
            
            // Unique constraint to prevent duplicate notifications for same user
            $table->unique(['user_id', 'notification_id']);
            
            // Indexes for better performance
            $table->index(['user_id', 'is_read']);
            $table->index('is_sent_email');
            $table->index('is_sent_sms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};
