<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dew’s Cake')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #fff8f5;
            color: #2f2f2f;
        }

        a {
            text-decoration: none;
        }

        /* ================= NAVBAR ================= */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 999;
            background: rgba(255, 250, 248, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .nav-container {
            max-width: 1100px;
            margin: auto;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .nav-logo {
            font-family: 'Pacifico', cursive;
            font-size: 28px;
            color: #d45c7a;
            white-space: nowrap;
        }

        .nav-menu {
            flex: 1;
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .nav-menu a {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
            position: relative;
        }

        .nav-menu a.active,
        .nav-menu a:hover {
            color: #d45c7a;
            font-weight: 600;
        }

        .nav-login a {
            padding: 10px 22px;
            border-radius: 16px;
            background: linear-gradient(135deg, #f7a6b8, #f28aa5);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
        }

        /* Hamburger */
        .nav-toggle {
            display: none;
            font-size: 26px;
            cursor: pointer;
            color: #d45c7a;
            margin-left: auto;
        }

        /* ================= MOBILE MENU ================= */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 70px;
            left: 0;
            right: 0;
            background: rgba(255, 248, 245, 0.98);
            backdrop-filter: blur(12px);
            padding: 24px;
            flex-direction: column;
            gap: 18px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.15);
            z-index: 998;
        }

        .mobile-menu a {
            font-size: 16px;
            font-weight: 500;
            color: #6b7280;
        }

        .mobile-menu a:hover {
            color: #d45c7a;
        }

        .mobile-login {
            margin-top: 10px;
            padding: 12px;
            text-align: center;
            border-radius: 18px;
            background: linear-gradient(135deg, #f7a6b8, #f28aa5);
            color: #fff !important;
            font-weight: 600;
        }

        /* ================= FOOTER ================= */
        .footer {
            background: linear-gradient(180deg, #8b3f52, #6f2f40);
            color: #fdecef;
            padding: 70px 0 30px;
            margin-top: 100px;
        }

        .footer-container {
            max-width: 1100px;
            margin: auto;
            padding: 0 20px;
        }

        .footer-main {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr;
            gap: 50px;
        }

        .footer-brand h3 {
            font-family: 'Pacifico', cursive;
            font-size: 34px;
            color: #fff;
        }

        .footer-brand p {
            font-size: 14px;
            line-height: 1.8;
            color: #f7d4dc;
        }

        .footer h4 {
            margin-bottom: 14px;
            font-size: 16px;
            color: #fff;
        }

        .footer-social a,
        .footer-info .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #f7d4dc;
            margin-bottom: 10px;
        }

        .footer-social i,
        .footer-info i {
            font-size: 16px;
            color: #ffd1db;
        }

        /* Hover effect */
        .footer-social a:hover {
            color: #ffffff;
        }

        .footer-social a:hover i {
            color: #ffffff;
        }


        .footer-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
            margin: 40px 0 20px;
        }

        .footer-bottom {
            text-align: center;
            font-size: 13px;
            color: #f7d4dc;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 900px) {

            .nav-menu,
            .nav-login {
                display: none;
            }

            .nav-toggle {
                display: block;
            }

            .footer-main {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-social a {
                justify-content: center;
            }
        }

        .footer-halal {
            margin-top: 16px;
        }

        .footer-halal img {
            width: 90px;
            height: auto;
            background: #fff;
            padding: 6px 8px;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }

        /* Center di mobile */
        @media (max-width: 900px) {
            .footer-halal {
                display: flex;
                justify-content: center;
            }
        }

        /* ================= ACCOUNT DROPDOWN (PREMIUM) ================= */
        .account-dropdown {
            position: relative;
        }

        .account-trigger {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 14px;
            padding-left: 6px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 92, 122, 0.15);
            color: #d45c7a;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 12px rgba(212, 92, 122, 0.08);
        }

        .account-trigger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 92, 122, 0.15);
            background: #fff;
            border-color: #d45c7a;
        }

        .avatar-initial {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #f7a6b8, #f28aa5);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            box-shadow: 0 4px 8px rgba(247, 166, 184, 0.4);
        }

        .account-trigger .fa-chevron-down {
            font-size: 10px;
            transition: transform 0.3s ease;
        }

        .account-dropdown:hover .fa-chevron-down {
            transform: rotate(180deg);
        }

        .account-menu {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 22px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
            min-width: 240px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            opacity: 0;
            transform: translateY(15px) scale(0.95);
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            z-index: 1000;
            padding: 10px;
        }

        .account-dropdown:hover .account-menu {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        /* Hover Bridge to prevent closing on gap */
        .account-menu::before {
            content: '';
            position: absolute;
            top: -15px;
            left: 0;
            right: 0;
            height: 15px;
            background: transparent;
        }

        .menu-header {
            padding: 15px;
            padding-bottom: 12px;
            margin-bottom: 8px;
            border-bottom: 1px solid rgba(212, 92, 122, 0.1);
        }

        .user-info-name {
            display: block;
            font-weight: 800;
            color: #d45c7a;
            font-size: 14px;
            line-height: 1.2;
        }

        .user-info-email {
            display: block;
            font-size: 11px;
            color: #9ca3af;
            margin-top: 4px;
        }

        .account-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            font-size: 13px;
            color: #4b5563;
            border-radius: 14px;
            transition: all 0.2s ease;
            margin-bottom: 2px;
        }

        .menu-icon-box {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .link-profile .menu-icon-box {
            background: #fdf2f8;
            color: #db2777;
        }

        .link-logout .menu-icon-box {
            background: #fef2f2;
            color: #ef4444;
        }

        .account-menu a:hover {
            background: rgba(212, 92, 122, 0.05);
            color: #d45c7a;
            transform: translateX(5px);
        }

        .account-menu a:hover .menu-icon-box {
            transform: scale(1.1);
        }

        .link-logout:hover {
            background: #fff1f2 !important;
            color: #ef4444 !important;
        }

        /* ===== MOBILE ACCOUNT MENU ===== */
        .mobile-account-wrapper {
            margin-top: 16px;
            padding-top: 18px;
            border-top: 1px solid #f3c6d2;
        }

        .mobile-account-name {
            background: #fdecef;
            color: #d45c7a;
            padding: 14px 16px;
            border-radius: 18px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 14px;
            text-align: center;
        }

        .mobile-account-menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mobile-account-menu a {
            padding: 14px 16px;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 500;
            text-align: center;
        }

        .mobile-account-menu .akun-link {
            background: #fff;
            color: #6b7280;
            border: 1px solid #f3c6d2;
        }

        .mobile-account-menu .akun-link:hover {
            background: #fdecef;
            color: #d45c7a;
        }

        .mobile-account-menu .logout-link {
            background: #fff;
            color: #ef4444;
            border: 1px solid #fecaca;
        }

        .mobile-account-menu .logout-link:hover {
            background: #fee2e2;
        }

        /* ================= SWEETALERT CUSTOM ================= */
        .swal2-popup {
            border-radius: 28px !important;
            padding: 2rem !important;
            font-family: 'Poppins', sans-serif !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1) !important;
        }

        .swal2-title {
            color: #8b3f52 !important;
            font-weight: 700 !important;
            font-size: 22px !important;
        }

        .swal2-html-container {
            color: #6b7280 !important;
            font-size: 14px !important;
            line-height: 1.6 !important;
        }

        .swal2-confirm {
            background: linear-gradient(135deg, #f7a6b8, #f28aa5) !important;
            border-radius: 14px !important;
            padding: 12px 30px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            box-shadow: 0 8px 20px rgba(247, 166, 184, 0.4) !important;
        }

        .swal2-cancel {
            background: #f3f4f6 !important;
            color: #6b7280 !important;
            border-radius: 14px !important;
            padding: 12px 30px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
        }

        .swal2-icon {
            border-width: 3px !important;
            margin-top: 10px !important;
        }

        .swal2-icon.swal2-warning {
            border-color: #fef08a !important;
            color: #eab308 !important;
        }
    </style>

    @yield('style')
</head>

<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">Dew’s Cake</div>

            <div class="nav-menu">
                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                <a href="/menu" class="{{ request()->is('menu*') ? 'active' : '' }}">Menu</a>
                <a href="{{ route('pesanan.saya') }}"
                    class="{{ request()->is('pesanan-saya*') ? 'active' : '' }}">Pesanan Saya</a>
                <!-- <a href="/riwayat">Riwayat</a> -->
                <a href="/lokasi">Lokasi</a>
            </div>

            <div class="nav-login">
                @guest
                    {{-- JIKA BELUM LOGIN --}}
                    <a href="{{ route('login') }}">Login</a>
                @endguest

                @auth
                    <div class="account-dropdown">
                        <div class="account-trigger">
                            <div class="avatar-initial">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="user-name-text">{{ explode(' ', Auth::user()->name)[0] }}</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>

                        <div class="account-menu">
                            <div class="menu-header">
                                <span class="user-info-name">{{ Auth::user()->name }}</span>
                                <span class="user-info-email">{{ Auth::user()->email }}</span>
                            </div>

                            <a href="{{ route('akun.index') }}" class="link-profile">
                                <div class="menu-icon-box">
                                    <i class="fa-regular fa-id-card"></i>
                                </div>
                                <span>Akun Saya</span>
                            </a>

                            <a href="#" class="link-logout"
                                onclick="event.preventDefault(); PremiumConfirm.fire({
                        title: 'Yakin mau Logout?',
                        text: 'Kami akan menunggumu kembali dengan kue-kue lezat lainnya!',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Logout',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    });">
                                <div class="menu-icon-box">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </div>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                @endauth
            </div>

            <div class="nav-toggle" onclick="toggleNav()">☰</div>
        </div>
    </nav>

    <!-- MOBILE MENU -->
    <div class="mobile-menu" id="mobileMenu">

        <a href="/">Beranda</a>
        <a href="/menu">Menu</a>
        <a href="{{ route('pesanan.saya') }}">Pesanan Saya</a>
        <a href="/riwayat">Riwayat</a>
        <a href="/lokasi">Lokasi</a>

        @auth
            <div class="mobile-account-wrapper">

                <div class="mobile-account-name">
                    👤 {{ Auth::user()->name }}
                </div>

                <div class="mobile-account-menu">
                    <a href="{{ route('akun.index') }}" class="akun-link">
                        Akun Saya
                    </a>

                    <a href="#" class="logout-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </div>

            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="mobile-login">Login</a>
        @endguest
    </div>

    <!-- ================= CONTENT ================= -->
    @yield('content')

    <!-- ================= FOOTER ================= -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-main">

                <!-- BRAND -->
                <div class="footer-brand">
                    <h3>Dew’s Cake</h3>
                    <p>Homemade cake & dessert preorder, fresh setiap hari 🍰</p>
                </div>

                <!-- INFO + HALAL -->
                <div class="footer-info">
                    <h4>Kontak</h4>
                    <p>📍 Kediri</p>
                    <p>📞 0857-0491-0466</p>

                    <div class="footer-halal">
                        <img src="{{ asset('images/halal.png') }}" alt="Sertifikasi Halal">
                    </div>
                </div>

                <!-- SOSIAL -->
                <div class="footer-social">
                    <h4>Sosial Media</h4>

                    <a href="https://www.instagram.com/agoy_dewi?igsh=MTY2eHJzNWU5MGs0aQ==" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                        <span>@dewscake</span>
                    </a>

                    <a href="https://wa.me/6285704910466" target="_blank">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span>085704910466</span>
                    </a>
                </div>

            </div>

            <div class="footer-divider"></div>

            <div class="footer-bottom">
                © 2026 Dew’s Cake • Made with ❤️
            </div>
        </div>
    </footer>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

    <!-- ================= JS ================= -->
    <script>
        function toggleNav() {
            const menu = document.getElementById('mobileMenu');
            menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
        }

        // Global SweetAlert Config
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Confirm Mixin for easier use
        const PremiumConfirm = Swal.mixin({
            customClass: {
                confirmButton: 'swal2-confirm',
                cancelButton: 'swal2-cancel'
            },
            buttonsStyling: false,
            borderRadius: '28px'
        });

        // Global Success/Error Listeners
        @if (session('success'))
            PremiumConfirm.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            PremiumConfirm.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}"
            });
        @endif
    </script>

</body>

</html>
