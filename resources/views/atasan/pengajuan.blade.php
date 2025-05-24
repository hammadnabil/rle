@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-200 to-blue-500 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto bg-white shadow-2xl rounded-2xl p-6 md:p-10">
        <h1 class="text-2xl sm:text-3xl font-bold text-center text-gray-800 mb-6">Pengajuan Izin</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white text-sm">
                <thead class="bg-blue-600 text-white uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Tanggal Izin</th>
                        <th class="px-4 py-3 text-left">Mulai</th>
                        <th class="px-4 py-3 text-left">Selesai</th>
                        <th class="px-4 py-3 text-left">Alasan</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($pengajuan as $izin)
                    <tr class="hover:bg-blue-50">
                        <td class="px-4 py-3 whitespace-nowrap">{{ $izin->pegawai->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $izin->tanggal_izin->format('d-m-Y') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $izin->jam_mulai }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $izin->jam_selesai }}</td>
                        <td class="px-4 py-3 max-w-xs truncate">{{ $izin->alasan }}</td>
                        <td class="px-4 py-3 capitalize font-semibold 
                            @if($izin->status == 'disetujui') text-green-600 
                            @elseif($izin->status == 'ditolak') text-red-600 
                            @else text-yellow-500 @endif">
                            {{ $izin->status }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('atasan.setujuiTolak', $izin->izin_id) }}" method="POST" class="flex flex-col sm:flex-row gap-2 items-center justify-center">
                                @csrf
                                <select name="status" class="w-full sm:w-auto px-2 py-1 border border-gray-300 rounded text-xs sm:text-sm" required>
                                    <option value="disetujui" {{ $izin->status == 'disetujui' ? 'selected' : '' }}>Setuju</option>
                                    <option value="ditolak" {{ $izin->status == 'ditolak' ? 'selected' : '' }}>Tolak</option>
                                </select>
                                <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs sm:text-sm">
                                    Proses
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('atasan.dashboard') }}" class="inline-block bg-gray-600 text-white px-5 py-2 rounded hover:bg-gray-700 text-sm font-medium">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

@endsection
