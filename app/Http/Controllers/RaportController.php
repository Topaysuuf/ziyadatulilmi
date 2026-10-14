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

        // 3. Hitung otomatis rekap absensi dari database (Flexible Case & Values)
        $sakit = DB::table('absensis')
            ->where('siswa_id', $id)
            ->where(function($q) {
                $q->whereRaw('LOWER(status) = ?', ['sakit'])
                  ->orWhereRaw('LOWER(status) = ?', ['s']);
            })
            ->count();

        $izin = DB::table('absensis')
            ->where('siswa_id', $id)
            ->where(function($q) {
                $q->whereRaw('LOWER(status) = ?', ['izin'])
                  ->orWhereRaw('LOWER(status) = ?', ['i']);
            })
            ->count();

        $alpa = DB::table('absensis')
            ->where('siswa_id', $id)
            ->where(function($q) {
                $q->whereRaw('LOWER(status) IN (?, ?, ?, ?)', ['alpa', 'tanpa keterangan', 'a', 'tk']);
            })
            ->count();

        // 4. Kirim semua variabel ke view raport.show
        return view('raport.show', compact('siswa', 'nilais', 'sakit', 'izin', 'alpa'));
    }
}