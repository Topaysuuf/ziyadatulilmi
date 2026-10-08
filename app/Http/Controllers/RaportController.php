<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    public function show($siswa_id)
    {
        // 1. Ambil data siswa (Gunakan find agar tidak memicu 500 jika ID tidak ada)
        $siswa = Siswa::find($siswa_id);

        if (!$siswa) {
            return response("Data siswa dengan ID {$siswa_id} tidak ditemukan di database.", 404);
        }

        // 2. Ambil data nilai secara independen dari tabel nilais
        $nilais = Nilai::where('siswa_id', $siswa_id)->get();

        // 3. Render ke view
        return view('raport.show', compact('siswa', 'nilais'));
    }
}