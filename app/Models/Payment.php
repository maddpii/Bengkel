<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id','payment_date','amount_paid',
        'payment_method','payment_status','payer_name','payer_notes','submitted_at',
        'midtrans_order_id','midtrans_transaction_id','midtrans_status','snap_token','midtrans_response',
        'payment_ready_notified_at','invoice_emailed_at'
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
            'submitted_at' => 'datetime',
            'payment_ready_notified_at' => 'datetime',
            'invoice_emailed_at' => 'datetime',
            'midtrans_response' => 'array',
        ];
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }
}
