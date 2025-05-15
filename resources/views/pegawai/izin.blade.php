@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-100 px-4 py-12 animate-fade-in">
    <div class="w-full max-w-xl bg-white p-8 rounded-2xl shadow-2xl">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Ajukan Izin</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('izin.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Pilih Atasan</label>
                <select name="atasan_id" required class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Atasan --</option>
                    @forelse($atasans as $atasan)
                        <option value="{{ $atasan->id }}">
                            {{ $atasan->name }} - {{ $atasan->jabatan }}
                        </option>
                    @empty
                        <option value="" disabled>Tidak ada atasan tersedia</option>
                    @endforelse
                </select>
                @error('atasan_id')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal Izin</label>
                <input type="date" name="tanggal_izin" class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                @error('tanggal_izin')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Alasan</label>
                <textarea name="alasan" rows="3" class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required></textarea>
                @error('alasan')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('pegawai.dashboard') }}" class="text-red-600 border border-red-500 px-4 py-2 rounded hover:bg-red-50 transition duration-200">
                    Kembali
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
</style>
@endsection
