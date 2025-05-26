@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-100 to-green-300 py-12 px-6">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Detail Pengguna</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm text-gray-600">Nama</label>
                <p class="text-lg font-semibold text-gray-800">{{ $user->name }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-600">Email</label>
                <p class="text-lg font-semibold text-gray-800">{{ $user->email }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-600">Jabatan</label>
                <p class="text-lg font-semibold text-gray-800 capitalize">{{ $user->jabatan }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-600">Nomor WA</label>
                <p class="text-lg font-semibold text-gray-800">{{ $user->no_wa ?? '-' }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-600">Umur</label>
                <p class="text-lg font-semibold text-gray-800">{{ $user->umur ?? '-' }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-600">Tanggal Bergabung</label>
                <p class="text-lg font-semibold text-gray-800">
                    {{ $user->tanggal_bergabung ? \Carbon\Carbon::parse($user->tanggal_bergabung)->format('d M Y') : '-' }}
                </p>
            </div>
            <div>
                <label class="block text-sm text-gray-600">Jenis Kelamin</label>
                <p class="text-lg font-semibold text-gray-800">
                    @if($user->gender === 'L') Laki-laki
                    @elseif($user->gender === 'P') Perempuan
                    @else - @endif
                </p>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('atasan.user.index') }}" class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded-lg">
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection
