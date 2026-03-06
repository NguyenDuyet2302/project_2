<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * Khai báo các cột được phép lưu dữ liệu vào database.
     * Thiếu cái nào trong này là cái đó sẽ bị NULL khi lưu!
     */
    protected $fillable = [
        'contract_id',        // Kết nối với hợp đồng
        'electricity_index',  // Chỉ số điện
        'water_index',        // Chỉ số nước
        'service_fee',        // Phí dịch vụ
        'total_amount',       // Tổng tiền (được tính toán từ Controller)
        'month',              // Tháng xuất hóa đơn
        'status'              // 0: Chưa thu, 1: Đã thu
    ];

    /**
     * Mối quan hệ: Một hóa đơn thuộc về một Hợp đồng.
     * Từ đây ta có thể lấy thông tin: $invoice->contract->user->fullname
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
