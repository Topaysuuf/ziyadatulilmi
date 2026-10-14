<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input & Kelola Nilai Santri - Pondok Pesantren Ziyadatul Ilmi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
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
                <a href="{{ route('absensi') }}" class="hover:text-yellow-300 transition flex items-center gap-1">
                    <i class="fa-solid fa-calendar-check"></i> Absensi
                </a>
                <a href="{{ route('nilai') }}" class="text-yellow-300 font-bold transition flex items-center gap-1">
                    <i class="fa-solid fa-graduation-cap"></i> Ujian & Nilai
                </a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="bg-yellow-400 text-[#004d25] font-bold px-3 py-1.5 rounded-lg text-xs hover:bg-yellow-300 transition">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-yellow-400 text-[#004d25] font-bold px-3 py-1.5 rounded-lg text-xs hover:bg-yellow-300 transition">
                        Login Admin
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Header Page -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap text-[#004d25]"></i> Kelola Ujian & Nilai Santri
                </h1>
                <p class="text-gray-500 text-sm mt-1">Pilih mata pelajaran dari daftar untuk memasukkan nilai ujian santri.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-green-600"></i> {{ session('success') }}
            </div>
        @endif

        @auth
        <!-- Form Input Nilai dengan Dropdown Mata Pelajaran -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-[#004d25]"></i> Form Input Nilai Siswa
            </h2>

            <form action="{{ route('nilai.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Pilih Siswa -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilih Santri / Siswa</label>
                        <select name="siswa_id" required class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none bg-white">
                            <option value="">-- Pilih Santri --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }} ({{ $siswa->kelas }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Mata Pelajaran (Kategori Pesantren, Umum, Jurusan) -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Mata Pelajaran</label>
                        <select name="mata_pelajaran" required class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none bg-white">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            
                            <optgroup label="--- A. MUATAN LOKAL PESANTREN ---">
                                <option value="Nahwu Jurumiyah">Nahwu Jurumiyah</option>
                                <option value="Nahwu Imriti">Nahwu Imriti</option>
                                <option value="Durusulfiqiyah">Durusulfiqiyah</option>
                                <option value="Akhlaqul Banin">Akhlaqul Banin</option>
                                <option value="B. Arab">B. Arab</option>
                                <option value="Taqrib/Matan">Taqrib/Matan</option>
                                <option value="Minhussaniyah">Minhussaniyah</option>
                            </optgroup>

                            <optgroup label="--- B. MATA PELAJARAN UMUM ---">
                                <option value="Pendidikan Agama Islam dan Budi Pekerti">Pendidikan Agama Islam dan Budi Pekerti</option>
                                <option value="Pendidikan Pancasila dan Kewarganegaraan">Pendidikan Pancasila dan Kewarganegaraan</option>
                                <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                                <option value="Matematika">Matematika</option>
                                <option value="Ilmu Pengetahuan Alam">Ilmu Pengetahuan Alam</option>
                                <option value="Ilmu Pengetahuan Sosial">Ilmu Pengetahuan Sosial</option>
                                <option value="Bahasa Inggris">Bahasa Inggris</option>
                                <option value="Pendidikan Jasmani Olahraga dan Kesehatan">Pendidikan Jasmani Olahraga dan Kesehatan</option>
                                <option value="Informatika">Informatika</option>
                                <option value="Seni Budaya">Seni Budaya</option>
                            </optgroup>

                            <optgroup label="--- C. MATA PELAJARAN JURUSAN ---">
                                <option value="Sosiologi">Sosiologi</option>
                                <option value="Sejarah">Sejarah</option>
                                <option value="Geografi">Geografi</option>
                                <option value="Ekonomi">Ekonomi</option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- Jenis Ujian -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Jenis Ujian</label>
                        <select name="jenis_ujian" required class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none bg-white">
                            <option value="ASTS">ASTS (Asesmen Sumatif Tengah Semester / UTS)</option>
                            <option value="ASAS">ASAS (Asesmen Sumatif Akhir Semester / UAS)</option>
                            <option value="Ulangan Harian">Ulangan Harian</option>
                            <option value="Tugas">Tugas</option>
                        </select>
                    </div>

                    <!-- Nilai -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nilai (0-100)</label>
                        <input type="number" name="nilai" min="0" max="100" placeholder="Contoh: 85" required class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#004d25] focus:outline-none">
                    </div>

                </div>

                <div class="mt-4 text-right">
                    <button type="submit" class="bg-[#004d25] hover:bg-[#00381b] text-white font-bold px-6 py-2.5 rounded-xl text-sm transition shadow-sm inline-flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Nilai
                    </button>
                </div>
            </form>
        </div>
        @endauth

        <!-- Daftar Nilai Terinput & Pilihan E-Raport -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                <i class="fa-solid fa-list-check text-[#004d25]"></i> Daftar Santri & E-Raport Digital
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 border-b">
                            <th class="p-3">No</th>
                            <th class="p-3">Nama Santri</th>
                            <th class="p-3">Kelas</th>
                            <th class="p-3 text-center">E-Raport Digital</th>
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
                                        <i class="fa-solid fa-file-invoice"></i> Lihat Raport
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-400 italic">Belum ada data santri.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>