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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            // Kết nối với hợp đồng (để biết phòng nào, khách nào)
            $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade');

            // Thông tin hóa đơn
            $table->string('month', 7); // Lưu kiểu "2026-03"
            $table->integer('electricity_index')->default(0); // Số điện
            $table->integer('water_index')->default(0);       // Số nước
            $table->integer('service_fee')->default(0);       // Phí dịch vụ (rác, wifi...)

            // Tổng tiền (Sửa lỗi "total mount" thành "total_amount")
            $table->decimal('total_amount', 15, 2)->default(0);

            // Trạng thái: 0: Chưa thanh toán, 1: Đã thanh toán
            $table->tinyInteger('status')->default(0);

            // Bắt buộc phải có timestamps để Laravel không báo lỗi created_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
