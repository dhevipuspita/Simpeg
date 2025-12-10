<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\Staff;
use App\Models\DataInduk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PerizinanController extends Controller
{
    public function index()
    {
        // ambil semua staff untuk dropdown
        $staff = Staff::orderBy('name')->get();

        // ambil semua perizinan + relasi staff & data_induk
        $perizinan = Perizinan::with(['staff', 'dataInduk'])
            ->orderBy('perizinanId', 'desc')
            ->get();

        // kirim KEDUANYA ke view
        return view('pages.perizinan.index', compact('staff', 'perizinan'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'staffId'       => 'required|exists:staff,staffId',
                'data_induk_id' => 'required|exists:data_induk,id',
                'tglSurat'      => 'required|date',
                'mulai_tanggal' => 'required|date',
                'akhir_tanggal' => 'required|date|after_or_equal:mulai_tanggal',
                'lamaCuti'      => 'nullable|integer|min:1',
                'alasan'        => 'nullable|string',
            ]);

            // Hitung lama cuti otomatis
            $mulai = Carbon::parse($request->mulai_tanggal);
            $akhir = Carbon::parse($request->akhir_tanggal);
            $lamaCuti = $mulai->diffInDays($akhir) + 1;

            // SIMPAN CUTI
            Perizinan::create([
                'staffId'       => $request->staffId,
                'data_induk_id' => $request->data_induk_id,
                'tglSurat'      => $request->tglSurat,
                'mulai_tanggal' => $request->mulai_tanggal,
                'akhir_tanggal' => $request->akhir_tanggal,
                'lamaCuti'      => $lamaCuti,
                'alasan'        => $request->alasan,
                'isComback'     => false, // default
            ]);

            // UPDATE STATUS PEGAWAI MENJADI CUTI
            $dataInduk = DataInduk::findOrFail($request->data_induk_id);
            $dataInduk->update([
                'status_pegawai' => 'cuti',
            ]);

            return back()->with('success', 'Cuti berhasil ditambahkan & status pegawai berubah menjadi CUTI.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'tglSurat'      => 'required|date',
                'mulai_hari'    => 'required|string',
                'mulai_tanggal' => 'required|date',
                'akhir_hari'    => 'required|string',
                'akhir_tanggal' => 'required|date|after_or_equal:mulai_tanggal',
                'alasan'        => 'nullable|string',
            ]);

            $perizinan = Perizinan::findOrFail($id);

            // Hitung ulang lama cuti
            $mulai = Carbon::parse($request->mulai_tanggal);
            $akhir = Carbon::parse($request->akhir_tanggal);
            $lamaCuti = $mulai->diffInDays($akhir) + 1;

            $perizinan->update([
                'tglSurat'      => $request->tglSurat,
                'mulai_tanggal' => $request->mulai_tanggal,
                'akhir_tanggal' => $request->akhir_tanggal,
                'lamaCuti'      => $lamaCuti,
                'alasan'        => $request->alasan,
            ]);

            return back()->with('success', 'Data cuti berhasil diperbarui.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $perizinan = Perizinan::findOrFail($id);

        // Jika cuti dihapus, status pegawai KEMBALI AKTIF
        $dataInduk = $perizinan->dataInduk;
        $dataInduk->update([
            'status_pegawai' => 'aktif'
        ]);

        $perizinan->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data perizinan berhasil dihapus & status pegawai kembali AKTIF.',
        ], 200);
    }

    public function updateStatus($id)
    {
        $perizinan = Perizinan::findOrFail($id);

        // Update perizinan
        $perizinan->update([
            'isComback' => true,
        ]);

        // UPDATE status pegawai → AKTIF
        $dataInduk = $perizinan->dataInduk;
        if ($dataInduk) {
            $dataInduk->update([
                'status_pegawai' => 'aktif',
            ]);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Pegawai sudah kembali & status diperbarui menjadi AKTIF.',
        ], 200);
    }
}
