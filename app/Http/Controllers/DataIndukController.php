<?php

namespace App\Http\Controllers;

use App\Models\DataInduk;
use Illuminate\Http\Request;

class DataIndukController extends Controller
{
    // Tampilkan semua data induk
    public function index()
    {
        $dataInduk = DataInduk::all();
        return view('pages.system.data_induk', compact('dataInduk'));
    }

    // Simpan data induk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no'              => 'nullable|integer',
            'mulai_bertugas'  => 'nullable|date',
            'npa'             => 'nullable|string|max:255',
            'nama'            => 'required|string|max:255',
            'jenjang_jabatan' => 'nullable|string|max:255',
            'gol'             => 'nullable|string|max:50',
            'status'          => 'nullable|string|max:50',
        ]);

        try {
            DataInduk::create($validated);
            return redirect()->back()->with('success', 'Data induk berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data induk gagal ditambahkan.');
        }
    }

    // Update data induk
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'no'              => 'nullable|integer',
            'mulai_bertugas'  => 'nullable|date',
            'npa'             => 'nullable|string|max:255',
            'nama'            => 'required|string|max:255',
            'jenjang_jabatan' => 'nullable|string|max:255',
            'gol'             => 'nullable|string|max:50',
            'status'          => 'nullable|string|max:50',
        ]);

        try {
            $data = DataInduk::findOrFail($id);
            $data->update($validated);

            return redirect()->back()->with('success', 'Data induk berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data induk gagal diubah.');
        }
    }

    // Hapus data induk
    public function destroy($id)
    {
        try {
            $data = DataInduk::findOrFail($id);
            $data->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data induk berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data induk gagal dihapus.',
            ], 500);
        }
    }
}
