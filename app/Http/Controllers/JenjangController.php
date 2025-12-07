<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use Illuminate\Http\Request;

class JenjangController extends Controller
{
    public function index()
    {
        $jenjang = Jenjang::all();
        return view('pages.system.jenjang', compact('jenjang'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jenjang' => 'nullable|string|max:255',
        ]);
        try {
            Jenjang::create($validated);
            return redirect()
                ->back()
                ->with('success', 'Data Jenjang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Data Jenjang gagal ditambahkan.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_jenjang' => 'nullable|string|max:255',
        ]);

        try {
            $jenjang = Jenjang::findOrFail($id); 

            $jenjang->update($validated);

            return redirect()
                ->back()
                ->with('success', 'Data Jenjang berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Data Jenjang gagal diubah.');
        }
    }

    public function destroy($id)
    {
        try {
            Jenjang::where('jenjangId', $id)->delete();

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
