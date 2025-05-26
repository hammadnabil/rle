@extends('layouts.pegawai')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 to-blue-300 py-12 px-6">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-xl">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Profil Pegawai</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <p class="mt-1 text-gray-900 font-semibold">{{ $user->name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="mt-1 text-gray-900 font-semibold">{{ $user->email }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                <p class="mt-1 text-gray-900 font-semibold capitalize">{{ $user->jabatan }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                <p class="mt-1 text-gray-900 font-semibold">{{ $user->no_wa ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Umur</label>
                <p class="mt-1 text-gray-900 font-semibold">{{ $user->umur ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                <p class="mt-1 text-gray-900 font-semibold">
                    {{ $user->tanggal_bergabung ? \Carbon\Carbon::parse($user->tanggal_bergabung)->format('d M Y') : '-' }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <p class="mt-1 text-gray-900 font-semibold">
                    @if($user->gender === 'L')
                        Laki-laki
                    @elseif($user->gender === 'P')
                        Perempuan
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('pegawai.dashboard') }}" class="inline-block bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
