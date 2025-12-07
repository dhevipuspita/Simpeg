<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\Staff;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PerizinanController extends Controller
{
    public function index()
    {
        $staff = Staff::orderBy('name')->get();

        $perizinan = Perizinan::with('staff')
            ->orderBy('perizinanId', 'desc')
            ->get();

        return view('pages.perizinan.index', compact('staff', 'perizinan'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'tglSurat'  => 'required|date',
                'staffId'   => 'required|exists:staff,staffId',
                'tglMulai'  => 'required|date',
                'tglAkhir'  => 'required|date|after_or_equal:tglMulai',
                'npa'       => 'nullable|string|max:255',
                'jenjang'   => 'nullable|string|max:255',
                'jabatan'   => 'nullable|string|max:255',
                'alasan'    => 'nullable|string',
                'isComback' => 'nullable|boolean',
            ]);

            $staff = Staff::findOrFail($request->staffId);

            // HITUNG LAMA CUTI (dalam hari, inklusif)
            $mulai = Carbon::parse($request->tglMulai);
            $akhir = Carbon::parse($request->tglAkhir);
            $lamaCuti = $mulai->diffInDays($akhir) + 1;

            Perizinan::create([
                'tglSurat'   => $request->tglSurat,
                'staffId'    => $staff->staffId,

                // AUTO COPY DARI STAFF
                'name'       => $staff->name,
                'nik'        => $staff->nik,
                'birthPlace' => $staff->birthPlace ?? null,
                'birthDate'  => $staff->birthDate ?? null,
                'alamat'     => $staff->alamat ?? null,

                // DIISI MANUAL DARI FORM
                'npa'        => $request->npa,
                'jenjang'    => $request->jenjang,
                'jabatan'    => $request->jabatan,

                // DARI FORM + HITUNGAN
                'tglMulai'   => $request->tglMulai,
                'tglAkhir'   => $request->tglAkhir,
                'lamaCuti'   => $lamaCuti,
                'alasan'     => $request->alasan,
                'isComback'  => $request->boolean('isComback', false),
            ]);

            return back()->with('success', 'Data perizinan berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $perizinan = Perizinan::findOrFail($id);

            $request->validate([
                'tglSurat'  => 'required|date',
                'staffId'   => 'required|exists:staff,staffId',
                'tglMulai'  => 'required|date',
                'tglAkhir'  => 'required|date|after_or_equal:tglMulai',
                'npa'       => 'nullable|string|max:255',
                'jenjang'   => 'nullable|string|max:255',
                'jabatan'   => 'nullable|string|max:255',
                'alasan'    => 'nullable|string',
                'isComback' => 'nullable|boolean',
            ]);

            $staff = Staff::findOrFail($request->staffId);

            // HITUNG ULANG LAMA CUTI
            $mulai = Carbon::parse($request->tglMulai);
            $akhir = Carbon::parse($request->tglAkhir);
            $lamaCuti = $mulai->diffInDays($akhir) + 1;

            $perizinan->update([
                'tglSurat'   => $request->tglSurat,
                'staffId'    => $staff->staffId,

                // AUTO UPDATE DARI STAFF
                'name'       => $staff->name,
                'nik'        => $staff->nik,
                'birthPlace' => $staff->birthPlace ?? null,
                'birthDate'  => $staff->birthDate ?? null,
                'alamat'     => $staff->alamat ?? null,

                // DIISI MANUAL DARI FORM
                'npa'        => $request->npa,
                'jenjang'    => $request->jenjang,
                'jabatan'    => $request->jabatan,

                // DARI FORM + HITUNGAN
                'tglMulai'   => $request->tglMulai,
                'tglAkhir'   => $request->tglAkhir,
                'lamaCuti'   => $lamaCuti,
                'alasan'     => $request->alasan,
                'isComback'  => $request->boolean('isComback', $perizinan->isComback),
            ]);

            return back()->with('success', 'Data perizinan berhasil diubah.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $perizinan = Perizinan::findOrFail($id);
        $perizinan->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data perizinan berhasil dihapus.',
        ], 200);
    }

    public function updateStatus($id)
    {
        $perizinan = Perizinan::findOrFail($id);

        $perizinan->update([
            'isComback' => true,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Status kepulangan berhasil diperbarui.',
        ], 200);
    }
}
