<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory;
    protected $table = 'service_details';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'room_id',
        'service_id',
        'old_index',
        'new_index',
        'reading_date'
    ];

    public function room() {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function service() {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
