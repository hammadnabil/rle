<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Histori Pengajuan Izin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
        }
        .subtitle {
            font-size: 14px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
        }
        .disetujui {
            color: green;
        }
        .ditolak {
            color: red;
        }
        .menunggu {
            color: orange;
        }

        @media print {
            body {
                margin: 0;
                padding: 10mm;
                font-size: 12px;
            }
            .title {
                font-size: 18px;
            }
            .subtitle {
                font-size: 12px;
            }
            .footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                text-align: right;
                padding: 5px 20px;
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">HISTORI PENGAJUAN IZIN</div>
        <div class="subtitle">
            Filter: {{ $name }} | {{ $bulan }} | {{ $minggu }} | {{ $tahun }}
        </div>
    </div>

    <table>
        <thead>

                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Izin</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Alasan</th>
                        <th>Status</th>

                </thead>


            </tr>
        </thead>
        <tbody>
            @forelse($histori as $index => $izin)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $izin->pegawai->name ?? 'N/A' }}</td>
                    <td>{{ $izin->tanggal_pengajuan->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($izin->jam_mulai)->format('H:i') }}</td> <!-- Tambahan -->
                    <td>{{ \Carbon\Carbon::parse($izin->jam_selesai)->format('H:i') }}</td> <!-- Tambahan -->
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

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
    </div>
</body>
</html>
