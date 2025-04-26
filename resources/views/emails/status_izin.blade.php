<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Status Izin</title>
</head>
<body>
    <h2>Halo {{ $izin->pegawai->nama }},</h2>

    <p>Pengajuan izin Anda pada tanggal <strong>{{ $izin->tanggal_izin }}</strong> telah <strong>{{ $izin->status }}</strong>.</p>

    <p>Alasan: {{ $izin->alasan }}</p>

    <br>
    <p>Terima kasih.</p>
</body>
</html>
