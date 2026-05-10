@extends('layouts.user')

@section('title', 'Pesanan Berhasil - Dew\'s Cake')

@section('style')
<style>
    :root {
        --primary-pink: #f7a6b8;
        --secondary-pink: #f28aa5;
        --accent-pink: #be185d;
    }

    .success-page-container {
        min-height: calc(100vh - 250px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        perspective: 1000px;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 40px;
        padding: 60px 40px;
        width: 100%;
        max-width: 600px;
        text-align: center;
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.1);
        animation: slideInUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(50px) rotateX(-5deg); }
        to { opacity: 1; transform: translateY(0) rotateX(0); }
    }

    .success-icon-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 30px;
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    .success-icon-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #fce7f3, #fbcfe8);
        border-radius: 40px;
        transform: rotate(15deg);
        z-index: 1;
    }

    .success-icon {
        position: relative;
        z-index: 2;
        font-size: 80px;
        line-height: 120px;
    }

    .success-content h2 {
        font-size: 32px;
        font-weight: 800;
        color: #8b3f52;
        margin-bottom: 15px;
        letter-spacing: -0.5px;
    }

    .success-content p {
        color: #6b7280;
        font-size: 16px;
        line-height: 1.7;
        margin-bottom: 40px;
        max-width: 450px;
        margin-inline: auto;
    }

    .nav-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
        width: 100%;
        max-width: 100%;
    }

    .btn-action {
        flex: 1;
        max-width: 220px;
        padding: 16px 20px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-sizing: border-box;
    }

    .btn-primary {
        background: linear-gradient(135deg, #f7a6b8, #f28aa5);
        color: #fff;
        box-shadow: 0 10px 25px rgba(242, 138, 165, 0.4);
    }

    .btn-secondary {
        background: #fff;
        color: #8b3f52;
        border: 2px solid #fce7f3;
    }

    .btn-action:hover {
        transform: translateY(-5px);
    }

    .btn-primary:hover {
        box-shadow: 0 15px 30px rgba(242, 138, 165, 0.5);
    }

    .btn-secondary:hover {
        background: #fff1f2;
        border-color: var(--primary-pink);
    }


    @media (max-width: 640px) {
        .success-page-container {
            padding: 20px 15px;
        }

        .glass-card {
            padding: 40px 20px;
            border-radius: 30px;
        }

        .success-icon-wrapper {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
        }

        .success-icon {
            font-size: 60px;
            line-height: 100px;
        }

        .success-content h2 { 
            font-size: 24px; 
            letter-spacing: -0.3px;
        }
        
        .success-content p { 
            font-size: 14px; 
            margin-bottom: 30px;
        }

        .nav-actions {
            flex-direction: column;
            gap: 12px;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
            padding: 14px 20px;
        }
    }
</style>
@endsection

@section('content')

<div class="success-page-container">
    <div class="glass-card">
        <div class="success-icon-wrapper">
            <div class="success-icon-bg"></div>
            <div class="success-icon">🎉</div>
        </div>

        <div class="success-content">
            <h2>Yay, Pesanan Berhasil!</h2>
            <p>
                Terima kasih sudah memesan di <strong>Dew's Cake</strong>. 🍰<br>
                Data pesanan Anda sudah kami simpan. Kami akan segera memproses kelezatan pesanan Anda setelah pembayaran terkonfirmasi.
            </p>
        </div>

        <div class="nav-actions">
            <a href="{{ route('pesanan.saya') }}" class="btn-action btn-secondary">
                <i class="fa-solid fa-receipt"></i> Lihat Pesanan
            </a>
            <a href="{{ route('beranda') }}" class="btn-action btn-primary">
                <i class="fa-solid fa-house"></i> Ke Beranda
            </a>
        </div>
    </div>
</div>

@endsection
