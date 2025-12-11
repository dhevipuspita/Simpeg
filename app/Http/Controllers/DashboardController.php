<?php

namespace App\Http\Controllers;

use App\Models\DataInduk;
use App\Models\Jenjang;
use App\Models\Perizinan;
use App\Models\Resign;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $countStaff   = DataInduk::count();

        $countJenjang = Jenjang::count();

        $staffIzin    = Perizinan::where('isComback', false)->count(); // masih cuti
        $staffKembali = Perizinan::where('isComback', true)->count();  // sudah kembali

        $latestPerizinan = Perizinan::with('dataInduk')
            ->latest()
            ->take(3)
            ->get();

        $staffKeluar = Resign::count();

        return view('pages.dashboard', compact(
            'user',
            'countStaff',
            'countJenjang',
            'staffIzin',
            'staffKembali',
            'staffKeluar',
            'latestPerizinan'
        ));
    }
}
