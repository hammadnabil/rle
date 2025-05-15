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

            <div class="flex items-center space-x-4">
                @auth
                    @if (Auth::user()->jabatan === 'pegawai')
                        <span class="text-sm text-gray-600">Login sebagai Pegawai</span>
                    @elseif (Auth::user()->jabatan === 'atasan')
                        <span class="text-sm text-gray-600">Login sebagai Atasan</span>
                    @endif
                    
                    <!-- Tombol Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition duration-200">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
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