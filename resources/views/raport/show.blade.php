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
            <p class="text-xs text-gray-500">Laporan Hasil Belajar PSTS Ganjil</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-gray-300 transition">
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
            $isSmp = str_contains($rawKelas, 'SMP') || str_contains($rawKelas, 'VII') || str_contains($rawKelas, 'VIII') || str_contains($rawKelas, 'IX') || str_contains($rawKelas, '7') || str_contains($rawKelas, '8') || str_contains($rawKelas, '9');
            $isSma = str_contains($rawKelas, 'SMA') || str_contains($rawKelas, 'X') || str_contains($rawKelas, 'XI') || str_contains($rawKelas, 'XII') || str_contains($rawKelas, '10') || str_contains($rawKelas, '11') || str_contains($rawKelas, '12');

            if ($isSma) {
                $isSmp = false;
            }

            $gambarKop = $isSmp ? 'kop smp web.jpg.jpg' : 'kop sma web.jpg.jpg';

            // Penentuan Fase & Nama Sekolah
            if ($isSmp) {
                $namaSekolah = 'SMP ZIYADATUL ILMI';
                $fase = 'E';
            } else {
                $namaSekolah = 'SMA ZIYADATUL ILMI';
                $fase = 'F';
            }

            // Struktur Kategori Mapel Persis Dokumen
            // Normalisasi Mapel dari Database
            $nilaiMap = [];
            foreach($nilais ?? [] as $n) {
                $nilaiMap[strtolower(trim($n->mata_pelajaran))] = $n->nilai;
            }

            // Template Pengelompokan Berdasarkan Kelas
            $kategoriMapel = [];

            if (!$isSmp) {
                // JENJANG SMA
                if (str_contains($rawKelas, '10') || str_contains($rawKelas, ' X') || str_ends_with($rawKelas, 'X')) {
                    // SMA Kelas X
                    $kategoriMapel = [
                        'A. Muatan Lokal Pesantren' => [
                            'Nahwu Jurumiyah', 'Nahwu Imriti', 'Durusulfiqiyah', 'Akhlaqul Banin', 'B. Arab', 'Taqrib/Matan', 'Minhussaniyah'
                        ],
                        'B. Mata Pelajaran Umum' => [
                            'Pendidikan Agama Islam dan Budi Pekerti',
                            'Pendidikan Pancasila dan Kewarganegaraan',
                            'Bahasa Indonesia',
                            'Matematika',
                            'Ilmu Pengetahuan Alam',
                            'Ilmu Pengetahuan Sosial',
                            'Bahasa Inggris',
                            'Pendidikan Jasmani Olahraga dan Kesehatan',
                            'Informatika',
                            'Seni Budaya'
                        ]
                    ];
                } else {
                    // SMA Kelas XI & XII
                    $kategoriMapel = [
                        'A. Muatan Lokal Pesantren' => [
                            'Nahwu Jurumiyah', 'Nahwu Imriti', 'Durusulfiqiyah', 'Akhlaqul Banin', 'B. Arab', 'Taqrib/Matan', 'Minhussaniyah'
                        ],
                        'B. Mata Pelajaran Umum' => [
                            'Pendidikan Agama Islam dan Budi Pekerti',
                            'Pendidikan Pancasila dan Kewarganegaraan',
                            'Bahasa Indonesia',
                            'Matematika',
                            'Ilmu Pengetahuan Alam',
                            'Ilmu Pengetahuan Sosial',
                            'Bahasa Inggris',
                            'Pendidikan Jasmani Olahraga dan Kesehatan',
                            'Informatika'
                        ],
                        'C. Mata Pelajaran Jurusan' => [
                            'Sosiologi', 'Sejarah', 'Geografi', 'Ekonomi'
                        ]
                    ];
                }
            } else {
                // JENJANG SMP
                if (str_contains($rawKelas, '7') || str_contains($rawKelas, 'VII')) {
                    // SMP Kelas VII
                    $kategoriMapel = [
                        'A. Muatan Lokal Pesantren' => [
                            'Imla/Pegon', 'Bahasa Arab', 'Yanbua', 'Fasholatan'
                        ],
                        'B. Mata Pelajaran Umum' => [
                            'Pendidikan Agama Islam dan Budi Pekerti',
                            'Pendidikan Pancasila dan Kewarganegaraan',
                            'Bahasa Indonesia',
                            'Matematika',
                            'Ilmu Pengetahuan Alam',
                            'Ilmu Pengetahuan Sosial',
                            'Bahasa Inggris',
                            'Pendidikan Jasmani Olahraga dan Kesehatan',
                            'Informatika'
                        ]
                    ];
                } else {
                    // SMP Kelas VIII & IX
                    $kategoriMapel = [
                        'A. Muatan Lokal Pesantren' => [
                            'Tajwid', 'Bahasa Arab', 'Akhlaqul Banin', 'Fiqih', 'Jurumiyah'
                        ],
                        'B. Mata Pelajaran Umum' => [
                            'Pendidikan Agama Islam dan Budi Pekerti',
                            'Pendidikan Pancasila dan Kewarganegaraan',
                            'Bahasa Indonesia',
                            'Matematika',
                            'Ilmu Pengetahuan Alam',
                            'Ilmu Pengetahuan Sosial',
                            'Bahasa Inggris',
                            'Pendidikan Jasmani Olahraga dan Kesehatan',
                            'Informatika'
                        ]
                    ];
                }
            }

            // Fungsi Helper untuk pencocokan nama mapel dari DB
            $findScore = function($targetMapel) use ($nilaiMap) {
                $targetLower = strtolower(trim($targetMapel));
                if (isset($nilaiMap[$targetLower])) return $nilaiMap[$targetLower];

                // Alias Matching
                foreach($nilaiMap as $mapelDb => $score) {
                    if (str_contains($mapelDb, $targetLower) || str_contains($targetLower, $mapelDb)) {
                        return $score;
                    }
                    if ($targetLower == 'pendidikan pancasila dan kewarganegaraan' && (str_contains($mapelDb, 'pkn') || str_contains($mapelDb, 'pancasila'))) return $score;
                    if ($targetLower == 'pendidikan agama islam dan budi pekerti' && (str_contains($mapelDb, 'pabd') || str_contains($mapelDb, 'pai'))) return $score;
                    if ($targetLower == 'ilmu pengetahuan alam' && $mapelDb == 'ipa') return $score;
                    if ($targetLower == 'ilmu pengetahuan sosial' && $mapelDb == 'ips') return $score;
                    if ($targetLower == 'pendidikan jasmani olahraga dan kesehatan' && $mapelDb == 'pjok') return $score;
                    if ($targetLower == 'informatika' && $mapelDb == 'tik') return $score;
                    if ($targetLower == 'b. arab' && str_contains($mapelDb, 'arab')) return $score;
                    if ($targetLower == 'nahwu jurumiyah' && str_contains($mapelDb, 'jurumiyah')) return $score;
                    if ($targetLower == 'taqrib/matan' && (str_contains($mapelDb, 'taqrip') || str_contains($mapelDb, 'matan'))) return $score;
                    if ($targetLower == 'durusulfiqiyah' && str_contains($mapelDb, 'durusulfiqiyah')) return $score;
                    if ($targetLower == 'imla/pegon' && (str_contains($mapelDb, 'imla') || str_contains($mapelDb, 'pegon') || str_contains($mapelDb, 'tajwid'))) return $score;
                    if ($targetLower == 'fiqih / fasholatan / yanbua' && (str_contains($mapelDb, 'fiqih') || str_contains($mapelDb, 'fasholatan') || str_contains($mapelDb, 'yanbua'))) return $score;
                }
                return null;
            };

            $totalNilai = 0;
            $countNilai = 0;
            $kkmDefault = 75;
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
                            <td style="width: 95px; color: #000; padding: 1px 0;">Nama</td>
                            <td style="padding: 1px 0;">: <span style="font-weight: bold; text-transform: uppercase;">{{ $siswa->nama ?? '' }}</span></td>
                        </tr>
                        <tr>
                            <td style="color: #000; padding: 1px 0;">NISN / NIS</td>
                            <td style="padding: 1px 0;">: {{ $siswa->nisn ?? $siswa->nis ?? '' }}</td>
                        </tr>
                        <tr>
                            <td style="color: #000; padding: 1px 0;">Nama Sekolah</td>
                            <td style="padding: 1px 0;">: {{ $namaSekolah }}</td>
                        </tr>
                        <tr>
                            <td style="color: #000; padding: 1px 0;">Alamat</td>
                            <td style="padding: 1px 0;">: Jl. Nancang Wetan, Karundang, Cipocok Jaya</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top; padding: 0 0 0 5px;">
                    <table class="no-border" style="width: 100%; border: none;">
                        <tr>
                            <td style="width: 95px; color: #000; padding: 1px 0;">Kelas</td>
                            <td style="padding: 1px 0;">: {{ $siswa->kelas ?? '' }}</td>
                        </tr>
                        <tr>
                            <td style="color: #000; padding: 1px 0;">Fase</td>
                            <td style="padding: 1px 0;">: {{ $fase }}</td>
                        </tr>
                        <tr>
                            <td style="color: #000; padding: 1px 0;">Semester</td>
                            <td style="padding: 1px 0;">: 1 (Satu) / Ganjil</td>
                        </tr>
                        <tr>
                            <td style="color: #000; padding: 1px 0;">Tahun Pelajaran</td>
                            <td style="padding: 1px 0;">: 2026/2027</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Tabel Nilai Utama Persis Format Docx -->
        <div style="margin-bottom: 12px;">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; font-size: 11px;">
                <thead>
                    <tr style="background-color: #ffffff; color: #000; font-weight: bold;">
                        <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 35px;">NO</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">NAMA PELAJARAN</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 45px;">KKM</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 50px;">NILAI</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 45%;">CAPAIAN KOMPETENSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoriMapel as $kategori => $mapels)
                        <!-- Header Kategori (A, B, C) -->
                        <tr style="font-weight: bold; background-color: #f3f4f6;">
                            <td colspan="5" style="border: 1px solid #000; padding: 4px 8px;">{{ $kategori }}</td>
                        </tr>

                        @foreach($mapels as $idx => $itemMapel)
                            @php
                                $score = $findScore($itemMapel);
                                
                                if ($score !== null) {
                                    $totalNilai += $score;
                                    $countNilai++;

                                    if ($score >= 85) {
                                        $capaian = "Menunjukkan penguasaan yang sangat baik dalam memahami materi $itemMapel.";
                                    } elseif ($score >= $kkmDefault) {
                                        $capaian = "Menunjukkan penguasaan yang baik dalam memahami materi $itemMapel.";
                                    } else {
                                        $capaian = "Perlu bimbingan dan pendampingan khusus dalam memahami materi $itemMapel.";
                                    }
                                } else {
                                    $capaian = "";
                                }
                            @endphp
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">{{ $idx + 1 }}</td>
                                <td style="border: 1px solid #000; padding: 3px 6px;">{{ $itemMapel }}</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">{{ $score !== null ? $kkmDefault : '' }}</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">{{ $score !== null ? $score : '' }}</td>
                                <td style="border: 1px solid #000; padding: 3px 6px; font-size: 10px; line-height: 1.2;">{{ $capaian }}</td>
                            </tr>
                        @endforeach
                    @endforeach

                    @php
                        $rataRata = $countNilai > 0 ? round($totalNilai / $countNilai, 2) : 0;
                    @endphp

                    <!-- Summary JUMLAH NILAI & NILAI RATA-RATA -->
                    <tr style="font-weight: bold;">
                        <td colspan="3" style="border: 1px solid #000; padding: 4px 8px; text-align: left;">JUMLAH NILAI</td>
                        <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $totalNilai > 0 ? $totalNilai : '' }}</td>
                        <td style="border: 1px solid #000; padding: 4px;"></td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td colspan="3" style="border: 1px solid #000; padding: 4px 8px; text-align: left;">NILAI RATA-RATA</td>
                        <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $rataRata > 0 ? $rataRata : '' }}</td>
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
                            <tr style="font-weight: bold;">
                                <th colspan="3" style="border: 1px solid #000; padding: 3px; text-align: center;">KEPRIBADIAN</th>
                            </tr>
                            <tr style="font-weight: bold;">
                                <th style="border: 1px solid #000; padding: 3px; text-align: center; width: 30px;">NO</th>
                                <th style="border: 1px solid #000; padding: 3px; text-align: center;">ASPEK</th>
                                <th style="border: 1px solid #000; padding: 3px; text-align: center; width: 45px;">NILAI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">1</td>
                                <td style="border: 1px solid #000; padding: 3px 6px;">Kelakuan</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">B</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">2</td>
                                <td style="border: 1px solid #000; padding: 3px 6px;">Kerajinan</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">B</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">3</td>
                                <td style="border: 1px solid #000; padding: 3px 6px;">Kebersihan/Kerapihan</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">B</td>
                            </tr>
                        </tbody>
                    </table>
                </td>

                <!-- Table Ketidak Hadiran -->
                <td style="width: 49%; vertical-align: top; padding: 0 0 0 1%;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                        <thead>
                            <tr style="font-weight: bold;">
                                <th colspan="3" style="border: 1px solid #000; padding: 3px; text-align: center;">KETIDAK HADIRAN</th>
                            </tr>
                            <tr style="font-weight: bold;">
                                <th style="border: 1px solid #000; padding: 3px; text-align: center; width: 30px;">NO</th>
                                <th style="border: 1px solid #000; padding: 3px; text-align: center;">ALASAN</th>
                                <th style="border: 1px solid #000; padding: 3px; text-align: center; width: 45px;">HARI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">1</td>
                                <td style="border: 1px solid #000; padding: 3px 6px;">Sakit</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">{{ $sakit ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">2</td>
                                <td style="border: 1px solid #000; padding: 3px 6px;">Izin</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">{{ $izin ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center;">3</td>
                                <td style="border: 1px solid #000; padding: 3px 6px;">Tanpa Keterangan</td>
                                <td style="border: 1px solid #000; padding: 3px; text-align: center; font-weight: bold;">{{ $alpa ?? 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Box Catatan Wali Kelas -->
        <div style="border: 1px solid #000; padding: 6px 8px; margin-bottom: 12px; font-size: 11px; min-height: 45px;">
            <p style="font-weight: bold; margin: 0 0 2px 0;">Catatan Wali Kelas:</p>
            <p style="font-style: italic; color: #374151; margin: 0;">Tingkatkan terus semangat belajar dan kedisiplinan dalam beribadah serta mengaji.</p>
        </div>

        <!-- Tanggal & Tanda Tangan Wali Kelas & Orang Tua Persis Dokumen -->
        <div style="font-size: 11px; text-align: right; margin-bottom: 10px; padding-right: 10%;">
            Serang, 1 November 2026
        </div>

        <table class="no-border" style="width: 100%; border: none; font-size: 11px; text-align: center;">
            <tr>
                <td colspan="2" style="font-weight: bold; padding-bottom: 10px;">Mengetahui,</td>
            </tr>
            <tr>
                <td style="width: 50%; padding-bottom: 45px;">Wali/ Orang Tua</td>
                <td style="width: 50%; padding-bottom: 45px;">Wali Kelas</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">( ............................................ )</td>
                <td style="font-weight: bold;">
                    ( ............................................ )<br>
                    <span style="font-weight: normal;">NIP: -</span>
                </td>
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