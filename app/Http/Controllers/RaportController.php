<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    public function show($siswa_id)
    {
        // Mengambil data siswa beserta nilai & mapel yang di-input guru
        $siswa = Siswa::with(['nilai.mapel', 'nilais.mapel'])->findOrFail($siswa_id);

        return view('raport.show', compact('siswa'));
    }
}