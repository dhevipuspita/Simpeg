<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view(
            'pages.system.kelas',
            compact('kelas')
        );
    }

    public function store(Request $request)
    {
        try {
            $request->validated([
                'name' => 'required',
            ]);

            Kelas::create([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Kelas berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Kelas gagal ditambahkan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            Kelas::where('kelasId', $id)->update([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Kelas berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Kelas gagal diubah');
        }
    }

    public function destroy($id)
    {
        try {
            Kelas::where('kelasId', $id)->delete();

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
