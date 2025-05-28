@extends('layouts.app')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-blue-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                
                <div class="bg-blue-600 px-6 py-4">
                    <div class="flex flex-col sm:flex-row justify-between items-center">
                        <h2 class="text-2xl font-bold text-white">Daftar Pengguna</h2>
                        <div class="mt-4 sm:mt-0 w-full sm:w-auto relative">
                            <div class="relative">
                                <input type="text" id="nama-pegawai" placeholder="Cari pengguna..."
                                    class="w-full pl-10 pr-4 py-2 rounded-lg border-0 focus:ring-2 focus:ring-blue-300 text-sm"
                                    autocomplete="off">
                                <div class="absolute left-3 top-2.5 text-blue-400">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                            <div id="suggestions-container" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg hidden max-h-60 overflow-auto"></div>
                        </div>
                    </div>
                </div>

    
                <div class="p-6">
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Jabatan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody" class="bg-white divide-y divide-gray-200">
                                @forelse ($users as $index => $user)
                                    <tr class="hover:bg-blue-50 transition-colors" 
                                        data-name="{{ strtolower($user->name) }}"
                                        data-email="{{ strtolower($user->email) }}" 
                                        data-jabatan="{{ strtolower($user->jabatan) }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-blue-600 font-medium">{{ substr($user->name, 0, 1) }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 capitalize">
                                                {{ $user->jabatan }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('atasan.user.detail', $user) }}"
                                                class="text-blue-600 hover:text-blue-900 flex items-center">
                                                <i class="fas fa-eye mr-1"></i> Lihat Profil
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center justify-center py-8">
                                                <i class="fas fa-users-slash text-4xl text-gray-300 mb-2"></i>
                                                <p>Tidak ada data pengguna</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                
                    @if($users->hasPages())
                    <div class="flex justify-between items-center mt-4 px-2">
                        <div class="text-sm text-gray-500">
                            Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} pengguna
                        </div>
                        <div>
                            {{ $users->links('pagination::tailwind') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            const namaPegawaiInput = $('#nama-pegawai');
            const userTableBody = $('#userTableBody');
            const suggestionsContainer = $('#suggestions-container');

     
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
                    suggestionsContainer.addClass('hidden');
                },
                open: function() {
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
                return $("<li>")
                    .append("<div class='px-4 py-2 hover:bg-blue-100 cursor-pointer text-sm'>" + item.label + "</div>")
                    .appendTo(ul);
            };

           
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

        
            namaPegawaiInput.on('input', function() {
                const term = $(this).val();
                if (term.length < 2) {
                    suggestionsContainer.addClass('hidden');
                }
                filterTable(term);
            });

          
            namaPegawaiInput.on('keyup', function(e) {
                if (e.key === 'Escape') {
                    $(this).val('');
                    filterTable('');
                    suggestionsContainer.addClass('hidden');
                }
            });

    
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#nama-pegawai, #suggestions-container').length) {
                    suggestionsContainer.addClass('hidden');
                }
            });
        });
    </script>

    <style>
     
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .ui-autocomplete li {
            padding: 0;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .ui-autocomplete li:last-child {
            border-bottom: none;
        }
        
        .ui-autocomplete .ui-menu-item-wrapper {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .ui-autocomplete .ui-menu-item-wrapper:hover {
            background-color: #f0f9ff;
            color: #1e40af;
        }
        
   
        tr {
            transition: all 0.2s ease;
        }
        

        #nama-pegawai:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }
    </style>
@endsection