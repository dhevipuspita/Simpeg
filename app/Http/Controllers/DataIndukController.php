<?php

namespace App\Http\Controllers;

use App\Models\DataInduk;
use Illuminate\Http\Request;
use App\Imports\DataIndukImport;
use Maatwebsite\Excel\Facades\Excel;


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
            'nama'              => 'required|string|max:255',
            'nik'               => 'nullable|string|max:255|unique:data_induk,nik',
            'npa'               => 'nullable|string|max:255',
            'jabatan'           => 'nullable|string|max:225',
            'gol'               => 'nullable|string|max:50',
            'jenjang'           => 'nullable|string|max:255',
            'mulai_bertugas'    => 'nullable|date',
            // DATA PRIBADI
            'ttl'               => 'nullable|string|max:255',
            'no_hp'             => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
            'suami_istri'       => 'nullable|string|max:255',
            'alamat'            => 'nullable|string',
            'email'             => 'nullable|email|max:255',
            'keterangan'        => 'nullable|string',
        ]);

        try {
            DataInduk::create($validated);
            return redirect()->back()->with('success', 'Data induk berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data induk gagal ditambahkan. Error: ' . $e->getMessage());
        }
    }

    // Update data induk
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            'nik'               => 'nullable|string|max:255|unique:data_induk,nik,' . $id,
            'npa'               => 'nullable|string|max:255',
            'jabatan'           => 'nullable|string|max:225',
            'gol'               => 'nullable|string|max:50',
            'jenjang'           => 'nullable|string|max:255',
            'mulai_bertugas'    => 'nullable|date',
            // DATA PRIBADI
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

            return redirect()->back()->with('success', 'Data induk berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data induk gagal diubah. Error: ' . $e->getMessage());
        }
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new DataIndukImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data Induk berhasil diimport');
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
