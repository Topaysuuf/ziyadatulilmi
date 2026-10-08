<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    public function show($siswa_id)
    {
        // Ambil data siswa beserta relasi nilainya
        $siswa = Siswa::with('nilais')->find($siswa_id) ?? Siswa::with('nilai')->findOrFail($siswa_id);

        // Jika view raport.show belum ada atau error, render view sederhana dulu
        if (!view()->exists('raport.show')) {
            return "View 'raport.show' tidak ditemukan di resources/views/raport/show.blade.php";
        }

        return view('raport.show', compact('siswa'));
    }
}