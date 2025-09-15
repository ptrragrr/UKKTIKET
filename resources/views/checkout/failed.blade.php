@extends('layouts.app')

@section('content')
<div class="status-container">
  <div class="status-icon failed">✖</div>
  <div class="status-title">Pembayaran Gagal</div>
  <div class="status-message">
    Maaf, pembayaran Anda tidak berhasil diproses.  
    Silakan coba lagi atau gunakan metode pembayaran lain.
  </div>
  <div class="status-actions">
    <a href="{{ url('/checkout') }}" class="btn-primary">Coba Lagi</a>
    <a href="{{ url('/') }}" class="btn-secondary">Kembali ke Beranda</a>
  </div>
</div>
@endsection
