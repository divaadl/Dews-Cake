@extends('layouts.user')

@section('title', 'Beranda | Dew’s Cake')

@section('style')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #f7a6b8;
            --primary-dark: #f28aa5;
            --primary-soft: #fde2e8;

            /* 🔥 SATU BACKGROUND SAJA */
            --bg-main: #fff8f5;

            --text-dark: #2f2f2f;
            --text-muted: #6b7280;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg-main);
            color: var(--text-dark);
        }

        section {
            padding: 90px 20px;
            background: var(--bg-main);
            position: relative;
            overflow: hidden;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        h1 {
            font-size: 36px;
            line-height: 1.3;
            margin-bottom: 18px;
        }

        h2 {
            font-size: 26px;
            margin-bottom: 14px;
        }

        p {
            font-size: 15px;
            line-height: 1.8;
            color: var(--text-muted);
        }

        

        /* ================= HERO ================= */
        .hero {
            background: linear-gradient(135deg, #fde2e8, #fff8f5);
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 40px;
            align-items: center;
        }

        .hero-image {
            display: flex;
            justify-content: flex-end;
            padding-right: 40px;
        }

        .hero-image img {
            width: 280px;
            height: 280px;
            object-fit: cover;
            border-radius: 50%;
            background: #fff;
            padding: 18px;
            box-shadow: 0 18px 40px rgba(247,166,184,0.45);
            transition: 
                transform 0.45s ease,
                box-shadow 0.45s ease,
                filter 0.45s ease;
        }

        .hero-image img:hover {
            transform: scale(1.08) rotate(-2deg);
            box-shadow: 0 26px 60px rgba(247,166,184,0.55);
            filter: brightness(1.05) saturate(1.1);
        }

        /* ================= GLOBAL BRAND TEXT ================= */
        .brand {
            font-family: 'Pacifico', cursive;
            letter-spacing: 1.1px;
            font-weight: 400;
        }

        .brand.glow {
            text-shadow: 
                0 2px 5px rgba(0,0,0,0.18),
                0 0 12px rgba(247,166,184,0.45);
        }

        .brand-text {
            font-family: 'Pacifico', cursive;
            font-size: 42px;
            font-weight: 400;
            color: #d45c7a;
            letter-spacing: 1.2px;
            text-shadow: 
                0 3px 6px rgba(0,0,0,0.18),
                0 0 14px rgba(247,166,184,0.55);
        }

        /* ================= ABOUT ================= */
        .section-about {
            background:
                linear-gradient(
                    180deg,
                    #fff5f7 0%,
                    rgba(245, 245, 245, 0.9) 100%
                ),
                url("/images/coklat.jpeg");

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .about-content {
            max-width: 720px;
            margin: auto;
            text-align: center;
        }

        .about-title {
            font-size: 28px;
            font-weight: 600;
            color: #8b3f52;
        }

        .about-punchline {
            font-size: 19px;
            font-weight: 600;
            color: #c08497;
            margin-bottom: 18px;
        }

        .about-text {
            color: #4b5563;
            line-height: 1.9;
        }

        .about-text strong {
            color: #b4536a;
        }

        .about-highlight {
            color: #8b5e3c;
            font-weight: 500;
        }

        /* ================= PREORDER ================= */
        .section-cream {
            background: linear-gradient(
                180deg,
                #fff8f5 0%,
                #fde2e8 100%
            );
        }

        .preorder-box {
            max-width: 820px;
            margin: auto;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(4px);
            padding: 42px 36px;
            border-radius: 26px;
            box-shadow: 0 18px 40px rgba(247,166,184,0.25);
            text-align: center;
        }

        .preorder-box h2 {
            color: #8b3f52;
            font-size: 28px;
            margin-bottom: 14px;
        }

        .preorder-box p {
            font-size: 15px;
            line-height: 1.9;
            max-width: 620px;
            margin: auto;
        }

        .preorder-highlight {
            margin-top: 26px;
            display: flex;
            justify-content: center;
            gap: 22px;
            flex-wrap: wrap;
        }

        .preorder-item {
            background: #fff;
            padding: 18px 22px;
            border-radius: 18px;
            box-shadow: 0 10px 26px rgba(0,0,0,0.06);
            font-size: 14px;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .preorder-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-soft);
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .preorder-note {
            margin-top: 22px;
            font-size: 14px;
            color: #8b5e3c;
            background: #fff1e6;
            padding: 12px 18px;
            border-radius: 14px;
            display: inline-block;
        }

        /* ================= FLEX ================= */
        .flex {
            display: flex;
            gap: 40px;
            align-items: center;
        }

        .image-box {
            height: 260px;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 16px 36px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
        }

        /* ================= BUTTON ================= */
        .btn {
            display: inline-block;
            padding: 14px 28px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: 0.25s;
        }

        .btn:hover {
            transform: translateY(-3px);
            opacity: 0.95;
        }

        /* ================= ORDER FLOW ================= */
        .section-order {
            background: linear-gradient(
                180deg,
                #fff8f5 0%,
                #fde2e8 100%
            );
        }

        .order-header {
            text-align: center;
            max-width: 680px;
            margin: auto;
        }

        .order-header h2 {
            font-size: 30px;
            font-weight: 600;
            color: #8b3f52;
            margin-bottom: 10px;
        }

        .order-header p {
            font-size: 16px;
            line-height: 1.9;
            color: #6b7280;
        }

        .order-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 56px;
        }

        .order-step {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(4px);
            border-radius: 26px;
            padding: 38px 28px;
            box-shadow: 0 18px 40px rgba(247,166,184,0.28);
            text-align: center;
            transition: 0.35s ease;
        }

        .order-step:hover {
            transform: translateY(-10px);
            box-shadow: 0 26px 56px rgba(247,166,184,0.45);
        }

        .order-badge {
            width: 56px;
            height: 56px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: linear-gradient(
                135deg,
                var(--primary),
                var(--primary-dark)
            );
            color: #fff;
            font-weight: 700;
            font-size: 17px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .order-title {
            font-size: 17px;
            font-weight: 600;
            color: #8b3f52;
            margin-bottom: 10px;
        }

        .order-desc {
            font-size: 15px;
            line-height: 1.85;
            color: #6b7280;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .order-steps {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .order-steps {
                grid-template-columns: 1fr;
            }

            .order-header h2 {
                font-size: 26px;
            }
        }

        /* ================= MENU & LOCATION ================= */
        .section-feature {
            background: linear-gradient(
                180deg,
                #fde2e8 0%,
                #fff8f5 100%
            );
        }

        .feature-box {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 48px;
            align-items: center;
        }

        .feature-text h2 {
            font-size: 28px;
            color: #8b3f52;
            margin-bottom: 12px;
        }

        .feature-text p {
            font-size: 16px;
            line-height: 1.9;
            max-width: 420px;
        }

        .feature-highlight {
            margin-top: 18px;
            font-size: 14px;
            color: #b4536a;
            font-weight: 500;
        }

        .feature-image.landscape {
            width: 100%;
            max-width: 560px;
            aspect-ratio: 16 / 10;
            border-radius: 28px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 12px 32px rgba(0,0,0,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature-image.landscape img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.4s ease;
        }

        .feature-image.landscape:hover img {
            transform: scale(1.04);
        }

        /* BALIK POSISI UNTUK LOKASI */
        .feature-reverse {
            grid-template-columns: 0.9fr 1.1fr;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .feature-box,
            .feature-reverse {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .feature-text p {
                margin: auto;
            }
        }


        @media (max-width: 900px) {
            .hero-content,
            .flex {
                flex-direction: column;
                text-align: center;
            }

            .steps {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-image {
                justify-content: center;
                padding-right: 0;
            }
        }

        @media (max-width: 500px) {
            h1 {
                font-size: 28px;
            }

            .steps {
                grid-template-columns: 1fr;
            }
        }

        /* ================= DECORATIVE SHAPES ================= */
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.35;
            filter: blur(40px);
            z-index: 0;
        }

        .shape.pink {
            background: #f7a6b8;
        }

        .shape.soft {
            background: #fde2e8;
        }

        /* POSISI SHAPE */
        .shape.hero-1 {
            width: 220px;
            height: 220px;
            top: -60px;
            left: -60px;
        }

        .shape.hero-2 {
            width: 280px;
            height: 280px;
            bottom: -90px;
            right: -90px;
        }

        .shape.about-1 {
            width: 200px;
            height: 200px;
            top: 30%;
            right: -80px;
        }

        /* ================= WAVE ================= */
        .wave {
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .wave svg {
            width: 100%;
            height: 90px;
            display: block;
        }

        /* ================= HERO RESPONSIVE FIX ================= */
        @media (max-width: 900px) {

            .hero {
                padding-top: 70px;
                padding-bottom: 60px;
            }

            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-image {
                justify-content: center;
                padding-right: 0;
                margin-top: 30px;
            }

            .hero-image img {
                width: 220px;
                height: 220px;
                padding: 14px;
            }

            /* kecilkan shape agar tidak motong */
            .shape.hero-1 {
                width: 160px;
                height: 160px;
                top: -40px;
                left: -40px;
            }

            .shape.hero-2 {
                width: 200px;
                height: 200px;
                bottom: -60px;
                right: -60px;
            }
        }

        /* EXTRA SMALL PHONE */
        @media (max-width: 480px) {

            .hero {
                padding-top: 60px;
                padding-bottom: 50px;
            }

            h1 {
                font-size: 26px;
            }

            .hero-image img {
                width: 180px;
                height: 180px;
            }
        }


    </style>
    @endsection

@section('content')

<section class="hero">
    <div class="shape pink hero-1"></div>
    <div class="shape soft hero-2"></div>
    <div class="container hero-content">
        <div>
            <h1>Selamat Datang di <span class="brand-text">Dew’s Cake</span></h1>
            <p>Dew’s Cake menghadirkan berbagai pilihan kue dan dessert dengan sistem preorder agar selalu fresh.</p>
        </div>
        <div class="hero-image">
            <img src="/images/logo.jpeg" alt="Logo Dew's Cake">
        </div>
    </div>
</section>

<section class="section-about">
    <div class="shape soft about-1"></div>
    <div class="container">
        <div class="about-content">

            <h2 class="about-title">
                Tentang <span class="brand" style="color:#b4536a;">Dew’s Cake</span>
            </h2>

            <div class="about-punchline">
                Dibuat dengan cinta, disajikan dengan rasa 🍰
            </div>

            <p class="about-text">
                <strong class="brand">Dew’s Cake</strong> adalah usaha rumahan yang
                menghadirkan aneka kue dan dessert untuk
                <span class="about-highlight">
                    setiap momen spesial
                </span>.
                Kami percaya bahwa kue bukan hanya tentang rasa,
                tetapi juga tentang
                <strong>kenangan dan kebahagiaan</strong>.
            </p>

            <p class="about-text" style="margin-top:14px;">
                Oleh karena itu, setiap pesanan dibuat secara
                <strong>fresh melalui sistem preorder</strong>,
                menggunakan bahan pilihan, dan diproses dengan
                perhatian penuh pada detail.
            </p>

        </div>
    </div>
</section>

<section class="section-cream">
    <div class="container">
        <div class="preorder-box">

            <h2>Sistem Preorder</h2>
            <p>
                Untuk menjaga kualitas dan rasa terbaik,
                <strong class="brand">Dew’s Cake</strong> menerapkan sistem preorder.
                Setiap kue dibuat setelah pesanan diterima,
                sehingga selalu fresh dan dibuat dengan perhatian penuh.
            </p>

            <p style="margin-top:14px;">
                Pemesanan dilakukan
                <strong>paling lambat H-5</strong>
                sebelum tanggal pengambilan atau acara,
                agar proses produksi dapat berjalan maksimal.
            </p>

            <div class="preorder-highlight">
                <div class="preorder-item">
                    <div class="preorder-icon">⏰</div>
                    Fresh setiap pesanan
                </div>
                <div class="preorder-item">
                    <div class="preorder-icon">🎂</div>
                    Dibuat sesuai request
                </div>
                <div class="preorder-item">
                    <div class="preorder-icon">✨</div>
                    Kualitas terjaga
                </div>
            </div>

            <div class="preorder-note">
                ⏳ Batas pemesanan maksimal H-5 sebelum kue diambil / acara berlangsung
            </div>

        </div>
    </div>
</section>

<section class="section-order">
    <div class="container">

        <div class="order-header">
            <h2>Cara Pemesanan</h2>
            <p>
                Kami ingin proses pemesanan terasa mudah dan menyenangkan.
                Ikuti langkah sederhana berikut untuk mendapatkan kue terbaik
                dari <strong class="brand">Dew’s Cake</strong>.
            </p>
        </div>

        <div class="order-steps">

            <div class="order-step">
                <div class="order-badge">1</div>
                <div class="order-title">Tentukan Menu Favorit</div>
                <div class="order-desc">
                    Pilih kue atau dessert sesuai
                    kebutuhan acara spesial Anda.
                </div>
            </div>

            <div class="order-step">
                <div class="order-badge">2</div>
                <div class="order-title">Lakukan Pemesanan</div>
                <div class="order-desc">
                    Pesan melalui website dan
                    tentukan tanggal pengambilan kue.
                </div>
            </div>

            <div class="order-step">
                <div class="order-badge">3</div>
                <div class="order-title">Proses Preorder</div>
                <div class="order-desc">
                    Pesanan dibuat fresh dari awal
                    sesuai jadwal preorder (H-5).
                </div>
            </div>

            <div class="order-step">
                <div class="order-badge">4</div>
                <div class="order-title">Kue Siap Diambil</div>
                <div class="order-desc">
                    Pesanan siap diambil
                    dengan rasa dan kualitas terbaik.
                </div>
            </div>

        </div>

    </div>
</section>

<!-- WAVE PINK -->
<div class="wave">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
        <path
            d="M0,40 
               C120,80 240,0 360,20 
               480,40 600,80 720,60 
               840,40 960,0 1080,10 
               1200,20 1320,40 1440,30 
               L1440,0 L0,0 Z"
            fill="#fde2e8">
        </path>
    </svg>
</div>

<section class="section-feature">
    <div class="container feature-box">

        <div class="feature-text">
            <h2>Menu Kami</h2>
            <p>
                Kami menghadirkan berbagai pilihan
                <strong>kue dan dessert homemade</strong>
                yang cocok untuk ulang tahun,
                acara keluarga, maupun momen spesial lainnya.
            </p>

            <div class="feature-highlight">
                🎂 Dibuat fresh • Bisa custom • Rasa premium
            </div>

            <a href="/menu" class="btn" style="margin-top:26px;">
                Lihat Menu
            </a>
        </div>

        <div class="feature-image">
            Foto menu unggulan Dew’s Cake
        </div>

    </div>
</section>

<section class="section-feature">
    <div class="container feature-box feature-reverse">

        <div class="feature-image landscape">
            <img src="/images/antar-roti.jpg" alt="Lokasi Pengambilan Dew’s Cake">
        </div>

        <div class="feature-text">
            <h2>Lokasi Pengambilan</h2>
            <p>
                Pengambilan pesanan dilakukan
                di lokasi <strong class="brand">Dew’s Cake</strong> sesuai
                jadwal preorder yang telah ditentukan,
                sehingga pesanan tetap fresh saat diterima.
            </p>

            <div class="feature-highlight">
                📍 Lokasi mudah dijangkau • Ambil sesuai jadwal
            </div>

            <a href="/lokasi" class="btn" style="margin-top:26px;">
                Lihat Lokasi
            </a>
        </div>

    </div>
</section>

@endsection