<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RaportController extends Controller
{
    public function show($id)
    {
        $siswa = DB::table('siswas')->where('id', $id)->first();
        $nilais = DB::table('nilais')->where('siswa_id', $id)->get();

        // Hitung total ketidakhadiran secara otomatis dari tabel absensis
        $sakit = DB::table('absensis')->where('siswa_id', $id)->where('status', 'Sakit')->count();
        $izin  = DB::table('absensis')->where('siswa_id', $id)->where('status', 'Izin')->count();
        $alpa  = DB::table('absensis')->where('siswa_id', $id)->whereIn('status', ['Alpa', 'Tanpa Keterangan'])->count();

        return view('raport.show', compact('siswa', 'nilais', 'sakit', 'izin', 'alpa'));
    }
}