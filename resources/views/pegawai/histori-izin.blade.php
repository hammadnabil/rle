@extends('layouts.pegawai')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-200 to-blue-500 py-12 px-4">
    <div class="max-w-5xl mx-auto bg-white shadow-2xl rounded-2xl p-6 md:p-10">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Histori Pengajuan Izin Saya</h1>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white">
                <thead class="bg-green-600 text-white text-sm uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left">Tanggal Izin</th>
                        <th class="px-6 py-3 text-left">Alasan</th>
                        <th class="px-6 py-3 text-left">Jam Mulai</th>
                        <th class="px-6 py-3 text-left">Jam Selesai</th>
                        <th class="px-6 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histori as $izin)
                        <tr class="hover:bg-blue-50 border-b">
                            <td class="px-6 py-4">{{ $izin->tanggal_pengajuan->format('d-m-Y') }}</td>
                            <td class="px-6 py-4">{{ $izin->tanggal_izin->format('d-m-Y') }}</td>
                            <td class="px-6 py-4">{{ $izin->alasan }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($izin->jam_mulai)->format('H:i') }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($izin->jam_selesai)->format('H:i') }}</td>
                            <td class="px-6 py-4 capitalize font-semibold 
                                @if($izin->status == 'disetujui') text-green-600 
                                @elseif($izin->status == 'ditolak') text-red-600 
                                @else text-yellow-500 @endif">
                                {{ $izin->status }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada pengajuan izin.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('pegawai.dashboard') }}" class="inline-block bg-gray-600 hover:bg-gray-700 transition text-white font-semibold px-6 py-3 rounded-lg">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

@endsection
