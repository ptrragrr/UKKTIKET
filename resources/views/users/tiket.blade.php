@extends('layouts.app')

@section('title', 'Pilih Tiket')

@section('content')
<style>
  * {
    box-sizing: border-box;
  }

  body {
    background: linear-gradient(135deg, #a4b494 0%, #8fa67e 50%, #b8a082 100%);
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 70px 20px;
  }

  .poster-banner {
    position: relative;
    margin-bottom: 40px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
  }

  .poster-banner img {
    width: 100%;
    height: 450px;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .poster-banner:hover img {
    transform: scale(1.05);
  }

  .poster-banner::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(164,180,148,0.3), rgba(184,160,130,0.3));
  }

  .page-title {
    text-align: center;
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 30px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
  }

  .ticket-container {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    align-items: flex-start;
  }

  .ticket-list {
    flex: 2;
    display: flex;
    flex-direction: column;
    gap: 30px;
  }

  /* Category Section */
  .ticket-category {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
  }

  .category-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 3px solid;
  }

  .category-icon {
    font-size: 2.5rem;
  }

  .category-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0;
  }

  /* VVIP Category */
  .ticket-category.vvip .category-header {
    border-color: #FFD700;
    color: #B8860B;
  }

  .ticket-category.vvip .category-title {
    background: linear-gradient(45deg, #FFD700, #FFA500);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  /* VIP Category */
  .ticket-category.vip .category-header {
    border-color: #C0C0C0;
    color: #708090;
  }

  .ticket-category.vip .category-title {
    background: linear-gradient(45deg, #C0C0C0, #A9A9A9);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  /* REGULER Category */
  .ticket-category.reguler .category-header {
    border-color: #CD7F32;
    color: #8B4513;
  }

  .ticket-category.reguler .category-title {
    background: linear-gradient(45deg, #CD7F32, #D2691E);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .category-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
  }

  .ticket-card {
    background: white;
    border: 2px solid rgba(164,180,148,0.2);
    border-radius: 15px;
    padding: 25px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .ticket-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
  }

  .ticket-category.vvip .ticket-card::before {
    background: linear-gradient(90deg, #FFD700, #FFA500);
  }

  .ticket-category.vip .ticket-card::before {
    background: linear-gradient(90deg, #C0C0C0, #A9A9A9);
  }

  .ticket-category.reguler .ticket-card::before {
    background: linear-gradient(90deg, #CD7F32, #D2691E);
  }

  .ticket-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    border-color: rgba(164,180,148,0.5);
  }

  .ticket-card h3 {
    color: #4a3728;
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 10px;
    background: linear-gradient(45deg, #a4b494, #4a3728);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .ticket-description {
    color: #6b5d4f;
    font-size: 0.9rem;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .ticket-description::before {
    content: '🎫';
    font-size: 1rem;
  }

  .ticket-price {
    font-weight: 700;
    font-size: 1.5rem;
    color: #8fa67e;
    margin: 15px 0;
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .ticket-price::before {
    content: '💰';
    font-size: 1.2rem;
  }

  .qty-control {
    display: flex;
    gap: 15px;
    align-items: center;
    justify-content: center;
    margin-top: 20px;
  }

  .qty-input {
    width: 60px;
    height: 45px;
    text-align: center;
    border: 2px solid #d4c4a8;
    background: #f9f7f4;
    font-weight: 700;
    font-size: 1.2rem;
    color: #4a3728;
    border-radius: 10px;
    transition: all 0.3s ease;
  }

  .qty-input:focus {
    outline: none;
    border-color: #8fa67e;
    box-shadow: 0 0 0 3px rgba(164,180,148,0.2);
  }

  .btn-minus, .btn-plus {
    width: 45px;
    height: 45px;
    background: linear-gradient(45deg, #a4b494, #8fa67e);
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.2rem;
    font-weight: 700;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .btn-minus:hover, .btn-plus:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 15px rgba(164,180,148,0.4);
  }

  .btn-minus:active, .btn-plus:active {
    transform: scale(0.95);
  }

  .order-summary {
    flex: 1;
    min-width: 320px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 30px;
    position: sticky;
    top: 20px;
    height: fit-content;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
  }

  .summary-title {
    font-weight: 700;
    font-size: 1.8rem;
    margin-bottom: 25px;
    color: #4a3728;
    text-align: center;
    position: relative;
    padding-bottom: 15px;
  }

  .summary-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #a4b494, #b8a082);
    border-radius: 2px;
  }

  #summary-list {
    margin-bottom: 20px;
    max-height: 250px;
    overflow-y: auto;
  }

  #summary-list::-webkit-scrollbar {
    width: 6px;
  }

  #summary-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }

  #summary-list::-webkit-scrollbar-thumb {
    background: linear-gradient(45deg, #a4b494, #b8a082);
    border-radius: 10px;
  }

  .summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 12px 0;
    padding: 8px 0;
    color: #6b5d4f;
    font-weight: 500;
  }

  .summary-item:not(:last-child) {
    border-bottom: 1px solid #e8e0d6;
  }

  .summary-total {
    font-weight: 700;
    font-size: 1.4rem;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #d4c4a8;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #4a3728;
  }

  .btn-checkout {
    margin-top: 25px;
    width: 100%;
    padding: 15px 20px;
    background: linear-gradient(45deg, #a4b494, #8fa67e);
    color: white;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: 700;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .btn-checkout::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
  }

  .btn-checkout:hover::before {
    left: 100%;
  }

  .btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(164,180,148,0.4);
  }

  .btn-checkout:active {
    transform: translateY(0);
  }

  .btn-checkout:disabled {
    background: #ccc !important;
    cursor: not-allowed !important;
    transform: none !important;
    box-shadow: none !important;
    opacity: 0.6;
  }

  .btn-checkout:disabled:hover {
    transform: none !important;
    box-shadow: none !important;
  }

  .btn-checkout.enabled {
    background: linear-gradient(45deg, #a4b494, #8fa67e) !important;
    cursor: pointer !important;
    opacity: 1;
  }

  @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
  }

  .ticket-card.selected {
    animation: pulse 0.6s ease-in-out;
  }

  .btn-checkout.loading {
    opacity: 0.7;
    cursor: wait;
  }

  .btn-checkout.loading::after {
    content: '⏳';
    margin-left: 10px;
  }

  /* Responsive Design */
  @media (max-width: 992px) {
    .container {
      padding: 20px 15px;
    }

    .ticket-container {
      flex-direction: column;
    }

    .order-summary {
      position: static;
      order: -1;
      margin-bottom: 30px;
    }

    .category-grid {
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
  }

  @media (max-width: 768px) {
    .page-title {
      font-size: 2rem;
      margin-bottom: 20px;
    }

    .poster-banner img {
      height: 250px;
    }

    .category-header {
      gap: 10px;
    }

    .category-icon {
      font-size: 2rem;
    }

    .category-title {
      font-size: 1.5rem;
    }

    .category-grid {
      grid-template-columns: 1fr;
    }

    .ticket-card {
      padding: 20px;
    }

    .ticket-card h3 {
      font-size: 1.2rem;
    }

    .ticket-price {
      font-size: 1.3rem;
    }

    .summary-title {
      font-size: 1.5rem;
    }

    .order-summary {
      padding: 25px;
    }
  }

  @media (max-width: 480px) {
    .container {
      padding: 10px;
    }

    .poster-banner img {
      height: 200px;
    }

    .page-title {
      font-size: 1.8rem;
    }

    .ticket-category {
      padding: 20px;
    }

    .category-title {
      font-size: 1.3rem;
    }

    .ticket-card {
      padding: 15px;
    }

    .qty-control {
      gap: 10px;
    }

    .qty-input {
      width: 50px;
      height: 40px;
      font-size: 1rem;
    }

    .btn-minus, .btn-plus {
      width: 40px;
      height: 40px;
      font-size: 1rem;
    }

    .order-summary {
      padding: 20px;
    }
  }
</style>

<div class="container">
  <h1 class="page-title">🎵 Pilih Tiket Festival 🎵</h1>
  
  <div class="poster-banner">
    <img src="{{ asset('images/banner.jpeg') }}" alt="SOD Festival Poster">
  </div>

  <div class="ticket-container">
    <!-- LEFT SIDE - Ticket Categories -->
    <div class="ticket-list">
      
      <!-- VVIP Section -->
      @php
        $vvipTickets = $tickets->filter(function($ticket) {
          return stripos($ticket->jenis_tiket, 'VVIP') !== false;
        });
      @endphp
      
      @if($vvipTickets->count() > 0)
      <div class="ticket-category vvip">
        <div class="category-header">
          <span class="category-icon">👑</span>
          <h2 class="category-title">VVIP - Premium Experience</h2>
        </div>
        <div class="category-grid">
          @foreach($vvipTickets as $ticket)
          <div class="ticket-card" 
               data-id="{{ $ticket->id }}" 
               data-price="{{ $ticket->harga_tiket }}" 
               data-stock="{{ $ticket->stok_tiket }}">
            <h3>{{ $ticket->nama_event ?? '-' }}</h3>
            <p class="ticket-description">
              Stok tersedia: {{ $ticket->stok_tiket }}
            </p>
            <div class="ticket-price">
              Rp {{ number_format($ticket->harga_tiket, 0, ',', '.') }}
            </div>
            <div class="qty-control">
              <button type="button" class="btn-minus">-</button>
              <input type="text" class="qty-input" value="0" readonly>
              <button type="button" class="btn-plus">+</button>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      <!-- VIP Section -->
      @php
        $vipTickets = $tickets->filter(function($ticket) {
          $jenis = $ticket->jenis_tiket;
          return stripos($jenis, 'VIP') !== false && stripos($jenis, 'VVIP') === false;
        });
      @endphp
      
      @if($vipTickets->count() > 0)
      <div class="ticket-category vip">
        <div class="category-header">
          <span class="category-icon">⭐</span>
          <h2 class="category-title">VIP - Enhanced Access</h2>
        </div>
        <div class="category-grid">
          @foreach($vipTickets as $ticket)
          <div class="ticket-card" 
               data-id="{{ $ticket->id }}" 
               data-price="{{ $ticket->harga_tiket }}" 
               data-stock="{{ $ticket->stok_tiket }}">
            <h3>{{ $ticket->nama_event ?? '-' }}</h3>
            <p class="ticket-description">
              Stok tersedia: {{ $ticket->stok_tiket }}
            </p>
            <div class="ticket-price">
              Rp {{ number_format($ticket->harga_tiket, 0, ',', '.') }}
            </div>
            <div class="qty-control">
              <button type="button" class="btn-minus">-</button>
              <input type="text" class="qty-input" value="0" readonly>
              <button type="button" class="btn-plus">+</button>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      <!-- REGULER Section -->
      @php
        $regulerTickets = $tickets->filter(function($ticket) {
          $jenis = $ticket->jenis_tiket;
          return stripos($jenis, 'REGULER') !== false || 
                 (stripos($jenis, 'VIP') === false && stripos($jenis, 'VVIP') === false);
        });
      @endphp
      
      @if($regulerTickets->count() > 0)
      <div class="ticket-category reguler">
        <div class="category-header">
          <span class="category-icon">🎟️</span>
          <h2 class="category-title">REGULER - General Admission</h2>
        </div>
        <div class="category-grid">
          @foreach($regulerTickets as $ticket)
          <div class="ticket-card" 
               data-id="{{ $ticket->id }}" 
               data-price="{{ $ticket->harga_tiket }}" 
               data-stock="{{ $ticket->stok_tiket }}">
            <h3>{{ $ticket->nama_event?? '-' }}</h3>
            <p class="ticket-description">
              Stok tersedia: {{ $ticket->stok_tiket }}
            </p>
            <div class="ticket-price">
              Rp {{ number_format($ticket->harga_tiket, 0, ',', '.') }}
            </div>
            <div class="qty-control">
              <button type="button" class="btn-minus">-</button>
              <input type="text" class="qty-input" value="0" readonly>
              <button type="button" class="btn-plus">+</button>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif

    </div>

    <!-- RIGHT SIDE - Order Summary -->
    <div class="order-summary">
      <div class="summary-title">📋 Order Summary</div>
      <div id="summary-list"></div>
      <div class="summary-item">
        <span>Subtotal</span><span id="subtotal">Rp 0</span>
      </div>
      <div class="summary-item">
        <span>Tax (10%)</span><span id="tax">Rp 0</span>
      </div>
      <div class="summary-item">
        <span>Platform Fee</span><span id="fee">Rp 0</span>
      </div>
      <div class="summary-total">
        Total: <span id="total">Rp 0</span>
      </div>
      
      <form id="checkout-form" action="{{ route('checkout.page') }}" method="GET">
        @csrf
        <input type="hidden" name="tickets" id="ticket-data" value="">
        <input type="hidden" name="subtotal" id="subtotal-data" value="0">
        <input type="hidden" name="tax" id="tax-data" value="0">
        <input type="hidden" name="fee" id="fee-data" value="0">
        <input type="hidden" name="total" id="total-data" value="0">

        <button type="submit" class="btn-checkout" id="checkout-btn" disabled>
          🛒 Checkout (0 tiket)
        </button>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.ticket-card');
    const summaryList = document.getElementById('summary-list');
    const subtotalEl = document.getElementById('subtotal');
    const taxEl = document.getElementById('tax');
    const feeEl = document.getElementById('fee');
    const totalEl = document.getElementById('total');
    const checkoutBtn = document.getElementById('checkout-btn');
    const hiddenInput = document.getElementById('ticket-data');
    const checkoutForm = document.getElementById('checkout-form');
    
    const subtotalData = document.getElementById('subtotal-data');
    const taxData = document.getElementById('tax-data');
    const feeData = document.getElementById('fee-data');
    const totalData = document.getElementById('total-data');

    function formatRupiah(value) {
      return 'Rp ' + Math.round(value).toLocaleString('id-ID');
    }

    function updateSummary() {
      let subtotal = 0;
      let ticketCount = 0;
      const ticketData = [];
      summaryList.innerHTML = '';

      cards.forEach(card => {
        const qty = parseInt(card.querySelector('.qty-input').value) || 0;
        const price = parseInt(card.dataset.price) || 0;
        const id = card.dataset.id;
        const title = card.querySelector('h3').innerText;

        if (qty > 0) {
          const total = qty * price;
          subtotal += total;
          ticketCount += qty;

          const item = document.createElement('div');
          item.classList.add('summary-item');
          item.innerHTML = `<span>${title}</span><span>${formatRupiah(price)} × ${qty}</span>`;
          summaryList.appendChild(item);

          ticketData.push({ 
            id: id, 
            qty: qty, 
            price: price,
            total: total
          });
        }
      });

      const tax = subtotal * 0.10;
      const fee = subtotal * 0.05;
      const grandTotal = subtotal + tax + fee;

      subtotalEl.innerText = formatRupiah(subtotal);
      taxEl.innerText = formatRupiah(tax);
      feeEl.innerText = formatRupiah(fee);
      totalEl.innerText = formatRupiah(grandTotal);
      
      checkoutBtn.innerHTML = `🛒 Checkout (${ticketCount} tiket)`;
      
      hiddenInput.value = JSON.stringify(ticketData);
      subtotalData.value = Math.round(subtotal);
      taxData.value = Math.round(tax);
      feeData.value = Math.round(fee);
      totalData.value = Math.round(grandTotal);

      if (ticketCount > 0) {
        checkoutBtn.disabled = false;
        checkoutBtn.classList.add('enabled');
        checkoutBtn.style.cursor = 'pointer';
      } else {
        checkoutBtn.disabled = true;
        checkoutBtn.classList.remove('enabled');
        checkoutBtn.style.cursor = 'not-allowed';
      }
    }

    cards.forEach(card => {
      const plusBtn = card.querySelector('.btn-plus');
      const minusBtn = card.querySelector('.btn-minus');
      const qtyInput = card.querySelector('.qty-input');
      const stock = parseInt(card.dataset.stock) || 0;

      plusBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const currentQty = parseInt(qtyInput.value) || 0;
        
        if (currentQty < stock) {
          qtyInput.value = currentQty + 1;
          card.classList.add('selected');
          setTimeout(() => card.classList.remove('selected'), 600);
          updateSummary();
        } else {
          alert(`Stok tidak mencukupi! Maksimal ${stock} tiket.`);
        }
      });

      minusBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const currentQty = parseInt(qtyInput.value) || 0;
        
        if (currentQty > 0) {
          qtyInput.value = currentQty - 1;
          updateSummary();
        }
      });
    });

    checkoutForm.addEventListener('submit', function(e) {
      const ticketData = JSON.parse(hiddenInput.value || '[]');
      
      if (ticketData.length === 0) {
        e.preventDefault();
        alert('Silakan pilih tiket terlebih dahulu!');
        return false;
      }

      checkoutBtn.classList.add('loading');
      checkoutBtn.disabled = true;
      checkoutBtn.innerHTML = '⏳ Processing...';
      
      setTimeout(() => {
        if (checkoutBtn.classList.contains('loading')) {
          checkoutBtn.classList.remove('loading');
          checkoutBtn.disabled = false;
          updateSummary();
        }
      }, 30000);
    });

    updateSummary();
  });
</script>

@if ($errors->any())
<script>
  document.addEventListener('DOMContentLoaded', function() {
    alert('Error: {{ $errors->first() }}');
  });
</script>
@endif

@if (session('error'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    alert('{{ session('error') }}');
  });
</script>
@endif

@endsection