@extends('layouts.app')

@section('content')
<style>
  :root {
    --primary-green: #1C290D;
    --sage-green: #676F53;
    --warm-beige: #B3B49A;
    --cream: #FEFAE0;
    --taupe: #A19379;
    --brown: #736046;
    --dark-brown: #381D03;
    --white: #ffffff;
    --shadow: rgba(28, 41, 13, 0.15);
    --shadow-hover: rgba(28, 41, 13, 0.25);
  }

  body {
    background: linear-gradient(135deg, var(--cream) 0%, var(--warm-beige) 100%);
    min-height: 100vh;
  }

  .contact-container {
    padding: 140px 2rem 4rem 2rem;
    width: 100%; /* FULL WIDTH */
    margin: 0;
    position: relative;
  }

  .contact-hero {
    text-align: center;
    margin-bottom: 4rem;
    position: relative;
  }

  .contact-hero::before {
    content: '';
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-green), var(--sage-green));
    border-radius: 2px;
  }

  .contact-title {
    font-size: 3.5rem;
    font-weight: 900;
    color: var(--primary-green);
    margin-bottom: 1.5rem;
    text-shadow: 2px 2px 4px rgba(28, 41, 13, 0.1);
    letter-spacing: -1px;
  }

  .contact-subtitle {
    font-size: 1.3rem;
    color: var(--brown);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    font-weight: 400;
  }

  .contact-content {
    display: flex;
    justify-content: center;
    margin-top: 4rem;
    width: 100%;
  }

  .contact-info {
    background: linear-gradient(135deg, var(--white) 0%, var(--cream) 100%);
    padding: 3rem;
    border-radius: 25px;
    box-shadow: 0 15px 40px var(--shadow);
    border: 2px solid var(--warm-beige);
    position: relative;
    overflow: hidden;
    width: 100%;
    max-width: none; /* REMOVE MAX-WIDTH RESTRICTION */
  }

  .contact-info::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(103, 111, 83, 0.05), transparent);
    transition: left 0.8s ease;
  }

  .contact-info:hover::before {
    left: 100%;
  }

  /* GRID LAYOUT FOR CONTACT SECTIONS */
  .contact-info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 4rem;
    align-items: start;
  }

  .info-section {
    text-align: center;
  }

  .info-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--primary-green);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  .info-icon {
    width: 24px;
    height: 24px;
    background: linear-gradient(135deg, var(--sage-green), var(--primary-green));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--cream);
    font-size: 0.9rem;
  }

  .info-details {
    color: var(--brown);
    font-size: 1.1rem;
    line-height: 1.6;
  }

  .social-links {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
    justify-content: center;
  }

  .social-link {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--sage-green), var(--primary-green));
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--cream);
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.2rem;
  }

  .social-link:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px var(--shadow-hover);
    background: linear-gradient(135deg, var(--brown), var(--dark-brown));
  }

  /* Dekorasi animasi */
  @keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(180deg); }
  }

  .contact-container::before,
  .contact-container::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    opacity: 0.2;
    animation: float 6s ease-in-out infinite;
  }

  .contact-container::before {
    top: 10%;
    left: 5%;
    width: 40px;
    height: 40px;
    background: var(--sage-green);
    animation-delay: 0s;
  }

  .contact-container::after {
    top: 20%;
    right: 8%;
    width: 30px;
    height: 30px;
    background: var(--warm-beige);
    animation-delay: 3s;
  }

  @media (max-width: 1024px) {
    .contact-info-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 3rem;
    }
  }

  @media (max-width: 768px) {
    .contact-container {
      padding: 120px 1rem 2rem 1rem;
    }

    .contact-title {
      font-size: 2.5rem;
    }

    .contact-subtitle {
      font-size: 1.1rem;
    }

    .contact-info-grid {
      grid-template-columns: 1fr;
      gap: 2rem;
    }

    .contact-info {
      padding: 2rem;
      border-radius: 20px;
    }
  }
</style>

<div class="contact-container">
  <div class="contact-hero">
    <h1 class="contact-title">Kontak Kami</h1>
    <p class="contact-subtitle">Hubungi kami untuk informasi lebih lanjut atau kerja sama.</p>
  </div>

  <div class="contact-content">
    <div class="contact-info">
      <div class="contact-info-grid">
        <div class="info-section">
          <div class="info-title">
            <div class="info-icon">📞</div>
            Telepon
          </div>
          <div class="info-details">
            +62 31 1234 5678<br>
            +62 812 3456 7890
          </div>
        </div>

        <div class="info-section">
          <div class="info-title">
            <div class="info-icon">✉️</div>
            Email
          </div>
          <div class="info-details">
            ourskyfest12@gmail.com<br>
            ourskyfestival@gmail.com
          </div>
        </div>

        <div class="info-section">
          <div class="info-title">
            <div class="info-icon">🌐</div>
            Media Sosial
          </div>
          <div class="social-links">
            <a href="https://www.instagram.com/ptrragrr/" class="social-link" title="Instagram">
              <img src="{{ asset('images/ig.png') }}" alt="Instagram" style="width: 24px; height: 24px;">
            </a>
            <!-- <a href="#" class="social-link" title="WhatsApp">
              <img src="{{ asset('images/wa.png') }}" alt="WhatsApp" style="width: 24px; height: 24px;">
            </a> -->
            <a href="https://x.com/NCTsmtown_DREAM" class="social-link" title="Twitter">
              <img src="{{ asset('images/x.png') }}" alt="Twitter" style="width: 24px; height: 24px;">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection