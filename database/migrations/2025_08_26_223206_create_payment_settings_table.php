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
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            
            // Ngân hàng
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_holder')->nullable();
            $table->string('bank_branch')->nullable();
            
            // Ví điện tử
            $table->string('momo_phone')->nullable();
            $table->string('momo_holder')->nullable();
            $table->string('zalopay_id')->nullable();
            $table->string('zalopay_holder')->nullable();
            $table->string('shopeepay_id')->nullable();
            $table->string('shopeepay_holder')->nullable();
            
            // API Keys
            $table->string('momo_partner_code')->nullable();
            $table->string('momo_access_key')->nullable();
            $table->text('momo_secret_key')->nullable();
            $table->string('momo_callback_url')->nullable();
            
            $table->string('zalopay_partner_code')->nullable();
            $table->string('zalopay_access_key')->nullable();
            $table->text('zalopay_secret_key')->nullable();
            $table->string('zalopay_callback_url')->nullable();
            
            // QR Code settings
            $table->string('qr_logo_path')->nullable();
            $table->string('qr_primary_color')->default('#000000');
            $table->string('qr_secondary_color')->default('#FFFFFF');
            $table->boolean('qr_show_logo')->default(true);
            $table->string('qr_style')->default('square'); // square, rounded, circle
            
            // Payment timeout
            $table->integer('payment_timeout_minutes')->default(15);
            
            // Status
            $table->boolean('bank_enabled')->default(true);
            $table->boolean('momo_enabled')->default(true);
            $table->boolean('zalopay_enabled')->default(true);
            $table->boolean('shopeepay_enabled')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
