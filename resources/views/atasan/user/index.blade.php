@extends('layouts.app')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    
    <div class="min-h-screen bg-blue-100 py-10 px-4">
        <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-6">Daftar Pengguna</h2>

            <div class="mb-6 w-full max-w-md mx-auto relative">
                <input type="text" id="nama-pegawai" placeholder="Cari pengguna..."
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
                    autocomplete="off">
                <div id="suggestions-container" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden"></div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full bg-white">
                    <thead class="bg-blue-600 text-white text-sm">
                        <tr>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Nama</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Email</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Jabatan</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @forelse ($users as $user)
                            <tr class="border-b hover:bg-blue-50" data-name="{{ strtolower($user->name) }}"
                                data-email="{{ strtolower($user->email) }}" data-jabatan="{{ strtolower($user->jabatan) }}">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $user->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-4 py-3 whitespace-nowrap capitalize">{{ $user->jabatan }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a href="{{ route('atasan.user.detail', $user) }}"
                                        class="text-blue-600 hover:underline">Lihat Profil</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="flex justify-center mb-3">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            const namaPegawaiInput = $('#nama-pegawai');
            const userTableBody = $('#userTableBody');
            const suggestionsContainer = $('#suggestions-container');

            // Initialize autocomplete
            namaPegawaiInput.autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('atasan.autocomplete') }}",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.text,
                                    value: item.text,
                                    id: item.id
                                };
                            }));
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    filterTable(ui.item.value);
                    // Hide the suggestions after selection
                    suggestionsContainer.addClass('hidden');
                },
                open: function() {
                    // Position the dropdown correctly
                    suggestionsContainer.removeClass('hidden')
                        .position({
                            my: "left top",
                            at: "left bottom",
                            of: namaPegawaiInput,
                            collision: "none"
                        });
                },
                close: function() {
                    suggestionsContainer.addClass('hidden');
                }
            }).data("ui-autocomplete")._renderItem = function(ul, item) {
                // Custom rendering of each item
                return $("<li>")
                    .append("<div class='px-4 py-2 hover:bg-blue-100 cursor-pointer'>" + item.label + "</div>")
                    .appendTo(ul);
            };

            // Manual filtering function
            function filterTable(searchTerm) {
                const term = searchTerm.toLowerCase().trim();

                if (term.length === 0) {
                    userTableBody.find('tr').show();
                    return;
                }

                userTableBody.find('tr').each(function () {
                    const $row = $(this);
                    const name = $row.data('name');
                    const email = $row.data('email');
                    const jabatan = $row.data('jabatan');

                    if (name.includes(term) || email.includes(term) || jabatan.includes(term)) {
                        $row.show();
                    } else {
                        $row.hide();
                    }
                });
            }

            // Handle manual input
            namaPegawaiInput.on('input', function() {
                const term = $(this).val();
                if (term.length < 2) {
                    suggestionsContainer.addClass('hidden');
                }
                filterTable(term);
            });

            // Handle escape key
            namaPegawaiInput.on('keyup', function(e) {
                if (e.key === 'Escape') {
                    $(this).val('');
                    filterTable('');
                    suggestionsContainer.addClass('hidden');
                }
            });

            // Hide suggestions when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#nama-pegawai, #suggestions-container').length) {
                    suggestionsContainer.addClass('hidden');
                }
            });
        });
    </script>
@endsection