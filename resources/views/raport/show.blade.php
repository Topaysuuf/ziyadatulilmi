<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Raport Digital - {{ $siswa->nama ?? $siswa->nama_siswa ?? 'Siswa' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; padding: 0 !important; margin: 0 !important; }
            .print-container { max-width: 100% !important; width: 100% !important; padding: 0 !important; box-shadow: none !important; border: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-4 md:p-6 text-gray-800">

    <div class="max-w-4xl mx-auto">
        <!-- Tombol Cetak & Kembali (Sembunyi saat diprint) -->
        <div class="no-print flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div>
                <h1 class="text-xl font-bold text-gray-800">E-Raport Digital</h1>
                <p class="text-sm text-gray-500">Laporan Hasil Belajar Siswa</p>
            </div>
            <div class="flex gap-2">
                <a href="javascript:history.back()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition">
                    ← Kembali
                </a>
                <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700 transition flex items-center gap-2">
                    🖨️ Cetak Raport / Simpan PDF
                </button>
            </div>
        </div>

        <!-- Lembar Raport -->
        <div class="print-container bg-white p-6 md:p-8 rounded-lg border border-gray-200 shadow-sm">
            
            <!-- Header Dokumen -->
            <div class="border-b-2 border-gray-800 pb-3 mb-6 text-center">
                <h2 class="text-2xl font-bold uppercase tracking-wider text-gray-900">LAPORAN HASIL BELAJAR SISWA</h2>
                <p class="text-sm text-gray-600 uppercase">E-RAPORT DIGITAL SEKOLAH</p>
            </div>

            <!-- Identitas Siswa -->
            <div class="grid grid-cols-2 gap-4 mb-6 text-sm text-gray-800">
                <div>
                    <table class="w-full text-left border-separate border-spacing-y-1">
                        <tr>
                            <td class="font-semibold w-32">Nama Siswa</td>
                            <td>: {{ $siswa->nama ?? $siswa->nama_siswa ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold">NISN / NIS</td>
                            <td>: {{ $siswa->nisn ?? $siswa->nis ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table class="w-full text-left border-separate border-spacing-y-1">
                        <tr>
                            <td class="font-semibold w-32">Kelas</td>
                            <td>: {{ $siswa->kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold">Tahun Ajaran</td>
                            <td>: {{ date('Y') }}/{{ date('Y')+1 }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Tabel Rekap Nilai -->
            <div class="overflow-x-auto mb-8">
                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-800 font-semibold">
                            <th class="border border-gray-300 px-3 py-2 text-center w-12">No</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Mata Pelajaran</th>
                            <th class="border border-gray-300 px-3 py-2 text-center w-28">Nilai Akhir</th>
                            <th class="border border-gray-300 px-3 py-2 text-center w-24">Predikat</th>
                            <th class="border border-gray-300 px-4 py-2 text-center w-36">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilais as $index => $item)
                            @php
                                $val = $item->nilai_akhir ?? $item->nilai ?? $item->skor ?? 0;
                                
                                if ($val >= 85) { 
                                    $predikat = 'A'; $ket = 'Sangat Baik'; 
                                } elseif ($val >= 75) { 
                                    $predikat = 'B'; $ket = 'Baik'; 
                                } elseif ($val >= 65) { 
                                    $predikat = 'C'; $ket = 'Cukup'; 
                                } else { 
                                    $predikat = 'D'; $ket = 'Perlu Bimbingan'; 
                                }
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-3 py-2 text-center">{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-4 py-2 font-medium text-gray-800">
                                    {{ $item->mapel->nama_mapel ?? $item->mapel->mapel ?? 'Mata Pelajaran' }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center font-bold text-gray-900">{{ $val }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center font-semibold">{{ $predikat }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center text-gray-700">{{ $ket }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border border-gray-300 px-4 py-6 text-center text-gray-500 italic">
                                    Belum ada data nilai yang di-input oleh guru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Kolom Tanda Tangan -->
            <div class="grid grid-cols-2 text-center text-sm text-gray-800 mt-12 print:mt-16">
                <div>
                    <p class="mb-16">Orang Tua / Wali Siswa,</p>
                    <p class="font-semibold text-gray-900">( .................................... )</p>
                </div>
                <div>
                    <p class="mb-16">Wali Kelas,</p>
                    <p class="font-semibold text-gray-900">( .................................... )</p>
                </div>
            </div>

        </div>
    </div>

</body>
</html>