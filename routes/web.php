<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AbsensiExportController;

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

// 7. Input Presensi & Nilai Admin
Route::post('/admin/absensi/store', [HomeController::class, 'storeAbsensi'])->name('admin.absensi.store');
Route::post('/admin/nilai/store', [HomeController::class, 'storeNilai'])->name('admin.nilai.store');

// 8. Export Rekap Excel (Hanya satu rute per fungsi yang aktif)
Route::get('/admin/absensi/export', [AbsensiExportController::class, 'exportExcel'])->name('absensi.export');
Route::get('/admin/nilai/export', [HomeController::class, 'exportNilai'])->name('admin.nilai.export');// 8. Export Rekap Excel
Route::get('/admin/absensi/export', [AbsensiExportController::class, 'exportExcel'])->name('absensi.export');
Route::get('/admin/absensi/export-alias', [AbsensiExportController::class, 'exportExcel'])->name('admin.absensi.export'); // Tambahan alias aman
Route::get('/admin/nilai/export', [HomeController::class, 'exportNilai'])->name('admin.nilai.export');