<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function index()
    {
        $services = ServiceType::all();
        return view('admin.master.services', compact('services'));
    }

    public function update(Request $request, $id)
    {
        $serviceType = ServiceType::findOrFail($id);

        $validated = $request->validate([
            'nama_layanan'          => 'required|string|max:255',
            'biaya'                 => 'required|numeric|min:0',
            'biaya_tambahan_menu'   => 'required|numeric|min:0',
            'biaya_tambahan_outlet' => 'required|numeric|min:0',
            'deskripsi'             => 'nullable|string',
        ]);

        $serviceType->update($validated);

        return redirect()->back()->with('success', 'Tarif jenis layanan dan biaya tambahan berhasil diperbarui.');
    }
}
