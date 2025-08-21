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
        // nếu đã có 'name' dùng cho Họ và tên thì giữ nguyên
        $table->enum('gender', ['male','female','other'])->nullable()->after('name');
        $table->string('address', 150)->nullable()->after('gender');
        $table->string('phone', 20)->unique()->nullable()->after('address');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['gender','address','phone']);
    });
}

};
