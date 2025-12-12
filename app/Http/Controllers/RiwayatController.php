<?php

namespace App\Http\Controllers;

use App\Models\DataInduk;
use App\Models\JenisGolongan;
use App\Models\Riwayat;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = Riwayat::with([
            'dataInduk',
            'jenisGolongan', 
            'latestRiwayatGolongan.jenisGolongan',
        ])->get();
        $dataInduk      = DataInduk::orderBy('nama')->get();
        $jenis_golongan = JenisGolongan::orderBy('jenis', 'asc')->get();

        return view('pages.system.riwayat', compact('riwayat', 'dataInduk', 'jenis_golongan'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'data_induk_id'   => 'required|exists:data_induk,id',
            'pendidikan' => 'nullable|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'tmt_awal' => 'nullable|date',
            'golongan' => 'nullable|exists:jenis_golongan,jenisId',
            'tmt_kini' => 'nullable|date',
            'riwayat_gol' => 'nullable|string|max:255',
            'riwayat_jabatan' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
        ]);
        try {
            Riwayat::create($validated);
            return redirect()
                ->back()
                ->with('success', 'Riwayat staff berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Riwayat staff gagal ditambahkan.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'data_induk_id'   => 'required|exists:data_induk,id',
            'pendidikan' => 'nullable|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'golongan' => 'nullable|exists:jenis_golongan,jenisId',
            'tmt_golongan' => 'nullable|date',
            'tmt_awal' => 'nullable|date',
            'status' => 'nullable|string|max:100',
            'riwayat_gol' => 'nullable|string|max:255',
            'riwayat_jabatan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $riwayat = Riwayat::findOrFail($id); 
            $riwayat->update($validated);

            return redirect()
                ->back()
                ->with('success', 'Riwayat staff berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Riwayat staff gagal diubah.');
        }
    }
    public function destroy($id)
    {
        try {
            $riwayat = Riwayat::findOrFail($id);
            $riwayat->delete(); 

            return response()->json([
                'status'  => 'success',
                'message' => 'Riwayat berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Riwayat gagal dihapus.',
            ], 500);
        }
    }
    public function show($id)
    {
        $riwayat = Riwayat::with([
                'dataInduk',
                'riwayatGolongan.jenisGolongan',
            ])
            ->findOrFail($id);

        $jenis_golongan = JenisGolongan::orderBy('jenis', 'asc')->get();

        return view('pages.system.riwayat_gol', compact('riwayat', 'jenis_golongan'));
    }

    public function show2($id)
    {
        $riwayat = Riwayat::with([
            'dataInduk',
            'riwayatJabatan'])
            ->findOrFail($id); 

        return view('pages.system.riwayat_jabatan', compact('riwayat'));
    }

}
