<?php

namespace App\Http\Controllers;

use App\Models\JenisGolongan;
use App\Models\Riwayat;
use App\Models\RiwayatGolongan;
use Illuminate\Http\Request;

// return view('pages.system.riwayat_gol', compact('riwayat', 'jenis_golongan'));

class RiwayatGolonganController extends Controller
{
    public function index()
    {
        return redirect()->route('riwayat.index');
    }    
    
    public function template()
    {
        return redirect()->route('riwayat.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'riwayatId'      => 'required|exists:riwayat,riwayatId',
            'jenis_golongan' => 'required|exists:jenis_golongan,jenisId',
            'tanggal'        => 'required|date',
        ]);

        RiwayatGolongan::create([
            'riwayatId'      => $request->riwayatId,
            'jenis_golongan' => $request->jenis_golongan,
            'tanggal'        => $request->tanggal,
        ]);

        $this->syncRiwayatTerakhir($request->riwayatId);

        return back()->with('success', 'Riwayat golongan berhasil ditambahkan.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        return back()->with('success', 'Import berhasil (dummy).');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'riwayatId'      => 'required|exists:riwayat,riwayatId',
            'jenis_golongan' => 'required|exists:jenis_golongan,jenisId',
            'tanggal'        => 'required|date',
        ]);

        $gol = RiwayatGolongan::findOrFail($id);

        $gol->update([
            'riwayatId'      => $request->riwayatId,
            'jenis_golongan' => $request->jenis_golongan,
            'tanggal'        => $request->tanggal,
        ]);

        $this->syncRiwayatTerakhir($request->riwayatId);

        return back()->with('success', 'Riwayat golongan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $gol = RiwayatGolongan::findOrFail($id);
        $riwayatId = $gol->riwayatId;

        $gol->delete();

        // setelah hapus, sinkronkan lagi golongan & tmt_kini
        $this->syncRiwayatTerakhir($riwayatId);

        return back()->with('success', 'Riwayat golongan berhasil dihapus.');
    }

    private function syncRiwayatTerakhir($riwayatId)
    {
        $riwayat = Riwayat::find($riwayatId);

        if (! $riwayat) {
            return;
        }

        $lastGol = RiwayatGolongan::where('riwayatId', $riwayatId)
            ->orderBy('tanggal', 'desc')
            ->orderBy('riwayat_gol_id', 'desc') // kalau tanggal sama
            ->first();

        if ($lastGol) {
            $jenis = JenisGolongan::find($lastGol->jenis_golongan);

            $riwayat->golongan = $jenis ? $jenis->jenis : null;
            $riwayat->tmt_kini = $lastGol->tanggal;
        } else {
            $riwayat->golongan = null;
            $riwayat->tmt_kini = null;
        }

        $riwayat->save();
    }

}
