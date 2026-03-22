<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceDetailFactory> */
    use HasFactory;
    protected $table = 'invoice_details';
    protected $fillable = ['invoice_id', 'service_id', 'old_index', 'new_index', 'quantity', 'price', 'amount'];
    public $timestamps = false;

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
