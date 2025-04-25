@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-200 to-blue-500 py-12 px-4">
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Pengajuan Izin</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white shadow-md rounded-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama Pegawai</th>
                        <th class="px-4 py-2 text-left">Tanggal Izin</th>
                        <th class="px-4 py-2 text-left">Alasan</th>
                        <th class="px-4 py-2 text-left">Status Persetujuan</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuan as $izin)
                        <tr class="border-t hover:bg-blue-50">
                            <td class="px-4 py-2">{{ $izin->pegawai->nama }}</td>
                            <td class="px-4 py-2">{{ $izin->tanggal_izin }}</td>
                            <td class="px-4 py-2">{{ $izin->alasan }}</td>
                            <td class="px-4 py-2 capitalize">{{ $izin->status }}</td>
                            <td class="px-4 py-2 text-center">
                                <form action="{{ route('atasan.setujuiTolak', $izin->izin_id) }}" method="POST">
                                    @csrf
                                    <select name="status" class="form-select w-full px-4 py-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                                        <option value="disetujui" {{ $izin->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="ditolak" {{ $izin->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                    <button type="submit" class="mt-2 w-full py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-300">
                                        Proses
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
