@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
          
                <div class="bg-blue-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold text-white">Pengajuan Izin</h1>
                        <a href="{{ route('atasan.dashboard') }}" class="flex items-center text-blue-100 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>

   
                <div class="px-6 pt-4 space-y-3">
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded flex items-start">
                            <svg class="w-5 h-5 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <p class="font-medium text-yellow-800">{{ session('warning') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    <div id="offline-alert" class="hidden bg-red-50 border-l-4 border-red-500 p-4 rounded flex items-start">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-medium text-red-800">Tidak ada koneksi internet. Silakan periksa koneksi Anda dan coba lagi.</p>
                        </div>
                    </div>
                </div>

            
                <div class="px-6 py-4">
                    @if($pengajuan->isEmpty())
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-700">Belum ada pengajuan izin</h3>
                            <p class="mt-1 text-gray-500">Tidak ada pengajuan izin yang perlu diproses saat ini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Nama</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Tanggal Izin</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Waktu</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Alasan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-blue-700 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pengajuan as $izin)
                                        <tr class="hover:bg-blue-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <span class="text-blue-600 font-medium">{{ substr($izin->pegawai->name, 0, 1) }}</span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $izin->pegawai->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $izin->pegawai->jabatan }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $izin->tanggal_izin->format('d M Y') }}</div>
                                                <div class="text-sm text-gray-500">{{ $izin->tanggal_izin->isoFormat('dddd') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $izin->jam_mulai }} - {{ $izin->jam_selesai }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    @php
                                                        $start = \Carbon\Carbon::parse($izin->jam_mulai);
                                                        $end = \Carbon\Carbon::parse($izin->jam_selesai);
                                                        echo $start->diffInHours($end) . ' jam';
                                                    @endphp
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate hover:whitespace-normal hover:max-w-full transition-all">
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
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('atasan.setujuiTolak', $izin->izin_id) }}" method="POST" class="space-y-3" id="form-{{ $izin->izin_id }}">
                                                    @csrf
                                                    <div class="flex flex-col space-y-2">
                                                        <select name="status" class="status-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" data-id="{{ $izin->izin_id }}">
                                                            <option value="disetujui" {{ $izin->status == 'disetujui' ? 'selected' : '' }}>Setujui</option>
                                                            <option value="ditolak" {{ $izin->status == 'ditolak' ? 'selected' : '' }}>Tolak</option>
                                                        </select>

                                                        <div class="alasan-ditolak hidden" data-id="{{ $izin->izin_id }}">
                                                            <label for="alasan_ditolak" class="block text-xs font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                                                            <textarea name="alasan_ditolak" rows="2" placeholder="Masukkan alasan penolakan" class="block w-full shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500 border border-gray-300 rounded-md p-2">{{ $izin->alasan_ditolak ?? '' }}</textarea>
                                                        </div>

                                                        <div class="mt-1">
                                                            <label class="block text-xs font-medium text-gray-700 mb-1">Notifikasi via:</label>
                                                            <div class="flex flex-wrap gap-2">
                                                                <div class="flex items-center">
                                                                    <input type="radio" name="notifikasi[{{ $izin->izin_id }}]" id="email-{{ $izin->izin_id }}" value="email" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                                                    <label for="email-{{ $izin->izin_id }}" class="ml-2 block text-xs text-gray-700">
                                                                        Email
                                                                    </label>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <input type="radio" name="notifikasi[{{ $izin->izin_id }}]" id="wa-{{ $izin->izin_id }}" value="wa" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                                                    <label for="wa-{{ $izin->izin_id }}" class="ml-2 block text-xs text-gray-700">
                                                                        WhatsApp
                                                                    </label>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <input type="radio" name="notifikasi[{{ $izin->izin_id }}]" id="both-{{ $izin->izin_id }}" value="both" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                                                    <label for="both-{{ $izin->izin_id }}" class="ml-2 block text-xs text-gray-700">
                                                                        Keduanya
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 w-full" id="submit-btn-{{ $izin->izin_id }}">
                                                            <span id="submit-text-{{ $izin->izin_id }}">Proses</span>
                                                            <svg id="spinner-{{ $izin->izin_id }}" class="hidden w-4 h-4 ml-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
      
            document.querySelectorAll('.status-select').forEach(select => {
                const formId = select.getAttribute('data-id');
                const rejectionReasonDiv = document.querySelector(`.alasan-ditolak[data-id="${formId}"]`);
                
          
                if (select.value === 'ditolak') {
                    rejectionReasonDiv.classList.remove('hidden');
                } else {
                    rejectionReasonDiv.classList.add('hidden');
                }

           
                select.addEventListener('change', function() {
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
                        return;
                    }
                    
                    
                    const status = this.querySelector('select[name="status"]').value;
                    const rejectionReason = this.querySelector('textarea[name="alasan_ditolak"]');
                    
                    if (status === 'ditolak' && (!rejectionReason || rejectionReason.value.trim() === '')) {
                        e.preventDefault();
                        alert('Harap isi alasan penolakan');
                        button.disabled = false;
                        buttonText.textContent = 'Proses';
                        spinner.classList.add('hidden');
                        return;
                    }
                    
                
                    const notificationMethod = this.querySelector(`input[name="notifikasi[${formId}]"]:checked`);
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
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        tr:hover .alasan-ditolak:not(.hidden) {
            max-height: 300px;
        }

    
        tr {
            transition: background-color 0.2s ease;
        }

    
        select:focus, textarea:focus, input:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }
    </style>
@endsection