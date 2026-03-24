<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'contracts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'room_id',
        'start_date',
        'end_date',
        'deposit',
        'status'
    ];

    public $timestamps = false;

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
