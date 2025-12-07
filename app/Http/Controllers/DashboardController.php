<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\Staff;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jumlah Staff
        $countStaff = Staff::count();

        // Statistik Perizinan
        $staffKeluar = Perizinan::where('isComback', false)->count();
        $staffKembali = Perizinan::where('isComback', true)->count();

        // Perizinan terbaru
        $latestPerizinan = Perizinan::with('staff')
            ->latest()
            ->take(3)
            ->get();

        return view(
            'pages.dashboard',
            compact(
                "user",
                "countStaff",
                "staffKeluar",
                "staffKembali",
                "latestPerizinan"
            )
        );
    }
}
