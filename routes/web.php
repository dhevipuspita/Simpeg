<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BpjsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisGolonganController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PerizinanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapIzinController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\RiwayatGolonganController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DataIndukController;
use App\Http\Controllers\ResignController;
use Illuminate\Support\Facades\Route;

/**
 * ==========================================================================================================
 * Route to the home page
 * ==========================================================================================================
 */
Route::get('/', [AuthController::class, 'index'])->name('home');
Route::put('/changePassword/{username}', [AuthController::class, 'changePassword'])->name('changePassword');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix("/")->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix("perizinan")->middleware("role:Admin,Pengurus")->group(function () {
        Route::get("/", [PerizinanController::class, 'index'])->name('perizinan.index');
        Route::post("/", [PerizinanController::class, 'store'])->name('perizinan.store');
        Route::put("/update-status/{id}", [PerizinanController::class, 'updateStatus'])->name('perizinan.updateStatus');
        Route::put("/{id}", [PerizinanController::class, 'update'])->name('perizinan.update');
        Route::delete("/{id}", [PerizinanController::class, 'destroy'])->name('perizinan.destroy');
    });

    Route::get("perizinan/check/{id}", [PerizinanController::class, 'check'])->name('perizinan.check');

    Route::prefix("rekap-perizinan")->middleware("role:Admin,Pengurus,Wali Santri")->group(function () {
        Route::get("/", [RekapIzinController::class, 'index'])->name('rekapPerizinan.index');
        Route::post("/export", [RekapIzinController::class, 'export'])->name('rekapPerizinan.export');
    });

    /**
     * =======================================================================================================
     * Route to the Admin page
     * =======================================================================================================
     */

    Route::prefix("data-induk")->middleware('role:Admin')->group(function () {
        Route::get('/', [DataIndukController::class, 'index'])->name('data-induk.index');
        Route::get("/create", [DataIndukController::class, 'create'])->name('data-induk.create');
        Route::post('/', [DataIndukController::class, 'store'])->name('data-induk.store');
        Route::get("/edit/{id}", [DataIndukController::class, 'edit'])->name('data-induk.edit');
        Route::put("/{id}", [DataIndukController::class, 'update'])->name('data-induk.update');
        Route::delete("/{id}", [DataIndukController::class, 'destroy'])->name('data-induk.destroy');
    });

    Route::prefix("staff")->middleware('role:Admin')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('staff.index');
        Route::get("/template", [StaffController::class, 'template'])->name('staff.template');
        Route::post('/', [StaffController::class, 'store'])->name('staff.store');
        Route::post("/import", [StaffController::class, 'import'])->name('staff.import');
        Route::put("/{id}", [StaffController::class, 'update'])->name('staff.update');
        Route::delete("/{id}", [StaffController::class, 'destroy'])->name('staff.destroy');
    });

    Route::prefix("riwayat")->middleware('role:Admin')->group(function () {
        Route::get('/', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get("/template", [RiwayatController::class, 'template'])->name('riwayat.template');
        Route::post('/', [RiwayatController::class, 'store'])->name('riwayat.store');
        Route::post("/import", [RiwayatController::class, 'import'])->name('riwayat.import');
        Route::put("/{id}", [RiwayatController::class, 'update'])->name('riwayat.update');
        Route::delete("/{id}", [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
        Route::get('/{id}/golongan', [RiwayatController::class, 'show'])->name('riwayat.golongan');
    });

    Route::prefix("riwayat_gol")->middleware('role:Admin')->group(function () {
        Route::get('/', [RiwayatGolonganController::class, 'index'])->name('riwayat_gol.index');
        Route::get("/template", [RiwayatGolonganController::class, 'template'])->name('riwayat_gol.template');
        Route::post('/', [RiwayatGolonganController::class, 'store'])->name('riwayat_gol.store');
        Route::post("/import", [RiwayatGolonganController::class, 'import'])->name('riwayat_gol.import');
        Route::put("/{id}", [RiwayatGolonganController::class, 'update'])->name('riwayat_gol.update');
        Route::delete("/{id}", [RiwayatGolonganController::class, 'destroy'])->name('riwayat_gol.destroy');
    });
    
    Route::prefix("jenis")->middleware("role:Admin")->group(function () {
        Route::get("/", [JenisGolonganController::class, 'index'])->name('jenis.index');
        Route::get("/template", [JenisGolonganController::class, 'template'])->name('jenis.template');
        Route::post("/", [JenisGolonganController::class, 'store'])->name('jenis.store');
        Route::post("/import", [JenisGolonganController::class, 'import'])->name('jenis.import');
        Route::put("/{id}", [JenisGolonganController::class, 'update'])->name('jenis.update');
        Route::delete("/{id}", [JenisGolonganController::class, 'destroy'])->name('jenis.destroy');
    });

    Route::prefix("resign")->middleware("role:Admin")->group(function () {
    Route::get("/", [ResignController::class, 'index'])->name('resign.index');
    Route::get("/create", [ResignController::class, 'create'])->name('resign.create');
    Route::post("/", [ResignController::class, 'store'])->name('resign.store');
    Route::put("/{id}", [ResignController::class, 'update'])->name('resign.update');
    Route::delete("/{id}", [ResignController::class, 'destroy'])->name('resign.destroy');
    });

    /**
     * =======================================================================================================
     * Route to the Profile page
     * =======================================================================================================
     */

    
    Route::prefix("bpjs")->middleware("role:Admin")->group(function () {
        Route::get("/", [BpjsController::class, 'index'])->name('bpjs.index');
        Route::get("/template", [BpjsController::class, 'template'])->name('bpjs.template');
        Route::post("/", [BpjsController::class, 'store'])->name('bpjs.store');
        Route::post("/import", [BpjsController::class, 'import'])->name('bpjs.import');
        Route::put("/{id}", [BpjsController::class, 'update'])->name('bpjs.update');
        Route::delete("/{id}", [BpjsController::class, 'destroy'])->name('bpjs.destroy');
    });

    Route::prefix("profile")->group(function () {
        Route::get("/", [ProfileController::class, 'index'])->name('profile.index');
        Route::put("/{id}", [ProfileController::class, 'update'])->name('profile.update');
        Route::put("/change-password/{id}", [ProfileController::class, 'updatePassword'])->name('profile.changePassword');
    });

    Route::prefix("reset-password")->group(function () {
        Route::get("/", [ProfileController::class, "resetIndex"])->name("reset.index");
        Route::put("/{id}", [ProfileController::class, "resetPassword"])->name("reset.update");
    });
});
