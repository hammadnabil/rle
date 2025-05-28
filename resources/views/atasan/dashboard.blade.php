@extends('layouts.app')

@section('content')
<div class="min-h-screen flex bg-gray-50">
    <main class="flex-1 p-6 space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="bg-white rounded-lg shadow p-6 transition hover:shadow-xl flex-1">
                <h1 class="text-2xl font-semibold text-gray-800 mb-2">Dashboard Tata Usaha</h1>
                <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>
            </div>

            <form method="GET" action="{{ route('atasan.dashboard') }}" class="bg-white rounded-lg shadow p-4 w-full md:w-auto">
                <div class="flex flex-col sm:flex-row items-end gap-4">
                    <div class="w-full sm:w-40">
                        <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <select name="tahun" id="tahun" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @for ($year = now()->year; $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ (request('tahun', $selectedTahun ?? now()->year) == $year) ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>

    
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
            <div class="bg-white rounded-lg shadow p-6 transition hover:shadow-lg hover:transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm font-medium">Total Izin</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalIzin }}</p>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-lg shadow p-6 transition hover:shadow-lg hover:transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm font-medium">Disetujui</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $disetujui }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $totalIzin > 0 ? round(($disetujui/$totalIzin)*100, 2) : 0 }}% dari total
                        </p>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-lg shadow p-6 transition hover:shadow-lg hover:transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm font-medium">Ditolak</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $ditolak }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $totalIzin > 0 ? round(($ditolak/$totalIzin)*100, 2) : 0 }}% dari total
                        </p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white rounded-lg shadow p-6 transition hover:shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Distribusi Status Izin</h2>
                    <span class="text-sm text-gray-500">{{ request('tahun', $selectedTahun ?? now()->year) }}</span>
                </div>
                <div class="w-full h-64">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

        
            <div class="bg-white rounded-lg shadow p-6 transition hover:shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Izin per Bulan</h2>
                    <span class="text-sm text-gray-500">{{ request('tahun', $selectedTahun ?? now()->year) }}</span>
                </div>
                <div class="w-full h-64">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </main>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const noDataPlugin = {
        id: 'noData',
        afterDraw: (chart) => {
            const { data } = chart;
            const total = data.datasets.reduce((sum, ds) => sum + ds.data.reduce((a, b) => a + b, 0), 0);
            if (total === 0) {
                const ctx = chart.ctx;
                const width = chart.width;
                const height = chart.height;

                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = '16px sans-serif';
                ctx.fillStyle = '#666';
                ctx.fillText('Tidak ada data', width / 2, height / 2);
                ctx.restore();
            }
        }
    };

    Chart.register(noDataPlugin);
    
    
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: ['Disetujui', 'Ditolak'],
            datasets: [{
                data: [{{ $disetujui }}, {{ $ditolak }}],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(239, 68, 68, 0.7)'
                ],
                borderColor: [
                    'rgba(16, 185, 129, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    const barCtx = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: @json($bulan),
            datasets: [
                {
                    label: 'Disetujui',
                    data: @json($izinDisetujuiPerBulan),
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1,
                    borderRadius: 5,
                    borderSkipped: false
                },
                {
                    label: 'Ditolak',
                    data: @json($izinDitolakPerBulan),
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1,
                    borderRadius: 5,
                    borderSkipped: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection