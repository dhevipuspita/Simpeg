<?php

namespace App\Http\Controllers;

use App\Models\Resign;
use App\Models\DataInduk;
use Illuminate\Http\Request;

class ResignController extends Controller
{
    // =====================================================
    // INDEX
    // =====================================================
    public function index(Request $request)
    {
        $resign = Resign::with('dataInduk')->get();

        // Ambil DataInduk
        $dataInduk = DataInduk::all()->map(function ($d) {
            return [
                'id' => 'di-' . $d->id,
                'nama' => $d->nama,
                'nik' => $d->nik,
                'npa' => $d->npa,
                'jabatan' => $d->jabatan,
                'gol' => $d->gol,
                'jenjang' => $d->jenjang,
                'ttl' => $d->ttl,
                'alamat' => $d->alamat,
                'source' => 'data_induk'
            ];
        });

        // Gabung untuk dropdown
        $pegawai = $dataInduk;

        // Buka modal jika datang dari data induk
        $openCreateModal = false;
        $selectedPegawai = null;

        if ($request->has('data_induk_id')) {
            $openCreateModal = true;
            $selectedPegawai = DataInduk::find($request->data_induk_id);
        }

        return view('pages.resign', compact(
            'resign',
            'pegawai',
            'openCreateModal',
            'selectedPegawai'
        ));
    }

    // =====================================================
    // CREATE → Redirect (agar modal terbuka)
    // =====================================================
    public function create(Request $request)
    {
        return redirect()->route('resign.index', [
            'data_induk_id' => $request->data_induk_id
        ]);
    }

    // =====================================================
    // STORE RESIGN
    // =====================================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'data_induk_id' => 'nullable',
            'source' => 'required|string',
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:255',
            'npa' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'gol' => 'nullable|string|max:50',
            'jenjang' => 'nullable|string|max:255',
            'ttl' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'tanggal_resign' => 'nullable|date',
            'alasan_resign' => 'nullable|string',
        ]);

        // Perbaiki id agar tidak tersimpan "di-1"
        if ($validated['source'] === 'data_induk') {
            $validated['data_induk_id'] = str_replace("di-", "", $validated['data_induk_id']);
        } else {
            $validated['data_induk_id'] = null;
        }

        try {

            // Simpan resign
            Resign::create($validated);

            // Jika dari Data Induk → ubah status pegawai
            if ($validated['source'] === 'data_induk') {
                DataInduk::where('id', $validated['data_induk_id'])
                    ->update(['status_pegawai' => 'resign']);
            }

            return redirect()->route('resign.index')->with('success', 'Data resign berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // =====================================================
    // UPDATE RESIGN
    // =====================================================
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:255',
            'npa' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'gol' => 'nullable|string|max:50',
            'jenjang' => 'nullable|string|max:255',
            'ttl' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'tanggal_resign' => 'nullable|date',
            'alasan_resign' => 'nullable|string',
        ]);

        try {
            Resign::findOrFail($id)->update($validated);

            return back()->with('success', 'Data resign berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Data resign gagal diperbarui.');
        }
    }

    // =====================================================
    // DELETE RESIGN
    // =====================================================
    public function destroy($id)
    {
        try {
            $resign = Resign::findOrFail($id);

            // Jika berasal dari data induk → aktifkan kembali pegawai
            if ($resign->source === 'data_induk') {
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
