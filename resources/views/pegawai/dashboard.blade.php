@extends('layouts.pegawai')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-2">Dashboard Pegawai</h1>
    <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>
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
