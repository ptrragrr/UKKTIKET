<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OURSKY.FEST - Modern Navigation</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #1C290D;
            --sage-green: #676F53;
            --warm-beige: #B3B49A;
            --cream: #FEFAE0;
            --taupe: #A19379;
            --brown: #736046;
            --dark-brown: #381D03;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--cream) 0%, var(--warm-beige) 100%);
            min-height: 100vh;
        }

        .navbar-custom {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--sage-green) 100%);
            backdrop-filter: blur(10px);
            border-bottom: 3px solid var(--brown);
            box-shadow: 0 8px 32px rgba(28, 41, 13, 0.3);
            transition: all 0.3s ease;
            padding: 1rem 0;
        }

        .navbar-custom:hover {
            box-shadow: 0 12px 40px rgba(28, 41, 13, 0.4);
        }

        .navbar-brand {
            font-size: 2.2rem !important;
            font-weight: 800 !important;
            color: var(--cream) !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            letter-spacing: 2px;
            position: relative;
            overflow: hidden;
        }

        .navbar-brand::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(254, 250, 224, 0.3), transparent);
            transition: left 0.5s;
        }

        .navbar-brand:hover::before {
            left: 100%;
        }

        .navbar-brand:hover {
            color: var(--cream) !important;
            transform: translateY(-2px);
        }

        .nav-link {
            color: var(--cream) !important;
            font-weight: 600;
            font-size: 1.1rem;
            margin: 0 0.5rem;
            padding: 0.8rem 1.5rem !important;
            border-radius: 50px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--taupe), var(--brown));
            transition: left 0.3s ease;
            z-index: -1;
        }

        .nav-link:hover::before {
            left: 0;
        }

        .nav-link:hover {
            color: var(--cream) !important;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(115, 96, 70, 0.4);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--brown), var(--dark-brown));
            color: var(--cream) !important;
            box-shadow: 0 4px 15px rgba(56, 29, 3, 0.5);
        }

        .navbar-toggler {
            border: 2px solid var(--cream);
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navbar-toggler:hover {
            background-color: var(--brown);
            transform: rotate(180deg);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23FEFAE0' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .hero-section {
            padding: 150px 0 100px;
            text-align: center;
            background: linear-gradient(45deg, var(--cream), var(--warm-beige), var(--taupe));
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 900;
            color: var(--primary-green);
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(28, 41, 13, 0.2);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            color: var(--sage-green);
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .cta-button {
            background: linear-gradient(135deg, var(--primary-green), var(--sage-green));
            color: var(--cream);
            padding: 1rem 3rem;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(28, 41, 13, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(28, 41, 13, 0.4);
            color: var(--cream);
        }

        .color-showcase {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin: 3rem 0;
            flex-wrap: wrap;
        }

        .color-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .color-circle:hover {
            transform: scale(1.1) translateY(-5px);
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem !important;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .nav-link {
                margin: 0.2rem 0;
                text-align: center;
            }
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .floating-element {
            position: absolute;
            width: 20px;
            height: 20px;
            background: var(--sage-green);
            border-radius: 50%;
            opacity: 0.3;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) { left: 10%; animation-delay: 0s; }
        .floating-element:nth-child(2) { left: 20%; animation-delay: 1s; }
        .floating-element:nth-child(3) { left: 35%; animation-delay: 2s; }
        .floating-element:nth-child(4) { right: 35%; animation-delay: 3s; }
        .floating-element:nth-child(5) { right: 20%; animation-delay: 4s; }
        .floating-element:nth-child(6) { right: 10%; animation-delay: 5s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold me-auto" href="#">
                <i class="fas fa-music me-2"></i>OURSKY.FEST
            </a>

            <button class="navbar-toggler" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#navbarNav" 
        aria-controls="navbarNav" 
        aria-expanded="false" 
        aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
            
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tickets') }}">
                            <i class="fas fa-ticket-alt me-1"></i>Tiket
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">
                            <i class="fas fa-users me-1"></i>About Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-1"></i>Contact
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- <section class="hero-section position-relative">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        
        <!-- <div class="container">
            <h1 class="hero-title">Selamat Datang di OURSKY.KONSER</h1>
            <p class="hero-subtitle">Temukan pengalaman konser terbaik dengan desain yang memukau</p>
            <a href="#" class="cta-button">
                <i class="fas fa-play me-2"></i>Jelajahi Sekarang
            </a> -->
            
            <!-- <div class="color-showcase">
                <div class="color-circle" style="background-color: #1C290D;" title="Primary Green - #1C290D">
                    <span style="font-size: 0.7rem;">PRIMARY<br>GREEN</span>
                </div>
                <div class="color-circle" style="background-color: #676F53;" title="Sage Green - #676F53">
                    <span style="font-size: 0.7rem;">SAGE<br>GREEN</span>
                </div>
                <div class="color-circle" style="background-color: #B3B49A;" title="Warm Beige - #B3B49A">
                    <span style="font-size: 0.7rem; color: #333;">WARM<br>BEIGE</span>
                </div>
                <div class="color-circle" style="background-color: #FEFAE0;" title="Cream - #FEFAE0">
                    <span style="font-size: 0.7rem; color: #333;">CREAM</span>
                </div>
                <div class="color-circle" style="background-color: #A19379;" title="Taupe - #A19379">
                    <span style="font-size: 0.7rem;">TAUPE</span>
                </div>
                <div class="color-circle" style="background-color: #736046;" title="Brown - #736046">
                    <span style="font-size: 0.7rem;">BROWN</span>
                </div>
                <div class="color-circle" style="background-color: #381D03;" title="Dark Brown - #381D03">
                    <span style="font-size: 0.7rem;">DARK<br>BROWN</span>
                </div>
            </div> -->
        <!-- </div> -->
    <!-- </section> --> 

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add smooth scrolling and interactive effects
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Remove active class from all links
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                // Add active class to clicked link
                this.classList.add('active');
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.style.background = 'linear-gradient(135deg, rgba(28, 41, 13, 0.95), rgba(103, 111, 83, 0.95))';
            } else {
                navbar.style.background = 'linear-gradient(135deg, var(--primary-green), var(--sage-green))';
            }
        });

        // Color circle interactions
        document.querySelectorAll('.color-circle').forEach(circle => {
            circle.addEventListener('click', function() {
                const color = this.style.backgroundColor;
                const colorName = this.getAttribute('title');
                
                // Create a temporary notification
                const notification = document.createElement('div');
                notification.textContent = `Copied: ${colorName}`;
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: var(--primary-green);
                    color: var(--cream);
                    padding: 1rem 2rem;
                    border-radius: 50px;
                    z-index: 9999;
                    font-weight: bold;
                    box-shadow: 0 8px 25px rgba(28, 41, 13, 0.3);
                    animation: slideIn 0.3s ease;
                `;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 2000);
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
// Script gabungan yang benar - ganti semua script yang ada dengan ini
document.addEventListener('DOMContentLoaded', function() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const navLinks = document.querySelectorAll('.nav-link');

    // Fungsi untuk menutup navbar (hanya di mobile)
    function closeNavbarIfMobile() {
        if (navbarToggler && window.getComputedStyle(navbarToggler).display !== 'none') {
            const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse) || new bootstrap.Collapse(navbarCollapse, {
                toggle: false
            });
            bsCollapse.hide();
        }
    }

    // Handle nav link clicks - gabungan active class dan close navbar
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove active class from all links
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            // Add active class to clicked link
            this.classList.add('active');
            
            // Close navbar if in mobile mode
            closeNavbarIfMobile();
        });
    });

    // Tutup navbar saat klik di luar navbar
    document.addEventListener('click', function(event) {
        const navbar = document.querySelector('.navbar');
        
        if (navbar && navbarCollapse && navbarToggler) {
            const isClickInsideNavbar = navbar.contains(event.target);
            const isNavbarOpen = navbarCollapse.classList.contains('show');
            const isTogglerVisible = window.getComputedStyle(navbarToggler).display !== 'none';
            
            if (!isClickInsideNavbar && isNavbarOpen && isTogglerVisible) {
                const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse) || new bootstrap.Collapse(navbarCollapse, {
                    toggle: false
                });
                bsCollapse.hide();
            }
        }
    });

    // Add scroll effect to navbar
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar-custom');
        if (window.scrollY > 50) {
            navbar.style.background = 'linear-gradient(135deg, rgba(28, 41, 13, 0.95), rgba(103, 111, 83, 0.95))';
        } else {
            navbar.style.background = 'linear-gradient(135deg, var(--primary-green), var(--sage-green))';
        }
    });

    // Color circle interactions
    document.querySelectorAll('.color-circle').forEach(circle => {
        circle.addEventListener('click', function() {
            const color = this.style.backgroundColor;
            const colorName = this.getAttribute('title');
            
            const notification = document.createElement('div');
            notification.textContent = `Copied: ${colorName}`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--primary-green);
                color: var(--cream);
                padding: 1rem 2rem;
                border-radius: 50px;
                z-index: 9999;
                font-weight: bold;
                box-shadow: 0 8px 25px rgba(28, 41, 13, 0.3);
                animation: slideIn 0.3s ease;
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 2000);
        });
    });
});
</script>
</body>
</html>