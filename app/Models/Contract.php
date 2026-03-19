<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    /** @use HasFactory<\Database\Factories\ContractFactory> */
    use HasFactory;
    protected $table = 'contracts';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'room_id', 'start_date', 'end_date', 'deposit', 'status'];
    public $timestamps = false;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }

}
