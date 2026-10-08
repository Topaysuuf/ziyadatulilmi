<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// 1. Halaman Utama / Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/ppdb', [HomeController::class, 'storePpdb'])->name('ppdb.store');

// 2. Detail Profil Yayasan
Route::get('/profil/{slug}', [HomeController::class, 'detailProfil'])->name('profil.detail');

// 3. Cek Absensi & Nilai Publik
Route::get('/absensi', [HomeController::class, 'absensi'])->name('absensi');
Route::get('/nilai', [HomeController::class, 'nilai'])->name('nilai');

// 4. Login Admin
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('admin.dashboard');
});

// 5. Dashboard Admin
Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');

// 6. Aksi SPMB Admin
Route::post('/admin/ppdb/status/{id}', [HomeController::class, 'updatePpdbStatus'])->name('admin.ppdb.updateStatus');
Route::delete('/admin/ppdb/delete/{id}', [HomeController::class, 'deletePpdb'])->name('admin.ppdb.delete');

// 7. Input Presensi, Nilai & Reset Admin
Route::post('/admin/absensi/store', [HomeController::class, 'storeAbsensi'])->name('admin.absensi.store');
Route::post('/admin/nilai/store', [HomeController::class, 'storeNilai'])->name('admin.nilai.store');
Route::delete('/admin/absensi/reset', [HomeController::class, 'resetAbsensi'])->name('admin.absensi.reset');
Route::delete('/admin/nilai/reset', [HomeController::class, 'resetNilai'])->name('admin.nilai.reset');

// 8. Export Rekap Excel / XLS
Route::get('/admin/absensi/export', [HomeController::class, 'exportAbsensi'])->name('absensi.export');
Route::get('/admin/absensi/export-alias', [HomeController::class, 'exportAbsensi'])->name('admin.absensi.export');
Route::get('/admin/nilai/export', [HomeController::class, 'exportNilai'])->name('admin.nilai.export');