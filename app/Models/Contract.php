<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'contracts';
    protected $primaryKey = 'id';

    // Bổ sung user_id và room_id vào đây để Laravel cho phép lưu dữ liệu
    protected $fillable = [
        'user_id',    // Phải có cái này
        'room_id',    // Và cái này
        'start_date',
        'end_date',
        'deposit',
        'status'
    ];

    // Nếu database của bạn có cột created_at và updated_at thì để true,
    // còn nếu không có thì để false như cũ của bạn nhé.
    public $timestamps = false;

    /**
     * Mối quan hệ: Một hợp đồng thuộc về một Khách thuê (User)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mối quan hệ: Một hợp đồng thuộc về một Phòng (Room)
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
