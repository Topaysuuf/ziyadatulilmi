<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profil;
use App\Models\Pengumuman;
use App\Models\Ppdb;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Nilai;

class HomeController extends Controller
{
    // Halaman Utama / Beranda
    public function index()
    {
        $profil = Profil::first();
        $pengumumans = Pengumuman::latest()->take(3)->get();
        return view('welcome', compact('profil', 'pengumumans'));
    }

    // Detail Profil Yayasan / Sekolah (Dinamis berdasarkan $slug)
    public function detailProfil($slug)
    {
        $profil = Profil::first();
        
        $judul = match ($slug) {
            'identitas-sekolah' => 'Identitas Sekolah & Legalitas',
            'sejarah', 'sejarah-sekolah' => 'Sejarah Singkat Sekolah',
            'visi-misi'          => 'Visi dan Misi Sekolah',
            'sambutan'           => 'Sambutan Pimpinan Yayasan',
            default              => 'Profil & Sejarah Sekolah'
        };

        return view('profil_detail', compact('profil', 'slug', 'judul'));
    }

    // Form / Halaman Publik Cek Absensi
    public function absensi(Request $request)
    {
        $kelases = Siswa::select('kelas')->distinct()->pluck('kelas');
        $siswas = collect();
        $siswaSelected = null;

        if ($request->has('kelas') && $request->kelas != '') {
            $siswas = Siswa::where('kelas', $request->kelas)->orderBy('nama')->get();
        }

        if ($request->has('siswa_id') && $request->siswa_id != '') {
            $siswaSelected = Siswa::with('absensis')->find($request->siswa_id);
        }

        return view('absensi', compact('kelases', 'siswas', 'siswaSelected'));
    }

    // Form / Halaman Publik Cek Nilai
    public function nilai(Request $request)
    {
        $kelases = Siswa::select('kelas')->distinct()->pluck('kelas');
        $siswas = collect();
        $siswaSelected = null;

        if ($request->has('kelas') && $request->kelas != '') {
            $siswas = Siswa::where('kelas', $request->kelas)->orderBy('nama')->get();
        }

        if ($request->has('siswa_id') && $request->siswa_id != '') {
            $siswaSelected = Siswa::with('nilais')->find($request->siswa_id);
        }

        return view('nilai', compact('kelases', 'siswas', 'siswaSelected'));
    }

    // Simpan Pendaftaran PPDB Online
    public function storePpdb(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'nisn'          => 'nullable|numeric',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_wa'         => 'required|string|max:20',
        ]);

        Ppdb::create($validated);
        return redirect()->back()->with('success', 'Pendaftaran SPMB berhasil dikirim!');
    }

    // Dashboard Admin
    public function adminDashboard()
    {
        $profil = Profil::first();
        $pendaftar = Ppdb::latest()->get();
        $siswas = Siswa::orderBy('kelas')->orderBy('nama')->get();
        $kelases = Siswa::select('kelas')->distinct()->pluck('kelas'); // <-- Pastikan ini ada supaya filter kelas di Excel nilai muncul

        return view('admin.dashboard', compact('profil', 'pendaftar', 'siswas', 'kelases'));
    }

    // Export Rekap Nilai Berdasarkan Kelas & Mata Pelajaran
    public function exportNilai(Request $request)
    {
        $kelas = $request->input('kelas');
        $mapel = $request->input('mata_pelajaran');

        $query = Nilai::with('siswa');

        if ($kelas) {
            $query->whereHas('siswa', function($q) use ($kelas) {
                $q->where('kelas', $kelas);
            });
        }

        if ($mapel) {
            $query->where('mata_pelajaran', 'LIKE', '%' . $mapel . '%');
        }

        $nilais = $query->latest()->get();
        $fileName = 'Rekap_Nilai_' . ($kelas ? str_replace(' ', '_', $kelas) : 'Semua_Kelas') . '_' . date('Y-m-d') . '.xls';

        return response()->streamDownload(function() use ($nilais, $kelas, $mapel) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>';
            echo '<body>';
            echo '<h3>Rekap Nilai Ujian Siswa</h3>';
            if ($kelas) echo '<p>Kelas: ' . htmlspecialchars($kelas) . '</p>';
            if ($mapel) echo '<p>Mata Pelajaran: ' . htmlspecialchars($mapel) . '</p>';
            echo '<table border="1">';
            echo '<tr style="background-color: #004d25; color: #ffffff; font-weight: bold;">';
            echo '<th>No</th><th>Nama Siswa</th><th>Kelas</th><th>Mata Pelajaran</th><th>Jenis Ujian</th><th>Nilai</th>';
            echo '</tr>';

            foreach ($nilais as $index => $item) {
                echo '<tr>';
                echo '<td>' . ($index + 1) . '</td>';
                echo '<td>' . htmlspecialchars($item->siswa->nama ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($item->siswa->kelas ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($item->mata_pelajaran) . '</td>';
                echo '<td>' . htmlspecialchars($item->jenis_ujian) . '</td>'; // <-- Sudah diperbaiki dari $item$item
                echo '<td>' . $item->nilai . '</td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '</body></html>';
        }, $fileName, [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$fileName",
        ]);
    }

    // Hapus Data SPMB Admin
    public function deletePpdb($id)
    {
        Ppdb::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data pendaftar dihapus!');
    }

    // Simpan Presensi oleh Admin
    public function storeAbsensi(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal'  => 'required|date',
            'status'   => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        Absensi::create($validated);
        return redirect()->back()->with('success', 'Berhasil mencatat presensi siswa!');
    }

    // Simpan Nilai oleh Admin
    public function storeNilai(Request $request)
    {
        $validated = $request->validate([
            'siswa_id'       => 'required|exists:siswas,id',
            'mata_pelajaran' => 'required|string|max:255',
            'jenis_ujian'    => 'required|string|max:100',
            'nilai'          => 'required|integer|min:0|max:100',
        ]);

        Nilai::create($validated);
        return redirect()->back()->with('success', 'Berhasil menginput nilai ujian!');
    }

    // Export Rekapitulasi Absensi untuk Halaman Publik
    public function exportAbsensi(Request $request)
    {
        $kelas = $request->input('kelas');
        
        $siswas = Siswa::when($kelas, function ($query) use ($kelas) {
            return $query->where('kelas', $kelas);
        })->get();

        $fileName = 'Rekap_Absensi_' . ($kelas ? str_replace(' ', '_', $kelas) : 'Semua_Kelas') . '_' . date('Y-m-d') . '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo '<table border="1">';
        echo '<tr style="background-color: #004d25; color: white; font-weight: bold;">';
        echo '<th>No</th>';
        echo '<th>Nama Siswa</th>';
        echo '<th>Kelas</th>';
        echo '<th>Hadir</th>';
        echo '<th>Sakit</th>';
        echo '<th>Izin</th>';
        echo '<th>Alpa</th>';
        echo '<th>Total Pertemuan</th>';
        echo '<th>Persentase Kehadiran</th>';
        echo '<th>Keterangan</th>';
        echo '</tr>';

        $no = 1;
        foreach ($siswas as $siswa) {
            $hadir = Absensi::where('siswa_id', $siswa->id)->where('status', 'Hadir')->count();
            $sakit = Absensi::where('siswa_id', $siswa->id)->where('status', 'Sakit')->count();
            $izin  = Absensi::where('siswa_id', $siswa->id)->where('status', 'Izin')->count();
            $alpa  = Absensi::where('siswa_id', $siswa->id)->where('status', 'Alpa')->count();

            $totalPertemuan = $hadir + $sakit + $izin + $alpa;
            $persentase = $totalPertemuan > 0 ? round(($hadir / $totalPertemuan) * 100, 2) : 0;
            $keterangan = $persentase < 75 ? 'Di Bawah Minimum (<75%)' : 'Aman';
            $warnaBg = $persentase < 75 ? 'style="background-color: #f8d7da; color: #721c24;"' : '';

            echo "<tr {$warnaBg}>";
            echo "<td>{$no}</td>";
            echo "<td>" . htmlspecialchars($siswa->nama) . "</td>";
            echo "<td>" . htmlspecialchars($siswa->kelas) . "</td>";
            echo "<td>{$hadir}</td>";
            echo "<td>{$sakit}</td>";
            echo "<td>{$izin}</td>";
            echo "<td>{$alpa}</td>";
            echo "<td>{$totalPertemuan}</td>";
            echo "<td>{$persentase}%</td>";
            echo "<td><b>{$keterangan}</b></td>";
            echo "</tr>";
            $no++;
        }

        echo '</table>';
        exit;
    }

    // Export Rekap Nilai Berdasarkan Kelas & Mata Pelajaran
    public function exportNilai(Request $request)
    {
        $kelas = $request->input('kelas');
        $mapel = $request->input('mata_pelajaran');

        $query = Nilai::with('siswa');

        if ($kelas) {
            $query->whereHas('siswa', function($q) use ($kelas) {
                $q->where('kelas', $kelas);
            });
        }

        if ($mapel) {
            $query->where('mata_pelajaran', 'LIKE', '%' . $mapel . '%');
        }

        $nilais = $query->latest()->get();
        $fileName = 'Rekap_Nilai_' . ($kelas ? str_replace(' ', '_', $kelas) : 'Semua_Kelas') . '_' . date('Y-m-d') . '.xls';

        return response()->streamDownload(function() use ($nilais, $kelas, $mapel) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>';
            echo '<body>';
            echo '<h3>Rekap Nilai Ujian Siswa</h3>';
            if ($kelas) echo '<p>Kelas: ' . htmlspecialchars($kelas) . '</p>';
            if ($mapel) echo '<p>Mata Pelajaran: ' . htmlspecialchars($mapel) . '</p>';
            echo '<table border="1">';
            echo '<tr style="background-color: #004d25; color: #ffffff; font-weight: bold;">';
            echo '<th>No</th><th>Nama Siswa</th><th>Kelas</th><th>Mata Pelajaran</th><th>Jenis Ujian</th><th>Nilai</th>';
            echo '</tr>';

            foreach ($nilais as $index => $item) {
                echo '<tr>';
                echo '<td>' . ($index + 1) . '</td>';
                echo '<td>' . htmlspecialchars($item->siswa->nama ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($item->siswa->kelas ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($item->mata_pelajaran) . '</td>';
                echo '<td>' . htmlspecialchars($item$item->jenis_ujian) . '</td>';
                echo '<td>' . $item->nilai . '</td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '</body></html>';
        }, $fileName, [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$fileName",
        ]);
    }
    // Reset / Hapus Seluruh Data Absensi
    public function resetAbsensi()
    {
        Absensi::truncate();
        return redirect()->back()->with('success', 'Semua riwayat absensi berhasil direset dan dikosongkan!');
    }

    // Reset / Hapus Seluruh Data Nilai
    public function resetNilai()
    {
        Nilai::truncate();
        return redirect()->back()->with('success', 'Semua riwayat nilai berhasil direset dan dikosongkan!');
    }
}