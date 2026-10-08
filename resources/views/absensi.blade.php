<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi - {{ $profil->nama_yayasan ?? 'SMA ZIYADATUL ILMI' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] text-gray-800 font-sans">

    <!-- Header Navbar -->
    <header class="bg-[#004d25] text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-2.5 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-white text-[#004d25] p-1.5 rounded-full font-bold text-xl w-10 h-10 flex items-center justify-center border-2 border-yellow-400 shadow">
                    Z
                </div>
                <div>
                    <h1 class="text-base md:text-lg font-bold uppercase leading-tight tracking-wide">{{ $profil->nama_yayasan ?? 'SMA ZIYADATUL ILMI' }}</h1>
                    <p class="text-xs text-gray-200">NPSN: {{ $profil->nsp ?? '510036730333' }} - SWASTA</p>
                </div>
            </div>

            <nav class="hidden lg:flex space-x-6 text-xs md:text-sm font-bold uppercase tracking-wider items-center">
                <a href="{{ route('home') }}" class="hover:text-yellow-300 transition">BERANDA</a>
                <a href="{{ route('home') }}#profil" class="hover:text-yellow-300 transition">PROFIL</a>
                <a href="{{ route('home') }}#pengumuman" class="hover:text-yellow-300 transition">BERITA</a>
                <a href="{{ route('home') }}#pengumuman" class="hover:text-yellow-300 transition">PENGUMUMAN</a>
                <a href="{{ route('home') }}#ppdb" class="hover:text-yellow-300 transition">SPMB</a>
                <a href="{{ route('absensi') }}" class="text-yellow-300 transition">ABSENSI</a>
                <a href="{{ route('nilai') }}" class="hover:text-yellow-300 transition">UJIAN & NILAI</a>
            </nav>

            <a href="/login" class="border border-white/70 text-white px-5 py-1.5 rounded-full text-sm font-semibold hover:bg-white hover:text-[#004d25] transition">
                Login
            </a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-10 max-w-4xl">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Cek Presensi / Absensi Siswa</h2>
            <p class="text-gray-500 text-sm mb-6">Pilih Kelas dan Nama Siswa untuk melihat rekap kehadiran.</p>

            <!-- Form Utama Pencarian Siswa -->
            <form action="{{ route('absensi') }}" method="GET" class="grid md:grid-cols-3 gap-4">
                <!-- Dropdown Pilih Kelas -->
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-600 mb-1">1. Pilih Kelas</label>
                    <select name="kelas" onchange="this.form.submit()" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#004d25] focus:outline-none text-sm">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Pilih Nama Siswa -->
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-600 mb-1">2. Pilih Nama Siswa</label>
                    <select name="siswa_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#004d25] focus:outline-none text-sm" {{ $siswas->isEmpty() ? 'disabled' : '' }}>
                        <option value="">-- Pilih Nama Siswa --</option>
                        @foreach($siswas as $s)
                            <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Cari -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-[#004d25] text-white px-6 py-2.5 rounded-lg font-bold hover:bg-[#003318] transition text-sm shadow">
                        Tampilkan Absensi
                    </button>
                </div>
            </form>

            <!-- Tombol Download Excel Rekap per Kelas -->
            <div class="mt-6 pt-6 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-gray-500">Unduh laporan rekapitulasi lengkap per kelas untuk keperluan rapat guru.</p>
                <form action="{{ route('absensi.export') }}" method="GET" class="flex gap-2 w-full md:w-auto">
                    <select name="kelas" class="px-3 py-2 border border-gray-300 rounded-lg text-xs focus:outline-none">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k }}">{{ $k }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-emerald-700 transition text-xs shadow flex items-center gap-1.5 whitespace-nowrap">
                        <i class="fa-solid fa-file-excel"></i> Download Rekap Excel
                    </button>
                </form>
            </div>
        </div>

        @if($siswaSelected)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="mb-6 border-b pb-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $siswaSelected->nama }}</h3>
                        <p class="text-sm text-gray-500">Kelas: <span class="font-semibold text-emerald-800">{{ $siswaSelected->kelas }}</span></p>
                    </div>
                    <span class="bg-emerald-50 text-[#004d25] px-3 py-1 rounded-full text-xs font-bold border border-emerald-200">
                        Siswa Terverifikasi
                    </span>
                </div>

                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b text-gray-600">
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaSelected->absensis as $absensi)
                            <tr class="border-b">
                                <td class="p-3">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }}</td>
                                <td class="p-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $absensi->status == 'Hadir' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $absensi->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="p-4 text-center text-gray-400">Belum ada rekap absensi untuk siswa ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </main>

</body>
</html>