<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RLE Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        html {
            overflow-x: hidden;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased" x-data="{ sidebarOpen: false }">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 w-64 bg-white shadow-md transform transition-transform duration-200 ease-in-out z-30 md:relative md:translate-x-0">
        <div class="p-6 border-b flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">RLE</h1>
            <button class="md:hidden text-gray-500" @click="sidebarOpen = false">✖</button>
        </div>
        <nav class="mt-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('atasan.pengajuan') }}"
                       class="block px-6 py-3 hover:bg-blue-100 text-gray-700 font-medium">
                        Kelola Pengajuan Izin
                    </a>
                </li>
                <li>
                    <a href="{{ route('atasan.histori') }}"
                       class="block px-6 py-3 hover:bg-blue-100 text-gray-700 font-medium">
                        Histori Izin
                    </a>
                </li>
                <li>
                    <a href="{{ route('atasan.dashboard') }}"
                       class="block px-6 py-3 hover:bg-blue-100 text-gray-700 font-medium">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('atasan.user.index') }}"
                       class="block px-6 py-3 hover:bg-blue-100 text-gray-700 font-medium">
                        List Pengguna
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-6 py-3 hover:bg-red-100 text-red-600 font-medium">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen w-0 md:w-auto overflow-hidden">

        <!-- Header -->
        <header class="bg-white shadow px-4 sm:px-6 py-4 flex justify-between items-center sticky top-0 z-20">
            <button @click="sidebarOpen = true" class="md:hidden text-gray-700 focus:outline-none">
                ☰
            </button>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-2 sm:p-4 md:p-6 overflow-auto">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="text-center text-sm text-gray-400 py-4 bg-white border-t">
            &copy; {{ date('Y') }} RLE. All rights reserved.
        </footer>
    </div>
</div>

</body>
</html>
