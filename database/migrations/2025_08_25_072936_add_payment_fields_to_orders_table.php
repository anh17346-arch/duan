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
        Schema::table('orders', function (Blueprint $table) {
            // Payment related fields
            $table->string('transaction_id')->nullable()->after('order_number');
            $table->timestamp('payment_confirmed_at')->nullable()->after('payment_status');
            $table->timestamp('payment_failed_at')->nullable()->after('payment_confirmed_at');
            $table->timestamp('cancelled_at')->nullable()->after('payment_failed_at');
            
            // Customer info fields (for guest checkout)
            $table->string('customer_name')->nullable()->after('user_id');
            $table->string('customer_phone')->nullable()->after('customer_name');
            $table->string('customer_email')->nullable()->after('customer_phone');
            
            // Order code for display
            $table->string('order_code')->nullable()->after('order_number');
            
            // Discount fields
            $table->decimal('discount_amount', 10, 0)->default(0)->after('subtotal');
            $table->string('promotion_code')->nullable()->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'transaction_id',
                'payment_confirmed_at',
                'payment_failed_at',
                'cancelled_at',
                'customer_name',
                'customer_phone',
                'customer_email',
                'order_code',
                'discount_amount',
                'promotion_code'
            ]);
        });
    }
};
