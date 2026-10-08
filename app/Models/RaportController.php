<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    public function show($siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);

        // Ambil nilai siswa tanpa memaksa relasi mapel
        $nilais = Nilai::where('siswa_id', $siswa_id)->get();

        return view('raport.show', compact('siswa', 'nilais'));
    }
}