<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'service_name','price','estimated_time'
    ];

    public function bookings(){
        return $this->belongsToMany(Booking::class, 'booking_services')
                    ->withPivot('price')
                    ->withTimestamps();
    }
}
