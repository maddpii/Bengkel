<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'booking_id','mekanik_id','kasir_id',
        'total_service','total_sparepart','grand_total',
        'manual_service_name','manual_service_price','cashier_notes','processed_at','cashier_ready_at',
        'work_summary','work_recommendation','completed_at'
    ];

    public function booking(){
        return $this->belongsTo(Booking::class);
    }

    public function mekanik(){
        return $this->belongsTo(User::class, 'mekanik_id');
    }

    public function kasir(){
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function spareparts(){
        return $this->belongsToMany(Sparepart::class, 'transaction_spareparts')
                    ->withPivot('qty','price','purchase_price','subtotal')
                    ->withTimestamps();
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(ServiceReview::class);
    }
}
