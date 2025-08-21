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
    Schema::create('registration_logs', function (Blueprint $t) {
        $t->id();
        $t->string('email')->index();
        $t->string('ip')->nullable();
        $t->string('user_agent', 255)->nullable();
        $t->string('status', 20); // success|failed
        $t->timestamps();
    });
}
public function down(): void { Schema::dropIfExists('registration_logs'); }

};
