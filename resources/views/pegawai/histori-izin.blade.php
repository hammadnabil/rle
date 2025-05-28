@extends('layouts.pegawai')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-200 to-blue-500 py-12 px-4">
    <div class="max-w-6xl mx-auto bg-white shadow-2xl rounded-2xl p-6 md:p-10">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Histori Pengajuan Izin Saya</h1>

        @if($histori->isEmpty())
            <div class="text-center text-gray-600 text-lg font-medium py-10">
                Belum ada pengajuan izin.
            </div>
        @else
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full bg-white text-sm">
                    <thead class="bg-green-600 text-white uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Tanggal Pengajuan</th>
                            <th class="px-4 py-3 text-left">Tanggal Izin</th>
                            <th class="px-4 py-3 text-left">Alasan</th>
                            <th class="px-4 py-3 text-left">Jam Mulai</th>
                            <th class="px-4 py-3 text-left">Jam Selesai</th>
                            <th class="px-4 py-3 text-left">Durasi</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Alasan Penolakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histori as $index => $izin)
                            <tr class="hover:bg-blue-50 border-b">
                                <td class="px-4 py-3">{{ ($histori->currentPage() - 1) * $histori->perPage() + $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ $izin->tanggal_pengajuan->format('d-m-Y') }}</td>
                                <td class="px-4 py-3">{{ $izin->tanggal_izin->format('d-m-Y') }}</td>
                                <td class="px-4 py-3">{{ $izin->alasan }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($izin->jam_mulai)->format('H:i') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($izin->jam_selesai)->format('H:i') }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $start = \Carbon\Carbon::parse($izin->jam_mulai);
                                        $end = \Carbon\Carbon::parse($izin->jam_selesai);
                                        $totalMinutes = $start->diffInMinutes($end);
                                        
                                        if ($totalMinutes % 60 === 0) {
                                            echo ($totalMinutes / 60) . ' jam';
                                        } else {
                                            $hours = floor($totalMinutes / 60);
                                            $minutes = $totalMinutes % 60;
                                            
                                            if ($hours > 0) {
                                                echo $hours . ' jam ' . $minutes . ' menit';
                                            } else {
                                                echo $minutes . ' menit';
                                            }
                                        }
                                    @endphp
                                </td>
                                <td class="px-4 py-3 capitalize font-semibold 
                                    @if($izin->status == 'disetujui') text-green-600 
                                    @elseif($izin->status == 'ditolak') text-red-600 
                                    @else text-yellow-500 @endif">
                                    {{ $izin->status }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $izin->status == 'ditolak' && $izin->alasan_ditolak ? $izin->alasan_ditolak : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

          
            <div class="flex flex-col md:flex-row justify-between items-center mt-6 px-4">
                <div class="text-sm text-gray-500 mb-4 md:mb-0">
                    Menampilkan {{ $histori->firstItem() }} - {{ $histori->lastItem() }} dari {{ $histori->total() }} data
                </div>
                <div>
                    {{ $histori->links('pagination::tailwind') }}
                </div>
            </div>
        @endif

        <div class="mt-10 text-center">
            <a href="{{ route('pegawai.dashboard') }}"
                class="inline-flex items-center bg-gray-600 hover:bg-gray-700 transition text-white font-semibold px-6 py-3 rounded-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection