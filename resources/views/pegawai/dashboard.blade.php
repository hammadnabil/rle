    @extends('layouts.app')

    @section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-blue-200 to-white py-12 px-4 animate-fade-in">
        <div class="bg-white shadow-2xl rounded-2xl w-full max-w-2xl p-10 text-center transition-transform duration-500 transform hover:scale-105">
            <h1 class="text-3xl font-bold text-gray-800">Selamat Datang,  {{ Auth::user()->nama }} </h1>
            <p class="mt-2 text-gray-600 text-lg">Ini adalah dashboard Pegawai.</p>

            <div class="mt-8">
                <a href="{{ route('izin.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition duration-300">
                    Ajukan Izin
                </a>
            </div>
            

            <form action="{{ route('logout') }}" method="POST" class="mt-8">
                @csrf
                <button type="submit" class="text-red-600 hover:underline text-sm tracking-wide">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }
    </style>
    @endsection
