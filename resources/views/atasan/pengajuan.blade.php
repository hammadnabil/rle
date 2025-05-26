@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-200 to-blue-500 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto bg-white shadow-2xl rounded-2xl p-6 md:p-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-center text-gray-800 mb-6">Pengajuan Izin</h1>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <p class="font-bold">Perhatian</p>
                        <p>{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div id="offline-alert"
                class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                Tidak ada koneksi internet. Silakan periksa koneksi Anda dan coba lagi.
            </div>

            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full bg-white text-sm">
                    <thead class="bg-blue-600 text-white uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Tanggal Izin</th>
                            <th class="px-4 py-3 text-left">Mulai</th>
                            <th class="px-4 py-3 text-left">Selesai</th>
                            <th class="px-4 py-3 text-left">Alasan</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pengajuan as $izin)
                            <tr class="hover:bg-blue-50">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $izin->pegawai->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $izin->tanggal_izin->format('d-m-Y') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $izin->jam_mulai }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $izin->jam_selesai }}</td>
                                <td class="px-4 py-3 max-w-xs truncate">{{ $izin->alasan }}</td>
                                <td class="px-4 py-3 capitalize font-semibold
                                                        @if($izin->status == 'disetujui') text-green-600
                                                        @elseif($izin->status == 'ditolak') text-red-600
                                                        @else text-yellow-500 @endif">
                                    {{ $izin->status }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('atasan.setujuiTolak', $izin->izin_id) }}" method="POST"
                                        class="space-y-2" id="form-{{ $izin->izin_id }}">
                                        @csrf
                                        <select name="status" class="status-select w-full border rounded p-1 text-sm"
                                            data-id="{{ $izin->izin_id }}">
                                            <option value="disetujui" {{ $izin->status == 'disetujui' ? 'selected' : '' }}>Setujui
                                            </option>
                                            <option value="ditolak" {{ $izin->status == 'ditolak' ? 'selected' : '' }}>Tolak
                                            </option>
                                        </select>

                                        <div class="alasan-ditolak hidden mt-2" data-id="{{ $izin->izin_id }}">
                                            <textarea name="alasan_ditolak" placeholder="Alasan penolakan"
                                                class="w-full border rounded p-1 text-sm">{{ $izin->alasan_ditolak ?? '' }}</textarea>
                                        </div>


                                        <div class="flex flex-col space-y-2 mt-2">
                                            <label class="text-xs font-medium">Metode Notifikasi:</label>
                                            <div class="flex items-center">
                                                <input type="radio" name="notifikasi[{{ $izin->izin_id }}]"
                                                    id="email-{{ $izin->izin_id }}" value="email" class="mr-2" checked>
                                                <label for="email-{{ $izin->izin_id }}" class="text-xs mr-3">Email</label>

                                                <input type="radio" name="notifikasi[{{ $izin->izin_id }}]"
                                                    id="wa-{{ $izin->izin_id }}" value="wa" class="mr-2">
                                                <label for="wa-{{ $izin->izin_id }}" class="text-xs mr-3">WhatsApp</label>

                                                <input type="radio" name="notifikasi[{{ $izin->izin_id }}]"
                                                    id="both-{{ $izin->izin_id }}" value="both" class="mr-2">
                                                <label for="both-{{ $izin->izin_id }}" class="text-xs">Keduanya</label>
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 flex items-center justify-center"
                                            id="submit-btn-{{ $izin->izin_id }}">
                                            <span id="submit-text-{{ $izin->izin_id }}">Proses</span>
                                            <svg id="spinner-{{ $izin->izin_id }}" class="hidden w-4 h-4 ml-2 animate-spin"
                                                fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('atasan.dashboard') }}"
                    class="inline-block bg-gray-600 text-white px-5 py-2 rounded hover:bg-gray-700 text-sm font-medium">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

   <script>

    document.querySelectorAll('.status-select').forEach(select => {
    
        const formId = select.getAttribute('data-id');
        const rejectionReasonDiv = document.querySelector(`.alasan-ditolak[data-id="${formId}"]`);
        if (select.value === 'ditolak') {
            rejectionReasonDiv.classList.remove('hidden');
        }

       
        select.addEventListener('change', function() {
            const formId = this.getAttribute('data-id');
            const rejectionReasonDiv = document.querySelector(`.alasan-ditolak[data-id="${formId}"]`);
            
            if (this.value === 'ditolak') {
                rejectionReasonDiv.classList.remove('hidden');
            } else {
                rejectionReasonDiv.classList.add('hidden');
            }
        });
    });

   
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const formId = this.id.split('-')[1];
            const button = document.getElementById(`submit-btn-${formId}`);
            const buttonText = document.getElementById(`submit-text-${formId}`);
            const spinner = document.getElementById(`spinner-${formId}`);
            
   
            button.disabled = true;
            buttonText.textContent = 'Memproses...';
            spinner.classList.remove('hidden');
        
            if (!navigator.onLine) {
                e.preventDefault();
                document.getElementById('offline-alert').classList.remove('hidden');
                button.disabled = false;
                buttonText.textContent = 'Proses';
                spinner.classList.add('hidden');
            }
            
       
            const status = this.querySelector('select[name="status"]').value;
            const rejectionReason = this.querySelector('textarea[name="alasan_ditolak"]');
            
            if (status === 'ditolak' && (!rejectionReason || rejectionReason.value.trim() === '')) {
                e.preventDefault();
                alert('Harap isi alasan penolakan');
                button.disabled = false;
                buttonText.textContent = 'Proses';
                spinner.classList.add('hidden');
            }
            
        
            const notificationMethod = document.querySelector(`input[name="notifikasi[${formId}]"]:checked`);
            if (!notificationMethod) {
                e.preventDefault();
                alert('Harap pilih metode notifikasi');
                button.disabled = false;
                buttonText.textContent = 'Proses';
                spinner.classList.add('hidden');
            }
        });
    });

 
    window.addEventListener('online', () => {
        document.getElementById('offline-alert').classList.add('hidden');
    });

    window.addEventListener('offline', () => {
        document.getElementById('offline-alert').classList.remove('hidden');
    });
</script>

<style>
    .alasan-ditolak {
        transition: all 0.3s ease;
        overflow: hidden;
        max-height: 0;
        opacity: 0;
    }
    
    .alasan-ditolak:not(.hidden) {
        max-height: 200px;
        opacity: 1;
    }
</style>
@endsection