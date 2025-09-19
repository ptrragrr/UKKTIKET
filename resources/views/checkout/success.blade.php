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
            <div class="leaf-decoration">
                <div class="leaf leaf-1">🍃</div>
                <div class="leaf leaf-2">🌿</div>
                <div class="leaf leaf-3">🍃</div>
                <div class="leaf leaf-4">🌿</div>
            </div>
        </div>

        <!-- Content -->
        <div class="success-content">
            <h1 class="success-title">Pembayaran Berhasil</h1>
            <div class="success-message">
                <p>Terima kasih! Pembayaran Anda sudah kami terima.</p>
                <p class="sub-message">Tiket akan segera dikirim ke email Anda seperti angin menyampaikan pesan.</p>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="icon-home"></i>
                    Kembali ke Beranda
                </a>
                {{-- <a href="{{ url('/tiket-saya') }}" class="btn btn-secondary">
                    <i class="icon-ticket"></i>
                    Lihat Tiket Saya
                </a> --}}
            </div>
        </div>

        <!-- Nature Decorative Elements -->
        <div class="nature-elements">
            <div class="floating-leaves">
                <div class="floating-leaf">🍃</div>
                <div class="floating-leaf">🌿</div>
                <div class="floating-leaf">🍃</div>
                <div class="floating-leaf">🌱</div>
                <div class="floating-leaf">🌿</div>
                <div class="floating-leaf">🍃</div>
            </div>
            <div class="grass-bottom"></div>
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
    /* background: linear-gradient(135deg, 
        #f0f9ff 0%, 
        #ecfdf5 25%, 
        #f0fdf4 50%, 
        #fefce8 75%, 
        #fffbeb 100%);
    overflow: hidden; */
}

.payment-success-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 80%, rgba(34, 197, 94, 0.1) 0%, transparent 25%),
        radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.1) 0%, transparent 25%),
        radial-gradient(circle at 40% 40%, rgba(168, 85, 247, 0.08) 0%, transparent 25%);
    pointer-events: none;
}

.success-container {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(34, 197, 94, 0.2);
    border-radius: 24px;
    padding: 3rem 2rem;
    max-width: 500px;
    width: 100%;
    text-align: center;
    box-shadow: 
        0 8px 32px rgba(34, 197, 94, 0.1),
        0 4px 16px rgba(0, 0, 0, 0.05),
        inset 0 1px 0 rgba(255, 255, 255, 0.5);
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
    z-index: 3;
}

.checkmark-svg {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: block;
    stroke-width: 2;
    stroke: #16a34a;
    stroke-miterlimit: 10;
    box-shadow: inset 0px 0px 0px #16a34a;
    animation: fill 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
}

.checkmark-circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 2;
    stroke-miterlimit: 10;
    stroke: #16a34a;
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark-check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    stroke: #16a34a;
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
        box-shadow: inset 0px 0px 0px 30px #16a34a;
    }
}

.success-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 140px;
    height: 140px;
    background: radial-gradient(circle, 
        rgba(34, 197, 94, 0.3) 0%, 
        rgba(74, 222, 128, 0.2) 30%,
        rgba(134, 239, 172, 0.1) 60%,
        transparent 80%);
    transform: translate(-50%, -50%);
    border-radius: 50%;
    animation: naturePulse 3s ease-in-out infinite;
    z-index: 1;
}

@keyframes naturePulse {
    0%, 100% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 0.8;
    }
    50% {
        transform: translate(-50%, -50%) scale(1.3);
        opacity: 0.4;
    }
}

.leaf-decoration {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 160px;
    height: 160px;
    transform: translate(-50%, -50%);
    z-index: 2;
}

.leaf {
    position: absolute;
    font-size: 1.2rem;
    animation: leafRotate 4s ease-in-out infinite;
}

.leaf-1 { 
    top: 10%; 
    left: 50%; 
    transform: translateX(-50%);
    animation-delay: 0s; 
}

.leaf-2 { 
    top: 50%; 
    right: 10%; 
    transform: translateY(-50%);
    animation-delay: 1s; 
}

.leaf-3 { 
    bottom: 10%; 
    left: 50%; 
    transform: translateX(-50%);
    animation-delay: 2s; 
}

.leaf-4 { 
    top: 50%; 
    left: 10%; 
    transform: translateY(-50%);
    animation-delay: 3s; 
}

@keyframes leafRotate {
    0%, 100% {
        transform: translate(-50%, -50%) rotate(0deg) scale(1);
        opacity: 0.7;
    }
    50% {
        transform: translate(-50%, -50%) rotate(180deg) scale(1.1);
        opacity: 1;
    }
}

.success-content {
    position: relative;
    z-index: 2;
}

.success-title {
    font-size: 2.25rem;
    font-weight: 700;
    background: linear-gradient(135deg, #15803d, #22c55e, #16a34a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.6s ease-out 0.3s both;
}

.success-message {
    margin-bottom: 2.5rem;
    animation: fadeInUp 0.6s ease-out 0.5s both;
}

.success-message p {
    font-size: 1.1rem;
    color: #374151;
    margin-bottom: 0.5rem;
    line-height: 1.6;
}

.sub-message {
    color: #65a30d !important;
    font-size: 1rem !important;
    font-style: italic;
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
    border-radius: 16px;
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
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s;
}

.btn:hover::before {
    left: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, #15803d 0%, #22c55e 50%, #16a34a 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: rgba(132, 204, 22, 0.1);
    color: #65a30d;
    border: 2px solid rgba(132, 204, 22, 0.3);
    backdrop-filter: blur(5px);
}

.btn-secondary:hover {
    background: rgba(132, 204, 22, 0.2);
    border-color: rgba(132, 204, 22, 0.5);
    transform: translateY(-2px);
    color: #4d7c0f;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(132, 204, 22, 0.2);
}

.nature-elements {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
}

.floating-leaves {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.floating-leaf {
    position: absolute;
    font-size: 1.2rem;
    animation: leafFloat 6s ease-in-out infinite;
    opacity: 0.6;
}

.floating-leaf:nth-child(1) { 
    top: 15%; 
    left: 10%; 
    animation-delay: 0s; 
    animation-duration: 5s;
}

.floating-leaf:nth-child(2) { 
    top: 25%; 
    right: 15%; 
    animation-delay: 1.5s; 
    animation-duration: 6s;
}

.floating-leaf:nth-child(3) { 
    top: 45%; 
    left: 5%; 
    animation-delay: 3s; 
    animation-duration: 7s;
}

.floating-leaf:nth-child(4) { 
    top: 65%; 
    right: 8%; 
    animation-delay: 4.5s; 
    animation-duration: 5.5s;
}

.floating-leaf:nth-child(5) { 
    top: 80%; 
    left: 12%; 
    animation-delay: 2s; 
    animation-duration: 6.5s;
}

.floating-leaf:nth-child(6) { 
    top: 85%; 
    right: 20%; 
    animation-delay: 6s; 
    animation-duration: 8s;
}

@keyframes leafFloat {
    0%, 100% {
        transform: translateY(0px) rotate(0deg) scale(1);
        opacity: 0.4;
    }
    25% {
        transform: translateY(-15px) rotate(45deg) scale(1.1);
        opacity: 0.8;
    }
    50% {
        transform: translateY(-25px) rotate(90deg) scale(0.9);
        opacity: 1;
    }
    75% {
        transform: translateY(-10px) rotate(135deg) scale(1.05);
        opacity: 0.6;
    }
}

.grass-bottom {
    position: absolute;
    bottom: -5px;
    left: 0;
    right: 0;
    height: 20px;
    background: linear-gradient(90deg, 
        transparent 0%, 
        rgba(132, 204, 22, 0.2) 10%,
        rgba(74, 222, 128, 0.3) 25%,
        rgba(34, 197, 94, 0.2) 50%,
        rgba(74, 222, 128, 0.3) 75%,
        rgba(132, 204, 22, 0.2) 90%,
        transparent 100%);
    border-radius: 0 0 20px 20px;
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

/* Icons with nature theme */
.icon-home::before {
    content: "🏡";
}

.icon-ticket::before {
    content: "🎋";
}

/* Responsive Design */
@media (max-width: 768px) {
    .payment-success-wrapper {
        padding: 3rem 1rem 2rem;
    }
    
    .success-container {
        padding: 2rem 1.5rem;
        margin: 1rem;
        border-radius: 20px;
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
    
    .leaf-decoration {
        width: 120px;
        height: 120px;
    }
    
    .leaf {
        font-size: 1rem;
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
        border-radius: 12px;
    }
    
    .success-glow {
        width: 100px;
        height: 100px;
    }
    
    .success-icon {
        width: 60px;
        height: 60px;
    }
    
    .checkmark-svg {
        width: 60px;
        height: 60px;
    }
}
</style>
@endsection