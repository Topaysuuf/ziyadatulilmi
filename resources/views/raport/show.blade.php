<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Raport Digital - {{ $siswa->nama ?? 'Siswa' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .print-card { box-shadow: none !important; border: none !important; padding: 0 !important; }
        }
        table.no-border, table.no-border td {
            border: none !important;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 py-8">

    <!-- Tombol Aksi (Kembali, Cetak PDF, & Download Word) -->
    <div class="max-w-5xl mx-auto px-4 mb-6 flex justify-between items-center no-print">
        <div>
            <h1 class="text-xl font-bold text-gray-800">E-Raport Digital</h1>
            <p class="text-xs text-gray-500">Laporan Hasil Belajar Siswa</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('nilai') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition">
                ← Kembali
            </a>
            <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
                🖨️ Cetak PDF
            </button>
            <button onclick="exportHTMLToWord()" class="bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-900 transition flex items-center gap-2 shadow-sm">
                📄 Download Word (.doc)
            </button>
        </div>
    </div>

    <!-- Container Lembar Raport -->
    <div id="raport-content" class="max-w-5xl mx-auto bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-gray-200 print-card">
        
        <!-- Gambar Kop Surat Otomatis Sinkron SMP / SMA -->
        <div class="mb-6">
            @php
                $kelas = strtoupper($siswa->kelas ?? '');
                $isSmp = str_contains($kelas, 'SMP') \vert{}\vert{} str_contains($kelas, 'VII') || str_contains($kelas, 'VIII') \vert{}\vert{} str_contains($kelas, 'IX');
                $gambarKop =$isSmp ? 'Kop SMP Gambar.png' : 'Kop SMA gambar.png';
                $fase =$isSmp ? 'D' : 'F';
            @endphp
            <img src="{{ asset('images/' . $gambarKop) }}" alt="Kop Surat Sekolah Ziyadatul Ilmi" style="width: 100%; height: auto; max-width: 100%;">
        </div>

        <!-- Identitas Siswa (Murni Menggunakan Tabel HTML Tanpa Border untuk Kompatibilitas Word) -->
        <table class="no-border" style="width: 100%; border: none; margin-bottom: 20px; font-size: 13px;">
            <tr>
                <td style="width: 50%; vertical-align: top; padding: 0 10px 0 0;">
                    <table class="no-border" style="width: 100%; border: none;">
                        <tr>
                            <td style="width: 110px; font-weight: bold; color: #374151; padding: 3px 0;">Nama</td>
                            <td style="padding: 3px 0;">: <span style="font-weight: bold; color: #111827; text-transform: uppercase;">{{ $siswa->nama ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: #374151; padding: 3px 0;">NISN / NIS</td>
                            <td style="padding: 3px 0;">: {{ $siswa->nisn ?? $siswa->nis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: #374151; padding: 3px 0;">Nama Sekolah</td>
                            <td style="padding: 3px 0;">: {{ $isSmp ? 'SMP ZIYADATUL ILMI KOTA SERANG' : 'SMA ZIYADATUL ILMI KOTA SERANG' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: #374151; padding: 3px 0;">Alamat</td>
                            <td style="padding: 3px 0;">: Jl. Nancang Wetan, Karundang, Cipocok Jaya</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top; padding: 0 0 0 10px;">
                    <table class="no-border" style="width: 100%; border: none;">
                        <tr>
                            <td style="width: 110px; font-weight: bold; color: #374151; padding: 3px 0;">Kelas</td>
                            <td style="padding: 3px 0;">: <span style="font-weight: bold;">{{ $siswa->kelas ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: #374151; padding: 3px 0;">Fase</td>
                            <td style="padding: 3px 0;">: {{ $fase }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: #374151; padding: 3px 0;">Semester</td>
                            <td style="padding: 3px 0;">: 1 (Satu) / Ganjil</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: #374151; padding: 3px 0;">Tahun Pelajaran</td>
                            <td style="padding: 3px 0;">: 2026/2027</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        @php
            $totalNilai = 0;
            $countNilai = 0;
            $kkmDefault = 75;

            foreach($nilais ?? [] as $n) {
                $totalNilai +=$n->nilai;
                $countNilai++;
            }
            
            $rataRata =$countNilai > 0 ? round($totalNilai / $countNilai, 2) : 0;
        @endphp

        <!-- Tabel Nilai Utama Sesuai Format -->
        <div class="overflow-x-auto mb-6">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; font-size: 13px;">
                <thead>
                    <tr style="background-color: #d1d5db; color: #000; font-weight: bold;">
                        <th rowspan="2" style="border: 1px solid #000; padding: 6px; text-align: center; width: 40px; vertical-align: middle;">NO.</th>
                        <th rowspan="2" style="border: 1px solid #000; padding: 6px; text-align: center; vertical-align: middle;">Nama Pelajaran</th>
                        <th colspan="3" style="border: 1px solid #000; padding: 4px; text-align: center;">Nilai Murni ASTS</th>
                    </tr>
                    <tr style="background-color: #d1d5db; color: #000; font-weight: bold;">
                        <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 60px;">KKM</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 70px;">NILAI</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 50%;">CAPAIAN KOMPETENSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilais ?? [] as $index =>$nilai)
                        @php
                            $score =$nilai->nilai;
                            $mapel =$nilai->mata_pelajaran;
                            
                            if ($score >= 85) {$capaian = "Menunjukkan penguasaan yang sangat baik dalam memahami materi $mapel.";
                            } elseif ($score >= $kkmDefault) {$capaian = "Menunjukkan penguasaan yang baik dalam memahami materi $mapel.";
                            } else {
                                $capaian = "Perlu bimbingan dan pendampingan khusus dalam memahami materi $mapel.";
                            }
                        @endphp
                        <tr>
                            <td style="border: 1px solid #000; padding: 6px; text-align: center;">{{ $index + 1 }}</td>
                            <td style="border: 1px solid #000; padding: 6px; font-weight: bold;">
                                {{ $mapel }}
                                @if(!empty($nilai->jenis_ujian))
                                    <span style="font-size: 11px; font-weight: normal; color: #4b5563;">({{ $nilai->jenis_ujian }})</span>
                                @endif
                            </td>
                            <td style="border: 1px solid #000; padding: 6px; text-align: center;">{{ $kkmDefault }}</td>
                            <td style="border: 1px solid #000; padding: 6px; text-align: center; font-weight: bold;">{{ $score }}</td>
                            <td style="border: 1px solid #000; padding: 6px; font-size: 12px;">{{ $capaian }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="border: 1px solid #000; padding: 12px; text-align: center; color: #9ca3af; font-style: italic;">
                                Belum ada data nilai yang diinput oleh guru/admin.
                            </td>
                        </tr>
                    @endforelse

                    <!-- Summary / Total & Rata-rata -->
                    <tr style="font-weight: bold; background-color: #f9fafb;">
                        <td colspan="3" style="border: 1px solid #000; padding: 6px; text-align: right;">Jumlah Nilai :</td>
                        <td style="border: 1px solid #000; padding: 6px; text-align: center;">{{ $totalNilai > 0 ?$totalNilai : '-' }}</td>
                        <td style="border: 1px solid #000; padding: 6px;"></td>
                    </tr>
                    <tr style="font-weight: bold; background-color: #f9fafb;">
                        <td colspan="3" style="border: 1px solid #000; padding: 6px; text-align: right;">Nilai Rata-rata Mata Pelajaran :</td>
                        <td style="border: 1px solid #000; padding: 6px; text-align: center;">{{ $rataRata > 0 ?$rataRata : '-' }}</td>
                        <td style="border: 1px solid #000; padding: 6px;"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabel Kepribadian & Ketidak Hadiran -->
        <table class="no-border" style="width: 100%; border: none; margin-bottom: 20px; font-size: 13px;">
            <tr>
                <!-- Table Kepribadian -->
                <td style="width: 48%; vertical-align: top; padding: 0 1% 0 0;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                        <thead>
                            <tr style="background-color: #d1d5db; font-weight: bold;">
                                <th colspan="3" style="border: 1px solid #000; padding: 5px; text-align: center;">KEPRIBADIAN</th>
                            </tr>
                            <tr style="background-color: #e5e7eb; font-weight: bold;">
                                <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 35px;">NO.</th>
                                <th style="border: 1px solid #000; padding: 4px; text-align: center;">ASPEK</th>
                                <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 50px;">NILAI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center;">1</td>
                                <td style="border: 1px solid #000; padding: 4px;">Kelakuan</td>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center; font-weight: bold;">B</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center;">2</td>
                                <td style="border: 1px solid #000; padding: 4px;">Kerajinan</td>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center; font-weight: bold;">B</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center;">3</td>
                                <td style="border: 1px solid #000; padding: 4px;">Kebersihan/Kerapihan</td>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center; font-weight: bold;">B</td>
                            </tr>
                        </tbody>
                    </table>
                </td>

                <!-- Table Ketidak Hadiran -->
                <td style="width: 48%; vertical-align: top; padding: 0 0 0 1%;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                        <thead>
                            <tr style="background-color: #d1d5db; font-weight: bold;">
                                <th colspan="3" style="border: 1px solid #000; padding: 5px; text-align: center;">KETIDAK HADIRAN</th>
                            </tr>
                            <tr style="background-color: #e5e7eb; font-weight: bold;">
                                <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 35px;">NO.</th>
                                <th style="border: 1px solid #000; padding: 4px; text-align: center;">ALASAN</th>
                                <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 50px;">HARI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center;">1</td>
                                <td style="border: 1px solid #000; padding: 4px;">Sakit</td>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center; font-weight: bold;">{{ $sakit ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center;">2</td>
                                <td style="border: 1px solid #000; padding: 4px;">Izin</td>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center; font-weight: bold;">{{ $izin ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center;">3</td>
                                <td style="border: 1px solid #000; padding: 4px;">Tanpa Keterangan</td>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center; font-weight: bold;">{{ $alpa ?? 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Box Catatan Wali Kelas -->
        <div style="border: 1px solid #000; padding: 10px; margin-bottom: 25px; font-size: 13px; min-height: 80px;">
            <p style="font-weight: bold; font-style: italic; margin: 0 0 5px 0;">Catatan Wali Kelas :</p>
            <p style="font-style: italic; color: #374151; margin: 0;">Tingkatkan terus semangat belajar dan kedisiplinan dalam beribadah serta mengaji.</p>
        </div>

        <!-- Tanda Tangan Wali Kelas & Orang Tua -->
        <table class="no-border" style="width: 100%; border: none; font-size: 13px; text-align: center;">
            <tr>
                <td style="width: 50%; padding-bottom: 60px;">Orang Tua / Wali Siswa,</td>
                <td style="