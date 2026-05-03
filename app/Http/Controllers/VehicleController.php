<?php

namespace App\Http\Controllers;

use App\Models\JenisVehicle;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = JenisVehicle::latest()->get();

        return view('vehicles.index', compact('vehicles'));
    }

    public function show($id)
    {
        $vehicle = JenisVehicle::findOrFail($id);

        return view('vehicles.show', compact('vehicle'));
    }
}
