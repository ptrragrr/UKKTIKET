@extends('layouts.app')
@section('title', 'Tentang Kami')

@section('content')
<style>
  .about-wrapper {
    padding: 100px 0 80px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #381D03;
    background: linear-gradient(135deg, #FEFAE0 0%, #B3B49A 100%);
    min-height: 100vh;
  }

  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .hero-section {
    text-align: center;
    margin-bottom: 80px;
    padding: 60px 40px;
    background: linear-gradient(135deg, #1C290D 0%, #676F53 50%, #A19379 100%);
    border-radius: 32px;
    color: white;
    box-shadow: 0 20px 40px rgba(28, 41, 13, 0.15);
    position: relative;
    overflow: hidden;
  }

  .hero-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .hero-section::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 300px;
    height: 300px;
    background: #FEFAE0;
    opacity: 0.1;
    border-radius: 50%;
  }

  .hero-section h1 {
    font-size: 3.5em;
    font-weight: 700;
    margin-bottom: 20px;
    position: relative;
    z-index: 2;
  }

  .hero-section .subtitle {
    font-size: 1.3em;
    opacity: 0.9;
    font-weight: 300;
    position: relative;
    z-index: 2;
  }

  .content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 80px;
  }

  .about-card {
    background: white;
    padding: 40px;
    border-radius: 24px;
    box-shadow: 0 12px 30px rgba(28, 41, 13, 0.1);
    border: 1px solid rgba(179, 180, 154, 0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .about-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #FEFAE0, #A19379, #676F53);
  }

  .about-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(28, 41, 13, 0.15);
  }

  .about-card h2 {
    font-size: 1.8em;
    margin-bottom: 20px;
    color: #381D03;
    font-weight: 600;
    display: flex;
    align-items: center;
  }

  .about-card h2::before {
    content: '';
    width: 8px;
    height: 8px;
    background: #676F53;
    border-radius: 50%;
    margin-right: 12px;
  }

  .about-card p {
    line-height: 1.8;
    color: #736046;
    font-size: 1.1em;
  }

  .team-section {
    background: white;
    padding: 60px 40px;
    border-radius: 32px;
    box-shadow: 0 20px 40px rgba(28, 41, 13, 0.1);
    margin-bottom: 60px;
    position: relative;
  }

  .team-section h2 {
    text-align: center;
    font-size: 2.5em;
    margin-bottom: 50px;
    color: #381D03;
    font-weight: 700;
  }

  .team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
  }

  .team-member {
    text-align: center;
    padding: 30px 20px;
    border-radius: 20px;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #FEFAE0 0%, rgba(179, 180, 154, 0.3) 100%);
  }

  .team-member:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(103, 111, 83, 0.2);
  }

  .team-member img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #B3B49A;
    margin-bottom: 20px;
    transition: all 0.3s ease;
  }

  .team-member:hover img {
    border-color: #676F53;
    transform: scale(1.05);
  }

  .team-member h3 {
    font-size: 1.3em;
    color: #381D03;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .team-member .role {
    color: #676F53;
    font-size: 0.95em;
    font-weight: 500;
  }

  .stats-section {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-bottom: 60px;
  }

  .stat-card {
    background: linear-gradient(135deg, #381D03 0%, #1C290D 100%);
    color: white;
    padding: 30px;
    border-radius: 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .stat-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .stat-number {
    font-size: 2.5em;
    font-weight: 700;
    margin-bottom: 10px;
    position: relative;
    z-index: 2;
  }

  .stat-label {
    font-size: 1em;
    opacity: 0.9;
    position: relative;
    z-index: 2;
  }

  .back-button {
    text-align: center;
    margin-top: 60px;
  }

  .back-button a {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #676F53 0%, #381D03 100%);
    color: white;
    padding: 15px 30px;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1em;
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(103, 111, 83, 0.3);
  }

  .back-button a::before {
    content: '←';
    margin-right: 10px;
    font-size: 1.2em;
  }

  .back-button a:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(103, 111, 83, 0.4);
    background: linear-gradient(135deg, #1C290D 0%, #381D03 100%);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .content-grid {
      grid-template-columns: 1fr;
      gap: 30px;
    }

    .stats-section {
      grid-template-columns: 1fr;
      gap: 20px;
    }

    .hero-section h1 {
      font-size: 2.5em;
    }

    .hero-section .subtitle {
      font-size: 1.1em;
    }

    .team-grid {
      grid-template-columns: 1fr;
    }

    .about-card {
      padding: 30px 20px;
    }

    .hero-section {
      padding: 40px 20px;
      margin-bottom: 50px;
    }
  }
</style>

<div class="about-wrapper">
  <div class="container">
    <div class="hero-section">
      <h1>OURSKY.FEST</h1>
      <p class="subtitle">Platform Tiket Konser Terdepan di Indonesia</p>
    </div>

    <!-- <div class="stats-section">
      <div class="stat-card">
        <div class="stat-number">10K+</div>
        <div class="stat-label">Pengguna Aktif</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">500+</div>
        <div class="stat-label">Event Sukses</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">50+</div>
        <div class="stat-label">Artis Partner</div>
      </div>
    </div> -->

    <div class="content-grid">
      <div class="about-card">
        <h2>Siapa Kami?</h2>
        <p>OURSKY.FEST adalah platform pemesanan tiket konser online yang hadir untuk memberikan kemudahan dan kenyamanan bagi para pecinta musik di seluruh Indonesia. Kami menghubungkan penggemar musik dengan artis favorit mereka melalui teknologi yang inovatif dan pengalaman yang tak terlupakan.</p>
      </div>

      <div class="about-card">
        <h2>Misi Kami</h2>
        <p>Kami berkomitmen untuk menyajikan pengalaman pemesanan tiket yang cepat, aman, dan menyenangkan, demi mendukung industri hiburan tanah air. Dengan teknologi terdepan, kami memastikan setiap transaksi berjalan lancar dan setiap konser menjadi pengalaman yang berkesan.</p>
      </div>
    </div>

    <!-- <div class="team-section">
      <h2>Tim Kreatif Kami</h2>
      <div class="team-grid">
        <div class="team-member">
          <img src="{{ asset('images/aston.jpeg') }}" alt="Jane Doe">
          <h3>Jane Doe</h3>
          <p class="role">CEO & Founder</p>
        </div>
        <div class="team-member">
          <img src="{{ asset('images/aston.jpeg') }}" alt="John Smith">
          <h3>John Smith</h3>
          <p class="role">CTO</p>
        </div>
        <div class="team-member">
          <img src="{{ asset('images/aston.jpeg') }}" alt="Alice Lee">
          <h3>Alice Lee</h3>
          <p class="role">Head of Design</p>
        </div>
        <div class="team-member">
          <img src="{{ asset('images/aston.jpeg') }}" alt="Michael Tan">
          <h3>Michael Tan</h3>
          <p class="role">Marketing Director</p>
        </div>
      </div>
    </div> -->

    <div class="back-button">
      <a href="{{ route('home') }}">Kembali ke Beranda</a>
    </div>
  </div>
</div>
@endsection