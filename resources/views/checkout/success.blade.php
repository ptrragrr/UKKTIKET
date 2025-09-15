@extends('layouts.app')

@section('content')
<div class="payment-success-wrapper">
    <div class="success-container">
        <!-- Animated Success Icon -->
        <div class="success-icon-wrapper">
            <div class="success-icon">
                <div class="checkmark">
                    <svg viewBox="0 0 52 52" class="checkmark-svg">
                        <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                        <path class="checkmark-check" fill="none" d="m14.1 27.2l7.1 7.2 16.7-16.8"/>
                    </svg>
                </div>
            </div>
            <div class="success-glow"></div>
        </div>

        <!-- Content -->
        <div class="success-content">
            <h1 class="success-title">Pembayaran Berhasil</h1>
            <div class="success-message">
                <p>Terima kasih! Pembayaran Anda sudah kami terima.</p>
                <p class="sub-message">Tiket akan segera dikirim ke email Anda.</p>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="icon-home"></i>
                    Kembali ke Beranda
                </a>
                <a href="{{ url('/tiket-saya') }}" class="btn btn-secondary">
                    <i class="icon-ticket"></i>
                    Lihat Tiket Saya
                </a>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="floating-particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
    </div>
</div>

<style>
.payment-success-wrapper {
    min-height: calc(100vh - 150px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 6rem 2rem 2rem;
    position: relative;
}

.success-container {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 3rem 2rem;
    max-width: 500px;
    width: 100%;
    text-align: center;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    position: relative;
    animation: slideUp 0.6s ease-out;
}

@keyframes slideUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.success-icon-wrapper {
    position: relative;
    margin-bottom: 2rem;
}

.success-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

.checkmark-svg {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: block;
    stroke-width: 2;
    stroke: #10b981;
    stroke-miterlimit: 10;
    box-shadow: inset 0px 0px 0px #10b981;
    animation: fill 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
}

.checkmark-circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 2;
    stroke-miterlimit: 10;
    stroke: #10b981;
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark-check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    stroke: #10b981;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes scale {
    0%, 100% {
        transform: none;
    }
    50% {
        transform: scale3d(1.1, 1.1, 1);
    }
}

@keyframes fill {
    100% {
        box-shadow: inset 0px 0px 0px 30px #10b981;
    }
}

.success-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 120px;
    height: 120px;
    background: radial-gradient(circle, rgba(16, 185, 129, 0.3) 0%, transparent 70%);
    transform: translate(-50%, -50%);
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
    z-index: 1;
}

@keyframes pulse {
    0%, 100% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 0.7;
    }
    50% {
        transform: translate(-50%, -50%) scale(1.2);
        opacity: 0.3;
    }
}

.success-content {
    position: relative;
    z-index: 2;
}

.success-title {
    font-size: 2.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.6s ease-out 0.3s both;
}

.success-message {
    margin-bottom: 2.5rem;
    animation: fadeInUp 0.6s ease-out 0.5s both;
}

.success-message p {
    font-size: 1.1rem;
    color: #4b5563;
    margin-bottom: 0.5rem;
    line-height: 1.6;
}

.sub-message {
    color: #6b7280 !important;
    font-size: 1rem !important;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    animation: fadeInUp 0.6s ease-out 0.7s both;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    border: none;
    cursor: pointer;
    font-size: 1rem;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn:hover::before {
    left: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: rgba(107, 114, 128, 0.1);
    color: #4b5563;
    border: 2px solid rgba(107, 114, 128, 0.2);
}

.btn-secondary:hover {
    background: rgba(107, 114, 128, 0.2);
    border-color: rgba(107, 114, 128, 0.4);
    transform: translateY(-1px);
    color: #374151;
    text-decoration: none;
}

.floating-particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
}

.particle {
    position: absolute;
    width: 6px;
    height: 6px;
    background: linear-gradient(45deg, #10b981, #3b82f6);
    border-radius: 50%;
    animation: float 3s ease-in-out infinite;
}

.particle:nth-child(1) { top: 20%; left: 20%; animation-delay: 0s; }
.particle:nth-child(2) { top: 60%; left: 80%; animation-delay: 1s; }
.particle:nth-child(3) { top: 80%; left: 30%; animation-delay: 2s; }
.particle:nth-child(4) { top: 30%; left: 70%; animation-delay: 0.5s; }
.particle:nth-child(5) { top: 70%; left: 10%; animation-delay: 1.5s; }
.particle:nth-child(6) { top: 10%; left: 90%; animation-delay: 2.5s; }

@keyframes float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.7;
    }
    50% {
        transform: translateY(-20px) rotate(180deg);
        opacity: 1;
    }
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Icons */
.icon-home::before {
    content: "🏠";
}

.icon-ticket::before {
    content: "🎫";
}

/* Responsive Design */
@media (max-width: 768px) {
    .payment-success-wrapper {
        padding: 3rem 1rem 2rem;
    }
    
    .success-container {
        padding: 2rem 1.5rem;
        margin: 1rem;
    }
    
    .success-title {
        font-size: 1.875rem;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .success-title {
        font-size: 1.75rem;
    }
    
    .success-message p {
        font-size: 1rem;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
    }
}
</style>
@endsection