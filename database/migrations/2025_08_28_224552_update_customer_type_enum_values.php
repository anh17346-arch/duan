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
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing enum column
            $table->dropColumn('customer_type');
        });

        Schema::table('users', function (Blueprint $table) {
            // Recreate with new enum values
            $table->enum('customer_type', ['regular', 'vip', 'internal', 'frequent_canceller', 'potential'])->default('regular')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the column
            $table->dropColumn('customer_type');
        });

        Schema::table('users', function (Blueprint $table) {
            // Recreate with original enum values
            $table->enum('customer_type', ['regular', 'vip', 'internal', 'frequent_canceller'])->default('regular')->after('status');
        });
    }
};
