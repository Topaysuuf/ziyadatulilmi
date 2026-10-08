<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profil->nama_yayasan ?? 'SMA ZIYADATUL ILMI' }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] text-gray-800 font-sans">

    <!-- Header Navbar Hijau Tua -->
    <header class="bg-[#004d25] text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-2.5 flex justify-between items-center">
            <!-- Logo & Nama Sekolah -->
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center overflow-hidden shadow">
    <img src="{{ asset('images/Logo Pondok.jpeg') }}" alt="Logo Pondok Pesantren Ziyadatul Ilmi" class="w-full h-full object-cover">
</div>

                <div>
                    <h1 class="text-base md:text-lg font-bold uppercase leading-tight tracking-wide">{{ $profil->nama_yayasan ?? 'SMA ZIYADATUL ILMI' }}</h1>
                    <p class="text-xs text-gray-200">NPSN: {{ $profil->nsp ?? '510036730333' }} - SWASTA</p>
                </div>
            </div>

            <!-- Menu Navigasi Tengah -->
            <nav class="hidden lg:flex space-x-6 text-xs md:text-sm font-bold uppercase tracking-wider items-center">
                <a href="{{ route('home') }}" class="hover:text-yellow-300 transition">BERANDA</a>
                
                <!-- Dropdown Profil -->
                <div class="relative group">
                    <button class="hover:text-yellow-300 transition flex items-center gap-1 uppercase py-2">
                        PROFIL <i class="fa-solid fa-caret-down text-xs"></i>
                    </button>
                    <div class="absolute left-0 mt-0 w-48 bg-white text-gray-800 rounded-lg shadow-xl py-2 hidden group-hover:block border">
                        <a href="{{ route('profil.detail', 'identitas-sekolah') }}" class="block px-4 py-2 hover:bg-emerald-50 text-xs font-semibold">Identitas Sekolah</a>
                        <a href="{{ route('profil.detail', 'sejarah-sekolah') }}" class="block px-4 py-2 hover:bg-emerald-50 text-xs font-semibold">Sejarah Sekolah</a>
                        <a href="{{ route('profil.detail', 'visi-misi') }}" class="block px-4 py-2 hover:bg-emerald-50 text-xs font-semibold">Visi & Misi</a>
                        <a href="{{ route('profil.detail', 'struktur-organisasi') }}" class="block px-4 py-2 hover:bg-emerald-50 text-xs font-semibold">Struktur Organisasi</a>
                        <a href="{{ route('profil.detail', 'fasilitas') }}" class="block px-4 py-2 hover:bg-emerald-50 text-xs font-semibold">Fasilitas</a>
                    </div>
                </div>

                <a href="#pengumuman" class="hover:text-yellow-300 transition">BERITA</a>
                <a href="#pengumuman" class="hover:text-yellow-300 transition">PENGUMUMAN</a>
                <a href="#ppdb" class="hover:text-yellow-300 transition">SPMB</a>
                <a href="{{ route('absensi') }}" class="hover:text-yellow-300 transition">ABSENSI</a>
                <a href="{{ route('nilai') }}" class="hover:text-yellow-300 transition">UJIAN & NILAI</a>
            </nav>

            <!-- Tombol Navigasi Kanan (Absen, Nilai, Login untuk HP & Desktop) -->
            <div class="flex items-center space-x-1.5 md:space-x-3">
                <a href="{{ route('absensi') }}" class="bg-yellow-400 text-[#004d25] px-2.5 py-1.5 rounded-lg text-xs font-bold shadow hover:bg-yellow-300 transition">
                    Absen
                </a>
                <a href="{{ route('nilai') }}" class="bg-yellow-400 text-[#004d25] px-2.5 py-1.5 rounded-lg text-xs font-bold shadow hover:bg-yellow-300 transition">
                    Nilai
                </a>
                <a href="/login" class="border border-white/70 text-white px-3.5 md:px-5 py-1.5 rounded-full text-xs md:text-sm font-semibold hover:bg-white hover:text-[#004d25] transition">
                    Login
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="beranda" class="bg-gradient-to-r from-[#00381b] to-[#006631] text-white py-20 text-center">
        <div class="container mx-auto px-4 max-w-3xl">
            <span class="bg-[#002411] text-yellow-300 text-xs px-3.5 py-1.5 rounded-full uppercase font-bold tracking-wider border border-yellow-400/30">Portal Resmi Yayasan</span>
            <h2 class="text-3xl md:text-5xl font-extrabold mt-4 mb-4 leading-tight">Selamat Datang di {{ $profil->nama_yayasan ?? 'SMA ZIYADATUL ILMI' }}</h2>
            <p class="text-emerald-100 text-base md:text-lg mb-8">
                Pimpinan: <span class="font-semibold text-white">{{ $profil->pimpinan ?? 'KH. Zainuri Yasmin, S.Ag. M.Pd.' }}</span>
            </p>
            <div class="flex justify-center gap-4">
                <a href="#ppdb" class="bg-yellow-400 text-[#004d25] px-6 py-3 rounded-lg font-bold shadow-lg hover:bg-yellow-300 transition">
                    Daftar SPMB Online
                </a>
                <a href="#profil" class="bg-[#002411] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#00170a] transition border border-emerald-500">
                    Lihat Profil
                </a>
            </div>
        </div>
    </section>

    <!-- Section Profil Sekolah (Presisi Sesuai Gambar) -->
    <section id="profil" class="py-16 bg-[#f1f5f9]">
        <div class="container mx-auto px-4 max-w-6xl">
            <h3 class="text-2xl font-bold text-[#0f172a] mb-8">Profil Sekolah</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- 1. Identitas Sekolah -->
                <a href="{{ route('profil.detail', 'identitas-sekolah') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start space-x-4 hover:shadow-md transition group">
                    <div class="bg-[#eff6ff] text-[#3b82f6] w-14 h-14 rounded-2xl flex items-center justify-center text-xl shrink-0 group-hover:bg-[#3b82f6] group-hover:text-white transition">
                        <i class="fa-solid fa-passport"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#0f172a] text-base group-hover:text-[#004d25] transition">Identitas Sekolah</h4>
                        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Informasi umum, perizinan, dan identitas resmi.</p>
                    </div>
                </a>

                <!-- 2. Sejarah Sekolah -->
                <a href="{{ route('profil.detail', 'sejarah-sekolah') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start space-x-4 hover:shadow-md transition group">
                    <div class="bg-[#fefce8] text-[#eab308] w-14 h-14 rounded-2xl flex items-center justify-center text-xl shrink-0 font-bold group-hover:bg-[#eab308] group-hover:text-white transition">
                        $
                    </div>
                    <div>
                        <h4 class="font-bold text-[#0f172a] text-base group-hover:text-[#004d25] transition">Sejarah Sekolah</h4>
                        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Perjalanan berdirinya sekolah dari masa ke masa.</p>
                    </div>
                </a>

                <!-- 3. Visi & Misi -->
                <a href="{{ route('profil.detail', 'visi-misi') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start space-x-4 hover:shadow-md transition group">
                    <div class="bg-[#ecfdf5] text-[#10b981] w-14 h-14 rounded-2xl flex items-center justify-center text-xl shrink-0 group-hover:bg-[#10b981] group-hover:text-white transition">
                        <i class="fa-solid fa-[#10b981] fa-bullseye"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#0f172a] text-base group-hover:text-[#004d25] transition">Visi & Misi</h4>
                        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Tujuan utama dan arah pendidikan sekolah ke depan.</p>
                    </div>
                </a>

                <!-- 4. Struktur Organisasi -->
                <a href="{{ route('profil.detail', 'struktur-organisasi') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start space-x-4 hover:shadow-md transition group">
                    <div class="bg-[#f1f5f9] text-[#64748b] w-14 h-14 rounded-2xl flex items-center justify-center text-xl shrink-0 group-hover:bg-[#64748b] group-hover:text-white transition">
                        <i class="fa-solid fa-sitemap"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#0f172a] text-base group-hover:text-[#004d25] transition">Struktur Organisasi</h4>
                        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Susunan kepengurusan dan manajemen pendidik.</p>
                    </div>
                </a>

                <!-- 5. Fasilitas -->
                <a href="{{ route('profil.detail', 'fasilitas') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start space-x-4 hover:shadow-md transition group">
                    <div class="bg-[#fdf2f8] text-[#ec4899] w-14 h-14 rounded-2xl flex items-center justify-center text-xl shrink-0 group-hover:bg-[#ec4899] group-hover:text-white transition">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#0f172a] text-base group-hover:text-[#004d25] transition">Fasilitas</h4>
                        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Sarana dan prasarana penunjang kegiatan belajar.</p>
                    </div>
                </a>

                <!-- 6. Mitra Sekolah -->
                <a href="{{ route('profil.detail', 'mitra-sekolah') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start space-x-4 hover:shadow-md transition group">
                    <div class="bg-[#faf5ff] text-[#a855f7] w-14 h-14 rounded-2xl flex items-center justify-center text-xl shrink-0 group-hover:bg-[#a855f7] group-hover:text-white transition">
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#0f172a] text-base group-hover:text-[#004d25] transition">Mitra Sekolah</h4>
                        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Jaringan kerjasama dengan industri dan lembaga lain.</p>
                    </div>
                </a>

                <!-- 7. Prestasi -->
                <a href="{{ route('profil.detail', 'prestasi') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start space-x-4 hover:shadow-md transition group">
                    <div class="bg-[#fff7ed] text-[#f97316] w-14 h-14 rounded-2xl flex items-center justify-center text-xl shrink-0 group-hover:bg-[#f97316] group-hover:text-white transition">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#0f172a] text-base group-hover:text-[#004d25] transition">Prestasi</h4>
                        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Pencapaian gemilang siswa dan sekolah.</p>
                    </div>
                </a>

                <!-- 8. Ekstrakurikuler -->
                <a href="{{ route('profil.detail', 'ekstrakurikuler') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start space-x-4 hover:shadow-md transition group">
                    <div class="bg-[#ecfeff] text-[#06b6d4] w-14 h-14 rounded-2xl flex items-center justify-center text-xl shrink-0 group-hover:bg-[#06b6d4] group-hover:text-white transition">
                        <i class="fa-regular fa-star-half-stroke"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#0f172a] text-base group-hover:text-[#004d25] transition">Ekstrakurikuler</h4>
                        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Wadah pengembangan bakat dan minat siswa.</p>
                    </div>
                </a>

                <!-- 9. Profil Alumni -->
                <a href="{{ route('profil.detail', 'profil-alumni') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start space-x-4 hover:shadow-md transition group">
                    <div class="bg-[#f0fdf4] text-[#14b8a6] w-14 h-14 rounded-2xl flex items-center justify-center text-xl shrink-0 group-hover:bg-[#14b8a6] group-hover:text-white transition">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#0f172a] text-base group-hover:text-[#004d25] transition">Profil Alumni</h4>
                        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Rekam jejak dan kiprah lulusan di masyarakat.</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Berita & Pengumuman -->
    <section id="pengumuman" class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center mb-12">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900">Pengumuman & Informasi Terbaru</h3>
                <div class="w-16 h-1 bg-[#004d25] mx-auto mt-2"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                @if (isset($pengumuman) && count($pengumuman) > 0)
                    @foreach ($pengumuman as $item)
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <span class="text-xs text-[#004d25] font-bold uppercase tracking-wider">{{ $item->kategori }}</span>
                            <h4 class="font-bold text-lg mt-1 mb-2 text-gray-800">{{ $item->judul }}</h4>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ $item->isi }}</p>
                            <span class="text-xs text-gray-400 block"><i class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-2 text-center text-gray-500 py-8">
                        Belum ada pengumuman terbaru.
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Form SPMB / PPDB -->
    <section id="ppdb" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-2xl">
            <div class="bg-emerald-50 border border-emerald-200 p-8 rounded-2xl shadow-sm">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-[#004d25]">Formulir Pendaftaran SPMB Online</h3>
                    <p class="text-gray-600 text-sm mt-1">Lengkapi data diri calon santri/siswa di bawah ini.</p>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 text-center font-medium">
                        <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('ppdb.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Siswa</label>
                        <input type="text" name="nama_lengkap" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#004d25] focus:outline-none" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                            <input type="number" name="nisn" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#004d25] focus:outline-none" placeholder="Nomor NISN">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#004d25] focus:outline-none">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp Orang Tua/Wali</label>
                        <input type="tel" name="no_wa" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#004d25] focus:outline-none" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <button type="submit" class="w-full bg-[#004d25] text-white font-bold py-3 rounded-lg hover:bg-[#003318] transition shadow">
                        Kirim Pendaftaran
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-10 border-t border-gray-800">
        <div class="container mx-auto px-4 max-w-6xl text-center md:text-left grid md:grid-cols-2 gap-8">
            <div>
                <h4 class="text-white font-bold text-lg mb-2">{{ $profil->nama_yayasan ?? 'SMA ZIYADATUL ILMI' }}</h4>
                <p class="text-sm text-gray-400 mb-4 leading-relaxed">{{ $profil->alamat ?? '-' }}</p>
                <p class="text-sm"><i class="fa-solid fa-phone mr-2"></i> WA: {{ $profil->no_wa ?? '-' }}</p>
            </div>
            <div class="md:text-right">
                <p class="text-sm mb-2">&copy; {{ date('Y') }} {{ $profil->nama_yayasan ?? 'SMA ZIYADATUL ILMI' }}. All rights reserved.</p>
                <p class="text-xs text-yellow-400 font-semibold">Domain Resmi: ziyadatulilmi.my.id</p>
            </div>
        </div>
    </footer>
</body>
</html>