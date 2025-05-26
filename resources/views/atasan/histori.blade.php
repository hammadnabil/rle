@extends('layouts.app')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-200 to-blue-500 py-12 px-4">
    <div class="max-w-6xl mx-auto bg-white shadow-2xl rounded-2xl p-6 md:p-10">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Histori Pengajuan Izin</h1>
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
    <form method="GET" action="{{ route('atasan.histori') }}" class="w-full md:w-auto grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="relative">
            <input type="text" id="nama-pegawai" name="name" value="{{ request('name') }}" placeholder="Nama Pegawai..." 
                class="w-full rounded-lg border-2 border-gray-400 focus:ring-2 focus:ring-blue-300 px-4 py-2 text-sm" autocomplete="off" />
            <div id="list-pegawai" class="absolute z-50 w-full bg-white border border-gray-300 rounded-b shadow-lg hidden max-h-60 overflow-auto mt-1"></div>
        </div>
        <select name="tahun" id="tahun-select"
            class="rounded-lg border-2 border-gray-400 focus:ring-2 focus:ring-blue-300 px-4 py-2 text-sm">
            <option value="">Pilih Tahun</option>
            @for ($year = now()->year; $year >= now()->year - 5; $year--)
                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endfor
        </select>
        <select name="bulan" id="bulan-select"
            class="rounded-lg border-2 border-gray-400 focus:ring-2 focus:ring-blue-300 px-4 py-2 text-sm" disabled>
            <option value="">Pilih Bulan</option>
            @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 
                       7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $name)
                <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
        <select name="minggu" id="minggu-select"
            class="rounded-lg border-2 border-gray-400 focus:ring-2 focus:ring-blue-300 px-4 py-2 text-sm" disabled>
            <option value="">Pilih Minggu</option>
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ request('minggu') == $i ? 'selected' : '' }}>
                    Minggu ke-{{ $i }}
                </option>
            @endfor
        </select>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 transition text-white font-semibold py-2 px-4 rounded-lg shadow-md">
            Cari
        </button>
    </form>
</div>
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white">
                <thead class="bg-green-600 text-white text-sm uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama Pegawai</th>
                        <th class="px-6 py-3 text-left">Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left">Tanggal Izin</th>
                        <th class="px-6 py-3 text-left">Alasan</th>
                        <th class="px-6 py-3 text-left">Jam Mulai</th>
                        <th class="px-6 py-3 text-left">Jam Selesai</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Alasan Penolakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histori as $izin)
                        <tr class="hover:bg-blue-50 border-b">
                            <td class="px-6 py-4">{{ $izin->pegawai->name }}</td>
                            <td class="px-6 py-4">{{ $izin->tanggal_pengajuan->format('d-m-Y') }}</td>
                            <td class="px-6 py-4">{{ $izin->tanggal_izin->format('d-m-Y') }}</td>
                            <td class="px-6 py-4">{{ $izin->alasan }}</td>
                            <td class="px-6 py-4">{{ $izin->jam_mulai }}</td>
                            <td class="px-6 py-4">{{ $izin->jam_selesai }}</td>
                            <td class="px-6 py-4 capitalize font-semibold 
                                @if($izin->status == 'disetujui') text-green-600 
                                @elseif($izin->status == 'ditolak') text-red-600 
                                @else text-yellow-500 @endif">
                                {{ $izin->status }}
                            </td>
                            <td class="px-6 py-4">
                        @if($izin->status == 'ditolak' && $izin->alasan_ditolak)
                                {{ $izin->alasan_ditolak }}
                            @else
                                -
                            @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada histori izin.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('atasan.histori.export', request()->all()) }}" 
               class="inline-block bg-red-600 hover:bg-red-700 transition text-white font-semibold py-1.5 px-4 text-sm rounded-lg shadow-md">
                Export PDF
            </a>
        </div>

     
    </div>

    
<div class="mt-10 text-center">
    <a href="{{ route('atasan.dashboard') }}" class="inline-block bg-gray-600 hover:bg-gray-700 transition text-white font-semibold px-6 py-3 rounded-lg">
        Kembali ke Dashboard
    </a>
</div>
</div>


<script>
$(document).ready(function() {
    
    function updateFilterState() {
        let tahunDipilih = $('#tahun-select').val();
        let bulanDipilih = $('#bulan-select').val();

        if (tahunDipilih) {
            $('#bulan-select').removeAttr('disabled');
        } else {
            $('#bulan-select').val('').attr('disabled', true);
            $('#minggu-select').val('').attr('disabled', true);
        }

        if (tahunDipilih && bulanDipilih) {
            $('#minggu-select').removeAttr('disabled');
        } else {
            $('#minggu-select').val('').attr('disabled', true);
        }
    }

    
    updateFilterState();

   
    $('#tahun-select, #bulan-select').on('change', function() {
        updateFilterState();
    });

  
    $('#nama-pegawai').on('input', function() {
        let query = $(this).val().trim();
        if (query.length >= 2) {
            $.ajax({
                url: "{{ route('cari.pegawai') }}",
                method: 'GET',
                data: { q: query },
                success: function(data) {
                    let pegawaiList = $('#list-pegawai');
                    pegawaiList.empty();
                    
                    if (data.length > 0) {
                        data.forEach(function(pegawai) {
                            pegawaiList.append(
                                $('<div>')
                                    .addClass('px-4 py-2 hover:bg-blue-100 cursor-pointer text-sm')
                                    .text(pegawai.text)
                                    .data('name', pegawai.text)
                                    .on('click', function() {
                                        $('#nama-pegawai').val($(this).data('name'));
                                        pegawaiList.addClass('hidden');
                                    })
                            );
                        });
                        pegawaiList.removeClass('hidden');
                    } else {
                        pegawaiList.append(
                            $('<div>')
                                .addClass('px-4 py-2 text-gray-400 text-sm')
                                .text('Tidak ditemukan')
                        );
                        pegawaiList.removeClass('hidden');
                    }
                },
                error: function() {
                    $('#list-pegawai').addClass('hidden');
                }
            });
        } else {
            $('#list-pegawai').addClass('hidden').empty();
        }
    });

 
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#nama-pegawai, #list-pegawai').length) {
            $('#list-pegawai').addClass('hidden');
        }
    });

   
    $('#nama-pegawai').on('focus', function() {
        if ($('#list-pegawai').children().length > 0) {
            $('#list-pegawai').removeClass('hidden');
        }
    });
});
</script>

@endsection
