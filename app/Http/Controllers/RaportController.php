<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;

class RaportController extends Controller
{
    public function show($siswa_id)
    {
        // 1. Cari data siswa dengan fallback DB jika Model tidak merespon
        if (class_exists('App\Models\Siswa')) {
            $siswa = Siswa::find($siswa_id);
        } else {
            $siswa = DB::table('siswas')->where('id', $siswa_id)->first();
        }

        // Jika ID siswa tidak ditemukan, lempar halaman 404 rapi
        if (!$siswa) {
            abort(404, 'Data santri tidak ditemukan.');
        }

        // 2. Ambil data nilai siswa
        if (class_exists('App\Models\Nilai')) {
            $nilais = Nilai::where('siswa_id', $siswa_id)->get();
        } else {
            $nilais = DB::table('nilais')->where('siswa_id', $siswa_id)->get();
        }

        // 3. Ambil data rekap absensi siswa
        if (class_exists('App\Models\Absensi')) {
            $sakit = Absensi::where('siswa_id', $siswa_id)->where('status', 'Sakit')->count();
            $izin  = Absensi::where('siswa_id', $siswa_id)->where('status', 'Izin')->count();
            $alpa  = Absensi::where('siswa_id', $siswa_id)->where('status', 'Alpa')->count();
        } else {
            $sakit = DB::table('absensis')->where('siswa_id', $siswa_id)->where('status', 'Sakit')->count();
            $izin  = DB::table('absensis')->where('siswa_id', $siswa_id)->where('status', 'Izin')->count();
            $alpa  = DB::table('absensis')->where('siswa_id', $siswa_id)->where('status', 'Alpa')->count();
        }

        // 4. Return view raport/show
        return view('raport.show', compact('siswa', 'nilais', 'sakit', 'izin', 'alpa'));
    }
}