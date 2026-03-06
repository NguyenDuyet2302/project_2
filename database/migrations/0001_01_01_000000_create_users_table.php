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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname'); // Tên đầy đủ
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 10)->unique();
            $table->string('id_card', 12)->unique(); // Căn cước công dân
            $table->string('address');

            // Chỉnh lại một chút: Dùng số nguyên và đặt mặc định là 0 (Khách)
            $table->tinyInteger('role')->default(0);

            // Hai dòng này của Laravel giúp hệ thống chạy ổn định hơn
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
