<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisVehicle extends Model
{
    protected $table = 'jenis_vehicles';

    protected $fillable = [
        'user_id',
        'brand',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
