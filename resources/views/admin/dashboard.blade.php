<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Portal Sekolah - Ziyadatul Ilmi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-800">

    <!-- Navbar Atas -->
    <nav class="bg-[#064e3b] text-white px-6 py-4 shadow-md flex flex-wrap justify-between items-center gap-3">
        <div class="flex items-center gap-3">
            <span class="bg-amber-400 text-[#064e3b] text-xs font-extrabold px-2.5 py-1 rounded">ADMIN</span>
            <h1 class="text-lg font-bold tracking-wide">Dashboard Portal Sekolah</h1>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('absen.scan') }}" class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold px-3.5 py-2 rounded-lg transition">
                📷 Scan QR
            </a>
            <a href="{{ route('absen.kartu') }}" class="bg-amber-400 hover:bg-amber-300 text-[#064e3b] text-xs font-bold px-3.5 py-2 rounded-lg transition">
                🪪 Kartu QR
            </a>
            <a href="{{ route('home') }}" class="bg-emerald-800 hover:bg-emerald-700 border border-emerald-600 text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition">
                🌐 Lihat Web
            </a>
            <a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-500 text-white text-xs font-bold px-3.5 py-2 rounded-lg transition">
                Logout
            </a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 space-y-6">

        <!-- Notifikasi Sukses / Error -->
        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-xl text-sm font-semibold">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl text-sm font-semibold">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Baris 1: Input Kehadiran & Export Nilai -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Card Kiri: Input Kehadiran Santri + Fitur QR -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <div>
                    <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                        📅 Input Kehadiran Santri
                    </h2>

                    <!-- Tombol Cepat Fitur Absensi QR -->
                    <div class="grid grid-cols-2 gap-3 mb-5 p-3 bg-emerald-50 border border-emerald-200 rounded-xl">
                        <a href="{{ route('absen.scan') }}" class="bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-bold py-2.5 px-3 rounded-lg text-center shadow-sm transition">
                            📷 Buka Scanner QR
                        </a>
                        <a href="{{ route('absen.kartu') }}" class="bg-amber-500 hover:bg-amber-400 text-white text-xs font-bold py-2.5 px-3 rounded-lg text-center shadow-sm transition">
                            🪪 Lihat & Cetak Kartu QR
                        </a>
                    </div>

                    <form action="{{ route('admin.absensi.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Siswa & Kelas</label>
                            <select name="siswa_id" required class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600">
                                @php $daftarSiswa = $siswas ?? \App\Models\Siswa::orderBy('kelas')->orderBy('nama')->get(); @endphp
                                @foreach($daftarSiswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->kelas }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status Kehadiran</label>
                                <select name="status" required class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Alpa">Alpa</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#064e3b] hover:bg-emerald-800 text-white font-bold text-sm py-3 rounded-xl transition">
                            Simpan Absensi
                        </button>
                    </form>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 space-y-2.5">
                    <a href="{{ route('admin.absensi.export') }}" class="block w-full bg-blue-600 hover:bg-blue-500 text-white text-center font-bold text-xs py-3 rounded-xl transition">
                        📄 Download Excel Rekap Kehadiran Santri (.XLS)
                    </a>
                    <form action="{{ route('admin.absensi.reset') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus seluruh data absensi?')">
                        @csrf
                        <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-bold text-xs py-2.5 rounded-xl transition">
                            🗑️ Reset Seluruh Data Absensi
                        </button>
                    </form>
                </div>
            </div>

            <!-- Card Kanan: Export Rekap Nilai Siswa (.XLS) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <div>
                    <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                        📊 Export Rekap Nilai Siswa (.XLS)
                    </h2>

                    <form action="{{ route('admin.nilai.export') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Filter Kelas</label>
                                <select name="kelas" class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600">
                                    <option value="">-- Semua Kelas --</option>
                                    <option value="SMP - Kelas 7">SMP - Kelas 7</option>
                                    <option value="SMP - Kelas 8">SMP - Kelas 8</option>
                                    <option value="SMP - Kelas 9">SMP - Kelas 9</option>
                                    <option value="SMA - Kelas 10">SMA - Kelas 10</option>
                                    <option value="SMA - Kelas 11">SMA - Kelas 11</option>
                                    <option value="SMA - Kelas 12">SMA - Kelas 12</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Filter Mapel</label>
                                <input type="text" name="mapel" placeholder="Semua Mapel" class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm py-3 rounded-xl transition">
                            ⬇️ Download Excel Nilai Berdasarkan Filter
                        </button>
                    </form>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <form action="{{ route('admin.nilai.reset') }}" method="POST" onsubmit="return confirm('Yakin ingin mereset seluruh data nilai?')">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-500 text-white font-bold text-xs py-3 rounded-xl transition">
                            🔄 Reset Seluruh Data Nilai
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Baris 2: Input Nilai Santri / Siswa -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
            <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
                <div>
                    <h2 class="text-base font-bold text-gray-800">📝 Input Nilai Santri / Siswa (Perorangan)</h2>
                    <p class="text-xs text-gray-500">Pilih nama siswa, masukkan mata pelajaran dan nilai, lalu simpan.</p>
                </div>
            </div>

            <form action="{{ route('admin.nilai.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Siswa</label>
                    <select name="siswa_id" required class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm">
                        @foreach($daftarSiswa as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->kelas }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Mata Pelajaran</label>
                    <input type="text" name="mapel" placeholder="Contoh: Matematika / Nahwu" required class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nilai (0 - 100)</label>
                    <input type="number" name="nilai" min="0" max="100" placeholder="85" required class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-[#064e3b] hover:bg-emerald-800 text-white font-bold text-sm py-2.5 rounded-xl transition">
                        Simpan Nilai
                    </button>
                </div>
            </form>
        </div>

    </div>

</body>
</html>