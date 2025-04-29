<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Histori Pengajuan Izin</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 14px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; }
        .disetujui { color: green; }
        .ditolak { color: red; }
        .menunggu { color: orange; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">HISTORI PENGAJUAN IZIN</div>
        <div class="subtitle">
            Filter: {{ $nama }} | {{ $bulan }} | {{ $minggu }} | {{ $tahun }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Tanggal Pengajuan</th>
                <th>Tanggal Izin</th>
                <th>Alasan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histori as $index => $izin)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $izin->pegawai->nama ?? 'N/A' }}</td>
                    <td>{{ $izin->tanggal_pengajuan->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d-m-Y') }}</td>
                    <td>{{ $izin->alasan }}</td>
                    <td class="{{ strtolower($izin->status) }}">
                        {{ ucfirst($izin->status) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

  
</body>
</html>