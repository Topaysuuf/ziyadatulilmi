<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $siswas = Siswa::orderBy('nama', 'asc')->get();
        return view('nilai', compact('siswas'));
    }

    // Simpan nilai perorangan (banyak mapel sekaligus untuk 1 siswa)
    public function storeBatch(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'jenis_ujian' => 'required|string',
            'nilai_mapel' => 'required|array',
            'nilai_mapel.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $siswaId = $request->siswa_id;
        $jenisUjian = $request->jenis_ujian;

        foreach ($request->nilai_mapel as $mapel => $nilai) {
            if ($nilai !== null && $nilai !== '') {
                Nilai::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'mata_pelajaran' => $mapel,
                        'jenis_ujian' => $jenisUjian,
                    ],
                    [
                        'nilai' => $nilai,
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Berhasil menyimpan semua nilai untuk siswa tersebut!');
    }
}