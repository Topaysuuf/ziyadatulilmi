<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SMA Ziyadatul Ilmi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar Admin -->
    <nav class="bg-[#004d25] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <span class="bg-yellow-400 text-[#004d25] font-bold px-2.5 py-1 rounded text-sm">ADMIN</span>
                <h1 class="font-bold text-lg hidden sm:block">Dashboard Portal Sekolah</h1>
            </div>
            <div class="flex items-center space-x-4 text-sm">
                <a href="{{ route('home') }}" target="_blank" class="hover:text-yellow-300 transition flex items-center gap-1">
                    <i class="fa-solid fa-globe"></i> Lihat Web
                </a>
                <a href="{{ route('home') }}" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Dashboard Manajemen Sekolah</h2>
            <p class="text-sm text-gray-500">Input Presensi dan Nilai Siswa berdasarkan Kelas & Nama.</p>
        </div>

        <!-- Section Input Absen & Nilai -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">

            <!-- Card Presensi -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                            <i class="fa-solid fa-calendar-check text-[#004d25]"></i> Input Presensi / Absensi
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">Pilih nama siswa & kelas untuk mencatat kehadiran.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <!-- Tombol Reset Absensi (Form POST) -->
                        <form action="{{ route('admin.absensi.reset') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus SELURUH data absensi?');">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1 shadow-sm">
                                <i class="fa-solid fa-trash-can"></i> Reset
                            </button>
                        </form>

                        <!-- Tombol Download Excel -->
                        <a href="{{ route('admin.absensi.export') }}" class="bg-emerald-100 text-[#004d25] hover:bg-[#004d25] hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1 shadow-sm">
                            <i class="fa-solid fa-file-excel"></i> Download Excel
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.absensi.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">NAMA SISWA & KELAS</label>
                        <select name="siswa_id" class="w-full border rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#004d25]" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }} (Kelas: {{ $siswa->kelas }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">TANGGAL</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border rounded-lg px-3 py-2.5 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">STATUS KEHADIRAN</label>
                            <select name="status" class="w-full border rounded-lg px-3 py-2.5 text-sm" required>
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Alpa">Alpa</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#004d25] text-white font-bold py-2.5 rounded-lg hover:bg-[#003318] transition text-sm shadow mt-2">
                        Simpan Absensi
                    </button>
                </form>
            </div>

            <!-- Card Nilai Ujian -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                            <i class="fa-solid fa-graduation-cap text-[#004d25]"></i> Input Nilai Ujian
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">Pilih nama siswa & kelas untuk menginput nilai.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <!-- Tombol Reset Nilai (Form POST) -->
                        <form action="{{ route('admin.nilai.reset') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus SELURUH data nilai?');">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1 shadow-sm">
                                <i class="fa-solid fa-trash-can"></i> Reset
                            </button>
                        </form>

                        <!-- Tombol Download Excel -->
                        <a href="{{ route('admin.nilai.export') }}" class="bg-emerald-100 text-[#004d25] hover:bg-[#004d25] hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1 shadow-sm">
                            <i class="fa-solid fa-file-excel"></i> Download Excel
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.nilai.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">NAMA SISWA & KELAS</label>
                        <select name="siswa_id" class="w-full border rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#004d25]" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }} (Kelas: {{ $siswa->kelas }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">MATA PELAJARAN</label>
                        <input type="text" name="mata_pelajaran" placeholder="Contoh: Pendidikan Agama Islam / Matematika" class="w-full border rounded-lg px-3 py-2.5 text-sm" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">JENIS UJIAN</label>
                            <select name="jenis_ujian" class="w-full border rounded-lg px-3 py-2.5 text-sm" required>
                                <option value="UTS">UTS</option>
                                <option value="UAS">UAS</option>
                                <option value="Tugas">Tugas</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">NILAI (0-100)</label>
                            <input type="number" name="nilai" min="0" max="100" placeholder="85" class="w-full border rounded-lg px-3 py-2.5 text-sm" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#004d25] text-white font-bold py-2.5 rounded-lg hover:bg-[#003318] transition text-sm shadow mt-2">
                        Simpan Nilai
                    </button>
                </form>
            </div>

        </div>

        <!-- Tabel Data SPMB -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-10">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                    <i class="fa-solid fa-users text-[#004d25]"></i> Data Pendaftar SPMB Online
                </h3>
                <span class="text-xs text-gray-400">Total: {{ $pendaftar->count() }} Pendaftar</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">NO</th>
                            <th class="px-6 py-3">NAMA LENGKAP</th>
                            <th class="px-6 py-3">NISN</th>
                            <th class="px-6 py-3">L/P</th>
                            <th class="px-6 py-3">NO. WHATSAPP</th>
                            <th class="px-6 py-3">STATUS</th>
                            <th class="px-6 py-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pendaftar as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-bold text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $item->nama_lengkap }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $item->nisn }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $item->jk }}</td>
                                <td class="px-6 py-4">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_whatsapp) }}" target="_blank" class="text-emerald-600 font-bold hover:underline flex items-center gap-1">
                                        <i class="fa-brands fa-whatsapp"></i> {{ $item->no_whatsapp }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold 
                                        {{ $item->status == 'Diterima' ? 'bg-emerald-100 text-emerald-800' : ($item->status == 'Ditolak' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.ppdb.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-1">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada pendaftar SPMB.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>