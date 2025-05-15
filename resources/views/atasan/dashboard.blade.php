@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 via-green-300 to-green-500 py-12 px-4 animate-gradient-x">
    <div class="bg-white shadow-lg rounded-xl w-full max-w-2xl p-8 text-center transform transition duration-500 hover:scale-105 hover:shadow-xl">
        <!-- Menampilkan Nama User setelah login -->
        <h1 class="text-2xl font-bold text-gray-800 transition duration-500 ease-in-out transform hover:text-green-600">
            Halo, {{ Auth::user()->nama }} <!-- Menggunakan Auth::user() -->
        </h1>
        <p class="mt-2 text-gray-600">Anda login sebagai {{ Auth::user()->jabatan }}.</p> <!-- Menampilkan jabatan berdasarkan data user -->

        <p class="mt-4 text-gray-500">Silakan kelola pengajuan izin dari pegawai.</p>

        <div class="mt-6">
            <a href="{{ route('atasan.pengajuan') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-800">
                Kelola Pengajuan Izin
            </a>
        </div>

        <div class="mt-4">
            <a href="{{ route('atasan.histori') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition duration-300 ease-in-out transform hover:scale-105 hover:bg-green-800">
                Lihat Histori Izin
            </a>
        </div>
        

        <!-- Form logout -->
        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="text-red-600 hover:text-red-800 text-lg font-semibold transition duration-300 ease-in-out">
                Logout
            </button>
        </form>
    </div>
</div>
@endsection
