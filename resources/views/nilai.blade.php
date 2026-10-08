@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama kamu --}}

@section('content')
<div class="container mx-auto p-4 md:p-6 max-w-6xl">
    <!-- Header Halaman -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Daftar Nilai & Raport Siswa</h1>
            <p class="text-sm text-gray-500">Pilih siswa untuk melihat atau mencetak E-Raport Digital</p>
        </div>
    </div>

    <!-- Tabel Daftar Siswa & E-Raport -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-800 font-semibold border-b border-gray-200">
                        <th class="px-4 py-3 text-center w-12">No</th>
                        <th class="px-4 py-3">NISN</th>
                        <th class="px-4 py-3">Nama Siswa</th>
                        <th class="px-4 py-3 text-center">Kelas</th>
                        <th class="px-4 py-3 text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($siswas as $index => $siswa)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-center font-medium text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-mono text-gray-700">{{ $siswa->nisn ?? $siswa->nis ?? '-' }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $siswa->nama ?? $siswa->nama_siswa }}</td>
                            <td class="px-4 py-3 text-center text-gray-700">{{ $siswa->kelas ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <!-- Tombol Menuju E-Raport -->
                                <a href="{{ route('raport.show', $siswa->id) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-md shadow-sm transition">
                                    📊 Lihat E-Raport
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500 italic">
                                Belum ada data siswa yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection