<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;
    protected $table = 'rooms';
    protected $primaryKey = 'id';
    protected $fillable = ['number', 'price', 'status', 'description', 'max_people'];
    public $timestamps = false;

    public function contacts(){
        return $this->hasMany(Contract::class);
    }
    public function serviceDetails(){
        return $this->hasMany(ServiceDetail::class);
    }
}
