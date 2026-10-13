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
    <div class="max-w-4xl mx-auto px-4 mb-6 flex justify-between items-center no-print">
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
    <div class="max-w-4xl mx-auto bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-gray-200 print-card">
        
        <!-- Gambar Kop Surat Otomatis Sinkron SMP / SMA -->
        <div class="mb-6">
            @php
                $kelas = strtoupper($siswa->kelas ?? '');
                $gambarKop = str_contains($kelas, 'SMP') ? 'Kop SMP Gambar.png' : 'Kop SMA gambar.png';
            @endphp
            <img src="{{ asset('images/' . $gambarKop) }}" alt="Kop Surat Sekolah Ziyadatul Ilmi" class="w-full h-auto object-contain">
        </div>

        <!-- Identitas Siswa (Langsung Muncul Setelah Kop) -->
        <div class="grid grid-cols-2 gap-4 text-sm mb-6 pt-2">
            <div>
                <table class="w-full text-left">
                    <tr>
                        <td class="w-28 font-semibold text-gray-600 py-1">Nama Siswa</td>
                        <td class="py-1">: <span class="font-bold text-gray-900">{{ $siswa->nama ?? '-' }}</span></td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-1">NISN / NIS</td>
                        <td class="py-1">: {{ $siswa->nisn ?? $siswa->nis ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div>
                <table class="w-full text-left">
                    <tr>
                        <td class="w-28 font-semibold text-gray-600 py-1">Kelas</td>
                        <td class="py-1">: {{ $siswa->kelas ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-1">Tahun Ajaran</td>
                        <td class="py-1">: 2026/2027</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Tabel Nilai Siswa -->
        <div class="overflow-x-auto mb-10">
            <table class="w-full border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-800">
                        <th class="border border-gray-300 px-4 py-2.5 text-center w-12">No</th>
                        <th class="border border-gray-300 px-4 py-2.5 text-left">Mata Pelajaran</th>
                        <th class="border border-gray-300 px-4 py-2.5 text-center w-24">KKM</th>
                        <th class="border border-gray-300 px-4 py-2.5 text-center w-28">Nilai Akhir</th>
                        <th class="border border-gray-300 px-4 py-2.5 text-center w-40">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilais ?? [] as $index => $nilai)
                        @php
                            $score = $nilai->nilai;
                            $kkm = 75; // Nilai KKM Standar
                            
                            // Hanya tampilkan 'Remedial' jika nilai di bawah KKM
                            $keterangan = $score < $kkm ? 'Remedial' : '-';
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2.5 text-center font-medium text-gray-600">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-2.5">
                                <span class="font-semibold text-gray-900">{{ $nilai->mata_pelajaran }}</span>
                                @if(!empty($nilai->jenis_ujian))
                                    <span class="text-xs text-gray-500 font-mono ml-1">({{ $nilai->jenis_ujian }})</span>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2.5 text-center font-semibold text-gray-600">{{ $kkm }}</td>
                            <td class="border border-gray-300 px-4 py-2.5 text-center font-bold text-gray-900">{{ $score }}</td>
                            <td class="border border-gray-300 px-4 py-2.5 text-center font-semibold {{ $score < $kkm ? 'text-red-600' : 'text-gray-500' }}">
                                {{ $keterangan }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border border-gray-300 px-4 py-6 text-center text-gray-400 italic">
                                Belum ada data nilai yang diinput untuk santri/siswa ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tanda Tangan Wali Kelas & Orang Tua -->
        <div class="grid grid-cols-2 gap-8 text-center text-sm pt-6">
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