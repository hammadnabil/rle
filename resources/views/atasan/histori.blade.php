@extends('layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">
    
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <h1 class="text-2xl font-bold text-white mb-4 md:mb-0">Histori Pengajuan Izin</h1>
                    
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('atasan.histori.export', request()->all()) }}"
                            class="flex items-center bg-white text-green-700 hover:bg-gray-100 transition-colors font-medium py-2 px-4 rounded-lg shadow-sm">
                            <i class="fas fa-file-pdf mr-2"></i> Export PDF
                        </a>
                        <a href="{{ route('atasan.dashboard') }}"
                            class="flex items-center bg-white text-gray-700 hover:bg-gray-100 transition-colors font-medium py-2 px-4 rounded-lg shadow-sm">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

         
            <div class="px-6 py-4 bg-gray-50 border-b">
                <form method="GET" action="{{ route('atasan.histori') }}" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    
                        <div class="relative">
                            <label for="nama-pegawai" class="sr-only">Cari Nama Pegawai</label>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                                </svg>
                            </div>
                            <input type="text" id="nama-pegawai" name="name" value="{{ request('name') }}"
                                placeholder="Cari nama pegawai..."
                                class="w-full h-[42px] pl-10 pr-4 rounded-lg border border-gray-300 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 text-sm transition"
                                autocomplete="off" />
                            <div id="list-pegawai"
                                class="absolute z-50 w-full bg-white border border-gray-200 rounded-lg shadow-lg hidden max-h-60 overflow-y-auto mt-1 transition-all duration-200">
    
                            </div>
                        </div>

    
                        <select name="tahun" id="tahun-select"
                            class="rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 text-sm">
                            <option value="">Semua Tahun</option>
                            @for ($year = now()->year; $year >= now()->year - 5; $year--)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>

    
                        <select name="bulan" id="bulan-select"
                            class="rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 text-sm" 
                            {{ !request('tahun') ? 'disabled' : '' }}>
                            <option value="">Semua Bulan</option>
                            @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                                     5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                                     9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $name)
                                <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>

    
                        <select name="minggu" id="minggu-select"
                            class="rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 text-sm"
                            {{ !(request('tahun') && request('bulan')) ? 'disabled' : '' }}>
                            <option value="">Semua Minggu</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ request('minggu') == $i ? 'selected' : '' }}>
                                    Minggu ke-{{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </form>
            </div>

    
            <div id="histori-izin-container" class="p-6">
                @if ($histori->isEmpty())
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-clipboard-list text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700">Tidak ada histori izin</h3>
                        <p class="mt-1 text-gray-500">Tidak ditemukan data pengajuan izin dengan filter yang dipilih</p>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-green-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Nama Pegawai</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Tanggal Pengajuan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Tanggal Izin</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Waktu Izin</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Alasan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($histori as $index => $izin)
                                <tr class="hover:bg-green-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ($histori->currentPage() - 1) * $histori->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                                                <span class="text-green-600 font-medium">
                                                    {{ substr($izin->pegawai->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $izin->pegawai->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $izin->pegawai->jabatan }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $izin->tanggal_pengajuan->isoFormat('D MMMM Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $izin->tanggal_izin->isoFormat('D MMMM Y') }}
                                        <div class="text-xs text-gray-400">{{ $izin->tanggal_izin->isoFormat('dddd') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $izin->jam_mulai }} - {{ $izin->jam_selesai }}
                                        <div class="text-xs text-gray-400">
                                            @php
                                                $start = \Carbon\Carbon::parse($izin->jam_mulai);
                                                $end = \Carbon\Carbon::parse($izin->jam_selesai);
                                                echo $start->diffInHours($end) . ' jam';
                                            @endphp
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs">
                                        <div class="line-clamp-2 hover:line-clamp-none transition-all">
                                            {{ $izin->alasan }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClasses = [
                                                'disetujui' => 'bg-green-100 text-green-800',
                                                'ditolak' => 'bg-red-100 text-red-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800'
                                            ];
                                            $statusClass = $statusClasses[$izin->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded-full capitalize {{ $statusClass }}">
                                            {{ $izin->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        @if($izin->status == 'ditolak' && $izin->alasan_ditolak)
                                            <div class="line-clamp-2 hover:line-clamp-none transition-all">
                                                {{ $izin->alasan_ditolak }}
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

    
                    <div class="flex flex-col md:flex-row justify-between items-center mt-6 px-2">
                        <div class="text-sm text-gray-500 mb-4 md:mb-0">
                            Menampilkan {{ $histori->firstItem() }} - {{ $histori->lastItem() }} dari {{ $histori->total() }} data
                        </div>
                        <div>
                            {{ $histori->onEachSide(1)->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const $namaPegawaiInput = $('#nama-pegawai');
    const $listPegawai = $('#list-pegawai');
    const $tahunSelect = $('#tahun-select');
    const $bulanSelect = $('#bulan-select');
    const $mingguSelect = $('#minggu-select');
    const $filterForm = $('#filterForm');
    
    let debounceTimer;
    const debounceDelay = 300;
    
    
    $tahunSelect.select2({
        placeholder: "Pilih Tahun",
        width: '100%',
        minimumResultsForSearch: Infinity
    });
    
    $bulanSelect.select2({
        placeholder: "Pilih Bulan",
        width: '100%',
        minimumResultsForSearch: Infinity,
        disabled: !$tahunSelect.val()
    });
    
    $mingguSelect.select2({
        placeholder: "Pilih Minggu",
        width: '100%',
        minimumResultsForSearch: Infinity,
        disabled: !($tahunSelect.val() && $bulanSelect.val())
    });

    
    $namaPegawaiInput.on('input', function() {
        clearTimeout(debounceTimer);
        const query = $(this).val().trim();
        
        if (query.length >= 2) {
            debounceTimer = setTimeout(() => {
                fetchPegawaiData(query);
            }, debounceDelay);
        } else {
            $listPegawai.addClass('hidden').empty();
            submitFilterForm();
        }
    });
    
    function fetchPegawaiData(query) {
        $.get("{{ route('cari.pegawai') }}", { q: query })
            .done(function(data) {
                renderPegawaiList(data);
            })
            .fail(function() {
                showError("Gagal memuat data pegawai");
            });
    }
    
    function renderPegawaiList(data) {
        $listPegawai.empty();
        
        if (data.length > 0) {
            data.forEach(pegawai => {
                $('<div>')
                    .addClass('px-4 py-2 hover:bg-green-100 cursor-pointer text-sm')
                    .text(pegawai.text)
                    .data('id', pegawai.id)
                    .data('name', pegawai.text)
                    .appendTo($listPegawai)
                    .on('click', selectPegawai);
            });
            $listPegawai.removeClass('hidden');
        } else {
            $('<div>')
                .addClass('px-4 py-2 text-gray-400 text-sm')
                .text('Tidak ditemukan')
                .appendTo($listPegawai);
            $listPegawai.removeClass('hidden');
        }
    }
    
    function selectPegawai() {
        const $selected = $(this);
        $namaPegawaiInput.val($selected.data('name'));
        $listPegawai.addClass('hidden');
        submitFilterForm();
    }
    
    function showError(message) {
        $listPegawai.empty()
            .append($('<div>').addClass('px-4 py-2 text-red-500 text-sm').text(message))
            .removeClass('hidden');
    }
    
    
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#nama-pegawai, #list-pegawai').length) {
            $listPegawai.addClass('hidden');
        }
    });
    
    
    $namaPegawaiInput.on('focus', function() {
        if ($listPegawai.children().length > 0) {
            $listPegawai.removeClass('hidden');
        }
    });
    
    
    function updateFilterState() {
        const tahun = $tahunSelect.val();
        const bulan = $bulanSelect.val();
        
     
        $bulanSelect.prop('disabled', !tahun).select2('enable', !!tahun);
        
     
        $mingguSelect.prop('disabled', !(tahun && bulan)).select2('enable', !!(tahun && bulan));
        
     
        if (!tahun) {
            $bulanSelect.val(null).trigger('change');
            $mingguSelect.val(null).trigger('change');
        } else if (!bulan) {
            $mingguSelect.val(null).trigger('change');
        }
        
        submitFilterForm();
    }
    
    
    function submitFilterForm() {
        
        $('#histori-izin-container').html(`
            <div class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-green-600 mb-4"></div>
                <p class="text-gray-600">Memuat data...</p>
            </div>
        `);
        
        
        $.ajax({
            url: $filterForm.attr('action'),
            type: "GET",
            data: $filterForm.serialize(),
            success: function(response) {
                const html = $(response).find('#histori-izin-container').html();
                $('#histori-izin-container').html(html);
            },
            error: function() {
                $('#histori-izin-container').html(`
                    <div class="text-center py-12">
                        <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-700">Gagal memuat data</h3>
                        <p class="mt-1 text-gray-500">Silakan coba lagi beberapa saat</p>
                    </div>
                `);
            }
        });
    }
    
    
    $tahunSelect.on('change', updateFilterState);
    $bulanSelect.on('change', updateFilterState);
    $mingguSelect.on('change', submitFilterForm);
    
    
    updateFilterState();
});
</script>

<style>
    
    .select2-container--default .select2-selection--single {
        height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px;
        padding-left: 16px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
    
    
    #list-pegawai::-webkit-scrollbar {
        width: 6px;
    }
    
    #list-pegawai::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 0 0 0.5rem 0.5rem;
    }
    
    #list-pegawai::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    #list-pegawai::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
    
    
    tr {
        transition: all 0.2s ease;
    }
    
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-none {
        -webkit-line-clamp: unset;
    }

    #list-pegawai div:hover {
    background-color: #f3f4f6; 
    cursor: pointer;
}

</style>
@endsection