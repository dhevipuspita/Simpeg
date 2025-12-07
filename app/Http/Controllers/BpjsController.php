<?php

namespace App\Http\Controllers;

use App\Models\Bpjs;
use App\Models\Staff;
use Illuminate\Http\Request;

class BpjsController extends Controller
{
    public function index()
    {
        // Ambil BPJS beserta relasi staff (kalau nanti mau dipakai di view)
        $bpjs  = Bpjs::with('staff')->get();
        $staff = Staff::orderBy('name')->get();

        return view('pages.bpjs.index', compact('bpjs', 'staff'));
    }

    public function create()
    {
        // Kalau masih pakai halaman create terpisah
        $staff = Staff::orderBy('name')->get();
        return view('bpjs.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'staffId'    => 'required|exists:staff,staffId',
            'noBpjs'     => 'nullable|string|max:255',
            'kjp_2p'     => 'nullable|string|max:255',
            'kjp_3p'     => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        // Ambil data staff yang dipilih
        $staff = Staff::findOrFail($request->staffId);

        Bpjs::create([
            'staffId'    => $staff->staffId,
            'name'       => $staff->name,                       
            'noBpjs'     => $request->noBpjs ?: 'Tidak ikut lembaga',
            'kjp_2p'     => $request->kjp_2p ?: 'Tidak ikut lembaga',
            'kjp_3p'     => $request->kjp_3p ?: 'Tidak ikut lembaga',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('bpjs.index')
            ->with('success', 'Data BPJS berhasil ditambahkan!');
    }

    public function show(Bpjs $bpjs)
    {
        $bpjs->load('staff');
        return view('bpjs.show', compact('bpjs'));
    }

    public function edit(Bpjs $bpjs)
    {
        $staff = Staff::orderBy('name')->get();
        return view('bpjs.edit', compact('bpjs', 'staff'));
    }

    public function update(Request $request, $id)
    {
        $bpjs = Bpjs::findOrFail($id);

        $request->validate([
            'staffId'    => 'required|exists:staff,staffId',
            'noBpjs'     => 'nullable|string|max:255',
            'kjp_2p'     => 'nullable|string|max:255',
            'kjp_3p'     => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $staff = Staff::findOrFail($request->staffId);

        $bpjs->update([
            'staffId'    => $staff->staffId,
            'name'       => $staff->name,                       
            'noBpjs'     => $request->noBpjs ?: 'Tidak ikut lembaga',
            'kjp_2p'     => $request->kjp_2p ?: 'Tidak ikut lembaga',
            'kjp_3p'     => $request->kjp_3p ?: 'Tidak ikut lembaga',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('bpjs.index')
            ->with('success', 'Data BPJS berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $bpjs = Bpjs::findOrFail($id);
        $bpjs->delete();

        return redirect()
            ->route('bpjs.index')
            ->with('success', 'Data BPJS berhasil dihapus!');
    }
}
