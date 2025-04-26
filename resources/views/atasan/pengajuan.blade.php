@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-200 to-blue-500 py-12 px-4">
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-4 sm:p-6 md:p-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-center text-gray-800 mb-6">Pengajuan Izin</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm sm:text-base">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white shadow-md rounded-lg text-sm sm:text-base">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-2 sm:px-2 py-2 text-left whitespace-nowrap">Nama Pegawai</th>
                        <th class="px-2 sm:px-2 py-2 text-left whitespace-nowrap">Tanggal Izin</th>
                        <th class="px-2 sm:px-2 py-2 text-left whitespace-nowrap">Alasan</th>
                        <th class="px-2 sm:px-2 py-2 text-left whitespace-nowrap">Status Persetujuan</th>
                        <th class="px-2 sm:px-2 py-2 text-center whitespace-nowrap w-50 sm:w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuan as $izin)
                        <tr class="border-t hover:bg-blue-50">
                            <td class="px-3 sm:px-4 py-2">{{ $izin->pegawai->nama }}</td>
                            <td class="px-3 sm:px-4 py-2">{{ $izin->tanggal_izin }}</td>
                            <td class="px-3 sm:px-4 py-2">{{ $izin->alasan }}</td>
                            <td class="px-3 sm:px-4 py-2 capitalize">{{ $izin->status }}</td>
                            <td class="px-3 sm:px-4 py-2 text-center w-40 sm:w-48">
                                <form action="{{ route('atasan.setujuiTolak', $izin->izin_id) }}" method="POST" class="flex flex-col sm:flex-row sm:items-center gap-2">
                                    @csrf
                                    <select name="status"
                                    class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 text-xs sm:text-sm md:text-base"
                                    required>
                                    <option value="disetujui" {{ $izin->status == 'disetujui' ? 'selected' : '' }}>setuju</option>
                                    <option value="ditolak" {{ $izin->status == 'ditolak' ? 'selected' : '' }}>tolak</option>
                                </select>
                                
             
                                    <button type="submit" class="w-full sm:w-auto py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-300 text-sm sm:text-base">
                                        Proses
                                    </button>
                                </form>
                            </td>                                                      
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('atasan.dashboard') }}" class="inline-block bg-gray-600 text-white px-5 sm:px-6 py-2 rounded hover:bg-gray-700 transition text-sm sm:text-base">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
