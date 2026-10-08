<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    public function show($siswa_id)
    {
        // 1. Cari data siswa berdasarkan ID
        $siswa = Siswa::find($siswa_id);

        if (!$siswa) {
            return "Siswa dengan ID $siswa_id tidak ditemukan di database.";
        }

        // 2. Ambil data nilai tanpa query relasi mapel dulu biar nggak crash
        $nilais = Nilai::where('siswa_id', $siswa_id)->get();

        // 3. Tampilkan ke view
        return view('raport.show', compact('siswa', 'nilais'));
    }
}