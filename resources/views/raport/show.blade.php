<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Raport Digital - {{ $siswa->nama ?? 'Siswa' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
            }
            .print-card {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 py-8">

    <!-- Tombol Aksi (Kembali & Cetak) -->
    <div class="max-w-5xl mx-auto px-4 mb-6 flex justify-between items-center no-print">
        <div>
            <h1 class="text-xl font-bold text-gray-800">E-Raport Digital</h1>
            <p class="text-xs text-gray-500">Laporan Hasil Belajar Kurikulum Merdeka</p>
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

        <!-- Identitas Siswa Sesuai Format Sekolah -->
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

        <!-- Tabel Nilai & Capaian Kompetensi -->
        <div class="overflow-x-auto mb-8">
            <table class="w-full border-collapse border border-gray-400 text-xs md:text-sm">
                <thead>
                    <tr class="bg-emerald-50 text-emerald-950">
                        <th class="border border-gray-400 px-3 py-2.5 text-center w-10">No</th>
                        <th class="border border-gray-400 px-4 py-2.5 text-left w-52">Mata Pelajaran</th>
                        <th class="border border-gray-400 px-3 py-2.5 text-center w-20">Nilai Akhir</th>
                        <th class="border border-gray-400 px-4 py-2.5 text-center">Capaian Kompetensi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilais ?? [] as $index => $nilai)
                        @php
                            $score = $nilai->nilai;
                            $mapel = $nilai->mata_pelajaran;
                            
                            // Generator Capaian Kompetensi Otomatis
                            if ($score >= 85) {
                                $tinggi = "Menunjukkan penguasaan yang sangat baik dalam memahami materi utama $mapel serta mampu mengaplikasikannya secara mandiri.";
                                $rendah = "Perlu mempertahankan dan mengasah konsistensi pemahaman pada materi pendukung.";
                            } elseif ($score >= 75) {
                                $tinggi = "Menunjukkan penguasaan dalam memahami konsep dasar materi $mapel dengan baik.";
                                $rendah = "Perlu bantuan dan latihan lebih lanjut dalam pemahaman pemecahan masalah kompleks.";
                            } else {
                                $tinggi = "Menunjukkan penguasaan cukup pada beberapa konsep dasar $mapel.";
                                $rendah = "Perlu bimbingan dan pendampingan khusus dalam memahami keseluruhan capaian pembelajaran $mapel.";
                            }
                        @endphp
                        <tr class="align-top">
                            <td class="border border-gray-400 px-3 py-3 text-center font-medium">{{ $index + 1 }}</td>
                            <td class="border border-gray-400 px-4 py-3 font-semibold text-gray-900">
                                {{ $mapel }}
                                @if(!empty($nilai->jenis_ujian))
                                    <span class="block text-[11px] font-normal text-gray-500">({{ $nilai->jenis_ujian }})</span>
                                @endif
                            </td>
                            <td class="border border-gray-400 px-3 py-3 text-center font-bold text-gray-900 text-base">{{ $score }}</td>
                            <td class="border border-gray-400 px-4 py-3 text-xs leading-relaxed space-y-2">
                                <p class="text-gray-800">• {{ $tinggi }}</p>
                                <p class="text-gray-600 italic">• {{ $rendah }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border border-gray-400 px-4 py-6 text-center text-gray-400 italic">
                                Belum ada data nilai yang diinput untuk santri/siswa ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tanda Tangan -->
        <div class="grid grid-cols-2 gap-8 text-center text-xs md:text-sm pt-4">
            <div>
                <p class="text-gray-600 mb-16">Orang Tua / Wali Siswa,</p>
                <p class="font-bold text-gray-900">( ............................................ )</p>
            </div>
            <div>
                <p class="text-gray-600 mb-16">Wali Kelas,</p>
                <p class="font-bold text-gray-900">( ............................................ )</p>
            </div>
        </div>

    </div>

</body>
</html>