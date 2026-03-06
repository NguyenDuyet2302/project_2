<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('image')->nullable(); // Thêm cột lưu ảnh
            $table->string('area')->nullable();  // Thêm cột diện tích
            $table->bigInteger('price');
            $table->tinyInteger('status')->default(1);
            $table->string('description')->nullable();
            $table->integer('max_people')->default(0);
            $table->timestamps(); // Nên có timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
