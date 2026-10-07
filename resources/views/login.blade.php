<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Operator - SMA ZIYADATUL ILMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100 w-full max-w-md">
        <div class="text-center mb-6">
            <div class="bg-[#004d25] text-yellow-400 w-14 h-14 rounded-full flex items-center justify-center font-bold text-2xl mx-auto mb-3 shadow">
                Z
            </div>
            <h2 class="text-xl font-bold text-gray-900">Login Portal Sekolah</h2>
            <p class="text-xs text-gray-400 mt-1">SMA ZIYADATUL ILMI</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Email / Username</label>
                <input type="text" name="email" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#004d25] focus:outline-none text-sm" value="admin@ziyadatulilmi.sch.id" required>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#004d25] focus:outline-none text-sm" value="admin123" required>
            </div>
            <button type="submit" class="w-full bg-[#004d25] text-white font-bold py-2.5 rounded-lg hover:bg-[#003318] transition text-sm shadow">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-[#004d25] transition"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>