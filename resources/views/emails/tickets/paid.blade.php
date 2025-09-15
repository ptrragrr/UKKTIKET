<h2>Halo {{ $transaksi->nama_pembeli }}</h2>

<p>Terima kasih telah membeli tiket. Berikut kode tiket Anda:</p>

<ul>
@foreach($transaksi->details as $detail)
    <li>
        {{ $detail->ticket->konser->nama_konser }} - {{ $detail->ticket->jenis_tiket }} : 
        <strong>{{ $detail->kode_tiket }}</strong>
    </li>
@endforeach
</ul>

<p>Silakan tunjukkan kode ini di venue. Admin akan memverifikasi dan mencetak tiket fisik Anda.</p>
