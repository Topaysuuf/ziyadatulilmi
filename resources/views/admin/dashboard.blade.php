<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SMA Ziyadatul Ilmi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tom Select CSS (Fitur Pencarian Dropdown) -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control {
            border-radius: 0.5rem !important;
            padding: 0.625rem 0.75rem !important;
            border-color: #e5e7eb !important;
            font-size: 0.875rem !important;
        }
        .ts-wrapper.focus .ts-control {
            border-color: #004d25 !important;
            box-shadow: 0 0 0 2px rgba(0, 77, 37, 0.2) !important;
        }
    </style>
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
                        <!-- Tombol Reset Absensi -->
                        <a href="{{ route('admin.absensi.reset') }}" onclick="return confirm('Yakin ingin menghapus SELURUH data absensi?');" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1 shadow-sm">
                            <i class="fa-solid fa-trash-can"></i> Reset
                        </a>

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
                        <!-- ID ditambahkan: select-siswa-absensi -->
                        <select name="siswa_id" id="select-siswa-absensi" required>
                            <option value="">-- Ketik / Pilih Nama Siswa --</option>
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
                        <!-- Tombol Reset Nilai -->
                        <a href="{{ route('admin.nilai.reset') }}" onclick="return confirm('Yakin ingin menghapus SELURUH data nilai?');" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1 shadow-sm">
                            <i class="fa-solid fa-trash-can"></i> Reset
                        </a>
                    </div>
                </div>

                <!-- Form Filter & Download Excel Nilai -->
                <form action="{{ route('admin.nilai.export') }}" method="GET" class="mb-4 bg-gray-50 p-3 rounded-xl border border-gray-100 flex flex-col gap-2">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-gray-500 mb-1">Filter Kelas</label>
                            <select name="kelas" class="w-full border rounded-lg px-2 py-1.5 text-xs">
                                <option value="">-- Semua Kelas --</option>
                                @foreach($kelases ?? [] as $kLS)
                                    <option value="{{ $kLS }}">{{ $kLS }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-gray-500 mb-1">Filter Mapel</label>
                            <input type="text" name="mata_pelajaran" placeholder="Semua Mapel" class="w-full border rounded-lg px-2 py-1.5 text-xs">
                        </div>
                    </div>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center justify-center gap-1 shadow-sm">
                        <i class="fa-solid fa-file-excel"></i> Download Excel Nilai Berdasarkan Filter
                    </button>
                </form>

                <form action="{{ route('admin.nilai.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">NAMA SISWA & KELAS</label>
                        <!-- ID ditambahkan: select-siswa-nilai -->
                        <select name="siswa_id" id="select-siswa-nilai" required>
                            <option value="">-- Ketik / Pilih Nama Siswa --</option>
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

        <!-- Tabel Akses Cepat E-Raport Siswa -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-10">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span>📊</span> Rekapitulasi & E-Raport Siswa
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 font-semibold border-b">
                            <th class="p-3">No</th>
                            <th class="p-3">Nama Siswa</th>
                            <th class="p-3">Kelas</th>
                            <th class="p-3 text-center">Aksi Raport</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($siswas ?? [] as $index => $s)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-gray-500">{{ $index + 1 }}</td>
                                <td class="p-3 font-semibold text-gray-800">{{ $s->nama }}</td>
                                <td class="p-3 text-gray-600">{{ $s->kelas }}</td>
                                <td class="p-3 text-center">
                                    <a href="{{ route('raport.show', $s->id) }}" 
                                       target="_blank"
                                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded transition">
                                        🖨️ Buka E-Raport
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500 italic">
                                    Belum ada data siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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

    <!-- Tom Select JS (Inisialisasi Fitur Pencarian Dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Aktifkan pencarian di form presensi
            if (document.getElementById('select-siswa-absensi')) {
                new TomSelect('#select-siswa-absensi', {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    placeholder: "-- Ketik / Pilih Nama Siswa --",
                    plugins: ['dropdown_input']
                });
            }

            // Aktifkan pencarian di form nilai
            if (document.getElementById('select-siswa-nilai')) {
                new TomSelect('#select-siswa-nilai', {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    placeholder: "-- Ketik / Pilih Nama Siswa --",
                    plugins: ['dropdown_input']
                });
            }
        });
    </script>
</body>
</html>