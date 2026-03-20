<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $fillable = ['contract_id', 'payment_method_id','invoice_id', 'payment_date', 'amount'];
    public $timestamps = false;

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class);
    }

}
