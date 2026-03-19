<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceDetailFactory> */
    use HasFactory;
    protected $table = 'service_details';
    protected $fillable = ['service_id', 'room_id', 'old_index', 'new_index', 'created_at', 'updated_at'];
    public $incrementing = false;
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function room(){
        return $this->belongsTo(Room::class);
    }

}
