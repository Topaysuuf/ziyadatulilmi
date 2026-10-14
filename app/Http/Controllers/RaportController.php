<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RaportController extends Controller
{
    public function show($id)
    {
        // 1. Ambil data siswa
        $siswa = DB::table('siswas')->where('id', $id)->first();
        
        if (!$siswa) {
            return redirect()->route('nilai')->with('error', 'Data siswa tidak ditemukan.');
        }

        // 2. Ambil data nilai siswa
        $nilais = DB::table('nilais')->where('siswa_id', $id)->get();

        // 3. Ambil data absensi siswa (Aman untuk MySQL & SQLite)
        $absensis = DB::table('absensis')->where('siswa_id', $id)->get();

        // 4. Hitung rekap absensi menggunakan filter PHP (Bebas dari error SQL 500)
        $sakit = $absensis->filter(function($a) {
            $status = strtolower(trim($a->status ?? ''));
            return in_array($status, ['sakit', 's']);
        })->count();

        $izin = $absensis->filter(function($a) {
            $status = strtolower(trim($a->status ?? ''));
            return in_array($status, ['izin', 'ijin', 'i']);
        })->count();

        $alpa = $absensis->filter(function($a) {
            $status = strtolower(trim($a->status ?? ''));
            return in_array($status, ['alpa', 'alpha', 'tanpa keterangan', 'a', 'tk']);
        })->count();

        // 5. Kirim semua variabel ke view raport.show
        return view('raport.show', compact('siswa', 'nilais', 'sakit', 'izin', 'alpa'));
    }
}