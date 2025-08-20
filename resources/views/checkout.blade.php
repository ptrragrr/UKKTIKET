@extends('layouts.app')

@section('content')
<div class="checkout-container">
  <div class="checkout-summary">
    <h2>Checkout Tiket</h2>

    <form id="checkout-form">
      @csrf

      {{-- Data Diri Pembeli --}}
      <div class="mb-3">
        <label for="nama_pembeli">Nama Lengkap</label>
        <input type="text" id="nama_pembeli" name="nama_pembeli" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="telepon">Nomor Telepon</label>
        <input type="tel" id="telepon" name="telepon" class="form-control" required>
      </div>

      {{-- Data Tiket (dari Controller) --}}
      <input type="hidden" id="konser_id" name="konser_id" value="{{ $konser->id }}">
      <input type="hidden" id="jumlah" name="jumlah" value="{{ $jumlah }}">
      <input type="hidden" id="metode_pembayaran" name="metode_pembayaran" value="snap">

      {{-- Ringkasan Pembelian --}}
      <div class="summary-item">
        <span>Tiket: {{ $konser->nama_konser }}</span>
        <span>Rp {{ number_format($harga, 0, ',', '.') }} × {{ $jumlah }}</span>
      </div>
      <div class="summary-item">
        <span>Tax (10%)</span>
        <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
      </div>
      <div class="summary-item">
        <span>Platform Fee</span>
        <span>Rp {{ number_format($platformFee, 0, ',', '.') }}</span>
      </div>
      <div class="summary-total">
        <strong>Total Bayar:</strong> Rp {{ number_format($total, 0, ',', '.') }}
      </div>

      {{-- Tombol Aksi --}}
      <div class="button-group">
        <button type="button" class="btn-pay" onclick="startPayment()">Bayar Sekarang</button>
        <button type="button" class="btn-cancel" onclick="window.location.href='{{ url('/') }}'">Batal</button>
      </div>
    </form>
  </div>
</div>

{{-- Midtrans Snap JS (Sandbox) --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
  function startPayment() {
    const payload = {
      nama_pembeli: document.getElementById('nama_pembeli').value,
      email: document.getElementById('email').value,
      telepon: document.getElementById('telepon').value,
      konser_id: document.getElementById('konser_id').value,
      jumlah: parseInt(document.getElementById('jumlah').value, 10),
      // Wajib karena validasi controller kamu butuh field ini
      metode_pembayaran: document.getElementById('metode_pembayaran').value || 'snap',
    };

    fetch("{{ url('/pay') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify(payload)
    })
    .then(async (res) => {
      const data = await res.json();
      if (!res.ok) {
        alert(data.message || 'Gagal membuat transaksi.');
        throw new Error(data.message || 'Request failed');
      }
      return data;
    })
    .then((data) => {
      if (data.token) {
        snap.pay(data.token, {
          onSuccess: function(){ window.location.href = '/?success=true'; },
          onPending: function(){ window.location.href = '/?pending=true'; },
          onError: function(){ alert('Pembayaran gagal. Silakan coba lagi.'); },
          onClose: function(){ /* optional */ }
        });
      } else {
        alert('Gagal mendapatkan token pembayaran.');
      }
    })
    .catch((err) => console.error(err));
  }
</script>

<style>
  body { padding-top: 80px; }
  .checkout-container {
    max-width: 600px; margin: 30px auto; background: #f9f9f9;
    padding: 40px 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.05);
  }
  .checkout-summary h2 { text-align: center; margin-bottom: 20px; }
  .summary-item, .summary-total { display: flex; justify-content: space-between; margin: 10px 0; }
  .button-group { display: flex; flex-direction: column; gap: 10px; margin-top: 20px; }
  .btn-pay, .btn-cancel { padding: 12px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; width: 100%; }
  .btn-pay { background-color: #4CAF50; color: white; }
  .btn-cancel { background-color: #f44336; color: white; }
  @media (max-width: 600px) { .checkout-container { padding: 25px 20px; } }
</style>
@endsection
