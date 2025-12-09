<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use App\Models\RiwayatJabatan;
use Illuminate\Http\Request;

class RiwayatJabatanController extends Controller
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
            'nama_jabatan'   => 'required|string|max:255',
            'tanggal'        => 'required|date',
        ]);

        RiwayatJabatan::create([
            'riwayatId'      => $request->riwayatId,
            'nama_jabatan'   => $request->nama_jabatan,
            'tanggal'        => $request->tanggal,
        ]);

        return back()->with('success', 'Riwayat jabatan berhasil ditambahkan.');
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
            'nama_jabatan'   => 'required|string|max:255',
            'tanggal'        => 'required|date',
        ]);

        $gol = RiwayatJabatan::findOrFail($id);

        $gol->update([
            'riwayatId'      => $request->riwayatId,
            'nama_jabatan'   => $request->nama_jabatan,
            'tanggal'        => $request->tanggal,
        ]);

        return back()->with('success', 'Riwayat jabatan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $jabatan = RiwayatJabatan::findOrFail($id);
        $jabatan->delete();

        return response()->json([
            'message' => 'Riwayat jabatan berhasil dihapus.'
        ]);
    }
}
