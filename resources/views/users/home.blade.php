@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OURSKY.FEST - Festival Musik Bertema Alam</title>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            background: var(--cream);
            color: var(--dark-brown);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--cream), var(--light-olive));
            min-height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 4rem;
            font-weight: 800;
            color: var(--dark-forest);
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .hero-content p {
            font-size: 1.3rem;
            color: var(--brown-text);
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button {
            display: inline-block;
            background: var(--sage-green);
            color: white;
            padding: 18px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .cta-button:hover {
            background: var(--dark-forest);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        /* Info Cards */
        .info-section {
            padding: 80px 0;
            background: white;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .info-card {
            background: var(--cream);
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            border: 1px solid var(--light-olive);
            transition: transform 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
        }

        .info-card .icon {
            font-size: 3rem;
            margin-bottom: 20px;
            display: block;
        }

        .info-card h3 {
            color: var(--dark-forest);
            font-size: 1.3rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .info-card p {
            color: var(--brown-text);
            font-size: 1rem;
        }

        /* Artists Section */
        .artists-section {
            padding: 80px 0;
            background: var(--light-olive);
            text-align: center;
        }

        .artists-section h2 {
            color: var(--dark-forest);
            font-size: 2.5rem;
            margin-bottom: 50px;
            font-weight: 700;
        }

        .artists-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .artist-card {
            background: white;
            border-radius: 15px;
            padding: 30px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .artist-card:hover {
            transform: translateY(-5px);
        }

        .artist-card h4 {
            color: var(--dark-forest);
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .artist-card p {
            color: var(--brown-text);
            font-size: 0.9rem;
        }

        /* Countdown Section */
        .countdown-section {
            padding: 80px 0;
            background: var(--sage-green);
            color: white;
            text-align: center;
        }

        .countdown-section h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .countdown {
            font-size: 2rem;
            font-weight: 600;
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 15px;
            display: inline-block;
            backdrop-filter: blur(10px);
        }

        /* Footer */
        .footer {
            background: var(--dark-brown);
            color: var(--cream);
            padding: 50px 0;
            text-align: center;
        }

        .footer h3 {
            margin-bottom: 20px;
            color: var(--cream);
        }

        .footer p {
            color: var(--warm-taupe);
            margin-bottom: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-content p {
                font-size: 1.1rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .artists-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .artists-section h2,
            .countdown-section h2 {
                font-size: 2rem;
            }

            .countdown {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>OURSKY.FEST</h1>
                <p>Festival musik untuk para music lovers</p>
                <a href="/tickets" class="cta-button">🎟️ Dapatkan Tiket</a>
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section class="info-section">
        <div class="container">
            <div class="info-grid">
                <div class="info-card">
                    <span class="icon">📅</span>
                    <h3>Tanggal & Waktu</h3>
                    <p>12 Oktober 2025<br>Mulai pukul 16:00 WIB</p>
                </div>
                <div class="info-card">
                    <span class="icon">📍</span>
                    <h3>Lokasi</h3>
                    <p>Lapangan Merdeka<br>Jakarta Pusat</p>
                </div>
                <div class="info-card">
                    <span class="icon">🎫</span>
                    <h3>Harga Tiket</h3>
                    <p>Mulai dari<br>Rp 150.000</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Artists Section -->
    <section class="artists-section">
        <div class="container">
            <h2>Line Up Artis</h2>
            <div class="artists-grid">
                <div class="artist-card">
                    <h4>Pamungkas</h4>
                    <p>Alternative Pop</p>
                </div>
                <div class="artist-card">
                    <h4>Nadin Amizah</h4>
                    <p>Indie Folk</p>
                </div>
                <div class="artist-card">
                    <h4>Reality Club</h4>
                    <p>Indie Rock</p>
                </div>
                <div class="artist-card">
                    <h4>Hindia</h4>
                    <p>Alternative</p>
                </div>
                <div class="artist-card">
                    <h4>Barasuara</h4>
                    <p>Alternative Rock</p>
                </div>
                <div class="artist-card">
                    <h4>& More Artists</h4>
                    <p>Coming Soon</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Countdown Section -->
    <section class="countdown-section">
        <div class="container">
            <h2>Menuju Festival</h2>
            <div class="countdown" id="countdown">
                ⏳ Loading countdown...
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <h3>OURSKY.FEST 2025</h3>
            <p>Festival musik bertema alam yang menginspirasi</p>
            <p>Jakarta Pusat • 12 Oktober 2025</p>
            <br>
            <p style="color: var(--warm-taupe); font-size: 0.9rem;">
                © 2025 OURSKY.FEST. All rights reserved.
            </p>
        </div>
    </footer>

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
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            
            countdownEl.innerText = `🌿 ${days} hari ${hours} jam ${minutes} menit`;
        }

        updateCountdown();
        setInterval(updateCountdown, 60000);
    </script>
</body>
</html>
@endsection