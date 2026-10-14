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
    </style>
</head>
<body class="bg-gray-100 text-gray-800 py-8">

    <!-- Tombol Aksi (Kembali & Cetak) -->
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
                🖨️ Cetak Raport / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Container Lembar Raport -->
    <div class="max-w-5xl mx-auto bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-gray-200 print-card">
        
        <!-- Gambar Kop Surat Otomatis Sinkron SMP / SMA -->
        <div class="mb-6">
            @php
                $kelas = strtoupper($siswa->kelas ?? '');
                $isSmp = str_contains($kelas, 'SMP') || str_contains($kelas, 'VII') || str_contains($kelas, 'VIII') || str_contains($kelas, 'IX');
                $gambarKop = $isSmp ? 'Kop SMP Gambar.png' : 'Kop SMA gambar.png';
                $fase = $isSmp ? 'D' : 'F';
            @endphp
            <img src="{{ asset('images/' . $gambarKop) }}" alt="Kop Surat Sekolah Ziyadatul Ilmi" class="w-full h-auto object-contain">
        </div>

        <!-- Identitas Siswa -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs md:text-sm mb-6 border-b pb-4">
            <div>
                <table class="w-full text-left">
                    <tr class="align-top">
                        <td class="w-28 font-semibold text-gray-700 py-1">Nama</td>
                        <td class="py-1">: <span class="font-bold text-gray-900 uppercase">{{ $siswa->nama ?? '-' }}</span></td>
                    </tr>
                    <tr class="align-top">
                        <td class="font-semibold text-gray-700 py-1">NISN / NIS</td>
                        <td class="py-1">: {{ $siswa->nisn ?? $siswa->nis ?? '-' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="font-semibold text-gray-700 py-1">Nama Sekolah</td>
                        <td class="py-1">: <span class="font-semibold">{{ $isSmp ? 'SMP ZIYADATUL ILMI KOTA SERANG' : 'SMA ZIYADATUL ILMI KOTA SERANG' }}</span></td>
                    </tr>
                    <tr class="align-top">
                        <td class="font-semibold text-gray-700 py-1">Alamat</td>
                        <td class="py-1">: Jl. Nancang Wetan, Karundang, Cipocok Jaya</td>
                    </tr>
                </table>
            </div>
            <div>
                <table class="w-full text-left">
                    <tr class="align-top">
                        <td class="w-28 font-semibold text-gray-700 py-1">Kelas</td>
                        <td class="py-1">: <span class="font-bold">{{ $siswa->kelas ?? '-' }}</span></td>
                    </tr>
                    <tr class="align-top">
                        <td class="font-semibold text-gray-700 py-1">Fase</td>
                        <td class="py-1">: {{ $fase }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="font-semibold text-gray-700 py-1">Semester</td>
                        <td class="py-1">: 1 (Satu) / Ganjil</td>
                    </tr>
                    <tr class="align-top">
                        <td class="font-semibold text-gray-700 py-1">Tahun Pelajaran</td>
                        <td class="py-1">: 2026/2027</td>
                    </tr>
                </table>
            </div>
        </div>

        @php
            $totalNilai = 0;
            $countNilai = 0;
            $kkmDefault = 75;

            foreach($nilais ?? [] as $n) {
                $totalNilai += $n->nilai;
                $countNilai++;
            }
            
            $rataRata = $countNilai > 0 ? round($totalNilai / $countNilai, 2) : 0;

            // Logika Fleksibel Hitung Rekap Absensi Langsung dari Tabel Absensis Database
            $siswaId = $siswa->id ?? 0;
            
            $realSakit = \DB::table('absensis')
                ->where('siswa_id', $siswaId)
                ->whereRaw('LOWER(status) IN (?, ?)', ['sakit', 's'])
                ->count();

            $realIzin = \DB::table('absensis')
                ->where('siswa_id', $siswaId)
                ->whereRaw('LOWER(status) IN (?, ?)', ['izin', 'i'])
                ->count();

            $realAlpa = \DB::table('absensis')
                ->where('siswa_id', $siswaId)
                ->whereRaw('LOWER(status) IN (?, ?, ?, ?)', ['alpa', 'tanpa keterangan', 'a', 'tk'])
                ->count();
        @endphp

        <!-- Tabel Nilai Sesuai Inputan Manual Guru/Admin -->
        <div class="overflow-x-auto mb-6">
            <table class="w-full border-collapse border border-gray-900 text-xs md:text-sm">
                <thead>
                    <tr class="bg-gray-300 text-gray-900 font-bold">
                        <th rowspan="2" class="border border-gray-900 px-2 py-2 text-center w-12 align-middle">NO.</th>
                        <th rowspan="2" class="border border-gray-900 px-3 py-2 text-center align-middle">Nama Pelajaran</th>
                        <th colspan="3" class="border border-gray-900 px-3 py-1 text-center">Nilai Murni ASTS</th>
                    </tr>
                    <tr class="bg-gray-300 text-gray-900 font-bold">
                        <th class="border border-gray-900 px-2 py-1 text-center w-16">KKM</th>
                        <th class="border border-gray-900 px-2 py-1 text-center w-20">NILAI</th>
                        <th class="border border-gray-900 px-3 py-1 text-center w-1/2">CAPAIAN KOMPETENSI</th>
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
                            <td class="border border-gray-900 px-2 py-1.5 text-center font-medium">{{ $index + 1 }}</td>
                            <td class="border border-gray-900 px-3 py-1.5 font-semibold text-gray-900">
                                {{ $mapel }}
                                @if(!empty($nilai->jenis_ujian))
                                    <span class="text-xs text-gray-500 font-normal">({{ $nilai->jenis_ujian }})</span>
                                @endif
                            </td>
                            <td class="border border-gray-900 px-2 py-1.5 text-center font-semibold text-gray-700">{{ $kkmDefault }}</td>
                            <td class="border border-gray-900 px-2 py-1.5 text-center font-bold text-gray-900">{{ $score }}</td>
                            <td class="border border-gray-900 px-3 py-1.5 text-xs text-gray-800">{{ $capaian }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border border-gray-900 px-4 py-6 text-center text-gray-400 italic">
                                Belum ada data nilai yang diinput oleh guru/admin.
                            </td>
                        </tr>
                    @endforelse

                    <!-- Summary / Total & Rata-rata -->
                    <tr class="font-bold bg-gray-50">
                        <td colspan="3" class="border border-gray-900 px-3 py-1.5 text-right">Jumlah Nilai :</td>
                        <td class="border border-gray-900 px-2 py-1.5 text-center font-bold">{{ $totalNilai > 0 ? $totalNilai : '-' }}</td>
                        <td class="border border-gray-900 px-3 py-1.5"></td>
                    </tr>
                    <tr class="font-bold bg-gray-50">
                        <td colspan="3" class="border border-gray-900 px-3 py-1.5 text-right">Nilai Rata-rata Mata Pelajaran :</td>
                        <td class="border border-gray-900 px-2 py-1.5 text-center font-bold">{{ $rataRata > 0 ? $rataRata : '-' }}</td>
                        <td class="border border-gray-900 px-3 py-1.5"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabel Kepribadian & Ketidak Hadiran Side by Side -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 text-xs md:text-sm">
            <!-- Table Kepribadian -->
            <div>
                <table class="w-full border-collapse border border-gray-900">
                    <thead>
                        <tr class="bg-gray-300 font-bold">
                            <th colspan="3" class="border border-gray-900 px-2 py-1 text-center">KEPRIBADIAN</th>
                        </tr>
                        <tr class="bg-gray-200 font-bold">
                            <th class="border border-gray-900 px-2 py-1 text-center w-10">NO.</th>
                            <th class="border border-gray-900 px-3 py-1 text-center">ASPEK</th>
                            <th class="border border-gray-900 px-2 py-1 text-center w-16">NILAI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-900 px-2 py-1 text-center">1</td>
                            <td class="border border-gray-900 px-3 py-1">Kelakuan</td>
                            <td class="border border-gray-900 px-2 py-1 text-center font-semibold">B</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-900 px-2 py-1 text-center">2</td>
                            <td class="border border-gray-900 px-3 py-1">Kerajinan</td>
                            <td class="border border-gray-900 px-2 py-1 text-center font-semibold">B</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-900 px-2 py-1 text-center">3</td>
                            <td class="border border-gray-900 px-3 py-1">Kebersihan/Kerapihan</td>
                            <td class="border border-gray-900 px-2 py-1 text-center font-semibold">B</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Table Ketidak Hadiran (Otomatis Sinkron dari Database Absensi) -->
            <div>
                <table class="w-full border-collapse border border-gray-900">
                    <thead>
                        <tr class="bg-gray-300 font-bold">
                            <th colspan="3" class="border border-gray-900 px-2 py-1 text-center">KETIDAK HADIRAN</th>
                        </tr>
                        <tr class="bg-gray-200 font-bold">
                            <th class="border border-gray-900 px-2 py-1 text-center w-10">NO.</th>
                            <th class="border border-gray-900 px-3 py-1 text-center">ALASAN</th>
                            <th class="border border-gray-900 px-2 py-1 text-center w-16">HARI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-900 px-2 py-1 text-center">1</td>
                            <td class="border border-gray-900 px-3 py-1">Sakit</td>
                            <td class="border border-gray-900 px-2 py-1 text-center font-semibold">{{ $realSakit }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-900 px-2 py-1 text-center">2</td>
                            <td class="border border-gray-900 px-3 py-1">Izin</td>
                            <td class="border border-gray-900 px-2 py-1 text-center font-semibold">{{ $realIzin }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-900 px-2 py-1 text-center">3</td>
                            <td class="border border-gray-900 px-3 py-1">Tanpa Keterangan</td>
                            <td class="border border-gray-900 px-2 py-1 text-center font-semibold">{{ $realAlpa }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Box Catatan Wali Kelas -->
        <div class="border border-gray-900 p-3 rounded-none mb-8 text-xs md:text-sm min-h-[90px]">
            <p class="font-bold italic text-gray-900">Catatan Wali Kelas :</p>
            <p class="mt-2 text-gray-700 italic">Tingkatkan terus semangat belajar dan kedisiplinan dalam beribadah serta mengaji.</p>
        </div>

        <!-- Tanda Tangan Wali Kelas & Orang Tua -->
        <div class="grid grid-cols-2 gap-8 text-center text-xs md:text-sm pt-2">
            <div>
                <p class="text-gray-700 mb-16">Orang Tua / Wali Siswa,</p>
                <p class="font-bold text-gray-900">( ............................................ )</p>
            </div>
            <div>
                <p class="text-gray-700 mb-16">Wali Kelas,</p>
                <p class="font-bold text-gray-900">( ............................................ )</p>
            </div>
        </div>

    </div>

</body>
</html>