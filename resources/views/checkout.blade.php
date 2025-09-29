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
          <span>{{ $item['ticket']->nama_event }} - {{ $item['ticket']->jenis_tiket }}</span>
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
        <button type="button" class="btn-pay" onclick="startPayment()" id="pay-button">
          <span id="pay-text">Bayar Sekarang</span>
          <span id="loading-text" style="display: none;">Processing...</span>
        </button>
        <button type="button" class="btn-cancel" onclick="window.location.href='{{ url('/') }}'">Batal</button>
      </div>
    </form>
  </div>
</div>

{{-- Loading Modal --}}
<div id="loading-modal" class="modal-overlay" style="display: none;">
  <div class="modal-content">
    <div class="spinner"></div>
    <p id="modal-text">Memproses pembayaran...</p>
  </div>
</div>

{{-- Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
  // Show loading modal
  function showLoading(text = 'Memproses pembayaran...') {
    document.getElementById('modal-text').textContent = text;
    document.getElementById('loading-modal').style.display = 'flex';
    document.getElementById('pay-button').disabled = true;
    document.getElementById('pay-text').style.display = 'none';
    document.getElementById('loading-text').style.display = 'inline';
  }

  // Hide loading modal
  function hideLoading() {
    document.getElementById('loading-modal').style.display = 'none';
    document.getElementById('pay-button').disabled = false;
    document.getElementById('pay-text').style.display = 'inline';
    document.getElementById('loading-text').style.display = 'none';
  }

  function startPayment() {
    // Validate form first
    const form = document.getElementById('checkout-form');
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    showLoading('Memproses pembayaran...');

    const fd = new FormData(form);
    // Build tickets array from FormData
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

    fetch('/checkout/pay', {
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
        hideLoading();
        alert(body.message || body.body || 'Gagal membuat transaksi');
        return;
      }
      
      if (body.token) {
        hideLoading();
        showLoading('Membuka jendela pembayaran...');
        
        snap.pay(body.token, {
          onSuccess: function(result) {
            console.log('Payment success:', result);
            showLoading('Memverifikasi pembayaran...');
            
            // Callback ke server untuk update status
            fetch('/checkout/callback', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify({
                order_id: result.order_id,
                transaction_status: result.transaction_status || 'settlement'
              })
            }).then(response => {
              if (response.redirected) {
                window.location.href = response.url;
              } else {
                window.location.href = `/checkout/success?order_id=${result.order_id}`;
              }
            }).catch(error => {
              console.error('Callback error:', error);
              // Fallback to success page
              window.location.href = `/checkout/success?order_id=${result.order_id}`;
            });
          },
          
          onPending: function(result) {
            console.log('Payment pending:', result);
            showLoading('Menunggu pembayaran...');
            
            setTimeout(() => {
              window.location.href = `/checkout/failed?order_id=${result.order_id}`;
            }, 2000);
          },
          
          onError: function(result) {
            console.log('Payment error:', result);
            hideLoading();
            alert('Pembayaran gagal: ' + (result.status_message || 'Terjadi kesalahan'));
            
            if (result.order_id) {
              setTimeout(() => {
                window.location.href = `/checkout/failed?order_id=${result.order_id}`;
              }, 3000);
            }
          },
          
          onClose: function() {
            console.log('Payment popup closed');
            hideLoading();
            // Don't show error, user might open it again
          }
        });
      } else {
        hideLoading();
        alert('Gagal mendapatkan token pembayaran.');
      }
    })
    .catch(err => {
      console.error(err);
      hideLoading();
      alert('Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
    });
  }

  // Auto check payment status every 10 seconds if on pending page
  function startStatusCheck(orderId) {
    const interval = setInterval(() => {
      fetch(`/checkout/check-status/${orderId}`)
        .then(response => response.json())
        .then(data => {
          if (data.status === 'paid') {
            clearInterval(interval);
            window.location.href = `/checkout/success?order_id=${orderId}`;
          } else if (data.status === 'cancelled') {
            clearInterval(interval);
            window.location.href = `/checkout/failed?order_id=${orderId}`;
          }
        })
        .catch(error => {
          console.error('Status check error:', error);
        });
    }, 10000); // Check every 10 seconds

    // Stop checking after 10 minutes
    setTimeout(() => {
      clearInterval(interval);
    }, 600000);
  }

  // Check if we're on a pending/failed page and have order_id
  document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get('order_id');
    
    if (orderId && (window.location.pathname.includes('failed') || window.location.search.includes('pending'))) {
      startStatusCheck(orderId);
    }
  });
</script>

<style>
  body { 
    padding-top: 80px; 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  
  .checkout-container {
    max-width: 600px; 
    margin: 30px auto; 
    background: #fff;
    padding: 40px 30px; 
    border-radius: 15px; 
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  }
  
  .checkout-summary h2 { 
    text-align: center; 
    margin-bottom: 30px; 
    color: #333;
    font-size: 28px;
  }
  
  .mb-3 {
    margin-bottom: 20px;
  }
  
  .mb-3 label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #555;
  }
  
  .form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
  }
  
  .form-control:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
  }
  
  .summary-item, .summary-total { 
    display: flex; 
    justify-content: space-between; 
    margin: 15px 0; 
    padding: 10px 0;
  }
  
  .summary-item {
    border-bottom: 1px solid #f0f0f0;
    color: #666;
  }
  
  .summary-total {
    border-top: 2px solid #4CAF50;
    font-size: 18px;
    color: #333;
    font-weight: bold;
    padding-top: 15px;
    margin-top: 20px;
  }
  
  .button-group { 
    display: flex; 
    flex-direction: column; 
    gap: 15px; 
    margin-top: 30px; 
  }
  
  .btn-pay, .btn-cancel { 
    padding: 15px 20px; 
    border: none; 
    border-radius: 10px; 
    font-weight: bold; 
    cursor: pointer; 
    width: 100%; 
    font-size: 16px;
    transition: all 0.3s ease;
    position: relative;
  }
  
  .btn-pay { 
    background: linear-gradient(135deg, #4CAF50, #45a049); 
    color: white;
    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
  }
  
  .btn-pay:hover:not(:disabled) { 
    background: linear-gradient(135deg, #45a049, #3d8b40);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
  }
  
  .btn-pay:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
  }
  
  .btn-cancel { 
    background: linear-gradient(135deg, #f44336, #d32f2f); 
    color: white;
    box-shadow: 0 4px 15px rgba(244, 67, 54, 0.3);
  }
  
  .btn-cancel:hover { 
    background: linear-gradient(135deg, #d32f2f, #c62828);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(244, 67, 54, 0.4);
  }

  /* Loading Modal Styles */
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10000;
  }

  .modal-content {
    background: white;
    padding: 40px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    max-width: 300px;
    width: 90%;
  }

  .spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #4CAF50;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px auto;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  .modal-content p {
    margin: 0;
    font-size: 16px;
    color: #333;
    font-weight: 500;
  }
  
  @media (max-width: 600px) { 
    .checkout-container { 
      margin: 15px;
      padding: 25px 20px; 
    }
    
    .checkout-summary h2 {
      font-size: 24px;
    }
    
    .btn-pay, .btn-cancel {
      padding: 12px 15px;
      font-size: 14px;
    }
  }

  /* Success/Failed page styles */
  .status-container {
    max-width: 500px;
    margin: 50px auto;
    text-align: center;
    padding: 40px 30px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  }

  .status-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
  }

  .status-icon.success {
    background: #d4edda;
    color: #28a745;
  }

  .status-icon.failed {
    background: #f8d7da;
    color: #dc3545;
  }

  .status-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 10px;
  }

  .status-message {
    color: #666;
    margin-bottom: 30px;
    line-height: 1.5;
  }

  .status-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .status-actions a, .status-actions button {
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .btn-primary {
    background: #4CAF50;
    color: white;
  }

  .btn-secondary {
    background: #6c757d;
    color: white;
  }

  .btn-primary:hover, .btn-secondary:hover {
    transform: translateY(-2px);
    opacity: 0.9;
  }
</style>
@endsection