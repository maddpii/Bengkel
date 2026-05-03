<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionSparepart extends Model
{
    protected $table = 'transaction_spareparts';

    protected $fillable = [
        'transaction_id','sparepart_id','qty','price','purchase_price','subtotal'
    ];
}
