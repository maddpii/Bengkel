<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartAdminController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::query()
            ->orderBy('name')
            ->get();

        return view('admin.spareparts.index', compact('spareparts'));
    }

    public function create()
    {
        return view('admin.spareparts.form', [
            'sparepart' => new Sparepart(),
            'pageTitle' => 'Tambah Sparepart',
        ]);
    }

    public function store(Request $request)
    {
        Sparepart::create($this->validateSparepart($request));

        return redirect()
            ->route('admin.spareparts.index')
            ->with('success', 'Sparepart berhasil ditambahkan.');
    }

    public function edit(Sparepart $sparepart)
    {
        return view('admin.spareparts.form', [
            'sparepart' => $sparepart,
            'pageTitle' => 'Edit Sparepart',
        ]);
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $sparepart->update($this->validateSparepart($request, $sparepart->id));

        return redirect()
            ->route('admin.spareparts.index')
            ->with('success', 'Sparepart berhasil diperbarui.');
    }

    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();

        return redirect()
            ->route('admin.spareparts.index')
            ->with('success', 'Sparepart berhasil dihapus.');
    }

    protected function validateSparepart(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:spareparts,name,' . $ignoreId],
            'stock' => ['required', 'integer', 'min:0'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);
    }
}
