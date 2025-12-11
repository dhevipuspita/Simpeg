<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\DataInduk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PerizinanController extends Controller
{
    public function index()
    {
        $perizinan = Perizinan::with('dataInduk')
            ->orderBy('perizinanId', 'desc')
            ->get();

        $dataInduk = DataInduk::orderBy('nama')->get();

        return view('pages.perizinan.index', compact('perizinan', 'dataInduk'));
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'data_induk_id' => 'required|exists:data_induk,id',
                'tglSurat'      => 'required|date',
                'mulai_tanggal' => 'required|date',
                'akhir_tanggal' => 'required|date|after_or_equal:mulai_tanggal',
                'alasan'        => 'required|string',
            ]);

            // Hitung lama cuti (inklusi hari pertama & terakhir)
            $mulai = Carbon::parse($request->mulai_tanggal);
            $akhir = Carbon::parse($request->akhir_tanggal);
            $lamaCuti = $mulai->diffInDays($akhir) + 1;

            // SIMPAN CUTI
            Perizinan::create([
                'data_induk_id' => $request->data_induk_id,
                'tglSurat'      => $request->tglSurat,
                'mulai_tanggal' => $request->mulai_tanggal,
                'akhir_tanggal' => $request->akhir_tanggal,
                'lamaCuti'      => $lamaCuti,
                'alasan'        => $request->alasan,
                'isComback'     => false,
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
                'mulai_tanggal' => 'required|date',
                'akhir_tanggal' => 'required|date|after_or_equal:mulai_tanggal',
                'alasan'        => 'required|string',
            ]);

            $perizinan = Perizinan::findOrFail($id);

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
        $dataInduk = $perizinan->dataInduk;

        if ($dataInduk) {
            $dataInduk->update([
                'status_pegawai' => 'aktif',
            ]);
        }

        $perizinan->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data perizinan berhasil dihapus & status pegawai kembali AKTIF.',
        ], 200);
    }

    public function updateStatus($id)
    {
        $perizinan = Perizinan::findOrFail($id);

        $perizinan->update([
            'isComback' => true,
        ]);

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
