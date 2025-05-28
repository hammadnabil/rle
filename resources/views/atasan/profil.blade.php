@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
            
            <div class="bg-blue-700 px-6 py-5 border-b border-blue-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-white">Profil </h2>
                    <a href="{{ route('atasan.dashboard') }}" class="flex items-center text-blue-100 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>

            <div class="px-6 py-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @php
                        $fields = [
                            ['label' => 'Nama Lengkap', 'value' => $user->name, 'color' => 'green', 'icon' => 'user'],
                            ['label' => 'Email', 'value' => $user->email, 'color' => 'blue', 'icon' => 'mail'],
                            ['label' => 'Jabatan', 'value' => ucfirst($user->jabatan), 'color' => 'purple', 'icon' => 'briefcase'],
                            ['label' => 'Nomor WhatsApp', 'value' => $user->no_wa ?? '-', 'color' => 'yellow', 'icon' => 'chat'],
                            ['label' => 'Umur', 'value' => $user->umur ?? '-', 'color' => 'indigo', 'icon' => 'clock'],
                            ['label' => 'Tanggal Bergabung', 'value' => $user->tanggal_bergabung ? \Carbon\Carbon::parse($user->tanggal_bergabung)->translatedFormat('d M Y') : '-', 'color' => 'pink', 'icon' => 'calendar'],
                            ['label' => 'Jenis Kelamin', 'value' => $user->gender === 'L' ? 'Laki-laki' : ($user->gender === 'P' ? 'Perempuan' : '-'), 'color' => 'red', 'icon' => 'user-circle'],
                        ];

                        $icons = [
                            'user' => 'M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z',
                            'mail' => 'M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z',
                            'briefcase' => 'M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2z M8 5a1 1 0 011-1h2a1 1 0 011 1v1H8V5z',
                            'chat' => 'M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z',
                            'clock' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z',
                            'calendar' => 'M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z M6 7a1 1 0 000 2h8a1 1 0 100-2H6z',
                            'user-circle' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm0-9a3 3 0 110-6 3 3 0 010 6z M4 14a6 6 0 0112 0v2H4v-2z',
                        ];
                    @endphp

                    @foreach ($fields as $field)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-{{ $field['color'] }}-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-{{ $field['color'] }}-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="{{ $icons[$field['icon']] }}" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">{{ $field['label'] }}</h3>
                                <p class="text-lg font-semibold text-gray-900">{{ $field['value'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
