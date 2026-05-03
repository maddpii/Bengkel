<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id','vehicle_id','customer_vehicle_model','customer_license_plate',
        'customer_vehicle_color','booking_date','booking_time','status','complaint'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function services(){
        return $this->belongsToMany(Service::class, 'booking_services')
                    ->withPivot('price')
                    ->withTimestamps();
    }

    public function transaction(){
        return $this->hasOne(Transaction::class);
    }
}
