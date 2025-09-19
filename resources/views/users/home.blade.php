@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OURSKY.FEST - Tata Cara Pesan Tiket</title>
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
            padding: 150px 0 100px 0;
            text-align: center;
            margin-top: 80px;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--dark-forest);
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .hero-content p {
            font-size: 1.3rem;
            color: var(--brown-text);
            margin-bottom: 3rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Steps Section */
        .steps-section {
            padding: 80px 0;
            background: white;
        }

        .section-title {
            text-align: center;
            color: var(--dark-forest);
            font-size: 2.5rem;
            margin-bottom: 60px;
            font-weight: 700;
        }

        .steps-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 50px;
            background: var(--cream);
            border-radius: 20px;
            padding: 30px;
            border-left: 5px solid var(--sage-green);
            transition: transform 0.3s ease;
        }

        .step:hover {
            transform: translateX(10px);
        }

        .step-number {
            background: var(--sage-green);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-right: 25px;
            flex-shrink: 0;
        }

        .step-content h3 {
            color: var(--dark-forest);
            font-size: 1.4rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .step-content p {
            color: var(--brown-text);
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .step-content ul {
            color: var(--brown-text);
            margin-left: 20px;
        }

        .step-content li {
            margin-bottom: 8px;
        }

        /* Ticket Types Section */
        .ticket-types {
            padding: 80px 0;
            background: var(--light-olive);
        }

        .tickets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .ticket-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ticket-card:hover {
            transform: translateY(-10px);
        }

        .ticket-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--sage-green);
        }

        .ticket-card.premium::before {
            background: var(--dark-forest);
        }

        .ticket-card h4 {
            color: var(--dark-forest);
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .ticket-price {
            font-size: 2rem;
            color: var(--sage-green);
            font-weight: 800;
            margin-bottom: 20px;
        }

        .ticket-card.premium .ticket-price {
            color: var(--dark-forest);
        }

        .ticket-features {
            text-align: left;
            color: var(--brown-text);
        }

        .ticket-features li {
            margin-bottom: 10px;
            padding-left: 20px;
            position: relative;
        }

        .ticket-features li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--sage-green);
            font-weight: bold;
        }

        /* Payment Methods */
        .payment-section {
            padding: 80px 0;
            background: white;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }

        .payment-method {
            background: var(--cream);
            padding: 30px 20px;
            border-radius: 15px;
            text-align: center;
            border: 2px solid var(--light-olive);
            transition: all 0.3s ease;
        }

        .payment-method:hover {
            border-color: var(--sage-green);
            transform: translateY(-5px);
        }

        .payment-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            display: block;
        }

        .payment-method h4 {
            color: var(--dark-forest);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .payment-method p {
            color: var(--brown-text);
            font-size: 0.9rem;
        }

        /* Concert Rules Section */
        .rules-section {
            padding: 80px 0;
            background: var(--light-olive);
        }

        .rules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .rules-category {
            background: white;
            padding: 30px;
            border-radius: 20px;
            border-left: 5px solid var(--sage-green);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .rules-category:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .rules-category h3 {
            color: var(--dark-forest);
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .rules-list {
            list-style: none;
            color: var(--brown-text);
        }

        .rules-list li {
            margin-bottom: 12px;
            padding-left: 25px;
            position: relative;
            font-size: 0.95rem;
        }

        .rules-list li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: var(--sage-green);
            font-weight: bold;
            font-size: 1.2rem;
        }

        .rules-warning {
            background: var(--sage-green);
            color: white;
            padding: 30px;
            border-radius: 20px;
            margin-top: 50px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .rules-warning h4 {
            color: white;
            font-size: 1.4rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .rules-warning p {
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .rules-warning strong {
            color: var(--cream);
            font-weight: 700;
        }

        /* Important Notes */
        .notes-section {
            padding: 80px 0;
            background: var(--dark-forest);
            color: white;
        }

        .notes-container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .notes-section h2 {
            font-size: 2.2rem;
            margin-bottom: 40px;
            font-weight: 700;
        }

        .note-item {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            text-align: left;
        }

        .note-item h4 {
            margin-bottom: 10px;
            font-weight: 600;
        }

        /* CTA Section */
        .cta-section {
            padding: 60px 0;
            background: var(--cream);
            text-align: center;
        }

        .cta-button {
            display: inline-block;
            background: var(--dark-forest);
            color: white;
            padding: 20px 50px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            margin: 0 10px 20px 10px;
        }

        .cta-button:hover {
            background: var(--sage-green);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.3);
        }

        .cta-button.secondary {
            background: transparent;
            color: var(--dark-forest);
            border: 2px solid var(--dark-forest);
        }

        .cta-button.secondary:hover {
            background: var(--dark-forest);
            color: white;
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

            .step {
                flex-direction: column;
                text-align: center;
            }

            .step-number {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .tickets-grid {
                grid-template-columns: 1fr;
            }

            .payment-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .rules-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .rules-category {
                padding: 25px 20px;
            }

            .rules-warning {
                padding: 25px 20px;
                margin-top: 30px;
            }

            .section-title {
                font-size: 2rem;
            }

            .cta-button {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>🎫 Tata Cara Pesan Tiket</h1>
                <p>Ikuti panduan lengkap di bawah ini untuk mendapatkan tiket OURSKY.FEST 2025 dengan mudah dan aman</p>
            </div>
        </div>
    </section>

    <!-- Steps Section -->
    <section class="steps-section">
        <div class="container">
            <h2 class="section-title">Langkah-langkah Pemesanan</h2>
            <div class="steps-container">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Kunjungi Website Resmi</h3>
                        <p>Pastikan Anda mengunjungi website resmi OURSKY.FEST untuk menghindari penipuan:</p>
                        <ul>
                            <li>www.ourskyfest.com (website resmi)</li>
                            <li>Hindari membeli dari website tidak resmi</li>
                            <li>Periksa logo dan desain yang sesuai</li>
                        </ul>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Pilih Jenis Tiket</h3>
                        <p>Tentukan kategori tiket yang sesuai dengan budget dan preferensi Anda:</p>
                        <ul>
                            <li>Regular Ticket - Akses ke area festival</li>
                            <li>VIP Ticket - Akses area VIP + fasilitas eksklusif</li>
                            <li>VVIP Ticket - Akses penuh + meet & greet</li>
                        </ul>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Isi Data Pembeli</h3>
                        <p>Lengkapi formulir pemesanan dengan data yang valid:</p>
                        <ul>
                            <li>Nama lengkap sesuai KTP</li>
                            <li>Email aktif untuk konfirmasi</li>
                            <li>Nomor telefon yang dapat dihubungi</li>
                        </ul>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Pilih Metode Pembayaran</h3>
                        <p>Selesaikan pembayaran melalui metode yang tersedia:</p>
                        <ul>
                            <li>Transfer bank (BCA, Mandiri, BNI, BRI)</li>
                            <li>E-wallet (OVO, GoPay, DANA, LinkAja)</li>
                            <li>Virtual Account</li>
                        </ul>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h3>Konfirmasi</h3>
                        <p>Setelah pembayaran berhasil:</p>
                        <ul>
                            <li>Cek email konfirmasi pembayaran</li>
                            <li>Perhatikan kode tiket yang diberikan</li>
                            <li>Simpan email dari kami lalu tunjukkan saat check-in</li>
                            <li>Siap untuk check-in di hari festival</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ticket Types Section -->
    <section class="ticket-types">
        <div class="container">
            <h2 class="section-title">Kategori Tiket</h2>
            <div class="tickets-grid">
                <div class="ticket-card">
                    <h4>🌱 Regular</h4>
                    <div class="ticket-price">Rp 150.000</div>
                    <ul class="ticket-features">
                        <li>Akses ke area festival</li>
                        <li>Akses ke semua panggung</li>
                        <li>Food court area</li>
                        <li>Free merchandise</li>
                        <li>Certificate kehadiran</li>
                    </ul>
                </div>

                <div class="ticket-card">
                    <h4>🌿 VIP</h4>
                    <div class="ticket-price">Rp 350.000</div>
                    <ul class="ticket-features">
                        <li>Semua fasilitas Regular</li>
                        <li>Akses area VIP</li>
                        <li>Tempat duduk eksklusif</li>
                        <li>Welcome drink</li>
                        <li>VIP merchandise</li>
                        <li>Priority entrance</li>
                    </ul>
                </div>

                <div class="ticket-card premium">
                    <h4>🌳 VVIP</h4>
                    <div class="ticket-price">Rp 750.000</div>
                    <ul class="ticket-features">
                        <li>Semua fasilitas VIP</li>
                        <li>Meet & greet dengan artis</li>
                        <li>Photo session</li>
                        <li>Signed poster</li>
                        <li>Backstage access</li>
                        <li>Catering premium</li>
                        <li>Parking gratis</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Methods -->
    <section class="payment-section">
        <div class="container">
            <h2 class="section-title">Metode Pembayaran</h2>
            <div class="payment-grid">
                <div class="payment-method">
                    <span class="payment-icon">🏦</span>
                    <h4>Transfer Bank</h4>
                    <p>BCA, Mandiri, BNI, BRI, dan bank lainnya</p>
                </div>
                <div class="payment-method">
                    <span class="payment-icon">📱</span>
                    <h4>E-Wallet</h4>
                    <p>OVO, GoPay, DANA, LinkAja, ShopeePay</p>
                </div>
                <div class="payment-method">
                    <span class="payment-icon">💳</span>
                    <h4>Virtual Account</h4>
                    <p>Bayar melalui ATM atau mobile banking</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Concert Rules Section -->
    <section class="rules-section">
        <div class="container">
            <h2 class="section-title">🎵 Peraturan Selama Festival</h2>
            <div class="rules-grid">
                <div class="rules-category">
                    <h3>🚫 Barang Terlarang</h3>
                    <ul class="rules-list">
                        <li>Minuman beralkohol</li>
                        <li>Narkoba dan obat-obatan terlarang</li>
                        <li>Senjata tajam atau berbahaya</li>
                        <li>Kembang api dan petasan</li>
                        <li>Makanan dan minuman dari luar</li>
                        <li>Hewan peliharaan</li>
                        <li>Payung berukuran besar</li>
                        <li>Poster atau banner berukuran besar</li>
                    </ul>
                </div>
                
                <div class="rules-category">
                    <h3>✅ Peraturan Umum</h3>
                    <ul class="rules-list">
                        <li>Wajib memakai masker jika merasa tidak sehat</li>
                        <li>Menjaga kebersihan area festival</li>
                        <li>Tidak boleh merokok di area non-smoking</li>
                        <li>Patuhi instruksi dari security dan staff</li>
                        {{-- <li>Tidak diperbolehkan membawa anak dibawah 12 tahun</li> --}}
                        <li>Berpakaian sopan dan pantas</li>
                        <li>Dilarang melakukan tindakan asusila</li>
                        <li>Hormati artis dan pengunjung lain</li>
                    </ul>
                </div>

                <div class="rules-category">
                    <h3>📱 Aturan Foto & Video</h3>
                    <ul class="rules-list">
                        <li>Boleh foto untuk keperluan pribadi</li>
                        <li>Dilarang menggunakan flash yang mengganggu</li>
                        <li>Tidak boleh merekam untuk keperluan komersial</li>
                        <li>Dilarang livestreaming tanpa izin</li>
                        <li>Jangan menghalangi pandangan orang lain</li>
                        <li>Hormati privacy pengunjung lain</li>
                        <li>Gunakan mode silent pada ponsel</li>
                    </ul>
                </div>

                <div class="rules-category">
                    <h3>🏥 Keamanan & Keselamatan</h3>
                    <ul class="rules-list">
                        <li>Ikuti jalur evakuasi yang telah ditentukan</li>
                        <li>Laporkan situasi darurat ke security</li>
                        <li>Jangan tinggalkan barang berharga tanpa pengawasan</li>
                        <li>Tetap tenang jika terjadi keadaan darurat</li>
                        <li>Gunakan hand sanitizer yang disediakan</li>
                        <li>Jaga jarak aman saat berdesakan</li>
                        <li>Medical team tersedia di area yang telah ditentukan</li>
                    </ul>
                </div>

                <div class="rules-category">
                    <h3>🌱 Peduli Lingkungan</h3>
                    <ul class="rules-list">
                        <li>Buang sampah pada tempatnya</li>
                        <li>Gunakan tempat sampah sesuai jenisnya</li>
                        <li>Hemat penggunaan air</li>
                        <li>Jangan merusak tanaman atau fasilitas</li>
                        <li>Dukung program go-green kami</li>
                        <li>Bawa tumbler sendiri untuk mengurangi sampah plastik</li>
                        <li>Parkir kendaraan di area yang telah disediakan</li>
                    </ul>
                </div>

                <div class="rules-category">
                    <h3>🎪 Aturan Area Festival</h3>
                    <ul class="rules-list">
                        <li>Tiket VIP tidak bisa akses area VVIP</li>
                        <li>Tidak boleh berpindah area tanpa tiket yang sesuai</li>
                        <li>Re-entry hanya berlaku dengan cap tangan</li>
                        <li>Area VIP memiliki fasilitas terpisah</li>
                        <li>Food court terbuka untuk semua pengunjung</li>
                        <li>Merchandise booth tersedia di area utama</li>
                        <li>Lost & found tersedia di information center</li>
                    </ul>
                </div>
            </div>
            
            <div class="rules-warning">
                <h4>⚡ PERINGATAN PENTING</h4>
                <p>Pengunjung yang melanggar peraturan dapat dikeluarkan dari area festival tanpa pengembalian uang tiket. Keputusan panitia bersifat final dan tidak dapat diganggu gugat.</p>
                <p><strong>Hotline Darurat:</strong> 0811-2345-6789 (24 jam)</p>
            </div>
        </div>
    </section>

    <!-- Important Notes -->
    <section class="notes-section">
        <div class="container">
            <div class="notes-container">
                <h2>⚠️ Informasi Penting</h2>
                <div class="note-item">
                    <h4>🕐 Batas Waktu Pembayaran</h4>
                    <p>Selesaikan pembayaran dalam 24 jam setelah pemesanan. Pesanan akan otomatis dibatalkan jika melewati batas waktu.</p>
                </div>
                <div class="note-item">
                    <h4>🎫 Kebijakan Refund</h4>
                    <p>Tiket yang sudah dibeli tidak dapat dikembalikan kecuali event dibatalkan oleh penyelenggara.</p>
                </div>
                <div class="note-item">
                    <h4>📋 Syarat & Ketentuan</h4>
                    <p>Dengan membeli tiket, Anda menyetujui semua syarat dan ketentuan yang berlaku. Baca selengkapnya di website resmi.</p>
                </div>
                <div class="note-item">
                    <h4>🆔 Verifikasi Identitas</h4>
                    <p>Bawa KTP/identitas resmi saat check-in. Nama pada tiket harus sesuai dengan identitas yang dibawa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <a href="/tickets" class="cta-button">🎟️ Pesan Tiket Sekarang</a>
            <a href="/contact" class="cta-button secondary">💬 Butuh Bantuan?</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <h3>OURSKY.FEST 2025</h3>
            <p>Festival musik bertema alam yang menginspirasi</p>
            <p>📧 ourskyfestival@gmail.com | 📞 (031) 1234-5678</p>
            <br>
            <p style="color: var(--warm-taupe); font-size: 0.9rem;">
                © 2025 OURSKY.FEST. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
@endsection