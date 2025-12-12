<?php

namespace App\Http\Controllers;

use App\Models\Resign;
use App\Models\DataInduk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResignController extends Controller
{
    public function index()
    {
        $resign = Resign::with(['dataInduk', 'riwayat'])
            ->orderBy('resignId', 'desc')
            ->get();

        $dataInduk = DataInduk::orderBy('nama')->get();

        return view('pages.resign', compact('resign', 'dataInduk'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'data_induk_id'     => 'required|exists:data_induk,id',
                'tanggal_resign'    => 'required|date',
                'alasan_resign'     => 'required|string',
                'no_sk'             => 'required|string',
            ]);

            // SIMPAN RESIGN
            Resign::create([
                'data_induk_id'     => $request->data_induk_id,
                'tanggal_resign'    => $request->tanggal_resign,
                'alasan_resign'     => $request->alasan_resign,
                'no_sk'             => $request->no_sk,
                'isComback'         => false,
            ]);

            // UPDATE STATUS PEGAWAI MENJADI RESIGN
            $dataInduk = DataInduk::findOrFail($request->data_induk_id);
            $dataInduk->update([
                'status_pegawai' => 'resign',
            ]);

            return back()->with('success', 'Resign berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'tanggal_resign'=> 'required|date',
                'alasan_resign' => 'required|string',
                'no_sk'         => 'required|string',
            ]);

            $resign = Resign::findOrFail($id);
            $resign->update([
                'tanggal_resign'=> $request->tanggal_resign,
                'alasan_resign' => $request->alasan_resign,
                'no_sk'         => $request->no_sk,
            ]);

            return back()->with('success', 'Data resign berhasil diperbarui.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $resign = Resign::findOrFail($id);
        $resign->update([
            'isComback' => true,
        ]);

        $dataInduk = $resign->dataInduk;
        if ($dataInduk) {
            $dataInduk->update([
                'status_pegawai' => 'aktif',
            ]);
        }

        $resign->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data resign berhasil dihapus & status pegawai kembali AKTIF.',
        ], 200);
    }
}
