<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tiket Konser - {{ $transaksi->kode_transaksi }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; color: #333; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: #fff; border-radius: 8px; padding: 20px; border: 1px solid #ddd; }
        h2 { color: #2c3e50; }
        .ticket { background: #f1f1f1; padding: 15px; border-radius: 6px; margin-top: 15px; }
        .footer { margin-top: 20px; font-size: 13px; color: #777; }
        .btn { display: inline-block; background: #3498db; color: white; padding: 10px 18px; text-decoration: none; border-radius: 5px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎉 Tiket Konsermu Berhasil Dibeli!</h2>
        <p>Halo <strong>{{ $transaksi->nama_pembeli }}</strong>,</p>
        <p>Terima kasih sudah membeli tiket konser melalui platform kami.</p>

        <div class="ticket">
            <p><strong>Order ID:</strong> {{ $transaksi->kode_transaksi }}</p>
            <p><strong>Nama:</strong> {{ $transaksi->nama_pembeli }}</p>
            <p><strong>Email:</strong> {{ $transaksi->email }}</p>
            <p><strong>Total Bayar:</strong> Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
            
            <p><strong>Detail Tiket:</strong></p>
            <ul>
                @foreach($transaksi->details as $detail)
                    <li>
                        {{ $detail->ticket->konser->nama_konser }} - {{ $detail->ticket->jenis_tiket }}
                        (x{{ $detail->jumlah }}) |
                        Kode Tiket: <strong>{{ $detail->kode_tiket ?? 'Belum digenerate' }}</strong>
                    </li>
                @endforeach
            </ul>
        </div>

        <p>Kamu bisa menunjukkan email ini saat check-in konser.</p>

        {{-- <a href="{{ url('/') }}" class="btn">Lihat Event</a> --}}
    {{-- <a href="{{ route('tiket.show', $transaksi->id) }}" 
   style="display:inline-block;padding:10px 20px;background:#007bff;color:#fff;text-decoration:none;border-radius:5px;">
   Lihat Tiket
</a> --}}


        <div class="footer">
            <p>Jika kamu merasa tidak melakukan pembelian ini, abaikan email ini.</p>
            <p>&copy; {{ date('Y') }} Tiket Konser. All rights reserved.</p>
        </div>
    </div>  
</body>
</html>
