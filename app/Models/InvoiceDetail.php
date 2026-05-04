<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $table = 'invoice_details';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'invoice_id',
        'service_id',
        'old_index',
        'new_index',
        'quantity',
        'price',
        'amount'
    ];
    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
    public function service() {
        return $this->belongsTo(Service::class, 'service_id');
    }


}
