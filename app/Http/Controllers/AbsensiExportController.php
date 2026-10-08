<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;

class AbsensiExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $kelas = $request->input('kelas'); // Menerima filter kelas dari user
        
        // Ambil data siswa berdasarkan kelas
        $siswas = Siswa::when($kelas, function ($query) use ($kelas) {
            return $query->where('kelas', $kelas);
        })->get();

        // Nama file Excel
        $fileName = 'Rekap_Absensi_' . ($kelas ? str_replace(' ', '_', $kelas) : 'Semua_Kelas') . '_' . date('Y-m-d') . '.xls';

        // Header agar dibaca sebagai file Excel oleh browser
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo '<table border="1">';
        echo '<tr style="background-color: #198754; color: white; font-weight: bold;">';
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
            // Hitung rekap dari tabel absensi berdasarkan id siswa
            $hadir = Absensi::where('siswa_id', $siswa->id)->where('status', 'Hadir')->count();
            $sakit = Absensi::where('siswa_id', $siswa->id)->where('status', 'Sakit')->count();
            $izin  = Absensi::where('siswa_id', $siswa->id)->where('status', 'Izin')->count();
            $alpa  = Absensi::where('siswa_id', $siswa->id)->where('status', 'Alpa')->count();

            $totalPertemuan = $hadir + $sakit + $izin + $alpa;
            
            // Hitung persentase kehadiran (jika total pertemuan 0, persentase 0)
            $persentase = $totalPertemuan > 0 ? round(($hadir / $totalPertemuan) * 100, 2) : 0;

            // Penentu status KKM Kehadiran (misal batas minimum 75%)
            $keterangan = $persentase < 75 ? 'Di Bawah Minimum (<75%)' : 'Aman';
            $warnaBg = $persentase < 75 ? 'style="background-color: #f8d7da; color: #721c24;"' : '';

            echo "<tr {$warnaBg}>";
            echo "<td>{$no}</td>";
            echo "<td>{$siswa->nama}</td>";
            echo "<td>{$siswa->kelas}</td>";
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
}