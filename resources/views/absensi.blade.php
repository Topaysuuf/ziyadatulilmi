<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kehadiran Santri - Pondok Pesantren Ziyadatul Ilmi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar Publik -->
    <nav class="bg-[#004d25] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="font-bold text-lg hover:text-yellow-300 transition flex items-center gap-2">
                    <i class="fa-solid fa-mosque"></i> Pondok Pesantren Ziyadatul Ilmi
                </a>
            </div>
            <div class="flex items-center space-x-4 text-sm">
                <a href="{{ route('home') }}" class="hover:text-yellow-300 transition flex items-center gap-1">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
                <a href="{{ route('nilai') }}" class="hover:text-yellow-300 transition flex items-center gap-1">
                    <i class="fa-solid fa-graduation-cap"></i> Ujian & Nilai
                </a>
                <a href="{{ route('login') }}" class="bg-yellow-400 text-[#004d25] font-bold px-3 py-1.5 rounded-lg text-xs hover:bg-yellow-300 transition">
                    Login Admin
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Halaman & Pencarian -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-[#004d25]"></i> Rekap Kehadiran Santri
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Cari dan lihat rekap persentase presensi harian santri</p>
                </div>
                <!-- Input Pencarian -->
                <div class="w-full md:w-72">
                    <div class="relative">
                        <input type="text" id="search-input" placeholder="Cari Nama / NISN..." 
                               class="w-full pl-10 pr-4 py-2 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#004d25]">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-sm"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Presensi Santri -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm" id="table-absensi">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 font-semibold border-b border-gray-100 uppercase text-xs">
                            <th class="px-6 py-4 text-center w-12">No</th>
                            <th class="px-6 py-4">NISN / ID</th>
                            <th class="px-6 py-4">Nama Santri</th>
                            <th class="px-6 py-4 text-center">Kelas</th>
                            <th class="px-6 py-4 text-center">Hadir</th>
                            <th class="px-6 py-4 text-center">Izin</th>
                            <th class="px-6 py-4 text-center">Sakit</th>
                            <th class="px-6 py-4 text-center">Alpa</th>
                            <th class="px-6 py-4 text-center">% Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($siswas ?? [] as $index => $siswa)
                            @php
                                $hadir = \Illuminate\Support\Facades\DB::table('absensis')->where('siswa_id', $siswa->id)->where('status', 'Hadir')->count();
                                $izin  = \Illuminate\Support\Facades\DB::table('absensis')->where('siswa_id', $siswa->id)->where('status', 'Izin')->count();
                                $sakit = \Illuminate\Support\Facades\DB::table('absensis')->where('siswa_id', $siswa->id)->where('status', 'Sakit')->count();
                                $alpa  = \Illuminate\Support\Facades\DB::table('absensis')->where('siswa_id', $siswa->id)->where('status', 'Alpa')->count();

                                $total = $hadir + $izin + $sakit + $alpa;
                                $persen = $total > 0 ? round(($hadir / $total) * 100) : 0;
                            @endphp
                            <tr class="hover:bg-gray-50 transition row-siswa">
                                <td class="px-6 py-4 text-center font-bold text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-mono text-gray-600 cell-nisn">{{ $siswa->nisn ?? $siswa->nis ?? '-' }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900 cell-nama">{{ $siswa->nama ?? $siswa->nama_siswa ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-gray-600">{{ $siswa->kelas ?? '-' }}</td>
                                <td class="px-6 py-4 text-center font-semibold text-green-600">{{ $hadir }}</td>
                                <td class="px-6 py-4 text-center font-semibold text-blue-600">{{ $izin }}</td>
                                <td class="px-6 py-4 text-center font-semibold text-yellow-600">{{ $sakit }}</td>
                                <td class="px-6 py-4 text-center font-semibold text-red-600">{{ $alpa }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $persen < 75 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $persen }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-gray-400 italic">
                                    Belum ada data santri yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script Pencarian Realtime -->
    <script>
        document.getElementById('search-input').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('.row-siswa');

            rows.forEach(row => {
                let nama = row.querySelector('.cell-nama').textContent.toLowerCase();
                let nisn = row.querySelector('.cell-nisn').textContent.toLowerCase();

                if (nama.includes(filter) || nisn.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>