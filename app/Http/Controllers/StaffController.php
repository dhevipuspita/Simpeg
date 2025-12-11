<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\DataInduk;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    // =========================
    //  TAMPILKAN STAFF + DATA_INDUK
    // =========================
    public function index()
    {
        // $staff = Staff::with('dataInduk')->get(); // Tidak dipakai di view
        $dataInduk = DataInduk::orderBy('nama')->get(); // untuk dropdown

        return view('pages.system.data_induk', compact('dataInduk'));
    }

    // =========================
    //  SIMPAN STAFF BARU
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'data_induk_id'    => 'required|exists:data_induk,id',
            'birthPlace'       => 'nullable|string|max:255',
            'birthDate'        => 'nullable|date',
            'nik'              => 'nullable|string|max:50',
            'noHp'             => 'nullable|string|max:50',
            'statusPerkawinan' => 'nullable|string|max:50',
            'suami_istri'      => 'nullable|string|max:255',
            'alamat'           => 'nullable|string',
            'email'            => 'nullable|email|max:255',
        ]);

        try {
            // AMBIL DATA PEGAWAI DARI TABEL DATA_INDUK
            $pegawai = DataInduk::findOrFail($request->data_induk_id);

            // INSERT KE TABEL STAFF
            Staff::create([
                'name'             => $pegawai->nama,   // ← ambil nama otomatis
                'birthPlace'       => $request->birthPlace,
                'birthDate'        => $request->birthDate,
                'nik'              => $request->nik,
                'noHp'             => $request->noHp,
                'statusPerkawinan' => $request->statusPerkawinan,
                'suami_istri'      => $request->suami_istri,
                'alamat'           => $request->alamat,
                'email'            => $request->email,
                'email'            => $request->email,
                'dataIndukId'      => $request->data_induk_id,
            ]);

            return redirect()->back()->with('success', 'Staff berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Staff gagal ditambahkan. ' . $e->getMessage());
        }
    }


    // =========================
    //  UPDATE STAFF
    // =========================
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'data_induk_id'    => 'required|exists:data_induk,id',
            'birthPlace'       => 'nullable|string|max:255',
            'birthDate'        => 'nullable|date',
            'nik'              => 'nullable|string|max:50',
            'noHp'             => 'nullable|string|max:50',
            'statusPerkawinan' => 'nullable|string|max:50',
            'suami_istri'      => 'nullable|string|max:255',
            'alamat'           => 'nullable|string',
            'email'            => 'nullable|email|max:255',
        ]);

        try {
            $staff = Staff::findOrFail($id);
            // Map validation to DB column
            $dataToUpdate = $validated;
            $dataToUpdate['dataIndukId'] = $validated['data_induk_id'];
            unset($dataToUpdate['data_induk_id']);

            $staff->update($dataToUpdate);

            return redirect()
                ->back()
                ->with('success', 'Staff berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Staff gagal diubah.');
        }
    }

    // =========================
    //  HAPUS STAFF
    // =========================
    public function destroy($id)
    {
        try {
            $staff = Staff::findOrFail($id);
            $staff->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'Staff berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Staff gagal dihapus.',
            ], 500);
        }
    }
}
