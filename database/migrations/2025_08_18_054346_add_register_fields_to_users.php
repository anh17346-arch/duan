<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username', 20)->nullable()->after('id');
                $table->unique('username'); // unique + nullable OK
            }

            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name', 20)->nullable()->after('username');
            }

            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name', 20)->nullable()->after('first_name');
            }

            if (!Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['male','female','other'])->nullable()->after('last_name');
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address', 150)->nullable()->after('gender');
            }

            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 11)->nullable()->after('address');
                $table->unique('phone'); // unique + nullable
            }

            if (!Schema::hasColumn('users', 'terms_accepted_at')) {
                $table->timestamp('terms_accepted_at')->nullable()->after('remember_token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Xoá index trước rồi mới xoá cột
            if (Schema::hasColumn('users','username')) {
                $table->dropUnique('users_username_unique');
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users','phone')) {
                $table->dropUnique('users_phone_unique');
                $table->dropColumn('phone');
            }
            foreach (['first_name','last_name','gender','address','terms_accepted_at'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
