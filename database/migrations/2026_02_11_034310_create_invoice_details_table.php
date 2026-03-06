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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->foreignId('invoice_id')->constrained('invoices');
            $table->foreignId('service_id')->constrained('services');
            $table->decimal('quantity', 8, 2);
            $table->decimal('price', 8, 2);
            $table->decimal('old_index', 8, 2);
            $table->decimal('new_index', 8, 2);
            $table->decimal('amount', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
