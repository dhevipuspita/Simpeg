<?php

namespace App\Http\Controllers;

use App\Models\Resign;
use App\Models\DataInduk;
use Illuminate\Http\Request;

class ResignController extends Controller
{
    // =========================
    //  INDEX (LIST RESIGN)
    // =========================
    public function index(Request $request)
    {
        $resign = Resign::with('dataInduk')->get();

        // Jika tombol "Resign" diklik dari Data Induk
        $openCreateModal = false;
        $dataInduk = null;

        if ($request->has('data_induk_id')) {
            $openCreateModal = true;
            $dataInduk = DataInduk::find($request->data_induk_id);
        }

        return view('pages.resign', [
            'resign' => $resign,
            'openCreateModal' => $openCreateModal,
            'dataInduk' => $dataInduk
        ]);
    }
    // =========================

    //  CREATE (REDIRECT KE INDEX)
    // =========================
    public function create(Request $request)
    {
        return redirect()->route('resign.index', [
            'data_induk_id' => $request->data_induk_id
        ]);
    }
    // =========================
    //  STORE (TAMBAH RESIGN)
    // =========================
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
            // Simpan resign
            $resign = Resign::create($validated);

            // Jika resign berasal dari Data Induk
            if (!empty($validated['data_induk_id'])) {

                $dataInduk = DataInduk::find($validated['data_induk_id']);

                // Update status pegawai menjadi resign
                $dataInduk->update([
                    'status_pegawai' => 'resign'
                ]);
            }

            return redirect()
                ->route('resign.index')
                ->with('success', 'Data resign berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // =========================
    //  UPDATE RESIGN
    // =========================
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

            return back()->with('success', 'Data resign berhasil diubah.');
        } catch (\Exception $e) {
            return back()->with('error', 'Data resign gagal diubah.');
        }
    }



    // =========================
    //  DELETE RESIGN
    // =========================
    public function destroy($id)
    {
        try {
            $resign = Resign::findOrFail($id);

            // Jika resign dihapus → status pegawai kembali aktif
            if ($resign->data_induk_id) {
                DataInduk::where('id', $resign->data_induk_id)
                    ->update(['status_pegawai' => 'aktif']);
            }

            $resign->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data resign berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data resign gagal dihapus.'
            ], 500);
        }
    }
}
