<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tiket Konser</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .card { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; text-align: center; }
        .card h2 { margin-bottom: 20px; }
        .qr { margin: 20px 0; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>🎟️ Tiket Konsermu</h2>
        <p><b>Nama:</b> {{ $transaksi->nama_pembeli }}</p>
        <p><b>Email:</b> {{ $transaksi->email }}</p>
        <p><b>Kode Tiket:</b> {{ $transaksi->kode_tiket }}</p>
        <p><b>Total Bayar:</b> Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
        <p><b>Status:</b> {{ ucfirst($transaksi->status_payment) }}</p>

        {{-- QR Code --}}
        <div class="qr">
            {!! QrCode::size(200)->generate($transaksi->kode_tiket) !!}
        </div>

        <a href="{{ url('/') }}" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>
