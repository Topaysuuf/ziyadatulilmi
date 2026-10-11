<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Lembaga - Pondok Pesantren Ziyadatul Ilmi</title>
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
                <a href="{{ route('absensi') }}" class="hover:text-yellow-300 transition flex items-center gap-1">
                    <i class="fa-solid fa-calendar-check"></i> Absensi
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

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Card Profil -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="border-b pb-4 mb-6">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <i class="fa-solid fa-school text-[#004d25]"></i> Profil & Identitas Lembaga
                </h1>
                <p class="text-gray-500 mt-1">Pondok Pesantren & Yayasan Ziyadatul Ilmi</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-500 block text-xs uppercase font-semibold">Nama Lembaga</span>
                        <span class="font-bold text-gray-800 text-base">Pondok Pesantren Ziyadatul Ilmi</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs uppercase font-semibold">NPSN / Kemenag</span>
                        <span class="font-semibold text-gray-800">510036730333</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs uppercase font-semibold">Pimpinan / Pengasuh</span>
                        <span class="font-semibold text-gray-800">KH. Zainuri Yasmin, S.Ag. M.Pd.</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <div>
                        <span class="text-gray-500 block text-xs uppercase font-semibold">Kategori Profil</span>
                        <span class="inline-block bg-green-100 text-[#004d25] font-bold px-3 py-1 rounded-full text-xs mt-1">
                            {{ ucfirst(str_replace('-', ' ', $slug ?? 'Identitas Sekolah')) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs uppercase font-semibold">Status Lembaga</span>
                        <span class="font-semibold text-gray-800">Swasta / Yayasan</span>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#004d25] hover:bg-[#00381b] text-white rounded-xl text-sm font-semibold transition">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

</body>
</html>