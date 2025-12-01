<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::all();
        return view(
            'pages.system.staff',
            compact('staff')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
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
            Staff::create($validated);
            return redirect()
                ->back()
                ->with('success', 'Staff berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Staff gagal ditambahkan.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
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

            $staff->update($validated);

            return redirect()
                ->back()
                ->with('success', 'Staff berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Staff gagal diubah.');
        }
    }

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
