<?php

namespace App\Http\Controllers;

use App\Models\JenisGolongan;
use Illuminate\Http\Request;

class JenisGolonganController extends Controller
{
    public function index()
    {
        $jenis_golongan = JenisGolongan::all();
        return view('pages.system.jenis_golongan', compact('jenis_golongan'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'nullable|string|max:255',
        ]);
        try {
            JenisGolongan::create($validated);
            return redirect()
                ->back()
                ->with('success', 'Jenis Golongan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Jenis Golongan gagal ditambahkan.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jenis' => 'nullable|string|max:255',
        ]);

        try {
            $jenis = JenisGolongan::findOrFail($id); 

            $jenis->update($validated);

            return redirect()
                ->back()
                ->with('success', 'Jenis Golongan berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Jenis Golongan gagal diubah.');
        }
    }

    public function destroy($id)
    {
        try {
            JenisGolongan::where('jenisId', $id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Kelas berhasil dihapus',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Kelas gagal dihapus',
            ]);
        }
    }
}
