<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul ?? 'Profil Sekolah' }} - SMA Ziyadatul Ilmi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Header / Navbar -->
    <header class="bg-[#004d25] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center font-bold text-[#004d25]">
                    ZI
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight">{{ $profil->nama_yayasan ?? 'SMA ZIYADATUL ILMI' }}</h1>
                    <p class="text-xs text-yellow-300">Unggul, Beriman & Berprestasi</p>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-sm bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </header>

    <!-- Content Utama -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow w-full">
        <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-sm border border-gray-100">
            
            <div class="border-b pb-6 mb-8">
                <span class="text-xs font-bold text-[#004d25] bg-emerald-100 px-3 py-1 rounded-full uppercase tracking-wider">PROFIL SEKOLAH</span>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-3">{{ $judul ?? 'Profil & Sejarah Sekolah' }}</h2>
            </div>

            {{-- KONDISI 1: Sejarah Sekolah --}}
            @if($slug == 'sejarah' || $slug == 'sejarah-sekolah')
                <div class="space-y-6 text-gray-700 leading-relaxed">
                    <div class="p-4 bg-emerald-50 rounded-xl border-l-4 border-[#004d25]">
                        <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                            <i class="fa-solid fa-landmark text-[#004d25]"></i> Pendirian & Perjalanan Lembaga
                        </h3>
                    </div>

                    <p>
                        <strong>SMA Ziyadatul Ilmi</strong> didirikan di bawah naungan yayasan pendidikan berasrama di Kota Serang, Banten, dengan cita-cita mulia menghadirkan lembaga pendidikan Islam terpadu yang memadukan kurikulum akademik nasional dan pembinaan karakter berbasis Al-Qur'an serta Sunnah.
                    </p>

                    <p>
                        Berlokasi strategis di Link. Nancang Wetan, Kelurahan Karundang, Kecamatan Cipocok Jaya, Kota Serang, lembaga ini terus berkembang dari waktu ke waktu melayani jenjang pendidikan SMP hingga SMA. Di bawah kepemimpinan <strong>{{ $profil->pimpinan ?? 'KH. Zainuri Yasmin, S.Ag. M.Pd.' }}</strong>, SMA Ziyadatul Ilmi berkomitmen melahirkan generasi santri dan siswa yang cerdas secara intelektual, matang secara spritual, serta siap menghadapi tantangan zaman.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">
                        <div class="p-4 bg-gray-50 rounded-xl text-center border">
                            <i class="fa-solid fa-school text-2xl text-[#004d25] mb-2"></i>
                            <h4 class="font-bold text-sm text-gray-900">Jenjang Lengkap</h4>
                            <p class="text-xs text-gray-500 mt-1">Pendidikan SMP & SMA Terpadu</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl text-center border">
                            <i class="fa-solid fa-book-quran text-2xl text-[#004d25] mb-2"></i>
                            <h4 class="font-bold text-sm text-gray-900">Program Tahfidz</h4>
                            <p class="text-xs text-gray-500 mt-1">Kajian Kitab & Bimbingan Al-Qur'an</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl text-center border">
                            <i class="fa-solid fa-certificate text-2xl text-[#004d25] mb-2"></i>
                            <h4 class="font-bold text-sm text-gray-900">NSP Resmi</h4>
                            <p class="text-xs text-gray-500 mt-1">{{ $profil->nsp ?? '510036730333' }}</p>
                        </div>
                    </div>
                </div>

            {{-- KONDISI 2: Visi & Misi --}}
            @elseif($slug == 'visi-misi')
                <div class="space-y-8">
                    <div>
                        <h3 class="text-xl font-bold text-[#004d25] mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-eye"></i> Visi Sekolah
                        </h3>
                        <p class="bg-emerald-50/50 border-l-4 border-[#004d25] p-4 text-gray-700 text-lg italic rounded-r-xl">
                            "{{ $profil->visi ?? 'Menjadi lembaga pendidikan Islam unggulan yang melahirkan generasi beriman, bertakwa, berprestasi, dan berwawasan global.' }}"
                        </p>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-[#004d25] mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-bullseye"></i> Misi Sekolah
                        </h3>
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $profil->misi ?? "1. Menyelenggarakan pendidikan berbasis Al-Qur'an dan Sunnah.\n2. Mengembangkan potensi akademik dan non-akademik siswa.\n3. Membina karakter kepemimpinan dan kemandirian." }}
                        </div>
                    </div>
                </div>

            {{-- KONDISI 3: Sambutan Pimpinan --}}
            @elseif($slug == 'sambutan')
                <div class="space-y-6">
                    <div class="flex items-center space-x-4 p-4 bg-emerald-50 rounded-2xl">
                        <div class="w-16 h-16 bg-[#004d25] text-white rounded-full flex items-center justify-center font-bold text-2xl shadow">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">{{ $profil->pimpinan ?? 'KH. Zainuri Yasmin, S.Ag. M.Pd.' }}</h4>
                            <p class="text-xs text-[#004d25] font-semibold">Pimpinan SMA Ziyadatul Ilmi</p>
                        </div>
                    </div>
                    <div class="text-gray-700 leading-relaxed space-y-4">
                        <p>Assalamu’alaikum Warahmatullahi Wabarakatuh.</p>
                        <p>Selamat datang di portal resmi SMA Ziyadatul Ilmi. Kami berkomitmen untuk terus menyelenggarakan pendidikan Islam berkualitas yang mengintegrasikan ilmu pengetahuan umum dan nilai-nilai Al-Qur'an.</p>
                        <p>Melalui sarana digital ini, kami berharap seluruh informasi terkait proses akademik, presensi, serta pendaftaran siswa baru dapat diakses secara transparan dan efisien.</p>
                        <p class="font-semibold text-gray-900 pt-4">Wassalamu’alaikum Warahmatullahi Wabarakatuh.</p>
                    </div>
                </div>

            {{-- KONDISI 4 / FALLBACK: Profil & Sejarah Umum --}}
            @else
                <div class="space-y-8">
                    <div class="space-y-4 text-gray-700 leading-relaxed border-b pb-6">
                        <h3 class="text-xl font-bold text-[#004d25] flex items-center gap-2">
                            <i class="fa-solid fa-landmark"></i> Sejarah Singkat
                        </h3>
                        <p>
                            <strong>SMA Ziyadatul Ilmi</strong> didirikan di Kota Serang, Banten, dengan misi menyediakan layanan pendidikan berlandaskan nilai-nilai Keislaman yang kuat dan akademik unggul. Berada di lingkungan asri Karundang, Cipocok Jaya, sekolah ini memfasilitasi pembinaan akademik, kajian kitab, dan program tahfidz Qur'an.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <span class="text-xs text-gray-400 font-bold block uppercase mb-1">Nama Lembaga / Yayasan</span>
                            <span class="text-lg font-bold text-gray-800">{{ $profil->nama_yayasan ?? 'SMA ZIYADATUL ILMI' }}</span>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <span class="text-xs text-gray-400 font-bold block uppercase mb-1">NSP / NPSN</span>
                            <span class="text-lg font-bold text-gray-800">{{ $profil->nsp ?? '510036730333' }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <span class="text-xs text-gray-400 font-bold block uppercase mb-1">Pimpinan Yayasan</span>
                            <span class="text-lg font-bold text-gray-800">{{ $profil->pimpinan ?? 'KH. Zainuri Yasmin, S.Ag. M.Pd.' }}</span>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <span class="text-xs text-gray-400 font-bold block uppercase mb-1">Kontak WhatsApp</span>
                            <span class="text-lg font-bold text-emerald-600">{{ $profil->no_wa ?? '081389554994' }}</span>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <span class="text-xs text-gray-400 font-bold block uppercase mb-1">Alamat Lengkap</span>
                        <span class="text-base text-gray-700 leading-relaxed">{{ $profil->alamat ?? 'Link. Nancang Wetan RT.004 RW.004, Kel. Karundang, Kec. Cipocok Jaya, Kota Serang, Banten' }}</span>
                    </div>
                </div>
            @endif

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-6 text-center text-xs mt-auto">
        <p>&copy; {{ date('Y') }} {{ $profil->nama_yayasan ?? 'SMA Ziyadatul Ilmi' }}. All rights reserved.</p>
    </footer>

</body>
</html>