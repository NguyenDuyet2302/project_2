<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'contract_id',
        'electricity_index',
        'water_index',
        'service_fee',
        'total_amount',
        'month',
        'status'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
    public function invoiceDetails() {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }
}
