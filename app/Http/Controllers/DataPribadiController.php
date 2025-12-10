<?php

namespace App\Http\Controllers;

use App\Models\DataInduk;
use Illuminate\Http\Request;

class DataPribadiController extends Controller
{
    // Tampilkan halaman Data Pribadi
    public function index()
    {
        $dataInduk = DataInduk::all();
        return view('pages.system.data_pribadi', compact('dataInduk'));
    }

    // Update data pribadi
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'ttl'               => 'nullable|string|max:255',
            'no_hp'             => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
            'suami_istri'       => 'nullable|string|max:255',
            'alamat'            => 'nullable|string',
            'email'             => 'nullable|email|max:255',
            'keterangan'        => 'nullable|string',
        ]);

        try {
            $data = DataInduk::findOrFail($id);
            $data->update($validated);

            return redirect()->back()->with('success', 'Data pribadi berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data pribadi gagal diubah. Error: ' . $e->getMessage());
        }
    }
}
