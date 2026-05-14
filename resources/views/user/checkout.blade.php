<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Pesanan - Dew’s Cake</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary: #be185d;
            --primary-soft: #fff1f2;
            --primary-border: #fecdd3;
            --accent: #e85d88;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-body: #fff8fb;
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 10px 30px -5px rgba(190, 24, 93, 0.1);
            --shadow-lg: 0 20px 40px -8px rgba(190, 24, 93, 0.15);
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        .container {
            margin: 50px auto;
            padding: 0 24px;
            max-width: 1150px;
        }

        h2 {
            color: var(--primary);
            margin-bottom: 40px;
            font-size: 36px;
            font-weight: 800;
            letter-spacing: -1.5px;
            text-align: center;
        }

        h3 {
            margin: 0 0 25px;
            color: var(--primary);
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        h3 i {
            font-size: 18px;
            opacity: 0.8;
        }

        .card {
            background: #ffffff;
            padding: 40px;
            border-radius: 32px;
            box-shadow: var(--shadow-md);
            border: 1px solid #fff;
            margin-bottom: 40px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        @media (max-width: 640px) {
            .card {
                padding: 24px 20px;
                border-radius: 24px;
                margin-bottom: 25px;
            }
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            opacity: 0.1;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 10px;
            display: block;
            padding-left: 4px;
        }

        input, textarea, select {
            width: 100%;
            padding: 16px 20px;
            border-radius: 20px;
            border: 2px solid #f1f5f9;
            background: #fff;
            transition: all 0.3s ease;
            font-size: 15px;
            color: var(--text-main);
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(190, 24, 93, 0.1);
            outline: none;
            background: #fff;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        input:read-only,
        textarea:read-only,
        select:disabled {
            background: #f8fafc;
            color: var(--text-muted);
            border-color: #f1f5f9;
        }

        .table-responsive {
            overflow-x: auto;
            margin: 0 -10px;
        }

        .pesanan-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .pesanan-table thead th {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 15px 10px;
            text-align: left;
            border: none;
        }

        .pesanan-table tbody tr {
            background: #fff;
            transition: all 0.3s ease;
        }

        .pesanan-table td {
            padding: 24px 15px;
            background: #fff;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }

        .pesanan-table td:first-child {
            border-left: 1px solid #f1f5f9;
            border-radius: 24px 0 0 24px;
        }

        .pesanan-table td:last-child {
            border-right: 1px solid #f1f5f9;
            border-radius: 0 24px 24px 0;
            text-align: right;
        }

        .row-paket {
            background: linear-gradient(to right, var(--primary-soft), #fff) !important;
        }

        .row-paket td {
            background: transparent !important;
            border-color: var(--primary-border) !important;
        }

        .radio-group {
            display: flex;
            gap: 16px;
        }

        /* ===== RADIOS & PILLS ===== */
        .radio-pill-group {
            display: flex;
            gap: 15px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .radio-pill {
            flex: 1;
            min-width: 140px;
            cursor: pointer;
            position: relative;
        }

        .radio-pill input {
            display: none;
        }

        .radio-pill .pill-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            border-radius: 24px;
            border: 2px solid #f1f5f9;
            background: #fff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
        }

        .radio-pill .pill-content i {
            font-size: 28px;
            margin-bottom: 10px;
            color: var(--text-muted);
            transition: 0.3s;
        }

        .radio-pill .pill-content span {
            font-weight: 700;
            font-size: 15px;
            color: var(--text-main);
            transition: 0.3s;
        }

        .radio-pill:hover .pill-content {
            border-color: var(--primary-border);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .radio-pill input:checked + .pill-content {
            border-color: var(--primary);
            background: var(--primary-soft);
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(190, 24, 93, 0.08);
        }

        .radio-pill input:checked + .pill-content i,
        .radio-pill input:checked + .pill-content span {
            color: var(--primary);
        }
        /* ===== TOTAL BOX ===== */
        .total-box {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: #fff;
            padding: 45px;
            border-radius: 40px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .total-box h3 {
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .total-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 16px;
            color: #94a3b8;
        }

        .total-line.grand {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            font-weight: 700;
        }

        .total-line.now-paying {
            background: rgba(190, 24, 93, 0.15);
            margin: 30px -45px -45px;
            padding: 30px 45px;
            border-top: 1px solid rgba(190, 24, 93, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .now-paying span {
            font-size: 14px;
            color: #fce7f3;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .now-paying strong {
            font-size: 38px;
            color: #fff;
            text-shadow: 0 0 20px rgba(244, 114, 182, 0.3);
        }

        @media (max-width: 640px) {
            .total-box {
                padding: 30px 20px;
                border-radius: 30px;
            }
            .total-line.now-paying {
                margin: 25px -20px -30px;
                padding: 25px 20px;
            }
            .now-paying strong {
                font-size: 30px;
            }
        }

        .btn-submit {
            margin-top: 40px;
            width: 100%;
            padding: 24px;
            border-radius: 24px;
            border: none;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s;
            box-shadow: 0 15px 35px rgba(190, 24, 93, 0.25);
            font-family: 'Poppins', sans-serif;
            letter-spacing: 0.5px;
        }

        @media (max-width: 640px) {
            .btn-submit {
                padding: 18px;
                font-size: 16px;
                border-radius: 20px;
                margin-top: 30px;
            }
        }

        .btn-submit:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 45px rgba(190, 24, 93, 0.35);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        /* ===== CATATAN PRODUK ===== */
        .catatan-box {
            position: relative;
            background: #fff;
            border-radius: 14px;
        }

        .catatan-icon {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 14px;
            opacity: 0.6;
        }

        .catatan-box textarea {
            width: 100%;
            min-height: 44px;
            padding: 8px 10px 8px 30px;
            border-radius: 12px;
            border: 1.5px solid #f3c2cd;
            font-size: 13px;
            resize: vertical;
            outline: none;
            transition: 0.25s;
            background: #fff;
        }

        .catatan-box textarea:focus {
            border-color: #f28aa5;
            box-shadow: 0 0 0 3px rgba(247,166,184,0.25);
        }

        .catatan-box textarea::placeholder {
            color: #9ca3af;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .total-box {
                position: sticky;
                bottom: 10px;
                z-index: 9;
            }
        }

        /* ===== INFO TEXT ===== */
        .info-text {
            background: linear-gradient(135deg,#fff6f8,#fdecef);
            padding: 14px 18px;
            border-radius: 16px;
            font-size: 13px;
            margin-bottom: 18px;
            border: 1px solid #f3c2cd;
            color: #8b3f52;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        /* ===== PRODUK GRID ===== */
        .produk-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill,minmax(220px,1fr));
            gap: 14px;
        }

        .produk-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding: 14px;
            border-radius: 16px;
            border: 1.5px solid #fde2e7;
            background: #fff;
            cursor: pointer;
            transition: .25s;
        }

        .produk-item:hover {
            border-color: #f28aa5;
            box-shadow: 0 6px 18px rgba(242,138,165,.2);
        }

        .produk-item input {
            margin-bottom: 6px;
        }

        .produk-item small {
            color: #6b7280;
            font-size: 12px;
        }

        /* ===== RADIO REKOMENDASI ===== */
        .radio-rekom {
            display: flex;
            gap: 16px;
            margin: 15px 0;
        }

        .radio-rekom label {
            padding: 10px 16px;
            border-radius: 14px;
            border: 1.5px solid #f3c2cd;
            cursor: pointer;
            transition: .25s;
        }

        .radio-rekom input {
            margin-right: 6px;
        }

        /* ===== PESANAN TABLE IMPROVE ===== */
        tbody tr:first-child {
            background: #fdecef;
        }

        tbody tr td {
            vertical-align: middle;
        }

        tbody tr td:first-child {
            font-weight: 500;
        }

        .radio-modern {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-top: 12px;
        }

        .radio-pill {
            position: relative;
            cursor: pointer;
        }

        .radio-pill input {
            display: none;
        }

        .radio-pill span {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 50px;
            border: 1.5px solid #f3c2cd;
            background: #fff;
            font-size: 14px;
            font-weight: 500;
            transition: 0.25s ease;
        }

        /* Hover effect */
        .radio-pill span:hover {
            border-color: #e85d88;
        }

        /* ACTIVE STYLE */
        .radio-pill input:checked + span {
            background: linear-gradient(135deg,#ff9fba,#e85d88);
            color: #fff;
            border-color: #e85d88;
            box-shadow: 0 8px 18px rgba(232,93,136,.35);
            transform: translateY(-1px);
        }

        /* ================= PESANAN SAYA CLEAN ================= */

        .pesanan-table {
            width: 100%;
            border-collapse: collapse;
        }

        .pesanan-table thead th {
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            color: #9ca3af;
            padding-bottom: 12px;
            border-bottom: 1px solid #f3d3db;
        }

        .pesanan-table tbody tr {
            border-bottom: 1px solid #f9e4ea;
        }

        .pesanan-table tbody tr:last-child {
            border-bottom: none;
        }

        .pesanan-table td {
            padding: 16px 8px;
            vertical-align: middle;
        }

        .paket-row {
            background: linear-gradient(135deg,#fff0f5,#fdecef);
            font-weight: 600;
            border-radius: 14px;
        }

        .sub-produk {
            color: #6b7280;
            font-weight: 500;
        }

        .total-row {
            background: #fff3f6;
            font-weight: 700;
        }

        .total-row td {
            padding-top: 20px;
            font-size: 15px;
        }

        .total-highlight {
            color: #e85d88;
            font-size: 22px;
        }

        .total-row strong {
            letter-spacing: .3px;
        }

        .btn-hapus {
            background: #fee2e2;
            color: #b91c1c;
            border: none;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 13px;
            cursor: pointer;
            transition: .2s;
        }

        .btn-hapus:hover {
            background: #fecaca;
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .checkout-header h2 {
            font-size: 30px;
            color: #be185d;
            margin-bottom: 6px;
        }

        .checkout-header p {
            font-size: 14px;
            color: #6b7280;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .qty-control button {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            border: none;
            background: #fde2e8;
            cursor: pointer;
            font-weight: bold;
        }

        .qty-control button:hover {
            background: #f8c7d4;
        }

        .qty-control input {
            width: 45px;
            text-align: center;
            border-radius: 8px;
            border: 1px solid #f3c2cd;
        }

        .row-paket {
            background: #fff1f5;
            font-weight: 600;
        }

        .row-isi-paket {
            background: #fff;
            color: #374151;
        }

        .row-isi-paket td {
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="checkout-header">
        <h2>Checkout Pesanan</h2>
        <p>Lengkapi detail pesanan sebelum konfirmasi 🎂</p>
    </div>


    <form method="POST" action="{{ route('pesanan.konfirmasi') }}">
        <input type="hidden" name="cart_data" id="checkout-cart-data">
        @csrf

        {{-- ================= DATA PEMESAN ================= --}}
        <div class="card">
            <h3><i class="fa-solid fa-user-circle"></i> Informasi Pelanggan</h3>

            <div class="grid-2-col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label>Nama Lengkap</label>
                    <input type="text" value="{{ auth()->user()->name }}" readonly>
                </div>
                <div>
                    <label>Nomor WhatsApp</label>
                    <input type="text" name="phone_pesanan"
                        value="{{ old('phone_pesanan', auth()->user()->phone) }}"
                        placeholder="Contoh: 08123456789">
                </div>
            </div>

            <div style="margin-top: 20px;">
                <label>Tanggal Checkout</label>
                <input type="text" value="{{ now()->format('d F Y') }}" readonly style="background: var(--bg-body);">
            </div>
        </div>

        {{-- ================= TANGGAL PENGAMBILAN ================= --}}
        <style>
            @media (max-width: 640px) {
                .grid-2-col {
                    grid-template-columns: 1fr !important;
                    gap: 15px !important;
                }
            }
        </style>
        <div class="card">
            <h3><i class="fa-solid fa-calendar-check"></i> Waktu Pengambilan</h3>
            
            <div style="background: var(--primary-soft); padding: 20px; border-radius: 20px; border: 1px solid var(--primary-border); margin-bottom: 25px; display: flex; gap: 15px; align-items: center;">
                <i class="fa-solid fa-clock" style="font-size: 24px; color: var(--primary);"></i>
                <p style="margin:0; font-size: 14px; color: var(--primary); font-weight: 500;">
                    ⏰ Pesanan minimal dibuat <strong>H-3 sebelum tanggal pengambilan</strong>.<br>
                    💳 Pembayaran DP wajib dilunasi maksimal <strong>H-2 sebelum tanggal pengambilan</strong>.<br>
                    📅 Pemesanan dapat dilakukan maksimal untuk <strong>jadwal pengambilan 3 bulan ke depan</strong>.<br>
                    🕒 Jam Operasional Pengambilan:<br>
                    • Senin - Jumat: <strong>08:00 - 20:00 WIB</strong><br>
                    • Sabtu - Minggu: <strong>09:00 - 21:00 WIB</strong>
                </p>
            </div>
            
            <div class="grid-2-col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label>Pilih Tanggal</label>
                    <input type="date" id="tanggal_pengambilan" name="tanggal_pengambilan" 
                        min="{{ now('Asia/Jakarta')->addDays(3)->format('Y-m-d') }}"
                        max="{{ now('Asia/Jakarta')->addMonths(3)->format('Y-m-d') }}"
                        value="{{ old('tanggal_pengambilan') }}" required>
                </div>
                <div>
                    <label>Pilih Jam</label>
                    <input type="time" id="jam_pengambilan" name="jam_pengambilan" value="{{ old('jam_pengambilan') }}" step="60" required>
                </div>
            </div>
        </div>

        {{-- ================= PESANAN ================= --}}
        <div class="card">
            <h3>
                <i class="fa-solid fa-basket-shopping"></i> Ringkasan Pesanan
                <span style="background: var(--primary-soft); color: var(--primary); padding: 5px 12px; border-radius: 999px; font-size: 13px; margin-left: 8px; font-weight: 700;">
                    CHECKOUT
                </span>
            </h3>

            <div class="table-responsive">
                <table class="pesanan-table">
                    <thead>
                        <tr>
                            <th>Rincian Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody id="pesanan-body">

                    @php $cartItems = is_array($cart) ? $cart : ($cart ?? []); @endphp
                    @forelse($cartItems as $item)
                        @php
                        if(($item['type'] ?? '') == 'paket'){
                            $hargaPaket = ($item['qty'] ?? 0) > 0 ? ($total ?? 0) / $item['qty'] : 0;
                            $subtotal = $total ?? 0;
                        }else{
                            $hargaPaket = $item['harga'] ?? 0;
                            $subtotal = ($item['qty'] ?? 1) * ($item['harga'] ?? 0);
                        }
                    @endphp

                        <tr
                            id="row-produk-{{ $item['id'] ?? '' }}"
                            class="{{ ($item['type'] ?? '') == 'paket' ? 'row-paket' : 'row-isi-paket' }}"
                        >
                            <td>
                                @if(($item['type'] ?? '') == 'paket')
                                    <strong><i class="fa-solid fa-box-open"></i> {{ $item['nama'] ?? 'Paket' }}</strong>
                                    <div style="font-size:12px;color:rgba(190, 24, 93, 0.7);margin-top:2px;">
                                        Paket utama (Wadah & Kardus)
                                    </div>
                                @else
                                    <span style="padding-left:24px; display:inline-block">
                                        <i class="fa-solid fa-cookie"></i> {{ $item['nama'] ?? 'Produk' }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $item['qty'] ?? 1 }}
                            </td>
                            <td>Rp {{ number_format($hargaPaket ?? 0) }}</td>
                            <td id="subtotal-{{ $item['id'] ?? '' }}">
                                Rp {{ number_format($subtotal ?? 0) }}
                            </td>

                            <td>
                                <div class="catatan-box">
                                    <span class="catatan-icon">📝</span>
                                    <textarea
                                        name="catatan_produk[{{ $item['id'] ?? '' }}]"
                                        rows="2"></textarea>
                                </div>
                            </td>
                        </tr>



                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center">Keranjang kosong</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- ================= METODE PENGAMBILAN ================= --}}
        <div class="card">
            <h3><i class="fa-solid fa-truck-fast"></i> Metode Pengambilan</h3>

            <div class="radio-pill-group">
                <label class="radio-pill">
                    <input type="radio" name="metode_pengambilan" value="ambil" checked>
                    <div class="pill-content">
                        <i class="fa-solid fa-store"></i>
                        <span>Ambil di Toko</span>
                    </div>
                </label>

                <label class="radio-pill">
                    <input type="radio" name="metode_pengambilan" value="kirim">
                    <div class="pill-content">
                        <i class="fa-solid fa-house-chimney"></i>
                        <span>Kirim ke Alamat</span>
                    </div>
                </label>
            </div>

            <div id="box-toko" style="margin-top:25px; padding: 25px; border-radius: 22px; background: rgba(254, 243, 199, 0.3); border: 1px solid #fde68a; display: flex; gap: 20px; align-items: flex-start;">
                <div style="background: #fef3c7; padding: 14px; border-radius: 16px; color: #b45309;">
                    <i class="fa-solid fa-location-dot" style="font-size: 24px;"></i>
                </div>
                <div>
                    <h4 style="margin:0 0 6px 0; color: #92400e; font-size: 16px; font-weight: 700;">Alamat Pengambilan</h4>
                    <p style="margin:0; font-size: 14px; color: #b45309; line-height: 1.6; font-weight: 500;">
                        <strong style="color: #92400e;">Dew’s Cake Official Store</strong><br>
                        Perumahan Bumi Asri Blok O No.1, Kaliombo, Kediri<br>
                        <span style="font-size: 12px; opacity: 0.8; font-style: italic;">*Harap tunjukkan kode pesanan saat pengambilan</span>
                    </p>
                </div>
            </div>

            <div id="box-ongkir" style="display:none; margin-top:15px;">
                @if(auth()->user()->province_id && auth()->user()->city_id && auth()->user()->district_id)
                    <div style="background: #fdf2f4; padding: 20px; border-radius: 18px; border: 1px solid #fce7f3; margin-bottom: 20px;">
                        <h4 style="margin: 0 0 12px 0; font-size: 13px; color: #8b3f52; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Alamat Pengiriman Saya</h4>
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <div style="background: #fff; padding: 10px; border-radius: 12px; color: #d45c7a; box-shadow: 0 4px 10px rgba(212,92,122,0.1);">
                                <i class="fa-solid fa-map-location-dot" style="font-size: 20px;"></i>
                            </div>
                            <div style="flex: 1;">
                                <p style="margin: 0; font-size: 14px; color: #1e293b; line-height: 1.6; font-weight: 500;">
                                    <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->phone }})<br>
                                    {{ auth()->user()->address }}<br>
                                    <span style="font-size: 13px; color: #64748b; font-weight: 500;">
                                        {{ auth()->user()->district_name ? auth()->user()->district_name . ', ' : '' }}
                                        {{ auth()->user()->city_name ? auth()->user()->city_name . ', ' : '' }}
                                        {{ auth()->user()->province_name ? auth()->user()->province_name : '' }}
                                    </span>
                                </p>
                                <a href="{{ route('akun.edit') }}" style="display: inline-block; margin-top: 10px; font-size: 12px; color: #d45c7a; font-weight: 600; text-decoration: none; border-bottom: 1.5px solid rgba(212,92,122,0.3); padding-bottom: 2px; transition: 0.3s;">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit Alamat di Profil
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Hidden inputs to keep the existing JS logic working --}}
                    <input type="hidden" id="provinsi" name="provinsi" value="{{ auth()->user()->province_id }}">
                    <input type="hidden" id="kota" name="kota" value="{{ auth()->user()->city_id }}">
                    <input type="hidden" id="kecamatan" name="kecamatan" value="{{ auth()->user()->district_id }}">
                    <input type="hidden" name="province_name" value="{{ auth()->user()->province_name }}">
                    <input type="hidden" name="city_name" value="{{ auth()->user()->city_name }}">
                    <input type="hidden" name="district_name" value="{{ auth()->user()->district_name }}">
                    <input type="hidden" name="alamat_lengkap" value="{{ auth()->user()->address }}">

                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #8b3f52; margin-bottom: 8px;">Pilih Kurir</label>
                        <select id="kurir" name="kurir" class="form-control" style="width: 100%; padding: 14px; border-radius: 16px; border: 1.5px solid #f3c2cd; background: #fff; appearance: none; cursor: pointer;">
                            <option value="">Pilih Kurir</option>
                            <option value="jne" {{ auth()->user()->preferred_courier == 'jne' ? 'selected' : '' }}>JNE (Reguler)</option>
                            <option value="pos" {{ auth()->user()->preferred_courier == 'pos' ? 'selected' : '' }}>POS Indonesia</option>
                            <option value="tiki" {{ auth()->user()->preferred_courier == 'tiki' ? 'selected' : '' }}>TIKI</option>
                        </select>
                    </div>

                    <div style="background: #fff; padding: 15px; border-radius: 16px; border: 1.5px solid #fce7f3; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 14px; color: #64748b; font-weight: 500;">Estimasi Ongkos Kirim:</span>
                        <span id="ongkir-text-box" style="font-size: 18px; font-weight: 800; color: #be185d;">Rp 0</span>
                    </div>
                    <input type="hidden" name="ongkir" id="ongkir" value="0">
                @else
                    <div style="background: #fff1f2; padding: 30px; border-radius: 24px; border: 1px solid #fecaca; text-align: center; box-shadow: 0 10px 25px rgba(239,68,68,0.05);">
                        <div style="background: #fee2e2; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: #ef4444;">
                            <i class="fa-solid fa-location-dot" style="font-size: 24px;"></i>
                        </div>
                        <h4 style="margin: 0 0 8px 0; color: #991b1b; font-size: 16px; font-weight: 700;">Alamat Belum Lengkap</h4>
                        <p style="margin: 0 0 20px 0; font-size: 13px; color: #b91c1c; line-height: 1.5;">
                            Anda perlu melengkapi data provinsi, kota, dan kecamatan di profil untuk menghitung ongkos kirim.
                        </p>
                        <a href="{{ route('akun.edit') }}" class="btn-submit" style="display: block; padding: 14px; border-radius: 16px; background: linear-gradient(135deg, #f7a6b8, #f28aa5); color: #fff; text-decoration: none; font-weight: 700; font-size: 14px; box-shadow: 0 8px 20px rgba(242, 138, 165, 0.3);">
                            <i class="fa-solid fa-user-gear" style="margin-right: 8px;"></i> Lengkapi Profil Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- ================= JENIS PEMBAYARAN (DP/LUNAS) ================= --}}
        <div class="card">
            <h3><i class="fa-solid fa-credit-card"></i> Pilihan Pembayaran</h3>
            
            <div class="radio-pill-group">
                <label class="radio-pill">
                    <input type="radio" name="jenis_pembayaran" value="lunas" checked>
                    <div class="pill-content">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                        <span>Bayar Lunas</span>
                        <small style="font-size: 11px; color: var(--text-muted); font-weight: 500; margin-top: 4px; display: block;">Bayar tagihan 100%</small>
                    </div>
                </label>
                
                <label class="radio-pill">
                    <input type="radio" name="jenis_pembayaran" value="dp">
                    <div class="pill-content">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                        <span>Bayar DP (50%)</span>
                        <small style="font-size: 11px; color: var(--text-muted); font-weight: 500; margin-top: 4px; display: block;">Bayar DP 50% di awal</small>
                    </div>
                </label>
            </div>
        </div>

        {{-- ================= METODE PEMBAYARAN (ONLINE/CASH) ================= --}}
        <div class="card">
            <h3><i class="fa-solid fa-wallet"></i> Metode Pembayaran</h3>
            
            <div class="radio-pill-group">
                <label class="radio-pill">
                    <input type="radio" name="metode_pembayaran_pilihan" value="online" checked>
                    <div class="pill-content">
                        <i class="fa-solid fa-globe"></i>
                        <span>Transfer Online</span>
                        <small style="font-size: 11px; color: var(--text-muted); font-weight: 500; margin-top: 4px; display: block;">Gopay, OVO, Transfer Bank, dll</small>
                    </div>
                </label>
                
                <label class="radio-pill">
                    <input type="radio" name="metode_pembayaran_pilihan" value="cash">
                    <div class="pill-content">
                        <i class="fa-solid fa-money-bill"></i>
                        <span>Bayar Tunai (Cash)</span>
                        <small style="font-size: 11px; color: var(--text-muted); font-weight: 500; margin-top: 4px; display: block;">Bayar langsung di toko</small>
                    </div>
                </label>
            </div>
            
            <div id="cash-note" style="display:none; margin-top:15px; padding: 15px; border-radius: 14px; background: #fffbeb; border: 1px solid #fef3c7; color: #92400e; font-size: 13px;">
                <i class="fa-solid fa-circle-info"></i> Pembayaran tunai dilakukan langsung di toko saat pengambilan pesanan.
            </div>
        </div>

        {{-- ================= TOTAL & SUBMIT ================= --}}
        <div class="total-box">
            <h3><i class="fa-solid fa-receipt"></i> Ringkasan Biaya</h3>
            
            <div class="total-line">
                <span>Total Produk</span>
                <span id="total-produk-text">
                    @php
                        // Hitung biaya wadah awal untuk ditampilkan
                        $biayaWadahAwal = 0;
                        if(isset($paketDipilih)) {
                            // Hitung total kue di keranjang
                            $totalKueCart = 0;
                            foreach($cart as $cartItem) {
                                if(in_array(($cartItem['type'] ?? ''), ['produk', 'rekomendasi'])) {
                                    $totalKueCart += $cartItem['qty'];
                                }
                            }
                            // Jika ada kue, hitung box
                            if($totalKueCart > 0) {
                                $kardusCart = ceil($totalKueCart / max(1, $paketDipilih->max_kue));
                                $biayaWadahAwal = $kardusCart * $paketDipilih->biaya_wadah;
                            }
                        }
                    @endphp
                    Rp {{ number_format($total) }}
                </span>
            </div>

            @if($biayaWadahAwal > 0)
            <div class="total-line" id="biaya-wadah-row">
                <span id="biaya-wadah-label">Biaya Packaging ({{ $kardusCart }} box)</span>
                <span id="biaya-wadah-val">Rp {{ number_format($biayaWadahAwal) }}</span>
            </div>
            @else
            <div class="total-line" id="biaya-wadah-row" style="display:none;">
                <span id="biaya-wadah-label"></span>
                <span id="biaya-wadah-val"></span>
            </div>
            @endif

            <div class="total-line">
                <span>Biaya Pengiriman (Ongkir)</span>
                <span id="ongkir-text-total">Rp 0</span>
            </div>

            <div class="total-line grand">
                <span>Total Pesanan</span>
                <span id="grand-total-text" style="font-size: 20px; color: #fff;">Rp {{ number_format($total + $biayaWadahAwal) }}</span>
            </div>

            <div class="total-line now-paying">
                <span>Total Pembayaran Saat Ini</span>
                <strong id="total-text">Rp {{ number_format($total + $biayaWadahAwal) }}</strong>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            Buat Pesanan & Bayar Sekarang <i class="fa-solid fa-arrow-right" style="margin-left: 10px;"></i>
        </button>

    </form>
</div>

<script>
const paketAktif = @json(optional($paketDipilih));

function getQtyPaket() {
    const el = document.getElementById('paket-qty');
    return el ? parseInt(el.innerText) || 1 : 1;
}

function updatePaketRowManual() {
    const hargaCell = document.getElementById('paket-harga');
    const subtotalCell = document.getElementById('paket-subtotal');

    if (!hargaCell || !subtotalCell) return;

    const qtyPaket = getQtyPaket();
    const subtotal = totalManual || 0;

    // 🔥 harga = subtotal / jumlah
    const hargaSatuan = qtyPaket > 0
        ? Math.floor(subtotal / qtyPaket)
        : 0;

    hargaCell.innerText =
        'Rp ' + hargaSatuan.toLocaleString('id-ID');

    subtotalCell.innerText =
        'Rp ' + subtotal.toLocaleString('id-ID');
}

const submitBtn = document.querySelector('.btn-submit');

let backendTotal = Number(@json($total ?? 0));
let totalProduk = {{ $total ?? 0 }};
let initialBiayaWadah = {{ $biayaWadahAwal ?? 0 }};
const ongkirInput = document.getElementById('ongkir');

const totalText       = document.getElementById('total-text');
const totalProdukText = document.getElementById('total-produk-text');
const ongkirBox       = document.getElementById('box-ongkir');
const ongkirTextBox   = document.getElementById('ongkir-text-box');
const ongkirTextTotal = document.getElementById('ongkir-text-total');

ongkirInput.addEventListener('input', updateTotal);

// Removed legacy rekomYa/rekomTidak logic to prevent ReferenceErrors and accidental UI resets.
// The checkout page now simply renders the items already stored in the session cart.

    // Mode determination is now handled by the data in the session cart,
    // so we don't need these manual radio toggles which were clearing the table.

document.addEventListener('DOMContentLoaded', function () {

    const alamatInput = document.getElementById('alamat_pesanan');
    const ongkirBox   = document.getElementById('box-ongkir');
    const ongkirInput = document.getElementById('ongkir');
    
    // RajaOngkir Elements
    const propinsiSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota');
    const kecamatanSelect = document.getElementById('kecamatan');
    const kurirSelect = document.getElementById('kurir');

    document.querySelectorAll('input[name="metode_pengambilan"]')
        .forEach(radio => {
            radio.addEventListener('change', function () {

                if (this.value === 'kirim') {

                    ongkirBox.style.display = 'block';
                    document.getElementById('box-toko').style.display = 'none';

                    // If it's a select element, load provinces
                    if (propinsiSelect && propinsiSelect.tagName === 'SELECT' && propinsiSelect.options.length <= 1) {
                        fetchProvinces();
                    }

                    // If we have values and kurir, trigger cekOngkir
                    if (kurirSelect && kurirSelect.value) {
                        checkOngkir(kecamatanSelect.value, kurirSelect.value);
                    }

                } else {
                    ongkirBox.style.display = 'none';
                    document.getElementById('box-toko').style.display = 'block';
                    ongkirInput.value = 0;
                    
                    // Reset dropdowns if they exist
                    if (propinsiSelect && propinsiSelect.tagName === 'SELECT') {
                        propinsiSelect.value = '';
                        kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                        kotaSelect.disabled = true;
                        kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                        kecamatanSelect.disabled = true;
                        kurirSelect.value = '';
                        kurirSelect.disabled = true;
                    }
                    
                    updateTotal();
                }
            });
        });

    // Trigger on load for existing selection
    const checkedRadio = document.querySelector('input[name="metode_pengambilan"]:checked');
    if (checkedRadio) {
        checkedRadio.dispatchEvent(new Event('change'));
    }

    // Fetch Provinces
    function fetchProvinces() {
        propinsiSelect.options[0].textContent = 'Loading...';
        fetch('{{ route("api.provinces") }}')
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    alert('Error: ' + data.message);
                    propinsiSelect.options[0].textContent = 'Pilih Provinsi';
                    return;
                }
                propinsiSelect.options[0].textContent = 'Pilih Provinsi';
                    data.forEach(prov => {
                        const option = document.createElement('option');
                        option.value = prov.id;
                        option.textContent = prov.name;
                        propinsiSelect.appendChild(option);
                    });
            })
            .catch(err => {
                console.error('Error fetching provinces:', err);
                propinsiSelect.options[0].textContent = 'Pilih Provinsi';
            });
    }

    // When Province Changes -> Fetch Cities
    propinsiSelect.addEventListener('change', function() {
        const provId = this.value;
        kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
        kotaSelect.disabled = true;
        kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        kecamatanSelect.disabled = true;
        kurirSelect.value = '';
        kurirSelect.disabled = true;
        
        // Reset ongkir
        ongkirInput.value = 0;
        updateTotal();

        if (provId) {
            kotaSelect.options[0].textContent = 'Loading...';
            
            fetch(`{{ url("api/cities") }}/${provId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert('Error: ' + data.message);
                        kotaSelect.options[0].textContent = 'Pilih Kota/Kabupaten';
                        return;
                    }
                    kotaSelect.options[0].textContent = 'Pilih Kota/Kabupaten';
                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        kotaSelect.appendChild(option);
                    });
                    kotaSelect.disabled = false;
                })
                .catch(err => {
                    console.error('Error fetching cities:', err);
                    kotaSelect.options[0].textContent = 'Pilih Kota/Kabupaten';
                });
        }
    });

    // When City Changes -> Fetch Districts
    kotaSelect.addEventListener('change', function() {
        const cityId = this.value;
        kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        kecamatanSelect.disabled = true;
        kurirSelect.value = '';
        kurirSelect.disabled = true;
        
        // Reset ongkir
        ongkirInput.value = 0;
        updateTotal();

        if (cityId) {
            kecamatanSelect.options[0].textContent = 'Loading...';
            
            fetch(`{{ url("api/districts") }}/${cityId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert('Error: ' + data.message);
                        kecamatanSelect.options[0].textContent = 'Pilih Kecamatan';
                        return;
                    }
                    kecamatanSelect.options[0].textContent = 'Pilih Kecamatan';
                    data.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.id;
                        option.textContent = district.name;
                        kecamatanSelect.appendChild(option);
                    });
                    kecamatanSelect.disabled = false;
                })
                .catch(err => {
                    console.error('Error fetching districts:', err);
                    kecamatanSelect.options[0].textContent = 'Pilih Kecamatan';
                });
        }
    });

    // When District Changes -> Enable Courier
    kecamatanSelect.addEventListener('change', function() {
        if (this.value) {
            kurirSelect.disabled = false;
        } else {
            kurirSelect.value = '';
            kurirSelect.disabled = true;
        }
        
        // Reset ongkir
        ongkirInput.value = 0;
        updateTotal();
    });

    // When Courier Changes -> Check Ongkir
    kurirSelect.addEventListener('change', function() {
        const districtId = kecamatanSelect.value;
        const courier = this.value;
        
        if (districtId && courier) {
            ongkirInput.value = 0;
            if (ongkirTextBox) ongkirTextBox.innerText = 'Menghitung...';
            
            checkOngkir(districtId, courier);
        } else {
            ongkirInput.value = 0;
            updateTotal();
        }
    });

    // Call API Cek Ongkir
    function checkOngkir(destination, courier) {
        
        // --- HITUNG BERAT DINAMIS ---
        let totalBerat = 0;
        const cartItems = @json($cart);
        
        cartItems.forEach(item => {
            if (item.type === 'produk' || item.type === 'rekomendasi') {
                totalBerat += (item.qty * (item.berat || 80));
            }
        });

        // Tambahkan estimasi berat kemasan (box)
        // Misal 1 box = 150 gram
        const elementKardus = document.getElementById('biaya-wadah-label');
        if (elementKardus) {
            const match = elementKardus.innerText.match(/(\d+)\sbox/);
            if (match && match[1]) {
                const jumlahBox = parseInt(match[1]);
                totalBerat += (jumlahBox * 150); // 150gr per box
            }
        }

        // Pastikan minimal berat ke kurir adalah 1000gr (1kg) jika hasil hitungan kecil
        // Tapi kirim berat asli jika lebih berat
        const finalWeight = Math.max(totalBerat, 1000); 

        if (ongkirTextBox) ongkirTextBox.innerText = 'Menghitung (' + (finalWeight/1000).toFixed(1) + ' kg)...';

        fetch('{{ route("cek.ongkir") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                destination: destination,
                weight: finalWeight,
                courier: courier
            })
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data.meta && data.meta.status === 'failed') {
                alert('Gagal mengecek ongkos kirim: ' + data.meta.message);
                ongkirInput.value = 0;
                kurirSelect.value = '';
                updateTotal();
                return;
            }

            const results = data.data;

            if (results && results.length > 0) {
                // Cari layanan REG (Reguler) jika ada, jika tidak pakai layanan pertama
                const layanan = results.find(r => r.service === 'REG') || results[0];
                const cost = layanan.cost;

                ongkirInput.value = cost;

            } else {
                alert('Tidak ada layanan pengiriman.');
            }
            updateTotal();
        })
        .catch(err => {
            console.error('Error checking ongkir:', err);
            alert('Gagal mengecek ongkos kirim. Silakan coba lagi.');
            ongkirInput.value = 0;
            updateTotal();
        });
    }

});
/* ================= MANUAL → PESANAN SAYA REALTIME ================= */

const pesananBody = document.getElementById('pesanan-body');

let totalManual = 0;
const qtyPerJenis = {{ optional($paketDipilih)->qty_per_jenis ?? 1 }};

document.querySelectorAll('.produk-checkbox').forEach(cb => {
    cb.addEventListener('change', function () {

        // hanya aktif jika pilih sendiri
        if (!rekomTidak || !rekomTidak.checked) return;

        const id    = this.value;
        const nama  = this.dataset.nama;
        const harga = parseInt(this.dataset.harga);
        const rowId = `row-produk-${id}`;

        if (this.checked) {

            const qtyPaket = getQtyPaket();
            const qty = qtyPerJenis * qtyPaket;
            const subtotal = harga * qty;
            totalManual += subtotal;

            const tr = document.createElement('tr');
            tr.id = rowId;
            tr.innerHTML = `
                <td class="sub-produk" style="padding-left:32px;">
                    ${nama}
                </td>
                <td>${qty}</td>
                <td>Rp ${harga.toLocaleString('id-ID')}</td>
                <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td>
                    <div class="catatan-box">
                        <span class="catatan-icon">📝</span>
                        <textarea
                            name="catatan_produk[${id}]"
                            rows="2"></textarea>
                    </div>
                </td>
                <td></td>
            `;

            pesananBody.appendChild(tr);

        } else {

            const tr = document.getElementById(rowId);
            if (tr) {
                const qtyPaket = getQtyPaket();
                totalManual -= harga * qtyPerJenis * qtyPaket;
                tr.remove();
            }
        }

        // --- UPDATE BIAYA WADAH SECARA DINAMIS (JIKA MANUAL) ---
        if (paketAktif) {
            // Hitung total kue yang dicentang
            let currentTotalKue = 0;
            document.querySelectorAll('.produk-checkbox:checked').forEach(checkedCb => {
                currentTotalKue += qtyPerJenis * getQtyPaket();
            });

            // Hitung kardus
            const kDib = Math.ceil(currentTotalKue / Math.max(1, paketAktif.max_kue));
            const newBiayaWadah = kDib * paketAktif.biaya_wadah;

            const wadahRow = document.getElementById('biaya-wadah-row');
            if (wadahRow) {
                if (newBiayaWadah > 0) {
                    wadahRow.style.display = 'flex';
                    const wadahVal = document.getElementById('biaya-wadah-val');
                    const wadahTextCell = document.getElementById('biaya-wadah-label');

                    if(wadahVal) wadahVal.innerText = 'Rp ' + newBiayaWadah.toLocaleString('id-ID');
                    if(wadahTextCell) wadahTextCell.innerHTML = `Biaya Packaging (${kDib} box)`;
                    
                    // Update global var utk perhitungan total
                    initialBiayaWadah = newBiayaWadah;
                } else {
                    wadahRow.style.display = 'none';
                    initialBiayaWadah = 0;
                }
            }
        }

        updateTotal();
    });
});

const btnRekom = document.getElementById('btn-rekomendasi');

if (btnRekom) {
    btnRekom.addEventListener('click', () => {
        const budget = document.querySelector('[name="budget"]').value;

        if (!budget) {
            alert('Masukkan budget terlebih dahulu');
            return;
        }

        fetch('{{ route("paket.rekomendasi") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                budget: budget,
                paket_id: paketId
            })
        })
        .then(() => {
            window.location.href = "{{ route('checkout') }}";
        });
    });
}


function updateTotal() {
    const ongkirVal = document.getElementById('ongkir');
    const ongkir = ongkirVal ? parseInt(ongkirVal.value) || 0 : 0;

    // totalAktif is products + packaging
    let currentTotal = backendTotal + initialBiayaWadah;
    
    // Grand Total
    const grandTotal = currentTotal + ongkir;

    // 1. Update Total Produk Murni
    const produkMurniText = document.getElementById('total-produk-text');
    if (produkMurniText) {
        produkMurniText.innerText = 'Rp ' + backendTotal.toLocaleString('id-ID');
    }

    // 2. Update Biaya Wadah Val
    const wadahValText = document.getElementById('biaya-wadah-val');
    if (wadahValText) {
        wadahValText.innerText = 'Rp ' + initialBiayaWadah.toLocaleString('id-ID');
    }

    // 3. Update Ongkir (Box & Total)
    const ongkirBoxText = document.getElementById('ongkir-text-box');
    if (ongkirBoxText) {
        ongkirBoxText.innerText = 'Rp ' + ongkir.toLocaleString('id-ID');
    }
    const ongkirTotalText = document.getElementById('ongkir-text-total');
    if (ongkirTotalText) {
        ongkirTotalText.innerText = 'Rp ' + ongkir.toLocaleString('id-ID');
    }

    // 4. Update Grand Total (Total Pesanan)
    const grandTotalEl = document.getElementById('grand-total-text');
    if (grandTotalEl) {
        grandTotalEl.innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    // 5. Hitung DP atau Lunas
    const dpRadio = document.querySelector('input[name="jenis_pembayaran"]:checked');
    const dpSelected = dpRadio ? dpRadio.value === 'dp' : false;
    const totalBayarSekarang = dpSelected ? Math.floor(grandTotal / 2) : grandTotal;

    // 6. Update Total Pembayaran Saat Ini
    const totalBayarSekarangEl = document.getElementById('total-text');
    if (totalBayarSekarangEl) {
        totalBayarSekarangEl.innerText = 'Rp ' + totalBayarSekarang.toLocaleString('id-ID');
    }
}

// Tambahkan Listener untuk pilihan DP/Lunas
const rbs = document.querySelectorAll('input[name="jenis_pembayaran"]');

rbs.forEach(rb => {
    rb.addEventListener('change', function() {
        updateTotal();
    });
});

// JS for Cash vs Online
const rbsMetode = document.querySelectorAll('input[name="metode_pembayaran_pilihan"]');
const cashNote = document.getElementById('cash-note');
const submitBtnReal = document.querySelector('.btn-submit');

rbsMetode.forEach(rb => {
    rb.addEventListener('change', function() {
        if (this.value === 'cash') {
            cashNote.style.display = 'block';
            submitBtnReal.innerHTML = 'Buat Pesanan & Bayar Tunai <i class="fa-solid fa-arrow-right" style="margin-left: 10px;"></i>';
        } else {
            cashNote.style.display = 'none';
            submitBtnReal.innerHTML = 'Buat Pesanan & Bayar Sekarang <i class="fa-solid fa-arrow-right" style="margin-left: 10px;"></i>';
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    updateTotal();
});

// 🔒 pastikan total awal terhitung
updateTotal();

const alamatInput = document.querySelector('[name="alamat_pesanan"]');
// 🔥 Trigger saat alamat berubah
let timeoutAlamat;
// alamatInput.addEventListener('input', function () {
//     clearTimeout(timeoutAlamat);

//     timeoutAlamat = setTimeout(() => {

//         // ❌ JANGAN HITUNG ONGKIR JIKA AMBIL DI TOKO
//         const metode = document.querySelector('[name="metode_pengambilan"]:checked')?.value;
//         if (metode !== 'kirim') return;

//         if (this.value.length > 10) {
//             hitungOngkirDariAlamat(this.value);
//         }

//     }, 800);
// });

submitBtn.addEventListener('click', function (e) {
    const metode = document.querySelector('[name="metode_pengambilan"]:checked')?.value;

    if (metode === 'kirim' && parseInt(ongkirInput.value) <= 0) {
        e.preventDefault();
        alert('Alamat belum valid, ongkir belum dihitung.');
        return;
    }

    const tglAmbil = document.getElementById('tanggal_pengambilan').value;
    if (tglAmbil) {
        const selectedDate = new Date(tglAmbil);
        const today = new Date();
        
        // Min Date (H-3)
        const minDate = new Date(today);
        minDate.setDate(today.getDate() + 3);
        minDate.setHours(0, 0, 0, 0);
        
        // Max Date (3 Months)
        const maxDate = new Date(today);
        maxDate.setMonth(today.getMonth() + 3);
        maxDate.setHours(0, 0, 0, 0);
        
        selectedDate.setHours(0, 0, 0, 0);

        if (selectedDate < minDate) {
            e.preventDefault();
            alert('Pemesanan minimal H-3 sebelum tanggal pengambilan. Tanggal paling awal yang tersedia adalah ' + minDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }));
            return;
        }

        if (selectedDate > maxDate) {
            e.preventDefault();
            alert('Pemesanan maksimal 3 bulan dari tanggal sekarang. Tanggal paling akhir yang tersedia adalah ' + maxDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }));
            return;
        }

        // Jam Pengambilan Validation
        const jamAmbil = document.getElementById('jam_pengambilan').value;
        if (jamAmbil) {
            const day = selectedDate.getDay(); // 0: Sunday, 1-5: Mon-Fri, 6: Saturday
            const [hour, minute] = jamAmbil.split(':').map(Number);
            
            let minH, maxH, scheduleText;
            if (day === 0 || day === 6) { // Weekend
                minH = 9;
                maxH = 21;
                scheduleText = "Sabtu - Minggu: 09:00 - 21:00";
            } else { // Weekday
                minH = 8;
                maxH = 20;
                scheduleText = "Senin - Jumat: 08:00 - 20:00";
            }

            if (hour < minH || hour > maxH || (hour === maxH && minute > 0)) {
                e.preventDefault();
                alert('Jam pengambilan tidak valid.\nJadwal Operasional:\n' + scheduleText);
                return;
            }
        }
    }

    // Use the backend session cart as the absolute source of truth
    const cartData = @json($cart);
    document.getElementById('checkout-cart-data').value = JSON.stringify(cartData);
});

// function updateTotalAfterRemove() {
//     updateTotalDynamic();
// }

console.log('SCRIPT SAMPAI SINI');
</script>

</body>
</html>