<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    protected $fillable = [
        'name','stock','price','purchase_price'
    ];

    public function transactions(){
        return $this->belongsToMany(Transaction::class, 'transaction_spareparts')
                    ->withPivot('qty','price','purchase_price','subtotal')
                    ->withTimestamps();
    }
}
