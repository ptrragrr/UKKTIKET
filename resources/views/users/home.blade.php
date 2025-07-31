@extends('layouts.app')
@section('title', 'NextPure Fest - Festival Musik Seru')

@section('content')
<style>
  :root {
    --dark-forest: #1C290D;
    --sage-green: #676F53;
    --light-olive: #B3B49A;
    --cream: #FEFAE0;
    --warm-taupe: #A19379;
    --brown-text: #736046;
    --dark-brown: #381D03;
  }

  html, body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    width: 100%;
    height: 100%;
  }

  .nature-hero {
    width: 100%;
    min-height: 100vh;
    background: linear-gradient(135deg, var(--cream), var(--light-olive));
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 120px;
    position: relative;
  }

  .nature-content {
    z-index: 1;
    width: 100%;
    max-width: 920px;
    padding: 40px;
    background: rgba(254, 250, 224, 0.95);
    border-radius: 30px;
    border: 1px solid rgba(103, 111, 83, 0.2);
    box-shadow: 0 20px 50px rgba(28, 41, 13, 0.15);
  }

  .nature-title {
    font-size: 3.5rem;
    text-shadow: 2px 2px 0 var(--sage-green), 4px 4px 0 var(--dark-brown);
    color: var(--dark-forest);
    margin-bottom: 1rem;
    font-weight: 700;
    line-height: 1.1;
    letter-spacing: -1px;
  }

  .nature-subtitle {
    font-size: 1.5rem;
    color: var(--dark-brown);
    margin-bottom: 2rem;
    line-height: 1.4;
  }

  .event-info-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 2rem;
  }

  .info-card {
    flex: 1 1 260px;
    background: linear-gradient(135deg, var(--sage-green), var(--dark-forest));
    color: white;
    padding: 20px;
    border-radius: 20px;
    min-width: 0;
  }

  .info-card-icon {
    font-size: 2rem;
    margin-bottom: 8px;
    display: block;
  }

  .info-card-title {
    font-size: 1rem;
    font-weight: bold;
    margin-bottom: 4px;
  }

  .info-card-text {
    font-size: 0.95rem;
    line-height: 1.4;
  }

  .artists-section {
    background: linear-gradient(135deg, var(--warm-taupe), var(--light-olive));
    padding: 20px;
    border-radius: 16px;
    margin-bottom: 2rem;
    text-align: center;
  }

  .artists-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
  }

  .artist-tag {
    background: rgba(255,255,255,0.2);
    padding: 8px 16px;
    border-radius: 30px;
    backdrop-filter: blur(4px);
    font-weight: 500;
  }

  .countdown-section {
    background: var(--dark-brown);
    color: var(--cream);
    padding: 25px;
    border-radius: 20px;
    margin-bottom: 2rem;
    text-align: center;
  }

  .countdown {
    font-size: 1.3rem;
    font-weight: 700;
    animation: glow 3s ease-in-out infinite alternate;
  }

  @keyframes glow {
    from {
      text-shadow: 0 0 5px var(--cream);
    }
    to {
      text-shadow: 0 0 15px var(--cream), 0 0 25px var(--sage-green);
    }
  }

  .btn-container {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    justify-content: center;
  }

  .btn-primary, .btn-secondary {
    padding: 16px 30px;
    font-size: 1.1rem;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
  }

  .btn-primary {
    background: linear-gradient(135deg, var(--sage-green), var(--dark-forest));
    color: white;
    font-weight: 600;
    border: none;
  }

  .btn-primary:hover {
    background: var(--dark-forest);
  }

  .btn-secondary {
    border: 2px solid var(--dark-brown);
    color: var(--dark-brown);
    background: transparent;
    font-weight: 500;
  }

  .btn-secondary:hover {
    background: var(--dark-brown);
    color: var(--cream);
  }

  /* Responsive */
  @media (max-width: 768px) {
    .nature-title {
      font-size: 2.8rem;
    }

    .nature-subtitle {
      font-size: 1.2rem;
    }

    .btn-container {
      flex-direction: column;
      gap: 12px;
    }

    .btn-primary, .btn-secondary {
      width: 100%;
      max-width: 300px;
      text-align: center;
    }
  }
</style>

<div class="nature-hero">
  <div class="nature-content">
    <h1 class="nature-title">OURSKY.FEST</h1>
    <p class="nature-subtitle">Festival musik bertema alam untuk para music lovers yang peduli lingkungan!</p>

    <div class="event-info-grid">
      <div class="info-card">
        <span class="info-card-icon">📅</span>
        <div class="info-card-title">Tanggal & Waktu</div>
        <div class="info-card-text">12 Oktober 2025<br>Mulai pukul 16:00 WIB</div>
      </div>
      <div class="info-card">
        <span class="info-card-icon">📍</span>
        <div class="info-card-title">Lokasi</div>
        <div class="info-card-text">Lapangan Merdeka<br>Jakarta Pusat</div>
      </div>
      <div class="info-card">
        <span class="info-card-icon">🎫</span>
        <div class="info-card-title">Harga Tiket</div>
        <div class="info-card-text">Mulai dari<br>Rp 150.000</div>
      </div>
    </div>

    <div class="artists-section">
      <strong>✨ LINE UP ARTIS ✨</strong>
      <div class="artists-list">
        <span class="artist-tag">Pamungkas</span>
        <span class="artist-tag">Nadin Amizah</span>
        <span class="artist-tag">Reality Club</span>
        <span class="artist-tag">Hindia</span>
        <span class="artist-tag">Barasuara</span>
        <span class="artist-tag">+ More</span>
      </div>
    </div>

    <div class="countdown-section">
      <div class="countdown" id="countdown">⏳ Loading countdown...</div>
    </div>

    <div class="btn-container">
      <a href="{{ route('tickets') }}" class="btn-primary">🎟️ Beli Tiket Sekarang</a>
      <!-- <a href="#info" class="btn-secondary">📋 Info Lengkap</a> -->
    </div>
  </div>
</div>

<script>
  const countdownEl = document.getElementById("countdown");
  const eventDate = new Date("2025-10-12T16:00:00+07:00");
  
  function updateCountdown() {
    const now = new Date();
    const diff = eventDate - now;

    if (diff <= 0) {
      countdownEl.innerText = "🎉 Festival sedang berlangsung!";
      return;
    }

    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    countdownEl.innerText = `🌿 ${days} hari ${hours} jam lagi menuju festival! 🎶`;
  }

  updateCountdown();
  setInterval(updateCountdown, 60000);
</script>
@endsection
