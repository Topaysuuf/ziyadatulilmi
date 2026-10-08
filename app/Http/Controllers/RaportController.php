<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    public function show($siswa_id)
    {
        // 1. Ambil data siswa
        $siswa = Siswa::findOrFail($siswa_id);

        // 2. Ambil data nilai siswa ini beserta mapel-nya
        $nilais = Nilai::with('mapel')->where('siswa_id', $siswa_id)->get();

        // 3. Tampilkan ke view
        return view('raport.show', compact('siswa', 'nilais'));
    }
}