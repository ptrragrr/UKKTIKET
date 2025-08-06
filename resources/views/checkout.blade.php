@extends('layouts.app')

@section('content')
<div class="checkout-container">
  <div class="checkout-summary">
    <h2>Checkout Tiket</h2>

    <form action="{{ route('transaksi.guest.store') }}" method="POST">
      @csrf

      <!-- Data Diri Pembeli -->
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

      <!-- Data Tiket -->
      <input type="hidden" name="konser_id" value="{{ $konser->id }}">
      <input type="hidden" name="jumlah" value="{{ $jumlah }}">
      <input type="hidden" name="metode_pembayaran" id="metode_pembayaran">

      <!-- Ringkasan Pembelian -->
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

      <!-- Tombol Aksi -->
      <div class="button-group">
        <button type="button" class="btn-pay" onclick="showModal()">Bayar Sekarang</button>
        <button type="button" class="btn-cancel" onclick="window.location.href='{{ url('/') }}'">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Pilih Metode Pembayaran -->
<div id="paymentModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h3>Pilih Metode Pembayaran</h3>
    <div class="payment-options">
      <button class="dana" onclick="selectPayment('DANA')">Bayar via DANA</button>
      <button class="ovo" onclick="selectPayment('OVO')">Bayar via OVO</button>
      <button class="gopay" onclick="selectPayment('GoPay')">Bayar via GoPay</button>
      <button class="bca" onclick="selectPayment('BCA')">Transfer BCA</button>
    </div>
  </div>
</div>

<script>
  function showModal() {
    document.getElementById("paymentModal").style.display = "block";
  }
  function closeModal() {
    document.getElementById("paymentModal").style.display = "none";
  }
  function selectPayment(method) {
    document.getElementById("metode_pembayaran").value = method;
    document.querySelector('form').submit();
  }
  window.onclick = function (event) {
    if (event.target == document.getElementById("paymentModal")) {
      closeModal();
    }
  }
</script>

<style>
  body { padding-top: 80px; }
  .checkout-container {
    max-width: 600px;
    margin: 30px auto;
    background: #f9f9f9;
    padding: 40px 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
  }
  .checkout-summary h2 { text-align: center; margin-bottom: 20px; }
  .summary-item, .summary-total {
    display: flex;
    justify-content: space-between;
    margin: 10px 0;
  }
  .button-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
  }
  .btn-pay, .btn-cancel {
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    width: 100%;
  }
  .btn-pay { background-color: #4CAF50; color: white; }
  .btn-cancel { background-color: #f44336; color: white; }
  .modal {
    display: none; position: fixed; z-index: 999; left: 0; top: 0;
    width: 100%; height: 100%; overflow: auto;
    background-color: rgba(0,0,0,0.4);
  }
  .modal-content {
    background-color: #fff; margin: 10% auto; padding: 30px;
    border-radius: 10px; width: 90%; max-width: 400px;
  }
  .close { color: #aaa; float: right; font-size: 28px; cursor: pointer; }
  .payment-options button {
    display: block; width: 100%; margin: 10px 0; padding: 12px;
    font-size: 16px; border-radius: 6px; border: none; cursor: pointer;
  }
  .dana { background: #1C72F5; color: white; }
  .ovo { background: #8B00FF; color: white; }
  .gopay { background: #00AA13; color: white; }
  .bca { background: #0033a0; color: white; }
  @media (max-width: 600px) {
    .checkout-container { padding: 25px 20px; }
    .modal-content { margin-top: 30%; }
  }
</style>
@endsection
