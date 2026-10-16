<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SMA Ziyadatul Ilmi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            
            <!-- 1. Input Absensi Harian + Download Excel Absensi + Reset -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex flex-col justify-between">
                <div>
                    <h2 class="text-base font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-[#004d25]"></i> Input Kehadiran Santri
                    </h2>

                    <form action="{{ route('admin.absensi.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama Siswa & Kelas</label>
                            <select name="siswa_id" required class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none bg-white">
                                <option value="">-- Ketik / Pilih Nama Siswa --</option>
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->nama }} (Kelas: {{ $siswa->kelas }})</option>
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

                <!-- Tombol Download Rekap Absensi & Reset Absensi -->
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

            <!-- 2. Download Rekap Excel Nilai & Reset Nilai -->
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

        <!-- 3. FORM INPUT NILAI PERORANGAN (SEMUA MAPEL SEKALIGUS) -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
            <div class="mb-4 pb-3 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-[#004d25]"></i> Input Nilai Santri / Siswa (Perorangan)
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Pilih nama siswa, lalu isi semua nilai mata pelajaran sekaligus dalam satu tampilan.</p>
                </div>
            </div>

            <form action="{{ route('admin.nilai.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Pilihan Nama Siswa & Jenis Ujian -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilih Nama Siswa & Kelas</label>
                        <select name="siswa_id" required class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none bg-white">
                            <option value="">-- Pilih Nama Siswa --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }} (Kelas: {{ $siswa->kelas }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Jenis Ujian / Penilaian</label>
                        <select name="jenis_ujian" required class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none bg-white">
                            <option value="UTS">UTS / ASTS</option>
                            <option value="UAS">UAS / ASAS</option>
                            <option value="Ulangan Harian">Ulangan Harian</option>
                            <option value="Tugas">Tugas</option>
                        </select>
                    </div>
                </div>

                <!-- Grid Seluruh Mata Pelajaran Langsung Tersedia -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-3">Daftar Nilai Mata Pelajaran (0 - 100)</label>
                    
                    @php
                        $daftarMapel = [
                            'Pendidikan Agama Islam',
                            'Pendidikan Pancasila (PPKn)',
                            'Bahasa Indonesia',
                            'Matematika',
                            'IPA',
                            'IPS',
                            'Bahasa Inggris',
                            'Seni Budaya',
                            'PJOK',
                            'Informatika',
                            'Bahasa Arab',
                            'Tahfizh / Al-Qur\'an',
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($daftarMapel as $mapel)
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-200 hover:border-gray-300 transition">
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">{{ $mapel }}</label>
                            <input type="number" name="nilai_mapel[{{ $mapel }}]" min="0" max="100" placeholder="0 - 100" class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none bg-white">
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

</body>
</html>