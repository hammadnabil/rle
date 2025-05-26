@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-blue-100 py-10 px-6">
        <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Daftar Pengguna</h2>

            <div class="mb-6 relative w-full max-w-md mx-auto">
                <input type="text" id="nama-pegawai" placeholder="Cari pengguna..."
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-blue-600 text-white text-sm">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Jabatan</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @forelse ($users as $user)
                        <tr class="border-b hover:bg-blue-50" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}" data-jabatan="{{ strtolower($user->jabatan) }}">
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3 capitalize">{{ $user->jabatan }}</td>
                            <td class="px-4 py-3">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const namaPegawaiInput = $('#nama-pegawai');
            const userTableBody = $('#userTableBody');

            // Fungsi untuk memfilter tabel
            function filterTable(searchTerm) {
                const term = searchTerm.toLowerCase().trim();

                if (term.length === 0) {
                    userTableBody.find('tr').show();
                    return;
                }

                userTableBody.find('tr').each(function() {
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
                filterTable($(this).val());
            });


            namaPegawaiInput.on('keyup', function(e) {
                if (e.key === 'Escape') {
                    $(this).val('');
                    filterTable('');
                }
            });
        });
    </script>
@endsection
