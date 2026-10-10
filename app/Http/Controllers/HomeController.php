<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\Ppdb; // Jika model PPDB/SPMB bernama Ppdb atau Pendaftar
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * 1. Halaman Utama / Beranda Publik
     */
    public function index()
    {
        return view('welcome'); // atau view('home') sesuai template beranda kamu
    }

    /**
     * Store Data Pendaftaran SPMB Online
     */
    public function storePpdb(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn'         => 'nullable|string',
            'jk'           => 'required|string',
            'no_whatsapp'  => 'required|string',
        ]);

        if (class_exists('App\Models\Ppdb')) {
            Ppdb::create([
                'nama_lengkap' => $request->nama_lengkap,
                'nisn'         => $request->nisn ?? '-',
                'jk'           => $request->jk,
                'no_whatsapp'  => $request->no_whatsapp,
                'status'       => 'Pending',
            ]);
        } else {
            DB::table('ppdbs')->insert([
                'nama_lengkap' => $request->nama_lengkap,
                'nisn'         => $request->nisn ?? '-',
                'jk'           => $request->jk,
                'no_whatsapp'  => $request->no_whatsapp,
                'status'       => 'Pending',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Pendaftaran SPMB berhasil dikirim!');
    }

    /**
     * 2. Detail Profil Yayasan
     */
    public function detailProfil($slug)
    {
        return view('profil', compact('slug'));
    }

    /**
     * 3. Cek Absensi Publik (/absensi)
     */
    public function absensi()
    {
        $siswas = class_exists('App\Models\Siswa') ? Siswa::all() : DB::table('siswas')->get();
        return view('absensi', compact('siswas'));
    }

    /**
     * 3. Cek Nilai & E-Raport Publik (/nilai)
     */
    public function nilai()
    {
        $siswas = class_exists('App\Models\Siswa') ? Siswa::all() : DB::table('siswas')->get();
        return view('nilai', compact('siswas'));
    }

    /**
     * 5. Dashboard Admin (/admin/dashboard)
     */
    public function adminDashboard()
    {
        $siswas = class_exists('App\Models\Siswa') ? Siswa::all() : DB::table('siswas')->get();
        
        $pendaftar = class_exists('App\Models\Ppdb') 
            ? Ppdb::all() 
            : (DB::getSchemaBuilder()->hasTable('ppdbs') ? DB::table('ppdbs')->get() : collect([]));

        // Kelompok kelas untuk filter export nilai
        $kelases = $siswas->pluck('kelas')->unique()->filter()->values();

        return view('admin.dashboard', compact('siswas', 'pendaftar', 'kelases'));
    }

    /**
     * 6. Aksi SPMB Admin (Update Status & Delete)
     */
    public function updatePpdbStatus($id, Request $request)
    {
        if (class_exists('App\Models\Ppdb')) {
            $p = Ppdb::findOrFail($id);
            $p->update(['status' => $request->status]);
        } else {
            DB::table('ppdbs')->where('id', $id)->update(['status' => $request->status]);
        }

        return redirect()->back()->with('success', 'Status pendaftar berhasil diperbarui!');
    }

    public function deletePpdb($id)
    {
        if (class_exists('App\Models\Ppdb')) {
            Ppdb::destroy($id);
        } else {
            DB::table('ppdbs')->where('id', $id)->delete();
        }

        return redirect()->back()->with('success', 'Data pendaftar berhasil dihapus!');
    }

    /**
     * 7. Simpan Absensi Admin
     */
    public function storeAbsensi(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'tanggal'  => 'required|date',
            'status'   => 'required|string',
        ]);

        if (class_exists('App\Models\Absensi')) {
            Absensi::create([
                'siswa_id' => $request->siswa_id,
                'tanggal'  => $request->tanggal,
                'status'   => $request->status,
            ]);
        } else {
            DB::table('absensis')->insert([
                'siswa_id'   => $request->siswa_id,
                'tanggal'    => $request->tanggal,
                'status'     => $request->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Data absensi berhasil disimpan!');
    }

    /**
     * 7. Simpan Nilai Admin
     */
    public function storeNilai(Request $request)
    {
        $request->validate([
            'siswa_id'       => 'required',
            'mata_pelajaran' => 'required|string',
            'jenis_ujian'    => 'required|string',
            'nilai'          => 'required|numeric|min:0|max:100',
        ]);

        if (class_exists('App\Models\Nilai')) {
            Nilai::create([
                'siswa_id'       => $request->siswa_id,
                'mata_pelajaran' => $request->mata_pelajaran,
                'jenis_ujian'    => $request->jenis_ujian,
                'nilai'          => $request->nilai,
            ]);
        } else {
            DB::table('nilais')->insert([
                'siswa_id'       => $request->siswa_id,
                'mata_pelajaran' => $request->mata_pelajaran,
                'jenis_ujian'    => $request->jenis_ujian,
                'nilai'          => $request->nilai,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Nilai ujian berhasil disimpan!');
    }

    /**
     * Reset Absensi & Nilai
     */
    public function resetAbsensi()
    {
        if (class_exists('App\Models\Absensi')) {
            Absensi::truncate();
        } else {
            DB::table('absensis')->truncate();
        }
        return redirect()->back()->with('success', 'Seluruh data absensi berhasil di-reset!');
    }

    public function resetNilai()
    {
        if (class_exists('App\Models\Nilai')) {
            Nilai::truncate();
        } else {
            DB::table('nilais')->truncate();
        }
        return redirect()->back()->with('success', 'Seluruh data nilai berhasil di-reset!');
    }

    /**
     * 8. Export Rekap Absensi ke Format Excel (.xls) Rekapitulasi Lengkap
     */
    public function exportAbsensi()
    {
        $fileName = 'Rekap_Absensi_Semua_Kelas_' . date('Y-m-d') . '.xls';

        $siswas = DB::table('siswas')->get();

        $headers = [
            "Content-Type"        => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Pragma"              => "no-cache",
            "Expires"             => "0"
        ];

        $callback = function() use ($siswas) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>';
            echo '<body>';
            echo '<table border="1">';
            echo '<tr style="background-color: #f2f2f2; font-weight: bold; text-align: center;">';
            echo '<th>No</th><th>Nama Siswa</th><th>Kelas</th><th>Hadir</th><th>Izin</th><th>Sakit</th><th>Alpa</th><th>Total Pertemuan</th><th>% Kehadiran</th><th>Keterangan</th>';
            echo '</tr>';

            foreach ($siswas as $index => $siswa) {
                $hadir = DB::table('absensis')->where('siswa_id', $siswa->id)->where('status', 'Hadir')->count();
                $izin  = DB::table('absensis')->where('siswa_id', $siswa->id)->where('status', 'Izin')->count();
                $sakit = DB::table('absensis')->where('siswa_id', $siswa->id)->where('status', 'Sakit')->count();
                $alpa  = DB::table('absensis')->where('siswa_id', $siswa->id)->where('status', 'Alpa')->count();

                $total = $hadir + $izin + $sakit + $alpa;
                $persen = $total > 0 ? round(($hadir / $total) * 100) : 0;
                
                $keterangan = $persen < 75 ? 'Di Bawah Minimum (<75%)' : 'Memenuhi';
                $bgColor = $persen < 75 ? '#fce4d6' : '#ffffff';

                echo "<tr style='background-color: {$bgColor};'>";
                echo "<td align='center'>" . ($index + 1) . "</td>";
                echo "<td>" . htmlspecialchars($siswa->nama ?? '-') . "</td>";
                echo "<td>" . htmlspecialchars($siswa->kelas ?? '-') . "</td>";
                echo "<td align='center'>{$hadir}</td>";
                echo "<td align='center'>{$izin}</td>";
                echo "<td align='center'>{$sakit}</td>";
                echo "<td align='center'>{$alpa}</td>";
                echo "<td align='center'>{$total}</td>";
                echo "<td align='right'>{$persen}%</td>";
                echo "<td><b>{$keterangan}</b></td>";
                echo "</tr>";
            }

            echo '</table>';
            echo '</body></html>';
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * 8. Export Rekap Nilai ke Format Excel (.xls)
     */
    public function exportNilai(Request $request)
    {
        $fileName = 'Rekap_Nilai_Siswa_' . date('Y-m-d') . '.xls';

        $query = DB::table('nilais')
            ->leftJoin('siswas', 'nilais.siswa_id', '=', 'siswas.id')
            ->select('siswas.nama', 'siswas.kelas', 'nilais.mata_pelajaran', 'nilais.jenis_ujian', 'nilais.nilai');

        if ($request->filled('kelas')) {
            $query->where('siswas.kelas', $request->kelas);
        }

        if ($request->filled('mata_pelajaran')) {
            $query->where('nilais.mata_pelajaran', 'LIKE', '%' . $request->mata_pelajaran . '%');
        }

        $nilais = $query->get();

        $headers = [
            "Content-Type"        => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Pragma"              => "no-cache",
            "Expires"             => "0"
        ];

        $callback = function() use ($nilais) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>';
            echo '<body>';
            echo '<table border="1">';
            echo '<tr style="background-color: #f2f2f2; font-weight: bold; text-align: center;">';
            echo '<th>No</th><th>Nama Siswa</th><th>Kelas</th><th>Mata Pelajaran</th><th>Jenis Ujian</th><th>Nilai</th>';
            echo '</tr>';

            foreach ($nilais as $index => $row) {
                echo '<tr>';
                echo '<td align="center">' . ($index + 1) . '</td>';
                echo '<td>' . htmlspecialchars($row->nama ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($row->kelas ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($row->mata_pelajaran) . '</td>';
                echo '<td align="center">' . htmlspecialchars($row->jenis_ujian) . '</td>';
                echo '<td align="right">' . htmlspecialchars($row->nilai) . '</td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '</body></html>';
        };

        return response()->stream($callback, 200, $headers);
    }
}