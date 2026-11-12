<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scan Absensi QR - Ziyadatul Ilmi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

    <!-- Header -->
    <div class="bg-emerald-800 text-white py-4 px-6 shadow-md flex justify-between items-center">
        <div>
            <h1 class="text-lg font-bold">SCAN ABSENSI SANTRI / SISWA</h1>
            <p class="text-xs text-emerald-200">Pondok Pesantren Ziyadatul Ilmi</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('absen.kartu') }}" class="bg-amber-400 text-emerald-950 text-xs font-bold px-3 py-2 rounded-lg hover:bg-amber-300">
                Kartu QR
            </a>
            <a href="{{ route('admin.dashboard') }}" class="bg-emerald-700 text-white text-xs font-semibold px-3 py-2 rounded-lg hover:bg-emerald-600">
                Dashboard
            </a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto p-4 grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        
        <!-- Area Kamera Scanner -->
        <div class="bg-white p-5 rounded-2xl shadow">
            <h2 class="font-bold text-gray-800 mb-3 text-center">Arahkan Kartu QR ke Kamera</h2>
            
            <div id="reader" class="w-full rounded-xl overflow-hidden border-2 border-emerald-600"></div>

            <!-- Notifikasi Hasil Scan -->
            <div id="status-box" class="mt-4 p-4 rounded-xl text-center font-semibold text-sm hidden"></div>
        </div>

        <!-- Riwayat Scan Hari Ini -->
        <div class="bg-white p-5 rounded-2xl shadow">
            <div class="flex justify-between items-center mb-3">
                <h2 class="font-bold text-gray-800">Hadir Hari Ini ({{ today()->format('d M Y') }})</h2>
                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-2.5 py-1 rounded-full" id="count-hadir">
                    {{ $riwayatHariIni->count() }} Terbaru
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 border-b">
                        <tr>
                            <th class="py-2 px-3">Jam</th>
                            <th class="py-2 px-3">Nama</th>
                            <th class="py-2 px-3">Kelas</th>
                        </tr>
                    </thead>
                    <tbody id="riwayat-list" class="divide-y">
                        @forelse($riwayatHariIni as $item)
                            <tr>
                                <td class="py-2 px-3 font-mono text-xs text-emerald-700 font-bold">{{ $item->jam_masuk ?? '-' }}</td>
                                <td class="py-2 px-3 font-medium text-gray-800">{{ $item->siswa->nama ?? '-' }}</td>
                                <td class="py-2 px-3 text-gray-500 text-xs">{{ $item->siswa->kelas ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr id="empty-row">
                                <td colspan="3" class="py-6 text-center text-gray-400 text-xs">Belum ada scan hari ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        let isProcessing = false;
        const statusBox = document.getElementById('status-box');
        const riwayatList = document.getElementById('riwayat-list');

        // Suara beep sederhana saat scan sukses
        function playBeep(success = true) {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(success ? 880 : 300, ctx.currentTime);
            osc.connect(ctx.destination);
            osc.start();
            osc.stop(ctx.currentTime + 0.15);
        }

        function showAlert(type, message) {
            statusBox.classList.remove('hidden', 'bg-emerald-100', 'text-emerald-800', 'bg-amber-100', 'text-amber-800', 'bg-red-100', 'text-red-800');
            if (type === 'success') {
                statusBox.classList.add('bg-emerald-100', 'text-emerald-800');
            } else if (type === 'warning') {
                statusBox.classList.add('bg-amber-100', 'text-amber-800');
            } else {
                statusBox.classList.add('bg-red-100', 'text-red-800');
            }
            statusBox.textContent = message;
        }

        function onScanSuccess(decodedText) {
            if (isProcessing) return;
            isProcessing = true;

            fetch("{{ route('absen.scan.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ qr_token: decodedText })
            })
            .then(res => res.json())
            .then(res => {
                playBeep(res.status === 'success');
                showAlert(res.status, res.message);

                if (res.status === 'success' && res.data) {
                    const emptyRow = document.getElementById('empty-row');
                    if (emptyRow) emptyRow.remove();

                    const row = `
                        <tr class="bg-emerald-50">
                            <td class="py-2 px-3 font-mono text-xs text-emerald-700 font-bold">${res.data.jam_masuk}</td>
                            <td class="py-2 px-3 font-medium text-gray-800">${res.data.nama}</td>
                            <td class="py-2 px-3 text-gray-500 text-xs">${res.data.kelas}</td>
                        </tr>
                    `;
                    riwayatList.insertAdjacentHTML('afterbegin', row);
                }
            })
            .catch(() => {
                showAlert('error', 'Gagal terhubung ke server.');
            })
            .finally(() => {
                // Jeda 2 detik sebelum scan kartu berikutnya biar nggak ke-scan berkali-kali
                setTimeout(() => { isProcessing = false; }, 2000);
            });
        }

        const html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: { width: 230, height: 230 } },
            false
        );
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>