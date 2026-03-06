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
        Schema::create('service_details', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('room_id')->constrained('rooms');
            $table->decimal('old_index', 8, 2);
            $table->decimal('new_index', 8, 2);
            $table->date('reading_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_details');
    }
};
