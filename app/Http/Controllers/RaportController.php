<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    public function show($siswa_id)
    {
        // Mengambil data siswa
        $siswa = Siswa::findOrFail($siswa_id);

        // Load relasi nilai jika method-nya ada
        if (method_exists($siswa, 'nilai')) {
            $siswa->load('nilai.mapel');
        } elseif (method_exists($siswa, 'nilais')) {
            $siswa->load('nilais.mapel');
        }

        return view('raport.show', compact('siswa'));
    }
}