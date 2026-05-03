<?php

namespace App\Http\Controllers;

use App\Models\JenisVehicle;
use Illuminate\Http\Request;

class VehicleAdminController extends Controller
{
    public function index()
    {
        $vehicles = JenisVehicle::with('user')->latest()->get();

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.form', [
            'vehicle' => new JenisVehicle(),
            'pageTitle' => 'Tambah Kendaraan',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateVehicle($request);
        $validated['user_id'] = auth()->id();

        JenisVehicle::create($validated);

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    public function edit(JenisVehicle $vehicle)
    {
        return view('admin.vehicles.form', [
            'vehicle' => $vehicle,
            'pageTitle' => 'Edit Kendaraan',
        ]);
    }

    public function update(Request $request, JenisVehicle $vehicle)
    {
        $vehicle->update($this->validateVehicle($request, $vehicle->id));

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy(JenisVehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Data kendaraan berhasil dihapus.');
    }

    protected function validateVehicle(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'brand' => ['required', 'string', 'max:50', 'unique:jenis_vehicles,brand,' . $ignoreId],
        ]);
    }
}
