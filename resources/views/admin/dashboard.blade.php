<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Portal Sekolah Ziyadatul Ilmi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tom Select (Fitur Ketik & Cari Nama Siswa) -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <style>
        .ts-control {
            border-radius: 0.75rem !important;
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            border-color: #d1d5db !important;
        }
        .ts-wrapper.single .ts-control {
            background-color: #ffffff !important;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    <!-- Top Navigation Bar -->
    <nav class="bg-[#004d25] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <span class="bg-yellow-400 text-[#004d25] text-xs font-black px-2.5 py-1 rounded-md uppercase tracking-wider">ADMIN</span>
                <h1 class="font-bold text-lg">Dashboard Portal Sekolah</h1>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="text-xs bg-white/10 hover:bg-white/20 text-white px-3 py-1.5 rounded-lg transition flex items-center gap-1.5">
                    <i class="fa-solid fa-globe"></i> Lihat Web
                </a>
                <a href="{{ route('home') }}" class="text-xs bg-red-600 hover:bg-red-700 text-white font-bold px-3 py-1.5 rounded-lg transition">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- Notifikasi Pesan Sukses -->
        @if(session('success'))
        <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded-2xl text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-green-600 text-base"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @endif

        <!-- Grid Input Absensi & Filter Export Excel Nilai -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- 1. Input Absensi Harian (Bisa Ketik / Cari Nama) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex flex-col justify-between">
                <div>
                    <h2 class="text-base font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-[#004d25]"></i> Input Kehadiran Santri
                    </h2>

                    <form action="{{ route('admin.absensi.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama Siswa & Kelas</label>
                            <select id="select-siswa-absensi" name="siswa_id" required placeholder="-- Ketik atau Pilih Nama Siswa --">
                                <option value="">-- Ketik atau Pilih Nama Siswa --</option>
                                @foreach($siswas->groupBy('kelas') as $namaKelas => $groupSiswa)
                                    <optgroup label="--- {{ $namaKelas }} ---">
                                        @foreach($groupSiswa as $siswa)
                                            <option value="{{ $siswa->id }}">{{ $siswa->nama }} ({{ $siswa->kelas }})</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Status Kehadiran</label>
                                <select name="status" required class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none bg-white">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Alpa">Alpa</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#004d25] hover:bg-[#00381b] text-white font-bold py-2.5 rounded-xl text-sm transition shadow-sm mt-2">
                            Simpan Absensi
                        </button>
                    </form>
                </div>

                <div class="mt-6 pt-4 border-t space-y-2">
                    <a href="{{ route('admin.absensi.export') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-xs transition shadow-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-file-excel text-sm"></i> Download Excel Rekap Kehadiran Santri (.XLS)
                    </a>

                    <form action="{{ route('admin.absensi.reset') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGHAPUS SELURUH data absensi?')">
                        @csrf
                        <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-700 font-semibold py-2 rounded-xl text-xs transition border border-red-200 flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-trash-can"></i> Reset Seluruh Data Absensi
                        </button>
                    </form>
                </div>
            </div>

            <!-- 2. Export Excel Nilai & Reset Nilai -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex flex-col justify-between">
                <div>
                    <h2 class="text-base font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                        <i class="fa-solid fa-file-excel text-green-600"></i> Export Rekap Nilai Siswa (.XLS)
                    </h2>

                    <form action="{{ route('admin.nilai.export') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Filter Kelas</label>
                                <select name="kelas" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none bg-white">
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach($kelases as $kelas)
                                        <option value="{{ $kelas }}">{{ $kelas }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Filter Mapel</label>
                                <input type="text" name="mata_pelajaran" placeholder="Semua Mapel" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl text-sm transition shadow-sm flex items-center justify-center gap-2 mt-2">
                            <i class="fa-solid fa-download"></i> Download Excel Nilai Berdasarkan Filter
                        </button>
                    </form>
                </div>

                <div class="mt-6 pt-4 border-t space-y-2">
                    <form action="{{ route('admin.nilai.reset') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGHAPUS SELURUH data nilai?')">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-arrow-rotate-right"></i> Reset Seluruh Data Nilai
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- 3. FORM INPUT NILAI PERORANGAN AKURAT (SMP / SMA) -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
            <div class="mb-4 pb-3 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-[#004d25]"></i> Input Nilai Santri / Siswa (Perorangan)
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Pilih nama siswa, filter jenjang mapel (SMP/SMA), lalu isi semua nilai sekaligus.</p>
                </div>
                
                <!-- Tab Filter Jenjang SMP/SMA -->
                <div class="flex bg-gray-100 p-1 rounded-xl gap-1">
                    <button type="button" onclick="switchJenjang('SMP')" id="btn-smp" class="px-4 py-1.5 rounded-lg text-xs font-bold bg-[#004d25] text-white shadow-sm transition">
                        Jenjang SMP
                    </button>
                    <button type="button" onclick="switchJenjang('SMA')" id="btn-sma" class="px-4 py-1.5 rounded-lg text-xs font-bold text-gray-600 hover:text-gray-900 transition">
                        Jenjang SMA
                    </button>
                </div>
            </div>

            <form action="{{ route('admin.nilai.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Pilihan Nama Siswa (Bisa Ketik / Cari Nama) & Jenis Ujian -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilih Nama Siswa & Kelas</label>
                        <select id="select-siswa-nilai" name="siswa_id" required placeholder="-- Ketik atau Pilih Nama Siswa --">
                            <option value="">-- Ketik atau Pilih Nama Siswa --</option>
                            @foreach($siswas->groupBy('kelas') as $namaKelas => $groupSiswa)
                                <optgroup label="--- {{ $namaKelas }} ---">
                                    @foreach($groupSiswa as $siswa)
                                        <option value="{{ $siswa->id }}">{{ $siswa->nama }} ({{ $siswa->kelas }})</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Jenis Ujian / Penilaian</label>
                        <select name="jenis_ujian" required class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none bg-white">
                            <option value="PSTS Ganjil">PSTS Ganjil (Penilaian Sumatif Tengah Semester)</option>
                            <option value="PAS Ganjil">PAS Ganjil</option>
                            <option value="Ulangan Harian">Ulangan Harian</option>
                        </select>
                    </div>
                </div>

                <!-- DAFTAR MAPEL SMP -->
                <div id="container-smp">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-3">Daftar Mata Pelajaran SMP Ziyadatul Ilmi (0 - 100)</label>
                    @php
                        $mapelSmp = [
                            'Bahasa Indonesia',
                            'Bahasa Inggris',
                            'Bahasa Arab',
                            'Matematika',
                            'IPA',
                            'IPS',
                            'PKn',
                            'PJOK',
                            'TIK',
                            'PABD',
                            'Tajwid / Imla / Pegon',
                            'Akhlaqul Banin',
                            'Fiqih / Fasholatan / Yanbua',
                            'Jurumiyah',
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($mapelSmp as $mapel)
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-200 hover:border-gray-300 transition">
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">{{ $mapel }}</label>
                            <input type="number" name="nilai_mapel[{{ $mapel }}]" min="0" max="100" placeholder="0 - 100" class="input-smp w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none bg-white">
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- DAFTAR MAPEL SMA -->
                <div id="container-sma" class="hidden">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-3">Daftar Mata Pelajaran SMA Ziyadatul Ilmi (0 - 100)</label>
                    @php
                        $mapelSma = [
                            'Bahasa Indonesia',
                            'Bahasa Inggris',
                            'Bahasa Arab',
                            'Matematika',
                            'PKn',
                            'PJOK',
                            'TIK',
                            'PABD',
                            'IPS / IPAS / SBK',
                            'Ekonomi',
                            'Sejarah',
                            'Geografi',
                            'Sosiologi',
                            'Akhlaqul Banin',
                            'Jurumiyah / Imriti',
                            'Durusulfiqiyah / Taqrip / Matan',
                            'Minahussaniyah',
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($mapelSma as $mapel)
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-200 hover:border-gray-300 transition">
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">{{ $mapel }}</label>
                            <input type="number" name="nilai_mapel[{{ $mapel }}]" disabled min="0" max="100" placeholder="0 - 100" class="input-sma w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none bg-white">
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-right pt-2 border-t">
                    <button type="submit" class="bg-[#004d25] hover:bg-[#00381b] text-white font-bold px-6 py-2.5 rounded-xl text-sm transition shadow-sm inline-flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Semua Nilai Siswa Ini
                    </button>
                </div>
            </form>
        </div>

        <!-- 4. Tabel Daftar Siswa & E-Raport Digital -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
            <h2 class="text-base font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                <i class="fa-solid fa-list-check text-[#004d25]"></i> Rekapitulasi & E-Raport Siswa
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 border-b">
                            <th class="p-3">No</th>
                            <th class="p-3">Nama Siswa</th>
                            <th class="p-3">Kelas</th>
                            <th class="p-3 text-center">Aksi Raport</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($siswas as $idx => $siswa)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-medium text-gray-500">{{ $idx + 1 }}</td>
                            <td class="p-3 font-semibold text-gray-800">{{ $siswa->nama }}</td>
                            <td class="p-3 text-gray-600">{{ $siswa->kelas }}</td>
                            <td class="p-3 text-center">
                                <a href="{{ route('raport.show', $siswa->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition shadow-sm">
                                    <i class="fa-solid fa-print"></i> Buka E-Raport
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-400 italic">Belum ada data siswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Script Searchable Dropdown & Switcher -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Searchable Dropdown untuk Absensi & Nilai
            new TomSelect('#select-siswa-absensi', {
                create: false,
                sortField: { field: 'text', direction: 'asc' }
            });

            new TomSelect('#select-siswa-nilai', {
                create: false,
                sortField: { field: 'text', direction: 'asc' }
            });
        });

        function switchJenjang(jenjang) {
            const containerSmp = document.getElementById('container-smp');
            const containerSma = document.getElementById('container-sma');
            const btnSmp = document.getElementById('btn-smp');
            const btnSma = document.getElementById('btn-sma');
            const inputsSmp = document.querySelectorAll('.input-smp');
            const inputsSma = document.querySelectorAll('.input-sma');

            if (jenjang === 'SMP') {
                containerSmp.classList.remove('hidden');
                containerSma.classList.add('hidden');
                
                inputsSmp.forEach(i => i.removeAttribute('disabled'));
                inputsSma.forEach(i => i.setAttribute('disabled', 'true'));

                btnSmp.className = "px-4 py-1.5 rounded-lg text-xs font-bold bg-[#004d25] text-white shadow-sm transition";
                btnSma.className = "px-4 py-1.5 rounded-lg text-xs font-bold text-gray-600 hover:text-gray-900 transition";
            } else {
                containerSma.classList.remove('hidden');
                containerSmp.classList.add('hidden');

                inputsSma.forEach(i => i.removeAttribute('disabled'));
                inputsSmp.forEach(i => i.setAttribute('disabled', 'true'));

                btnSma.className = "px-4 py-1.5 rounded-lg text-xs font-bold bg-[#004d25] text-white shadow-sm transition";
                btnSmp.className = "px-4 py-1.5 rounded-lg text-xs font-bold text-gray-600 hover:text-gray-900 transition";
            }
        }
    </script>

</body>
</html>