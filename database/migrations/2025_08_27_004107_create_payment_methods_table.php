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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên hiển thị (VD: VNPay, PayPal, etc.)
            $table->string('code')->unique(); // Mã định danh (VD: vnpay, paypal, etc.)
            $table->string('type'); // Loại: ewallet, bank, card, crypto, etc.
            $table->text('description')->nullable(); // Mô tả
            $table->string('icon')->nullable(); // Icon (VD: vnpay, paypal, etc.)
            $table->string('color')->default('#3B82F6'); // Màu sắc
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->integer('sort_order')->default(0); // Thứ tự hiển thị
            
            // Cấu hình chung
            $table->json('config')->nullable(); // Cấu hình linh hoạt (API keys, settings, etc.)
            
            // Thông tin hiển thị cho khách hàng
            $table->string('account_identifier')->nullable(); // Số tài khoản/ID
            $table->string('account_holder')->nullable(); // Tên chủ tài khoản
            $table->text('instructions')->nullable(); // Hướng dẫn thanh toán
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
