<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AbsensiQrController extends Controller
{
    // 1. Halaman Scanner Kamera untuk Guru/Petugas
    public function scan()
    {
        $riwayatHariIni = Absensi::with('siswa')
            ->whereDate('tanggal', today())
            ->orderByDesc('jam_masuk')
            ->orderByDesc('id')
            ->take(15)
            ->get();

        return view('absen.scan', compact('riwayatHariIni'));
    }

    // 2. Proses Simpan Data dari Hasil Scan QR
    public function storeScan(Request $request)
    {
        $request->validate([
            'qr_token' => 'required|string',
        ]);

        $siswa = Siswa::where('qr_token', $request->qr_token)->first();

        if (!$siswa) {
            return response()->json([
                'status'  => 'error',
                'message' => 'QR Code tidak dikenali / bukan santri terdaftar!',
            ], 404);
        }

        // Cek supaya tidak double absen di hari yang sama
        $sudahAbsen = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->first();

        if ($sudahAbsen) {
            return response()->json([
                'status'  => 'warning',
                'message' => "{$siswa->nama} ({$siswa->kelas}) sudah absen hari ini pukul {$sudahAbsen->jam_masuk}.",
            ]);
        }

        $jamSekarang = now()->format('H:i:s');

        Absensi::create([
            'siswa_id'  => $siswa->id,
            'tanggal'   => today(),
            'jam_masuk' => $jamSekarang,
            'status'    => 'Hadir',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => "Hadir: {$siswa->nama} ({$siswa->kelas}) - {$jamSekarang}",
            'data'    => [
                'nama'      => $siswa->nama,
                'kelas'     => $siswa->kelas,
                'jam_masuk' => $jamSekarang,
            ]
        ]);
    }

    // 3. Halaman Daftar & Cetak Kartu QR Siswa (Sekaligus auto-generate token bagi siswa lama)
    public function kartu()
    {
        // Isi otomatis qr_token untuk data siswa lama yang masih NULL
        $siswasTanpaQr = Siswa::whereNull('qr_token')->orWhere('qr_token', '')->get();
        foreach ($siswasTanpaQr as $s) {
            $s->update(['qr_token' => 'ZI-' . strtoupper(Str::random(10))]);
        }

        $siswas = Siswa::orderBy('kelas')->orderBy('nama')->get();

        return view('absen.kartu', compact('siswas'));
    }
}