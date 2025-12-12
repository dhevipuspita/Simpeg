<?php

namespace App\Http\Controllers;

use App\Models\DataInduk;
use Illuminate\Http\Request;
use App\Imports\DataIndukImport;
use App\Models\JenisGolongan;
use App\Models\Jenjang;
use Maatwebsite\Excel\Facades\Excel;

class DataIndukController extends Controller
{
   public function index()
    {
        $dataInduk = DataInduk::orderBy('id', 'asc')->get();
        $jenis_golongan = JenisGolongan::orderBy('jenis')->get();
        $jenjang = Jenjang::orderBy('nama_jenjang')->get();

        return view('pages.system.data_induk', compact('dataInduk', 'jenis_golongan', 'jenjang'));
    }

    // Simpan data induk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mulai_bertugas'   => 'nullable|date',
            'npa'              => 'nullable|string|max:255',
            'nama'             => 'required|string|max:255',
            'jenjang'          => 'nullable|string|max:255',
            'jabatan'          => 'nullable|string|max:225',
            'gol'              => 'nullable|string|max:50',
            'status'           => 'nullable|string|max:50',
            'status_pegawai'   => 'nullable|string|max:50',
            'birthPlace'       => 'nullable|string|max:255',
            'birthDate'        => 'nullable|date',
            'nik'              => 'nullable|string|max:50',
            'noHp'             => 'nullable|string|max:20',
            'statusPerkawinan' => 'nullable|string|max:50',
            'suami_istri'      => 'nullable|string|max:255',
            'alamat'           => 'nullable|string',
            'email'            => 'nullable|email|max:255',
            'keterangan'       => 'nullable|string',
        ]);

        try {
            DataInduk::create($validated);
            return redirect()->back()->with('success', 'Data induk berhasil ditambahkan.');
        } catch (\Exception $e) {
            // kalau mau debug:
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'Data induk gagal ditambahkan.');
        }
    }

    // Update data induk
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'mulai_bertugas'   => 'nullable|date',
            'npa'              => 'nullable|string|max:255',
            'nama'             => 'required|string|max:255',
            'jenjang'          => 'nullable|string|max:255',
            'jabatan'          => 'nullable|string|max:225',
            'gol'              => 'nullable|string|max:50',
            'status'           => 'nullable|string|max:50',
            'status_pegawai'   => 'nullable|string|max:50',

            // biodata (harus ditambah kalau mau ikut di-update)
            'birthPlace'       => 'nullable|string|max:255',
            'birthDate'        => 'nullable|date',
            'nik'              => 'nullable|string|max:50',
            'noHp'             => 'nullable|string|max:20',
            'statusPerkawinan' => 'nullable|string|max:50',
            'suami_istri'      => 'nullable|string|max:255',
            'alamat'           => 'nullable|string',
            'email'            => 'nullable|email|max:255',
            'keterangan'       => 'nullable|string',
        ]);

        $data = DataInduk::findOrFail($id);
        $data->update($validated);

        return redirect()->back()->with('success', 'Data induk berhasil diubah.');
    }


    // Import excel
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
