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

      {{-- Hidden: tickets[] --}}
      @foreach($keranjang as $i => $item)
        <input type="hidden" name="tickets[{{ $i }}][id]" value="{{ $item['ticket']->id }}">
        <input type="hidden" name="tickets[{{ $i }}][qty]" value="{{ $item['qty'] }}">
      @endforeach

      <input type="hidden" id="metode_pembayaran" name="metode_pembayaran" value="snap">

      {{-- Ringkasan Pembelian --}}
      @foreach($keranjang as $item)
        <div class="summary-item">
          <span>{{ $item['ticket']->konser->nama_konser }} - {{ $item['ticket']->jenis_tiket }}</span>
          <span>Rp {{ number_format($item['ticket']->harga_tiket, 0, ',', '.') }} × {{ $item['qty'] }}</span>
        </div>
      @endforeach

      <div class="summary-item">
        <span>Subtotal</span>
        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
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

      <div class="button-group">
        <button type="button" class="btn-pay" onclick="startPayment()">Bayar Sekarang</button>
        <button type="button" class="btn-cancel" onclick="window.location.href='{{ url('/') }}'">Batal</button>
      </div>
    </form>
  </div>
</div>

{{-- Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
  function startPayment() {
    const form = document.getElementById('checkout-form');
    const fd = new FormData(form);
    // Bangun array tickets dari FormData
    const tickets = [];
    for (let pair of fd.entries()) {
      const key = pair[0];
      const val = pair[1];
      const m = key.match(/tickets\[(\d+)\]\[(.+)\]/);
      if (m) {
        const idx = parseInt(m[1], 10);
        const k = m[2];
        tickets[idx] = tickets[idx] || {};
        tickets[idx][k] = k === 'qty' ? parseInt(val, 10) : val;
      }
    }

    const payload = {
      nama_pembeli: fd.get('nama_pembeli'),
      email: fd.get('email'),
      telepon: fd.get('telepon'),
      tickets: tickets,
      metode_pembayaran: fd.get('metode_pembayaran')
    };

    fetch("{{ route('checkout.pay') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify(payload)
    })
    .then(res => res.json().then(body => ({ ok: res.ok, body })))
    .then(({ ok, body }) => {
      if (!ok) {
        alert(body.message || body.body || 'Gagal membuat transaksi');
        return;
      }
      if (body.token) {
        snap.pay(body.token, {
          onSuccess: function(result) {
            // update status ke server
            fetch("{{ route('transaksi.updateStatus') }}", {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify({
                order_id: body.order_id,
                status: 'paid',
                bayar: result.gross_amount
              })
            }).then(()=> {
              window.location.href = '/?success=true';
            });
          },
          onPending: function(result) {
            window.location.href = '/?pending=true';
          },
          onError: function(err) {
            alert('Pembayaran gagal. Coba lagi.');
          },
          onClose: function() {
            // user close snap modal
          }
        });
      } else {
        alert('Gagal mendapatkan token pembayaran.');
      }
    })
    .catch(err => {
      console.error(err);
      alert('Terjadi kesalahan.');
    });
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
