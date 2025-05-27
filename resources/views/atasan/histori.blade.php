    @extends('layouts.app')

    @section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-200 to-blue-500 py-8 px-4">
        <div class="max-w-6xl mx-auto bg-white shadow-2xl rounded-2xl p-6 md:p-10">
            <h1 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-8">Histori Pengajuan Izin</h1>

            <div class="mb-8">
                <form method="GET" action="{{ route('atasan.histori') }}">
        <div class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-[220px] relative">
                <input type="text" id="nama-pegawai" name="name" value="{{ request('name') }}"
                    placeholder="Nama Pegawai..."
                    class="w-full rounded-lg border-2 border-gray-400 focus:ring-2 focus:ring-blue-300 px-4 py-2 text-sm"
                    autocomplete="off" />
                <div id="list-pegawai"
                    class="absolute z-50 w-full bg-white border border-gray-300 rounded-b shadow-lg hidden max-h-60 overflow-auto mt-1">
                </div>
            </div>

            <select name="tahun" id="tahun-select"
                class="w-40 rounded-lg border-2 border-gray-400 focus:ring-2 focus:ring-blue-300 px-4 py-2 text-sm">
                <option value="">Pilih Tahun</option>
                @for ($year = now()->year; $year >= now()->year - 5; $year--)
                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endfor
            </select>

            <select name="bulan" id="bulan-select"
                class="w-40 rounded-lg border-2 border-gray-400 focus:ring-2 focus:ring-blue-300 px-4 py-2 text-sm" disabled>
                <option value="">Pilih Bulan</option>
                @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $name)
                    <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>

            <select name="minggu" id="minggu-select"
                class="w-40 rounded-lg border-2 border-gray-400 focus:ring-2 focus:ring-blue-300 px-4 py-2 text-sm" disabled>
                <option value="">Pilih Minggu</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ request('minggu') == $i ? 'selected' : '' }}>Minggu ke-{{ $i }}</option>
                @endfor
            </select>
        </div>
    </form>

            </div>

            <div id="histori-izin-container">
                @if ($histori->isEmpty())
                    <div class="text-center text-gray-600 text-lg font-medium py-10">
                        Tidak ada histori izin.
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg shadow">
                        <table class="min-w-full bg-white text-sm">
                            <thead class="bg-green-600 text-white uppercase">
                                <tr>
                                    <th class="px-4 py-3 text-left">Nama Pegawai</th>
                                    <th class="px-4 py-3 text-left">Tanggal Pengajuan</th>
                                    <th class="px-4 py-3 text-left">Tanggal Izin</th>
                                    <th class="px-4 py-3 text-left">Alasan</th>
                                    <th class="px-4 py-3 text-left">Jam Mulai</th>
                                    <th class="px-4 py-3 text-left">Jam Selesai</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                    <th class="px-4 py-3 text-left">Alasan Penolakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($histori as $izin)
                                    <tr class="hover:bg-blue-50 border-b">
                                        <td class="px-4 py-3">{{ $izin->pegawai->name }}</td>
                                        <td class="px-4 py-3">{{ $izin->tanggal_pengajuan->format('d-m-Y') }}</td>
                                        <td class="px-4 py-3">{{ $izin->tanggal_izin->format('d-m-Y') }}</td>
                                        <td class="px-4 py-3">{{ $izin->alasan }}</td>
                                        <td class="px-4 py-3">{{ $izin->jam_mulai }}</td>
                                        <td class="px-4 py-3">{{ $izin->jam_selesai }}</td>
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

                    <div class="flex justify-center mt-6">
                        {{ $histori->links('pagination::tailwind') }}
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('atasan.histori.export', request()->all()) }}"
                        class="inline-block bg-red-600 hover:bg-red-700 transition text-white font-semibold py-2 px-4 rounded-lg shadow-md">
                            Export PDF
                        </a>
                    </div>
                @endif
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('atasan.dashboard') }}"
                class="inline-block bg-gray-600 hover:bg-gray-700 transition text-white font-semibold px-6 py-3 rounded-lg">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <script>
        function fetchHistoriIzin() {
            const name = $('#nama-pegawai').val();
            const tahun = $('#tahun-select').val();
            const bulan = $('#bulan-select').val();
            const minggu = $('#minggu-select').val();

            $.ajax({
                url: "{{ route('atasan.histori') }}",
                type: "GET",
                data: { name, tahun, bulan, minggu },
                success: function (response) {
                    const html = $(response).find('#histori-izin-container').html();
                    $('#histori-izin-container').html(html);
                },
                error: function () {
                    $('#histori-izin-container').html('<div class="text-center text-red-600 py-10">Gagal memuat data.</div>');
                }
            });
        }

        $(document).ready(function () {
            function updateFilterState() {
                const tahun = $('#tahun-select').val();
                const bulan = $('#bulan-select').val();
                $('#bulan-select').prop('disabled', !tahun);
                $('#minggu-select').prop('disabled', !(tahun && bulan));
                if (!tahun) $('#bulan-select').val('');
                if (!(tahun && bulan)) $('#minggu-select').val('');
            }

            updateFilterState();
            $('#tahun-select, #bulan-select').on('change', updateFilterState);

            $('#nama-pegawai').on('input', function () {
                let query = $(this).val().trim();
                if (query.length >= 2) {
                    $.get("{{ route('cari.pegawai') }}", { q: query }, function (data) {
                        let list = $('#list-pegawai').empty();
                        if (data.length > 0) {
                            data.forEach(pegawai => {
                                $('<div>')
                                    .addClass('px-4 py-2 hover:bg-blue-100 cursor-pointer text-sm')
                                    .text(pegawai.text)
                                    .data('name', pegawai.text)
                                    .appendTo(list)
                                    .on('click', function () {
                                        $('#nama-pegawai').val($(this).data('name'));
                                        list.addClass('hidden');
                                        fetchHistoriIzin();
                                    });
                            });
                        } else {
                            $('<div>')
                                .addClass('px-4 py-2 text-gray-400 text-sm')
                                .text('Tidak ditemukan')
                                .appendTo(list);
                        }
                        list.removeClass('hidden');
                    });
                } else {
                    $('#list-pegawai').addClass('hidden').empty();
                }
            });

            $(document).on('click', function (e) {
                if (!$(e.target).closest('#nama-pegawai, #list-pegawai').length) {
                    $('#list-pegawai').addClass('hidden');
                }
            });

            $('#nama-pegawai').on('focus', function () {
                if ($('#list-pegawai').children().length > 0) {
                    $('#list-pegawai').removeClass('hidden');
                }
            });

            $('#nama-pegawai, #tahun-select, #bulan-select, #minggu-select').on('change keyup', function () {
                fetchHistoriIzin();
            });
        });
    </script>

    @endsection
