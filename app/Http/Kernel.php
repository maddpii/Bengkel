<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = DB::table('vehicles')
            ->join('users', 'vehicles.user_id', '=', 'users.id')
            ->select('vehicles.*', 'users.name', 'users.email')
            ->get();

        return view('admin.vehicles.index', compact('vehicles'));
    }
}

// ...existing code...