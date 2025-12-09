<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\Perizinan;
use App\Models\Resign;
use App\Models\Staff;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jumlah 
        $countStaff = Staff::count();
        $countJenjang = Jenjang::count();

        // Statistik Perizinan
        $staffIzin = Perizinan::where('isComback', false)->count();
        $staffKembali = Perizinan::where('isComback', true)->count();

        // Perizinan terbaru
        $latestPerizinan = Perizinan::with('staff')
            ->latest()
            ->take(3)
            ->get();

        // Staff Keluar
        $staffKeluar = Resign::count();

        return view(
            'pages.dashboard',
            compact(
                "user",
                "countStaff",
                "countJenjang",
                "staffIzin",
                "staffKembali",
                "staffKeluar",
                "latestPerizinan"
            )
        );
    }
}
