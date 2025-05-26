<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Status Izin</title>
</head>
<body>
    <h2>Halo {{ $izin->pegawai->nama }},</h2>

    <p>Pengajuan izin Anda pada tanggal <strong>{{ $izin->tanggal_izin->format('d-m-Y')}}</strong> telah <strong>{{ $izin->status }}</strong>.</p>

    <p>Alasan: {{ $izin->alasan }}</p>

    @if ($izin->status === 'ditolak')
        <p><strong>Alasan penolakan:</strong> {{ $izin->alasan_ditolak }}</p>
    @endif

    <br>
    <p>Terima kasih.</p>
</body>
</html>
