<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $fillable = ['contract_id','billing_date', 'total_amount', 'status'];
    public $timestamps = false;

    public function contract(){
        return $this->belongsTo(Contract::class);
    }
    public function payment(){
        return $this->hasMany(Payment::class);
    }
}
