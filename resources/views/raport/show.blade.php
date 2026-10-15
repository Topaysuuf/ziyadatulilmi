<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Raport Digital - {{ $siswa->nama ?? 'Siswa' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: A4 portrait;
            margin: 8mm 10mm;
        }
        @media print {
            .no-print { display: none !important; }
            body { 
                background: white !important; 
                padding: 0 !important; 
                margin: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .print-card { 
                box-shadow: none !important; 
                border: none !important; 
                padding: 0 !important; 
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            .page-break-inside-avoid {
                page-break-inside: avoid;
            }
        }
        table.no-border, table.no-border td {
            border: none !important;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 py-6">

    <!-- Tombol Aksi (Kembali, Cetak PDF, & Download Word) -->
    <div class="max-w-4xl mx-auto px-4 mb-4 flex justify-between items-center no-print">
        <div>
            <h1 class="text-xl font-bold text-gray-800">E-Raport Digital</h1>
            <p class="text-xs text-gray-500">Laporan Hasil Belajar Siswa</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('nilai') }}" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-gray-300 transition">
                ← Kembali
            </a>
            <button onclick="window.print()" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-700 transition flex items-center gap-1.5 shadow-sm">
                🖨️ Cetak PDF (1 Halaman)
            </button>
            <button onclick="exportHTMLToWord()" class="bg-blue-800 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-900 transition flex items-center gap-1.5 shadow-sm">
                📄 Download Word (.doc)
            </button>
        </div>
    </div>

    <!-- Container Lembar Raport -->
    <div id="raport-content" class="max-w-4xl mx-auto bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-200 print-card page-break-inside-avoid">
        
        @php
            $rawKelas = strtoupper($siswa->kelas ?? '');
            
            // Cek persis apakah siswa SMP atau SMA
            $isSmp = str_contains($rawKelas, 'SMP') || str_contains($rawKelas, 'VII') || str_contains($rawKelas, 'VIII') || str_contains($rawKelas, 'IX');
            
            // Jika mengandung kata SMA / Kelas 10/11/12/X/XI/XII, secara eksplisit dipastikan SMA
            $isSma = str_contains($rawKelas, 'SMA') || str_contains($rawKelas, '10') || str_contains($rawKelas, '11') || str_contains($rawKelas, '12') || str_contains($rawKelas, ' X') || str_contains($rawKelas, ' XI') || str_contains($rawKelas, ' XII');

            if ($isSma) {
                $isSmp = false;
            }

            $fase = $isSmp ? 'D' : 'F';
            $gambarKop = $isSmp ? 'kop smp web.jpg.jpg' : 'kop sma web.jpg.jpg';
        @endphp

        <!-- Gambar Kop Surat Hasil Gabungan (Otomatis Sync SMP / SMA) -->
        <div class="mb-3 w-full">
            <img src="{{ asset('images/' . $gambarKop) }}" alt="Kop Surat Sekolah Ziyadatul Ilmi" style="width: 100%; height: auto; max-width: 100%; display: block;">
        </div>

        <!-- Identitas Siswa -->
        <table class="no-border" style="width: 100%; border: none; margin-bottom: 12px; font-size: 11px; line-height: 1.3;">
            <tr>
                <td style="width: 50%; vertical-align: top; padding: 0 5px 0 0;">
                    <table class="no-border" style="width: 100%; border: none;">
                        <tr>
                            <td style="width: 95px; font-weight: bold; color: #374151; padding: 1px 0;">Nama</td>
                            <td style="padding: 1px 0;">: <span style="font-weight: bold; color: #111827; text-transform: uppercase;">{{ $siswa->nama ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: #374151; padding: 1px 0;">NISN / NIS</td>
                            <td style="padding: 1px 0;">: {{ $siswa->nisn ?? $siswa->nis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: #374151; padding: 1px 0;">Nama Sekolah</td>
                            <td style="padding: 1px 0;">: {{ $isSmp ? 'SMP ZIYADATUL ILMI KOTA SERANG' : 'SMA ZIYADATUL ILMI KOTA SERANG' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: #374151; padding: 1px 0;">Alamat</td>
                            <td style="padding: 1px 0;">: Jl. Nancang Wetan, Karundang, Cipocok Jaya</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top; padding: 0 0 0 5px;">
                    <table class="no-border" style="width: 100%; border: none;">
                        <tr>
                            <td style="width: 95px; font-weight: bold; color: #374151; padding: 1px 0;">Kelas</td>
                            <td style="padding: 1px 0;">: <span style="font-weight: bold;">{{ $siswa->kelas ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: #374151; padding: 1px 0;">Fase</td>
                            <td style="padding: 1px 0;">: {{ $fase }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: #374151; padding: 1px 0;">Semester</td>
                            <td style="padding: 1px 0;">: 1 (Satu) / Ganjil</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: #374151; padding: 1px 0;">Tahun Pelajaran</td>
                            <td style="padding: 1px 0;">: 2026/2027</td>
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
                $totalNilai += $n->nilai;
                $countNilai++;
            }
            
            $rataRata = $countNilai > 0 ? round($totalNilai / $countNilai, 2) : 0;
        @endphp

        <!-- Tabel Nilai Utama -->
        <div style="margin-bottom: 12px;">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; font-size: 11px;">
                <thead>
                    <tr style="background-color: #d1d5db; color: #000; font-weight: bold;">
                        <th rowspan="2" style="border: 1px solid #000; padding: 4px; text-align: center; width: 30px; vertical-align: middle;">NO.</th>
                        <th rowspan="2" style="border: 1px solid #000; padding: 4px; text-align: center; vertical-align: middle;">Nama Pelajaran</th>
                        <th colspan="3" style="border: 1px solid #000; padding: 2px; text-align: center;">Nilai Murni ASTS</th>
                    </tr>
                    <tr style="background-color: #d1d5db; color: #000; font-weight: bold;">
                        <th style="border: 1px solid #000; padding: 2px; text-align: center; width: 45px;">KKM</th>
                        <th style="border: 1px solid #000; padding: 2px; text-align: center; width: 50px;">NILAI</th>
                        <th style="border: 1px solid #000; padding: 2px; text-align: center; width: 50%;">CAPAIAN KOMPETENSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilais ?? [] as $index => $nilai)
                        @php
                            $score = $nilai->nilai;
                            $mapel = $nilai->mata_pelajaran;
                            
                            if ($score >= 85) {
                                $capaian = "Menunjukkan penguasaan yang sangat baik dalam memahami materi $mapel.";
                            } elseif ($score >= $kkmDefault) {
                                $capaian = "Menunjukkan penguasaan yang baik dalam memahami materi $mapel.";
                            } else {
                                $capaian = "Perlu bimbingan dan pendampingan khusus dalam memahami materi $mapel.";
                            }
                        @endphp
                        <tr>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $index + 1 }}</td>
                            <td style="border: 1px solid #000; padding: 4px; font-weight: bold;">
                                {{ $mapel }}
                                @if(!empty($nilai->jenis_ujian))
                                    <span style="font-size: 10px; font-weight: normal; color: #4b5563;">({{ $nilai->jenis_ujian }})</span>
                                @endif
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $kkmDefault }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center; font-weight: bold;">{{ $score }}</td>
                            <td style="border: 1px solid #000; padding: 4px; font-size: 10px; line-height: 1.2;">{{ $capaian }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="border: 1px solid #000; padding: 8px; text-align: center; color: #9ca3af; font-style: italic;">
                                Belum ada data nilai yang diinput oleh guru/admin.
                            </td>
                        </tr>
                    @endforelse

                    <!-- Summary / Total & Rata-rata -->
                    <tr style="font-weight: bold; background-color: #f9fafb;">
                        <td colspan="3" style="border: 1px solid #000; padding: 4px; text-align: right;">Jumlah Nilai :</td>
                        <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $totalNilai > 0 ? $totalNilai : '-' }}</td>
                        <td style="border: 1px solid #000; padding: 4px;"></td>
                    </tr>
                    <tr style="font-weight: bold; background-color: #f9fafb;">
                        <td colspan="3" style="border: 1px solid #000; padding: 4px; text-align: right;">Nilai Rata-rata Mata Pelajaran :</td>
                        <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $rataRata > 0 ? $rataRata : '-' }}</td>
                        <td style="border: 1px solid #000; padding: 4px;"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabel Kepribadian & Ketidak Hadiran -->
        <table class="no-border" style="width: 100%; border: none; margin-bottom: 12px; font-size: 11px;">
            <tr>
                <!-- Table Kepribadian -->
                <td style="width: 49%; vertical-align: top; padding: 0 1% 0 0;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                        <thead>
                            <tr style="background-color: #d1d5db; font-weight: bold;">
                                <th colspan="3" style="border: 1px solid #000; padding: 3px; text-align: center;">KEPRIBADIAN</th>
                            </tr>
                            <tr style="background-color: #e5e7eb; font-weight: bold;">
                                <th style="border: 1px solid #000; padding: 3px; text-align: center; width: 30px;">NO.</th>
                                <th style="border: 1px solid #000; padding: 3px; text-align: center;">ASPEK</th>
                                <th style="border: 1px solid #000; padding: 3px; text-align: center; width: 45px;">NILAI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">1</td>
                                <td style="border: 1px solid #000; padding: 3px;">Kelakuan</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">B</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">2</td>
                                <td style="border: 1px solid #000; padding: 3px;">Kerajinan</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">B</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">3</td>
                                <td style="border: 1px solid #000; padding: 3px;">Kebersihan/Kerapihan</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">B</td>
                            </tr>
                        </tbody>
                    </table>
                </td>

                <!-- Table Ketidak Hadiran -->
                <td style="width: 49%; vertical-align: top; padding: 0 0 0 1%;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                        <thead>
                            <tr style="background-color: #d1d5db; font-weight: bold;">
                                <th colspan="3" style="border: 1px solid #000; padding: 3px; text-align: center;">KETIDAK HADIRAN</th>
                            </tr>
                            <tr style="background-color: #e5e7eb; font-weight: bold;">
                                <th style="border: 1px solid #000; padding: 3px; text-align: center; width: 30px;">NO.</th>
                                <th style="border: 1px solid #000; padding: 3px; text-align: center;">ALASAN</th>
                                <th style="border: 1px solid #000; padding: 3px; text-align: center; width: 45px;">HARI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">1</td>
                                <td style="border: 1px solid #000; padding: 3px;">Sakit</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">{{ $sakit ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">2</td>
                                <td style="border: 1px solid #000; padding: 3px;">Izin</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">{{ $izin ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">3</td>
                                <td style="border: 1px solid #000; padding: 3px;">Tanpa Keterangan</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">{{ $alpa ?? 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Box Catatan Wali Kelas -->
        <div style="border: 1px solid #000; padding: 6px 8px; margin-bottom: 16px; font-size: 11px; min-height: 45px;">
            <p style="font-weight: bold; font-style: italic; margin: 0 0 2px 0;">Catatan Wali Kelas :</p>
            <p style="font-style: italic; color: #374151; margin: 0;">Tingkatkan terus semangat belajar dan kedisiplinan dalam beribadah serta mengaji.</p>
        </div>

        <!-- Tanda Tangan Wali Kelas & Orang Tua -->
        <table class="no-border" style="width: 100%; border: none; font-size: 11px; text-align: center;">
            <tr>
                <td style="width: 50%; padding-bottom: 35px;">Orang Tua / Wali Siswa,</td>
                <td style="width: 50%; padding-bottom: 35px;">Wali Kelas,</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">( ............................................ )</td>
                <td style="font-weight: bold;">( ............................................ )</td>
            </tr>
        </table>

    </div>

    <!-- Script Export HTML to Word Document -->
    <script>
        function exportHTMLToWord(){
            var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
                "xmlns:w='urn:schemas-microsoft-com:office:word' "+
                "xmlns='http://www.w3.org/TR/REC-html40'>"+
                "<head><meta charset='utf-8'><title>Export Word</title>"+
                "<style>"+
                "body { font-family: 'Times New Roman', serif; }"+
                "table { border-collapse: collapse; }"+
                "table.no-border, table.no-border td { border: none !important; }"+
                "</style></head><body>";
            var footer = "</body></html>";
            
            var content = document.getElementById("raport-content").cloneNode(true);
            var sourceHTML = header + content.innerHTML + footer;
            
            var namaSiswa = "{{ $siswa->nama ?? 'Siswa' }}".toLowerCase().replace(/[^a-z0-9]/g, '-');
            
            var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
            var fileDownload = document.createElement("a");
            document.body.appendChild(fileDownload);
            fileDownload.href = source;
            fileDownload.download = 'Raport_' + namaSiswa + '.doc';
            fileDownload.click();
            document.body.removeChild(fileDownload);
        }
    </script>

</body>
</html>