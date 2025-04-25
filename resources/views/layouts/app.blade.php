<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RLE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-600">RLE</h1>

            @auth('pegawai')
                <span class="text-sm text-gray-600">Login sebagai Pegawai</span>
            @endauth
            @auth('atasan')
                <span class="text-sm text-gray-600">Login sebagai Atasan</span>
            @endauth
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="text-center text-sm text-gray-400 py-4">
        &copy; {{ date('Y') }} LRE. All rights reserved.
    </footer>

</body>
</html>
