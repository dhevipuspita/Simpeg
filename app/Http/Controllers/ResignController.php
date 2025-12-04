<?php

namespace App\Http\Controllers;

use App\Models\Resign;
use App\Models\DataInduk;
use Illuminate\Http\Request;

class ResignController extends Controller
{
    // ======================
    //  TAMPILKAN SEMUA RESIGN
    // ======================
    public function index()
    {
        $resign = Resign::with('dataInduk')->get();
        return view('pages.resign', compact('resign'));
    }

    // ======================
    //  FORM RESIGN
    //  Bisa berasal dari Data Induk
    // ======================
    public function create(Request $request)
    {
        $dataIndukId = $request->query('data_induk_id');
        $dataInduk = null;

        if ($dataIndukId) {
            $dataInduk = DataInduk::findOrFail($dataIndukId);
        }

        return view('pages.resign_form', compact('dataInduk'));
    }

    // ======================
    //  SIMPAN RESIGN
    // ======================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'data_induk_id' => 'nullable|exists:data_induk,id',
            'no' => 'nullable|integer',
            'mulai_bertugas' => 'nullable|date',
            'npa' => 'nullable|string|max:255',
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'gol' => 'nullable|string|max:50',
            'jenjang' => 'nullable|string|max:255',
            'ttl' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'pendidikan' => 'nullable|string|max:255',
            'tanggal_resign' => 'nullable|date',
            'alasan_resign' => 'nullable|string',
            'nik' => 'nullable|string|max:255',
            'status_kepegawaian' => 'nullable|string|max:255',
            'tgl' => 'nullable|string',
            'bln' => 'nullable|string',
            'thn' => 'nullable|string',
            'no_sk' => 'nullable|string|max:255',
        ]);

        try {
            // Simpan ke tabel resign
            $resign = Resign::create($validated);

            // Jika berasal dari Data Induk → Update Status Pegawai
            if (!empty($validated['data_induk_id'])) {
                DataInduk::where('id', $validated['data_induk_id'])
                    ->update(['status_pegawai' => 'resign']);
            }

            return redirect()
                ->route('resign.index')
                ->with('success', 'Data resign berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ======================
    //  UPDATE DATA RESIGN
    // ======================
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'no' => 'nullable|integer',
            'mulai_bertugas' => 'nullable|date',
            'npa' => 'nullable|string|max:255',
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'gol' => 'nullable|string|max:50',
            'jenjang' => 'nullable|string|max:255',
            'ttl' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'pendidikan' => 'nullable|string|max:255',
            'tanggal_resign' => 'nullable|date',
            'alasan_resign' => 'nullable|string',
            'nik' => 'nullable|string|max:255',
            'status_kepegawaian' => 'nullable|string|max:255',
            'tgl' => 'nullable|string',
            'bln' => 'nullable|string',
            'thn' => 'nullable|string',
            'no_sk' => 'nullable|string|max:255',
        ]);

        try {
            $resign = Resign::findOrFail($id);
            $resign->update($validated);

            return redirect()
                ->back()
                ->with('success', 'Data resign berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Data resign gagal diubah.');
        }
    }

    // ======================
    //  HAPUS DATA RESIGN
    // ======================
    public function destroy($id)
    {
        try {
            $resign = Resign::findOrFail($id);
            $resign->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data resign berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data resign gagal dihapus.',
            ], 500);
        }
    }
}
