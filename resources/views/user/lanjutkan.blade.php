@extends('layouts.user')

@section('title', 'Konfirmasi Pesanan - Dew\'s Cake')

@section('style')
<style>
    :root {
        --primary-pink: #f7a6b8;
        --secondary-pink: #f28aa5;
        --accent-pink: #be185d;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.4);
    }

    .payment-page-container {
        min-height: calc(100vh - 250px);
        padding: 50px 20px;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 35px;
        max-width: 800px;
        margin: 0 auto;
        padding: 45px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
    }

    .page-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .page-title h2 {
        font-size: 30px;
        font-weight: 800;
        color: #8b3f52;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .page-title p {
        color: #6b7280;
        font-size: 15px;
        margin-top: 10px;
    }

    .review-section {
        margin-bottom: 30px;
        background: #ffffff;
        border: 1px solid #fce7f3;
        border-radius: 24px;
        padding: 25px;
        transition: 0.3s;
    }

    .review-section:hover {
        border-color: var(--primary-pink);
        box-shadow: 0 10px 30px rgba(247, 166, 184, 0.1);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 16px;
        font-weight: 700;
        color: #8b3f52;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #fce7f3;
    }

    .section-title i { color: var(--primary-pink); font-size: 18px; }

    /* INFO GRID */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .info-item label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .info-item span {
        font-size: 15px;
        font-weight: 600;
        color: #374151;
    }

    /* PRODUCT LIST */
    .product-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px dashed #fce7f3;
    }

    .product-row:last-child { border-bottom: none; }

    .product-info {
        display: flex;
        flex-direction: column;
    }

    .product-name { font-weight: 600; color: #374151; }
    .product-qty { font-size: 13px; color: #9ca3af; }
    .product-price { font-weight: 700; color: #8b3f52; }

    /* SUMMARY */
    .summary-total {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px solid #fce7f3;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .total-label { font-size: 18px; font-weight: 800; color: #374151; }
    .total-value { font-size: 24px; font-weight: 900; color: var(--accent-pink); }

    /* FORM STYLES */
    .form-label {
        font-size: 14px;
        font-weight: 700;
        color: #8b3f52;
        margin-bottom: 12px;
        display: block;
    }

    .custom-select {
        width: 100%;
        padding: 15px 20px;
        border-radius: 18px;
        border: 2px solid #fce7f3;
        background: #fff;
        font-family: inherit;
        font-weight: 600;
        color: #374151;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23f28aa5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 20px center;
        background-size: 18px;
    }

    .custom-select:focus {
        outline: none;
        border-color: var(--primary-pink);
        box-shadow: 0 0 0 4px rgba(247, 166, 184, 0.1);
    }

    .btn-main {
        width: 100%;
        padding: 18px;
        border-radius: 22px;
        border: none;
        font-weight: 800;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        color: #fff;
        background: linear-gradient(135deg, #f7a6b8, #f28aa5);
        box-shadow: 0 12px 28px rgba(242, 138, 165, 0.4);
        margin-top: 20px;
    }

    .btn-main:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(242, 138, 165, 0.5);
    }

    .trust-indicator {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        margin-top: 25px;
        color: #9ca3af;
        font-size: 13px;
    }

    .trust-indicator i { color: #10b981; }

    /* RESPONSIVE */
    @media (max-width: 640px) {
        .glass-card { padding: 30px 20px; }
        .info-grid { grid-template-columns: 1fr; gap: 15px; }
        .page-title h2 { font-size: 24px; }
        .total-value { font-size: 20px; }
    }
</style>
@endsection

@section('content')
<div class="payment-page-container">
    <div class="glass-card">
        <div class="page-title">
            <h2>🥧 Langkah Terakhir!</h2>
            <p>Silakan tinjau kembali rincian pesanan Anda sebelum melakukan pembayaran.</p>
        </div>

        {{-- DETAIL PESANAN --}}
        <div class="review-section">
            <div class="section-title">
                <i class="fa-solid fa-receipt"></i> Ringkasan Nota
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <label>Nomor Nota</label>
                    <span>#ORD-{{ str_pad($pesanan->pesanan_id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="info-item">
                    <label>Status</label>
                    <span style="color: #be185d;">{{ ucfirst(str_replace('_',' ', $pesanan->status_pesanan)) }}</span>
                </div>
                <div class="info-item">
                    <label>Tanggal Pengambilan</label>
                    <span>{{ \Carbon\Carbon::parse($pesanan->tanggal_pengambilan)->format('d F Y') }}</span>
                </div>
                <div class="info-item">
                    <label>Waktu Transaksi</label>
                    <span>{{ $pesanan->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- RINCIAN PRODUK --}}
        <div class="review-section">
            <div class="section-title">
                <i class="fa-solid fa-cake-candles"></i> Rincian Produk
            </div>
            <div class="products-container">
                @foreach($pesanan->detailPesanan as $item)
                    <div class="product-row">
                        <div class="product-info">
                            <span class="product-name">{{ $item->produk->nama_produk }}</span>
                            <span class="product-qty">Jumlah: {{ $item->qty }}</span>
                        </div>
                        <span class="product-price">Rp {{ number_format($item->subtotal,0,',','.') }}</span>
                    </div>
                @endforeach
            </div>

            <div class="summary-total">
                <span class="total-label">Total Pembayaran</span>
                <span class="total-value">Rp {{ number_format($pesanan->total_harga,0,',','.') }}</span>
            </div>
        </div>

        {{-- METODE PENGAMBILAN --}}
        <div class="review-section">
            <div class="section-title">
                <i class="fa-solid fa-truck-ramp-box"></i> Metode Pengiriman
            </div>
            
            @if(!$pesanan->metode_pengambilan_id)
                <form action="{{ route('pesanan.updateMetode',$pesanan->pesanan_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <label class="form-label">Silakan Pilih Metode:</label>
                    <select name="metode_pengambilan_id" class="custom-select" required>
                        <option value="">-- Klik untuk memilih --</option>
                        @foreach($metode as $m)
                            <option value="{{ $m->metode_pengambilan_id }}">
                                {{ $m->nama_metode }} (+Rp {{ number_format($m->biaya,0,',','.') }})
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn-main">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan & Lanjutkan
                    </button>
                </form>
            @else
                <div class="info-grid" style="grid-template-columns: 1fr;">
                    <div class="info-item">
                        <label>Metode Terpilih</label>
                        <span style="font-size: 16px; color: #166534;">
                            <i class="fa-solid fa-circle-check"></i> 
                            {{ $pesanan->metodePengambilan->nama_metode }} 
                            (Rp {{ number_format($pesanan->metodePengambilan->biaya,0,',','.') }})
                        </span>
                    </div>
                </div>
            @endif
        </div>

        {{-- BUTTON BAYAR --}}
        @if($pesanan->status_pesanan == 'menunggu_pembayaran' && $pesanan->metode_pengambilan_id)
            <form action="{{ route('pesanan.bayar',$pesanan->pesanan_id) }}" method="POST" style="margin-top: 20px;">
                @csrf
                <button type="submit" class="btn-main" style="background: linear-gradient(135deg, #be185d, #9d174d); box-shadow: 0 12px 28px rgba(190, 24, 93, 0.3);">
                    <i class="fa-solid fa-credit-card"></i> Bayar Sekarang via Midtrans
                </button>
            </form>
            
            <div class="trust-indicator">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Pembayaran Aman & Terenkripsi via Midtrans</span>
            </div>
        @endif

        @if($pesanan->metode_pengambilan_id)
        <div style="text-align: center; margin-top: 25px;">
            <a href="{{ route('pesanan.saya') }}" style="color: #94a3b8; text-decoration: none; font-size: 13px; font-weight: 600;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Pesanan Saya
            </a>
        </div>
        @endif
    </div>
</div>
@endsection