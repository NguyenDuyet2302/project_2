<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory;
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'unit_price', 'unit_name'];
    public $timestamps = false;
}
