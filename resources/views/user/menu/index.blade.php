@extends('layouts.user')

@section('title', 'Menu - Dew’s Cake')

@section('style')
    <style>
        /* ===== INFO PAKET HIGHLIGHT ===== */
        .paket-info {
            max-width: 820px;
            margin: 0 auto 40px;
            padding: 28px 32px;
            background: linear-gradient(135deg, #fdecef, #fff);
            border-radius: 26px;
            text-align: center;
            box-shadow: 0 14px 40px rgba(242, 138, 165, 0.25);
            border: 2px solid #f7a6b8;
            position: relative;
        }

        .paket-info::before {
            content: "🎂";
            position: absolute;
            top: -22px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 20px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
        }

        .paket-info h3 {
            font-size: 22px;
            color: #be185d;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .paket-info p {
            color: #6b7280;
            font-size: 15px;
            line-height: 1.7;
        }

        .paket-info strong {
            color: #9d174d;
        }

        /* ===== STYLE MENU ===== */
        .menu-wrapper {
            max-width: 1100px;
            margin: 60px auto;
            padding: 0 20px;
            transition: all 0.5s cubic-bezier(.22,1,.36,1);
        }

        /* Geser konten jika sidebar aktif di Desktop */
        @media (min-width: 1025px) {
            body.sidebar-open .menu-wrapper {
                margin-right: 440px;
                max-width: calc(100% - 480px);
                margin-left: 40px;
            }
        }

        .menu-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .menu-title h1 {
            font-size: 32px;
            color: #6f2f40;
        }

        .menu-title p {
            color: #6b7280;
            margin-top: 6px;
        }

        .menu-title .brand {
            font-family: 'Pacifico', cursive;
            background: linear-gradient(45deg, #be185d, #db2777);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* TAB MENU */
        .menu-tabs {
            display: flex;
            justify-content: center;
            gap: 18px;
            margin-bottom: 40px;
        }

        /* SEARCH */
        .menu-search {
            max-width: 420px;
            margin: 0 auto 40px;
            position: relative;
        }

        .menu-search input {
            width: 100%;
            padding: 12px 44px 12px 18px;
            border-radius: 22px;
            border: 2px solid #f3c2cd;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .menu-search input:focus {
            border-color: #f28aa5;
            box-shadow: 0 0 0 4px rgba(247, 166, 184, 0.25);
        }

        .menu-search button {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: linear-gradient(135deg, #f7a6b8, #f28aa5);
            color: #fff;
            padding: 8px 14px;
            border-radius: 16px;
            cursor: pointer;
            font-size: 13px;
        }

        /* FILTER */
        .menu-filter {
            max-width: 100%;
            width: 100%;
            margin: 0 auto 50px;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 30px;
            border-radius: 32px;
            box-shadow: 0 10px 40px rgba(188, 24, 93, 0.08);
            border: 1px solid rgba(243, 194, 205, 0.5);
            position: relative;
            box-sizing: border-box;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            align-items: flex-end;
            width: 100%;
            box-sizing: border-box;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 0;
            /* Prevents flex/grid items from pushing out */
        }

        .filter-group label {
            font-size: 11px;
            font-weight: 700;
            color: #8b3f52;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-left: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-input-wrapper {
            position: relative;
            width: 100%;
        }

        .filter-group input,
        .filter-group select {
            width: 100%;
            height: 46px;
            padding: 0 16px;
            border-radius: 16px;
            border: 1.5px solid #f3c2cd;
            background: #fff;
            font-size: 14px;
            color: #1f2937;
            outline: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-sizing: border-box;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            border-color: #f28aa5;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(242, 138, 165, 0.15);
            transform: translateY(-1px);
        }

        .filter-actions {
            display: flex;
            align-items: flex-end;
        }

        .btn-filter {
            width: 100%;
            height: 46px;
            border-radius: 16px;
            border: none;
            background: linear-gradient(135deg, #f7a6b8, #f28aa5);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 6px 15px rgba(242, 138, 165, 0.3);
        }

        .btn-filter:hover {
            background: linear-gradient(135deg, #f28aa5, #e85d88);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(242, 138, 165, 0.45);
        }

        .btn-filter:active {
            transform: translateY(0);
        }

        .btn-clear-filter {
            height: 46px;
            padding: 0 16px;
            border-radius: 16px;
            border: 1.5px solid #f3c2cd;
            background: #fff;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
            margin-right: 10px;
        }

        .btn-clear-filter:hover {
            background: #fdf2f8;
            color: #be185d;
            border-color: #f28aa5;
        }

        .tab {
            padding: 10px 26px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            color: #8b3f52;
            border: 2px solid #f3c2cd;
            background: #fff;
            transition: 0.3s ease;
            text-decoration: none;
        }

        .tab:hover {
            background: #fdecef;
        }

        .tab.active {
            background: linear-gradient(135deg, #f7a6b8, #f28aa5);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 6px 18px rgba(247, 166, 184, 0.5);
        }

        /* KATEGORI */
        .kategori-block {
            margin-bottom: 60px;
        }

        .kategori-title {
            font-size: 22px;
            margin-bottom: 20px;
            color: #8b3f52;
            position: relative;
        }

        .kategori-title::after {
            content: "";
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #f7a6b8, #f28aa5);
            position: absolute;
            left: 0;
            bottom: -8px;
            border-radius: 10px;
        }

        /* GRID */
        .produk-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 22px;
        }

        /* CARD */
        .produk-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08);
            transition: 0.4s ease;
            display: flex;
            flex-direction: column;
        }

        .produk-card:hover {
            transform: translateY(-6px);
            box-shadow:
                0 16px 40px rgba(0, 0, 0, 0.12),
                0 0 18px rgba(242, 138, 165, 0.35);
        }

        .produk-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .produk-body {
            padding: 12px 14px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .produk-body h4 {
            font-size: 14px;
            margin-bottom: 4px;
            color: #6f2f40;
        }

        .produk-body p {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .produk-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .harga {
            font-weight: 700;
            color: #d45c7a;
            font-size: 13px;
        }

        .btn-pesan {
            padding: 6px 14px;
            border-radius: 14px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: linear-gradient(135deg, #f7a6b8, #f28aa5);
            color: #fff;
        }

        /* ===== QTY CONTROL ===== */
        .qty-control {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .qty-btn {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            border: none;
            background: #fde2e8;
            color: #be185d;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }

        .qty-btn:hover {
            background: #f7a6b8;
            color: #fff;
        }

        .qty-input {
            width: 40px;
            height: 26px;
            text-align: center;
            border-radius: 8px;
            border: 1px solid #f3c2cd;
            font-size: 13px;
        }

        .qty-input:disabled {
            background: #f3f4f6;
            cursor: not-allowed;
        }

        .btn-pesan:hover {
            transform: scale(1.05);
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            background: #fde2e8;
            color: #be185d;
            font-size: 12px;
            border-radius: 999px;
            margin-top: 6px;
        }

        /* ===== FLOATING CART ===== */
        .cart-bar {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: linear-gradient(135deg, #fff, #fdecef);
            padding: 18px 24px;
            border-radius: 26px;
            box-shadow:
                0 18px 45px rgba(0, 0, 0, 0.18),
                0 0 25px rgba(242, 138, 165, 0.35);
            display: flex;
            align-items: center;
            gap: 18px;
            opacity: 0;
            pointer-events: none;
            transition: all 0.35s ease;
            z-index: 999;
        }

        .cart-bar.active {
            opacity: 1;
            pointer-events: auto;
            transform: translateX(-50%) translateY(0);
        }

        .cart-bar span {
            font-size: 14px;
            font-weight: 600;
            color: #8b3f52;
        }

        .btn-cart {
            padding: 10px 22px;
            border-radius: 16px;
            border: none;
            background: linear-gradient(135deg, #f7a6b8, #f28aa5);
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-cart:hover {
            box-shadow: 0 8px 20px rgba(247, 166, 184, 0.45);
        }

        .cart-icon {
            position: relative;
            font-size: 26px;
        }

        #cart-badge {
            position: absolute;
            top: -6px;
            right: -10px;
            background: #db2777;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 999px;
        }

        /* EMPTY */
        .empty {
            text-align: center;
            color: #9ca3af;
            font-style: italic;
            margin: 40px 0;
        }

        @media (max-width: 900px) {
            .menu-filter {
                padding: 24px;
            }

            .filter-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-actions {
                justify-content: center;
            }
        }

        @media (max-width: 520px) {
            .menu-filter {
                padding: 20px 16px;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .btn-filter {
                width: 100%;
            }
        }

        /* ===== LOGIN MODAL ===== */
        .login-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: 0.3s ease;
            z-index: 9999;
        }

        .login-modal.active {
            opacity: 1;
            pointer-events: auto;
        }

        .login-modal-box {
            background: #fff;
            padding: 28px 30px;
            border-radius: 26px;
            text-align: center;
            width: 90%;
            max-width: 360px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            animation: popup 0.35s ease;
        }

        @keyframes popup {
            from {
                transform: translateY(20px) scale(0.95);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .login-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .login-modal-box h3 {
            color: #be185d;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .login-modal-box p {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
        }

        .login-actions {
            margin-top: 18px;
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn-login {
            padding: 10px 22px;
            border-radius: 16px;
            border: none;
            background: linear-gradient(135deg, #f7a6b8, #f28aa5);
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-login:hover {
            box-shadow: 0 8px 20px rgba(247, 166, 184, 0.45);
        }

        .btn-cancel {
            padding: 10px 20px;
            border-radius: 16px;
            border: 2px solid #f3c2cd;
            background: #fff;
            color: #8b3f52;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-smart-budget {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #be185d, #ec4899);
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(190, 24, 93, 0.3);
            margin-left: auto;
            text-decoration: none;
        }

        .btn-smart-budget:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(190, 24, 93, 0.4);
            filter: brightness(1.1);
        }

        @media (max-width: 768px) {
            .menu-tabs {
                flex-wrap: wrap;
                gap: 10px;
            }
            .btn-smart-budget {
                width: 100%;
                justify-content: center;
                margin-left: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="menu-wrapper">
        <div class="menu-title">
            <h1>Menu <span class="brand">Dew’s Cake</span></h1>
            <p>Pilih produk favoritmu berdasarkan kategori 🍰</p>
        </div>

        {{-- TAB --}}
        <div class="menu-tabs">
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="{{ route('menu', ['tab' => 'satuan']) }}"
                    class="tab {{ $tab == 'satuan' ? 'active' : '' }}">Produk Satuan </a>
                <a href="{{ route('menu', ['tab' => 'paket']) }}" class="tab {{ $tab == 'paket' ? 'active' : '' }}">Paket </a>
            </div>
        </div>

        <div class="menu-filter">
            <form method="GET" action="{{ route('menu') }}">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="filter-grid">
                    {{-- SEARCH --}}
                    <div class="filter-group">
                        <label><i class="fa-solid fa-magnifying-glass"></i>Cari Produk</label>
                        <input type="text" name="q" placeholder="Nama produk / paket" value="{{ request('q') }}">
                    </div>
                    {{-- KATEGORI --}}
                    <div class="filter-group">
                        <label><i class="fa-solid fa-tag"></i>Kategori</label>
                        <select name="kategori">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoriList as $k)
                                <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }} </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- HARGA MIN --}}
                    <div class="filter-group">
                        <label><i class="fa-solid fa-coins"></i>Harga Min</label>
                        <input type="number" name="min" placeholder="Rp 0" value="{{ request('min') }}">
                    </div>
                    {{-- HARGA MAX --}}
                    <div class="filter-group">
                        <label><i class="fa-solid fa-sack-dollar"></i>Harga Max</label>
                        <input type="number" name="max" placeholder="Rp 500.000" value="{{ request('max') }}">
                    </div>
                    {{-- BUTTON --}}
                    <div class="filter-actions"
                        style="grid-column: 1 / -1; display: flex; justify-content: flex-end; margin-top: 5px;">
                        @if (request('q') || request('kategori') || request('min') || request('max'))
                            <a href="{{ route('menu', ['tab' => $tab]) }}" class="btn-clear-filter" title="Reset Filter">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        @endif
                        <button class="btn-filter"><i class="fa-solid fa-sliders"></i>Terapkan Filter </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- ================= TAB SATUAN ================= --}}
        @if ($tab == 'satuan')
            @forelse($kategori as $kat)
                @if ($kat->produk->count())
                    <div class="kategori-block">
                        <h2 class="kategori-title">{{ $kat->nama_kategori }}</h2>
                        <div class="produk-grid">
                            @foreach ($kat->produk as $p)
                                <div class="produk-card">
                                    <img src="{{ $p->gambar ? asset('storage/' . $p->gambar) : asset('images/no-image.png') }}"
                                        class="produk-img" alt="{{ $p->nama_produk }}">
                                    <div class="produk-body">
                                        <h4>{{ $p->nama_produk }}</h4>
                                        <p>{{ $p->deskripsi }}</p>

                                        @if($p->masa_simpan && is_array($p->masa_simpan) && count(array_filter($p->masa_simpan)) > 0)
                                            <div class="masa-simpan-box" style="
                                                background: #fdf2f8; 
                                                border-radius: 10px; 
                                                padding: 10px 12px; 
                                                margin: 12px 0;
                                                border-left: 3px solid #f472b6;
                                            ">
                                                <div style="
                                                    display: flex; 
                                                    align-items: center; 
                                                    gap: 6px; 
                                                    color: #be185d; 
                                                    font-size: 11px; 
                                                    font-weight: 700; 
                                                    text-transform: uppercase; 
                                                    letter-spacing: 0.5px;
                                                    margin-bottom: 6px;
                                                ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                    Masa Simpan
                                                </div>
                                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                                    @foreach($p->masa_simpan as $ms)
                                                        @if(!empty($ms))
                                                            <div style="
                                                                font-size: 12px; 
                                                                color: #4b5563; 
                                                                display: flex; 
                                                                align-items: flex-start; 
                                                                gap: 5px;
                                                                line-height: 1.4;
                                                            ">
                                                                <span style="color: #f472b6; font-weight: bold;">•</span>
                                                                <span>{{ $ms }}</span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="produk-footer">
                                            <div>
                                                {{-- HARGA --}}
                                                <div class="harga">Rp {{ number_format($p->harga, 0, ',', '.') }} </div>
                                                {{-- QTY CONTROL --}}
                                                <div class="qty-control" data-id="{{ $p->produk_id }}"
                                                    data-nama="{{ $p->nama_produk }}" data-harga="{{ $p->harga }}">
                                                    <button type="button" class="qty-btn" onclick="kurangQty(this)">−</button>
                                                    <input type="number" class="qty-input" value="0" min="0" readonly
                                                        data-id="{{ $p->produk_id }}" data-nama="{{ $p->nama_produk }}"
                                                        data-harga="{{ $p->harga }}" data-type="produk">
                                                    <button type="button" class="qty-btn" onclick="tambahQty(this)">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @empty
                <div class="empty">Belum ada produk.</div>
            @endforelse
        @endif

        {{-- ================= TAB PAKET ================= --}}
        @if ($tab == 'paket')
            <div class="paket-info" style="display: flex; flex-direction: column; gap: 15px;">
                <div>
                    <h3 style="margin-bottom: 8px;">Paket Custom Sesuai Budget 🎉</h3>
                    <p>Paket di <strong>Dew’s Cake</strong> bersifat <strong>custom sesuai budget</strong>🎂<br>
                        Kamu cukup menentukan kisaran budget yang diinginkan, lalu sistem kami akan menampilkan
                        <strong>rekomendasi pilihan kue</strong> dengan harga yang sesuai dengan budget tersebut.
                    </p>
                    <p style="margin-top:12px">👉 Selanjutnya, kamu bisa memilih kue berdasarkan <strong>rekomendasi yang diberikan</strong> atau <strong>memilih sendiri</strong> sesuai selera sebelum melanjutkan pemesanan. </p>
                </div>
                
                <div style="border-top: 1px dashed #fbcfe8; padding-top: 15px; margin-top: 5px;">
                    <button type="button" onclick="openBudgetSidebar()" class="btn-smart-budget" style="margin-left: 0; width: fit-content; padding: 12px 24px; font-size: 14px;">
                        <span>✨</span> Gunakan Rekomendasi Pintar Sekarang
                    </button>
                </div>
            </div>
            <div id="info-paket" class="info-paket" style="display:none;">
                ℹ️ Anda hanya bisa memilih <strong>satu jenis paket</strong>. Kosongkan paket yang dipilih untuk mengganti
                paket lain.
            </div>

            @forelse($paket as $jenis => $listPaket)
                <h3 style="margin:30px 0 15px; color:#db2777; font-size:20px; font-weight:600">
                    {{ ucfirst($jenis) }}
                </h3>
                <div class="produk-grid">
                    @foreach ($listPaket as $p)
                        <div class="produk-card">
                            {{-- GAMBAR --}}
                            <img src="{{ $p->gambar ? asset('storage/' . $p->gambar) : asset('images/no-image.png') }}"
                                class="produk-img" alt="{{ $p->nama_paket }}">
                            {{-- BODY --}}
                            <div class="produk-body">
                                <h4>{{ $p->nama_paket }}</h4>
                                <p>{{ $p->deskripsi }}</p>
                                {{-- HARGA --}}
                                <div class="harga" style="margin-bottom:10px">
                                    Rp {{ number_format($p->minimal_budget) }} – Rp {{ number_format($p->maksimal_budget) }}
                                </div>
                                <div class="qty-control" data-id="{{ $p->paket_id }}" data-nama="{{ $p->nama_paket }}"
                                    data-min="{{ $p->minimal_budget }}" data-max="{{ $p->maksimal_budget }}"
                                    data-jenis="{{ $p->jenis_paket }}" data-maxkue="{{ $p->max_kue }}"
                                    data-qtyperjenis="{{ $p->qty_per_jenis }}" data-detail='@json($p->detail)'
                                    data-type="paket">
                                    <button type="button" class="qty-btn" onclick="kurangQty(this)">−</button>
                                    <input type="number" class="qty-input" value="0" min="0" readonly
                                        data-id="{{ $p->paket_id }}" data-nama="{{ $p->nama_paket }}"
                                        data-harga="{{ $p->minimal_budget }}" data-type="paket">
                                    <button type="button" class="qty-btn" onclick="tambahQty(this)">+</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @empty
                <p style="text-align:center;color:#9ca3af">Tidak ada paket tersedia </p>
            @endforelse
        @endif

        @include('partials.sidebar-budget')
    </div>

    @if (($tab ?? '') !== 'paket')
        <div id="cart-bar" class="cart-bar">
            <div class="cart-icon">🛒 <span id="cart-badge">0</span></div>
            <span id="cart-info">0 item dipilih</span>
            <button class="btn-cart" onclick="goCheckout()">Pesan Sekarang </button>
        </div>
    @endif

    <div id="login-modal" class="login-modal">
        <div class="login-modal-box">
            <div class="login-icon">🧁</div>
            <h3>Login Diperlukan</h3>
            <p>Silakan login terlebih dahulu untuk<br>menambahkan produk ke keranjang. </p>
            <div class="login-actions">
                <button class="btn-login" onclick="goLogin()">Login</button>
                <button class="btn-cancel" onclick="closeLoginModal()">Batal</button>
            </div>
        </div>
    </div>
    @push('script')
    <script>
        let budgetSudahDiset = false;
        let budgetSudahDipilih = false;
        let rekomendasiItems = [];
        let globalResultsData = [];
        let paketAktif = null;
        let currentCartItems = @json($cart);

        function closeSidebar() {
            const sidebar = document.getElementById('budget-sidebar');
            if (sidebar) {
                sidebar.classList.remove('active');
                document.body.classList.remove('sidebar-open');
                
                // Reset states and quantities
                clearAllQtyInputs();
                paketAktif = null;
                rekomendasiItems = [];
                budgetSudahDipilih = false;
                budgetSudahDiset = false;
                lockOtherPaket(null);
                
                // Reset UI boxes
                const pesananBox = document.getElementById("pesanan-saya");
                if(pesananBox) pesananBox.style.display = "none";
                const hasilBox = document.getElementById("hasil-rekomendasi");
                if(hasilBox) hasilBox.style.display = "none";
                
                updateCart();
            }
        }

        function getCurrentCartType() {
            if (!currentCartItems || Object.keys(currentCartItems).length === 0) return null;
            const firstItem = Object.values(currentCartItems)[0];
            return firstItem.type === 'paket' ? 'paket' : 'produk';
        }

        function clearAllQtyInputs() {
            document.querySelectorAll('.qty-input').forEach(input => {
                input.value = 0;
            });
        }

        function toggleCheckoutButton() {
            const btn = document.getElementById("btn-lanjut-checkout");
            if (!btn) return;

            const modeInput = document.getElementById("input-mode-pesan-val");
            const mode = modeInput ? modeInput.value : 'manual';
            const totalText = document.getElementById("total-pesanan")?.innerText || "0";
            const total = parseInt(totalText.replace(/\D/g, '')) || 0;

            const isManualValid = () => {
                if (!paketAktif) return false;
                const checked = document.querySelectorAll(".produk-checkbox:checked");
                const qtyPerJenis = paketAktif.jenis_paket === "kotak" ? 1 : paketAktif.qty_per_jenis;
                const maxKueTotal = paketAktif.max_kue * paketAktif.qty;
                const totalPcs = checked.length * qtyPerJenis * paketAktif.qty;
                return totalPcs === maxKueTotal;
            };

            const isValid = (mode === 'manual') ? isManualValid() : (total > 0);

            if (mode && isValid) {
                btn.disabled = false;
                
                const inputMode = document.getElementById("input-mode-pesan");
                if(inputMode) inputMode.value = mode;
                
                const inputBudget = document.getElementById("input-budget");
                if(inputBudget) inputBudget.value = document.getElementById("sidebar-budget-input")?.value || 0;
                
                const inputTotal = document.getElementById("input-total-harga");
                if(inputTotal) inputTotal.value = total;
                
                const inputCart = document.getElementById("input-cart-data");
                if(inputCart) inputCart.value = JSON.stringify(buildCartData());
                
            } else if (paketAktif) {
                btn.disabled = false; 
            } else {
                btn.disabled = true;
            }
        }

        function openBudgetSidebar() {
            const sidebar = document.getElementById('budget-sidebar');
            if (sidebar) {
                sidebar.classList.add('active');
                document.body.classList.add('sidebar-open');
                if (!paketAktif) {
                    const infoPaket = document.getElementById('sidebar-paket-info');
                    if(infoPaket) infoPaket.style.display = "block";
                    const budgetForm = document.getElementById('sidebar-budget-form');
                    if(budgetForm) budgetForm.style.display = 'none';
                    const globalUI = document.getElementById('sidebar-global-recommendation');
                    if(globalUI) globalUI.style.display = 'block';
                }
            }
        }

        function submitBudget() {
            if (!paketAktif) return;
            const budgetInput = document.getElementById('sidebar-budget-input');
            const budget = budgetInput ? budgetInput.value : 0;
            const qty = paketAktif.qty;

            fetch(`/paket/rekomendasi-ajax?budget=${budget}&paket_id=${paketAktif.id}&qty=${qty}`)
                .then(res => res.json())
                .then(data => {
                    const listRekom = document.getElementById("list-rekomendasi");
                    const hasilBox = document.getElementById("hasil-rekomendasi");
                    if (!listRekom || !hasilBox) return;

                    if (data.info) {
                        listRekom.innerHTML = `<div class="info-paket">ℹ️ ${data.info}</div>`;
                        hasilBox.style.display = "block";
                        return;
                    }

                    let itemsHtml = data.items.map(it => `- ${it.nama} (${it.qty} pcs)`).join('<br>');
                    listRekom.innerHTML = `
                        <div class="rekomendasi-card" onclick="applySpecificRecommendation()" style="cursor:pointer">
                            <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:8px">
                                <div>
                                    <span style="font-weight:700;color:#be185d">Kombinasi Terbaik</span>
                                    <div style="font-size:12px;color:#059669;font-weight:700">Total: Rp ${data.total.toLocaleString('id-ID')}</div>
                                </div>
                            </div>
                            <div style="font-size:11px;color:#6b7280;line-height:1.5">${itemsHtml}</div>
                            <div style="text-align:center;margin-top:10px;font-size:10px;color:#ec4899;font-weight:600">Klik untuk gunakan</div>
                        </div>
                    `;
                    hasilBox.style.display = "block";
                    rekomendasiItems = data.items;
                    budgetSudahDiset = true;
                });
        }

        function updatePaketExclusive(input) {
            const qty = parseInt(input.value);
            const sidebar = document.getElementById('budget-sidebar');
            const wrapper = input.closest('.qty-control');
            const infoPaket = document.getElementById('sidebar-paket-info');

            if (qty > 0) {
                paketAktif = {
                    id: wrapper.dataset.id,
                    nama: wrapper.dataset.nama,
                    min: parseInt(wrapper.dataset.min),
                    max: parseInt(wrapper.dataset.max),
                    jenis_paket: wrapper.dataset.jenis,
                    max_kue: parseInt(wrapper.dataset.maxkue),
                    qty_per_jenis: parseInt(wrapper.dataset.qtyperjenis),
                    qty: qty,
                    detail: JSON.parse(wrapper.dataset.detail),
                    biaya_wadah: parseInt(wrapper.dataset.biayawadah || 0),
                    harga_manual: 0,
                    harga_rekomendasi: 0
                };
                lockOtherPaket(paketAktif.id);
                if(infoPaket) infoPaket.style.display = "none";

                const budgetForm = document.getElementById('sidebar-budget-form');
                if(budgetForm) budgetForm.style.display = 'block';

                const namaEl = document.getElementById('sidebar-paket-nama');
                if(namaEl) namaEl.innerText = paketAktif.nama;

                const minEl = document.getElementById('budget-min');
                const maxEl = document.getElementById('budget-max');
                if(minEl) minEl.innerText = paketAktif.min.toLocaleString('id-ID');
                if(maxEl) maxEl.innerText = paketAktif.max.toLocaleString('id-ID');

                const inputBudget = document.getElementById('sidebar-budget-input');
                if (inputBudget && !budgetSudahDipilih) {
                    inputBudget.value = paketAktif.min;
                }

                const manualCard = document.getElementById("manual-produk-card");
                const manualList = document.getElementById("manual-produk-list");
                const hasilBox = document.getElementById("hasil-rekomendasi");
                const modeInput = document.getElementById("input-mode-pesan-val");
                const globalUI = document.getElementById("sidebar-global-recommendation");

                if (hasilBox) hasilBox.style.display = "none";
                if (globalUI) globalUI.style.display = "none";
                if (modeInput) modeInput.value = 'manual';

                if (manualCard && manualList) {
                    manualCard.style.display = "block";
                    manualList.innerHTML = "";
                    const details = Array.isArray(paketAktif.detail) ? paketAktif.detail : Object.values(paketAktif.detail);
                    details.forEach(item => {
                        if (!item.produk) return;
                        manualList.innerHTML += `
                            <label style="display:block;margin-bottom:6px; cursor:pointer;">
                                <input type="checkbox" class="produk-checkbox" value="${item.produk.produk_id}" data-nama="${item.produk.nama_produk}" data-harga="${item.produk.harga}">
                                <span style="font-size: 13px;">${item.produk.nama_produk}</span>
                                <small style="color:#6b7280">(Rp ${Number(item.produk.harga).toLocaleString('id-ID')})</small>
                            </label>
                        `;
                    });
                }
                sidebar.classList.add('active');
                document.body.classList.add('sidebar-open');
                updateManualCount();
                toggleCheckoutButton();
            } else {
                paketAktif = null;
                rekomendasiItems = [];
                budgetSudahDipilih = false;
                budgetSudahDiset = false;
                lockOtherPaket(null);
                if(infoPaket) infoPaket.style.display = "none";
                if(sidebar) sidebar.classList.remove('active');
                document.body.classList.remove('sidebar-open');
            }

            if (rekomendasiItems.length > 0) {
                renderPesananDariRekomendasi();
            }
        }

        function updateSubtotal(id, harga) {
            const qty = document.getElementById("qty-" + id).value;
            const subtotal = qty * harga;
            const subEl = document.getElementById("subtotal-" + id);
            if(subEl) subEl.innerText = "Rp " + subtotal.toLocaleString('id-ID');
            hitungTotal();
            toggleCheckoutButton();
        }

        function hitungTotal() {
            let total = 0;
            document.querySelectorAll("[id^='subtotal-']").forEach(el => {
                const angka = el.innerText.replace(/[^0-9]/g, "");
                total += parseInt(angka) || 0;
            });
            const totalEl = document.getElementById("total-pesanan");
            if(totalEl) totalEl.innerText = "Rp " + total.toLocaleString('id-ID');
            toggleCheckoutButton();
        }

        document.addEventListener("change", function(e) {
            if (!e.target.classList.contains("produk-checkbox")) return;
            if (!paketAktif) return;

            const modeInput = document.getElementById("input-mode-pesan-val");
            if(modeInput) modeInput.value = 'manual';
            budgetSudahDipilih = true; 
            
            const checked = document.querySelectorAll(".produk-checkbox:checked");
            const qtyPerJenis = paketAktif.jenis_paket === "kotak" ? 1 : paketAktif.qty_per_jenis;
            const maxKueTotal = paketAktif.max_kue * paketAktif.qty;
            const totalPcs = checked.length * qtyPerJenis * paketAktif.qty;
            const infoKombinasi = document.getElementById("info-kombinasi");

            if (totalPcs > maxKueTotal) {
                if(infoKombinasi) {
                    infoKombinasi.innerHTML = `ℹ️ Total kue tidak boleh lebih dari <strong>${maxKueTotal} pcs</strong>.`;
                    infoKombinasi.style.display = "block";
                }
                e.target.checked = false;
                return;
            } else {
                if(infoKombinasi) infoKombinasi.style.display = "none";
            }

            const listPesanan = document.getElementById("list-pesanan");
            const totalEl = document.getElementById("total-pesanan");
            const pesananBox = document.getElementById("pesanan-saya");

            if(listPesanan) {
                listPesanan.innerHTML = "";
                let hargaProdukTotal = 0;
                checked.forEach(item => {
                    const nama = item.dataset.nama;
                    const harga = parseInt(item.dataset.harga);
                    const qty = qtyPerJenis * paketAktif.qty;
                    const subtotal = harga * qty;
                    hargaProdukTotal += harga * qtyPerJenis;

                    listPesanan.insertAdjacentHTML("beforeend", `
                        <tr>
                            <td>${nama}</td>
                            <td style="text-align:center">${qty}</td>
                            <td style="text-align:center">Rp ${harga.toLocaleString('id-ID')}</td>
                            <td style="text-align:center">Rp ${subtotal.toLocaleString('id-ID')}</td>
                            <td><textarea placeholder="Catatan..."></textarea></td>
                        </tr>
                    `);
                });
                paketAktif.harga_manual = hargaProdukTotal;
                let total = paketAktif.harga_manual * paketAktif.qty;
                if(totalEl) totalEl.innerText = "Rp " + total.toLocaleString('id-ID');
                updateManualCount();
                toggleCheckoutButton();
                if(pesananBox) pesananBox.style.display = checked.length > 0 ? "block" : "none";
            }
        });

        function toggleSidebarByPaket(input) {
            const sidebar = document.getElementById("budget-sidebar");
            if (input.dataset.type !== "paket") return;
            const qty = parseInt(input.value);
            if (qty > 0) {
                if(sidebar) sidebar.classList.add("active");
                document.body.classList.add('sidebar-open');
            } else {
                if(sidebar) sidebar.classList.remove("active");
                document.body.classList.remove('sidebar-open');
                const form = document.getElementById("sidebar-budget-form");
                if(form) form.style.display = "none";
                const hasil = document.getElementById("hasil-rekomendasi");
                if(hasil) hasil.style.display = "none";
                const pesanan = document.getElementById("pesanan-saya");
                if(pesanan) pesanan.style.display = "none";
            }
        }

        function renderPesananDariRekomendasi() {
            const modeInput = document.getElementById("input-mode-pesan-val");
            const mode = modeInput ? modeInput.value : 'rekomendasi';
            if (mode === 'manual') return;
            if (!paketAktif || rekomendasiItems.length === 0) return;

            const listPesanan = document.getElementById("list-pesanan");
            if(!listPesanan) return;
            listPesanan.innerHTML = "";

            let hargaProdukOnly = 0;
            rekomendasiItems.forEach(item => {
                hargaProdukOnly += item.qty * item.harga;
            });
            paketAktif.harga_rekomendasi = hargaProdukOnly;
            let totalFinal = paketAktif.harga_rekomendasi * paketAktif.qty;

            rekomendasiItems.forEach(item => {
                const qtyTotal = item.qty * paketAktif.qty;
                const subtotal = item.harga * qtyTotal;
                listPesanan.insertAdjacentHTML("beforeend", `
                    <tr>
                        <td>${item.nama}</td>
                        <td style="text-align:center">${qtyTotal}</td>
                        <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
                        <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                        <td><textarea placeholder="Catatan..."></textarea></td>
                    </tr>
                `);
            });
            const totalEl = document.getElementById("total-pesanan");
            if(totalEl) totalEl.innerText = "Rp " + totalFinal.toLocaleString('id-ID');
            const pesananBox = document.getElementById("pesanan-saya");
            if(pesananBox) pesananBox.style.display = "block";
            const hasilBox = document.getElementById("hasil-rekomendasi");
            if(hasilBox) hasilBox.style.display = "block";

            // Sembunyikan pilih manual jika pakai rekomendasi
            const manualCard = document.getElementById("manual-produk-card");
            if(manualCard) manualCard.style.display = "none";

            toggleCheckoutButton();
        }

        function applySpecificRecommendation() {
            const modeInput = document.getElementById("input-mode-pesan-val");
            if(modeInput) modeInput.value = 'rekomendasi';
            budgetSudahDipilih = true;
            renderPesananDariRekomendasi();
            toggleCheckoutButton();
            const pesananBox = document.getElementById('pesanan-saya');
            if(pesananBox) {
                pesananBox.style.display = 'block';
                pesananBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        function lockOtherPaket(activePaketId = null) {
            const paketWrappers = document.querySelectorAll('.qty-control[data-type="paket"]');
            paketWrappers.forEach(wrapper => {
                const input = wrapper.querySelector('.qty-input');
                const minus = wrapper.querySelector('.qty-btn:first-child');
                const plus = wrapper.querySelector('.qty-btn:last-child');
                if (activePaketId && wrapper.dataset.id !== activePaketId) {
                    if(plus) plus.disabled = true;
                    if(minus) minus.disabled = true;
                    if(input) input.disabled = true;
                    wrapper.classList.add('paket-disabled');
                } else {
                    if(plus) plus.disabled = false;
                    if(minus) minus.disabled = false;
                    if(input) input.disabled = false;
                    wrapper.classList.remove('paket-disabled');
                }
            });
        }

        function buildCartData() {
            let cart = [];
            const modeInput = document.getElementById("input-mode-pesan-val");
            const mode = modeInput ? modeInput.value : 'manual';

            if (paketAktif) {
                const totalKueSatuPaket = mode === 'rekomendasi' ?
                    rekomendasiItems.reduce((sum, i) => sum + i.qty, 0) :
                    document.querySelectorAll('.produk-checkbox:checked').length * (paketAktif.jenis_paket === 'kotak' ? 1 : paketAktif.qty_per_jenis);

                const kardusPerSatuPaket = Math.ceil(totalKueSatuPaket / Math.max(1, paketAktif.max_kue));
                const biayaWadahSatuPaket = kardusPerSatuPaket * (paketAktif.biaya_wadah || 0);

                cart.push({
                    id: paketAktif.id,
                    nama: paketAktif.nama,
                    type: 'paket',
                    harga: biayaWadahSatuPaket,
                    qty: paketAktif.qty
                });

                if (mode === 'rekomendasi') {
                    rekomendasiItems.forEach(item => {
                        cart.push({
                            id: item.id,
                            nama: item.nama,
                            type: 'produk',
                            harga: item.harga,
                            qty: item.qty * paketAktif.qty
                        });
                    });
                } else {
                    document.querySelectorAll('.produk-checkbox:checked').forEach(cb => {
                        const qtyProduk = paketAktif.jenis_paket === 'kotak' ? paketAktif.qty : paketAktif.qty_per_jenis * paketAktif.qty;
                        cart.push({
                            id: cb.value,
                            nama: cb.dataset.nama,
                            type: 'produk',
                            harga: parseInt(cb.dataset.harga),
                            qty: qtyProduk
                        });
                    });
                }
            }
            return cart;
        }

        function updateManualCount() {
            if (!paketAktif) return;
            const modeInput = document.getElementById("input-mode-pesan-val");
            const mode = modeInput ? modeInput.value : 'manual';
            const countEl = document.getElementById("manual-count");
            if (!countEl) return;

            if (mode !== 'manual') {
                countEl.innerText = "";
                return;
            }

            const checked = document.querySelectorAll(".produk-checkbox:checked");
            const qtyPerJenis = paketAktif.jenis_paket === "kotak" ? 1 : paketAktif.qty_per_jenis;
            const maxKueTotal = paketAktif.max_kue * paketAktif.qty;
            const totalPcs = checked.length * qtyPerJenis * paketAktif.qty;

            countEl.innerText = `${totalPcs} / ${maxKueTotal} pcs`;
            if (totalPcs < maxKueTotal) {
                countEl.style.color = "#be185d";
                countEl.innerText = `Pilih ${maxKueTotal - totalPcs} lagi (${totalPcs}/${maxKueTotal})`;
            } else if (totalPcs === maxKueTotal) {
                countEl.style.color = "#166534";
                countEl.innerText = `Lengkap (${totalPcs}/${maxKueTotal})`;
            } else {
                countEl.style.color = "#be185d";
                countEl.innerText = `Kelebihan! (${totalPcs}/${maxKueTotal})`;
            }
        }

        function hitungUlangManual() {
            if (!paketAktif) return;
            const checked = document.querySelectorAll(".produk-checkbox:checked");
            if (checked.length === 0) {
                paketAktif.harga_manual = 0;
                const totalEl = document.getElementById("total-pesanan");
                if(totalEl) totalEl.innerText = "Rp 0";
                toggleCheckoutButton();
                return;
            }
            const qtyPerJenis = paketAktif.jenis_paket === "kotak" ? 1 : paketAktif.qty_per_jenis;
            let hargaProdukOnly = 0;
            checked.forEach(item => {
                hargaProdukOnly += parseInt(item.dataset.harga) * qtyPerJenis;
            });
            paketAktif.harga_manual = hargaProdukOnly;
            let totalFinal = paketAktif.harga_manual * paketAktif.qty;
            const totalEl = document.getElementById("total-pesanan");
            if(totalEl) totalEl.innerText = "Rp " + totalFinal.toLocaleString('id-ID');
            toggleCheckoutButton();
        }

        const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
        const loginUrl = "{{ route('login') }}";
        function showLoginModal() { document.getElementById('login-modal').classList.add('active'); }
        function closeLoginModal() { document.getElementById('login-modal').classList.remove('active'); }
        function goLogin() { window.location.href = loginUrl; }

        function tambahQty(btn) {
            if (!isLoggedIn) { showLoginModal(); return; }
            const input = btn.previousElementSibling;
            const newType = input.dataset.type === 'paket' ? 'paket' : 'produk';
            const currentType = getCurrentCartType();

            if (currentType && currentType !== newType) {
                PremiumConfirm.fire({
                    title: 'Ganti Jenis Pesanan?',
                    text: 'Mengganti jenis pesanan akan mengosongkan keranjang sebelumnya. Lanjut?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Ganti'
                }).then((result) => {
                    if (result.isConfirmed) {
                        clearAllQtyInputs();
                        input.value = 1;
                        if (newType === 'paket') {
                            updatePaketExclusive(input);
                            toggleSidebarByPaket(input);
                        }
                        updateCart();
                    }
                });
                return;
            }

            input.value = parseInt(input.value) + 1;
            if (input.dataset.type === 'paket') {
                updatePaketExclusive(input);
                toggleSidebarByPaket(input);
            }
            const modeInput = document.getElementById("input-mode-pesan-val");
            if (modeInput && modeInput.value === 'manual') hitungUlangManual();
            updateCart();
        }

        function kurangQty(btn) {
            if (!isLoggedIn) { showLoginModal(); return; }
            const input = btn.nextElementSibling;
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                if (input.dataset.type === 'paket') {
                    updatePaketExclusive(input);
                    toggleSidebarByPaket(input);
                }
                const modeInput = document.getElementById("input-mode-pesan-val");
                if (modeInput && modeInput.value === 'manual') hitungUlangManual();
                updateCart();
            }
        }

        function updateCart() {
            const inputs = document.querySelectorAll('.qty-input');
            let items = [];
            let totalItem = 0;
            inputs.forEach(input => {
                const qty = parseInt(input.value);
                if (qty > 0) {
                    items.push({
                        id: input.dataset.id,
                        nama: input.dataset.nama,
                        type: input.dataset.type ?? 'produk',
                        harga: input.dataset.harga,
                        qty: qty
                    });
                    totalItem += qty;
                }
            });

            fetch("{{ route('cart.update') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ items })
            }).then(res => res.json()).then(data => { currentCartItems = items; });

            const cartBar = document.getElementById('cart-bar');
            if (cartBar) cartBar.classList.toggle('active', totalItem > 0);
            const cartInfo = document.getElementById('cart-info');
            if (cartInfo) cartInfo.innerText = totalItem + ' item dipilih';
            const cartBadge = document.getElementById('cart-badge');
            if (cartBadge) cartBadge.innerText = totalItem;
        }

        document.getElementById('form-lanjut')?.addEventListener('submit', function(e) {
            const totalText = document.getElementById("total-pesanan")?.innerText || "0";
            const total = parseInt(totalText.replace(/\D/g, '')) || 0;
            if (paketAktif && (total <= 0 || !budgetSudahDipilih)) {
                e.preventDefault();
                PremiumConfirm.fire({
                    icon: 'info',
                    title: 'Pesanan Belum Lengkap',
                    text: 'Silakan tentukan budget atau pilih produk secara manual.'
                });
            }
        });

        function goCheckout() { window.location.href = "{{ route('checkout') }}"; }

        /* GLOBAL RECOMMENDATION FUNCTIONS MOVED FROM SIDEBAR */
        function getGlobalRecommendation(e) {
            if (e) e.preventDefault();
            const totalBudget = document.getElementById('global-total-budget').value;
            const jumlahOrang = document.getElementById('global-jumlah-orang').value;

            if (!totalBudget || !jumlahOrang) {
                alert('Harap isi total dana dan jumlah orang');
                return;
            }

            const btn = e ? e.currentTarget : document.activeElement;
            const originalText = btn.innerText;
            btn.disabled = true;
            btn.innerText = 'Mencari...';

            fetch("{{ route('rekomendasi.global') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    total_budget: totalBudget,
                    jumlah_orang: jumlahOrang
                })
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerText = originalText;

                const container = document.getElementById('global-results');
                const list = document.getElementById('global-recommendations-list');
                list.innerHTML = '';

                if (!data.recommendations || data.recommendations.length === 0) {
                    list.innerHTML = '<p style="font-size: 13px; color: #6b7280; text-align: center; padding: 10px;">Maaf, tidak ada paket yang cocok dengan dana tersebut.</p>';
                    container.style.display = 'block';
                    return;
                }

                globalResultsData = data.recommendations;
                container.style.display = 'block';

                data.recommendations.forEach((rec, index) => {
                    const itemsHtml = rec.isi_per_kotak.map(i => `• ${i.nama}`).join('<br>');
                    
                    list.innerHTML += `
                        <div onclick="applyGlobalRecommendation(${index}, ${jumlahOrang})" style="
                            background: white; 
                            border: 1px solid #fbcfe8; 
                            border-radius: 12px; 
                            padding: 12px; 
                            cursor: pointer; 
                            transition: 0.2s;
                            position: relative;
                            overflow: hidden;
                        " onmouseover="this.style.borderColor='#ec4899'; this.style.background='#fff5f7'" onmouseout="this.style.borderColor='#fbcfe8'; this.style.background='white'">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                <span style="font-weight: 700; color: #be185d; font-size: 14px;">${rec.nama_paket}</span>
                                <div style="text-align: right;">
                                    <span style="display: block; font-size: 12px; font-weight: 700; color: #166534; background: #dcfce7; padding: 2px 8px; border-radius: 99px; white-space: nowrap;">
                                        Rp ${(rec.total_estimasi_per_orang).toLocaleString('id-ID')} / org
                                    </span>
                                    <small style="font-size: 9px; color: #9ca3af; display: block; margin-top: 2px;">
                                        (Produk: ${rec.total_harga_produk.toLocaleString('id-ID')} + Wadah: ${rec.biaya_wadah_satuan.toLocaleString('id-ID')})
                                    </small>
                                </div>
                            </div>
                            <div style="font-size: 11px; color: #6b7280; line-height: 1.5; margin-bottom: 8px;">
                                ${itemsHtml}
                            </div>
                            <div style="font-size: 11px; font-weight: 600; color: #4b5563; border-top: 1px dashed #fce7f3; margin-top: 8px; padding-top: 8px;">
                                Total Estimasi (${jumlahOrang} org): <span style="color: #be185d">Rp ${rec.total_estimasi_keseluruhan.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                    `;
                });
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerText = originalText;
                console.error(err);
                alert('Terjadi kesalahan saat mencari rekomendasi');
            });
        }

        function applyGlobalRecommendation(index, qty) {
            const rec = globalResultsData[index];
            if (!rec) return;

            const inputPaket = document.querySelector(`.qty-input[data-id="${rec.paket_id}"][data-type="paket"]`);
            if (!inputPaket) {
                alert('Paket tidak ditemukan di daftar menu.');
                return;
            }

            inputPaket.value = qty;
            updatePaketExclusive(inputPaket);
            
            const budgetInput = document.getElementById('sidebar-budget-input');
            if (budgetInput) {
                budgetInput.value = rec.total_estimasi_per_orang;
            }

            rekomendasiItems = rec.isi_per_kotak;
            budgetSudahDipilih = true;
            budgetSudahDiset = true;

            const modeInputVal = document.getElementById('input-mode-pesan-val');
            if (modeInputVal) modeInputVal.value = 'rekomendasi';

            renderPesananDariRekomendasi();
            toggleCheckoutButton();
            updateCart();

            const pesananBox = document.getElementById('pesanan-saya');
            if(pesananBox) {
                pesananBox.style.display = 'block';
                pesananBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                pesananBox.style.boxShadow = '0 0 20px rgba(236, 72, 153, 0.4)';
                setTimeout(() => {
                    pesananBox.style.boxShadow = '';
                }, 2000);
            }
        }
    </script>
    @endpush
@endsection
