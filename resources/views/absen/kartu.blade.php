<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu QR Santri / Siswa - Ziyadatul Ilmi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

    <div class="no-print bg-emerald-800 text-white py-4 px-6 shadow-md flex justify-between items-center">
        <div>
            <h1 class="text-lg font-bold">CETAK KARTU ABSENSI QR</h1>
            <p class="text-xs text-emerald-200">Pondok Pesantren Ziyadatul Ilmi</p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()" class="bg-amber-400 text-emerald-950 text-xs font-bold px-4 py-2 rounded-lg hover:bg-amber-300">
                Cetak / Save PDF
            </button>
            <a href="{{ route('absen.scan') }}" class="bg-emerald-700 text-white text-xs font-semibold px-3 py-2 rounded-lg hover:bg-emerald-600">
                Buka Scanner
            </a>
        </div>
    </div>

    <div class="max-w-5xl mx-auto p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
        @forelse($siswas as $siswa)
            <div class="bg-white border-2 border-emerald-700 rounded-2xl p-4 shadow-sm flex flex-col items-center text-center break-inside-avoid">
                <div class="w-full bg-emerald-800 text-white py-1.5 px-3 rounded-lg mb-3">
                    <p class="text-[10px] tracking-wider uppercase text-amber-300 font-bold">Kartu Presensi Digital</p>
                    <p class="text-xs font-bold">PONPES ZIYADATUL ILMI</p>
                </div>

                <!-- Tempat Render QR Code -->
                <div id="qr-{{ $siswa->id }}" class="p-2 bg-white border rounded-xl my-1"></div>

                <h3 class="font-bold text-gray-900 text-sm mt-2">{{ $siswa->nama }}</h3>
                <p class="text-xs text-emerald-700 font-semibold">Kelas: {{ $siswa->kelas }}</p>
                <p class="text-[11px] text-gray-500 mt-0.5">NISN: {{ $siswa->nisn }}</p>
                <p class="text-[10px] font-mono text-gray-400 mt-1">{{ $siswa->qr_token }}</p>
            </div>

            <script>
                new QRCode(document.getElementById("qr-{{ $siswa->id }}"), {
                    text: "{{ $siswa->qr_token }}",
                    width: 130,
                    height: 130,
                    colorDark: "#064e3b",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            </script>
        @empty
            <div class="col-span-3 text-center py-12 text-gray-500">
                Belum ada data siswa di database.
            </div>
        @endforelse
    </div>

</body>
</html>