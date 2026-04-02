@extends('layouts.user')

@section('title', 'Selesaikan Pembayaran - Dew\'s Cake')

@section('style')
<script type="text/javascript"
    src="{{ env('MIDTRANS_IS_PRODUCTION') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
</script>
<style>
.pay-wrapper {
    max-width: 750px;
    margin: 60px auto;
    padding: 35px;
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 14px 40px rgba(0,0,0,0.08);
}
.pay-icon {
    font-size: 50px;
    text-align: center;
    margin-bottom: 15px;
}
.pay-title {
    color: #be185d;
    font-size: 26px;
    text-align: center;
    margin-bottom: 8px;
    font-weight: 700;
}
.pay-desc {
    color: #6b7280;
    text-align: center;
    margin-bottom: 30px;
    font-size: 15px;
}
.order-details {
    background: #fff9fb;
    border: 1px solid #fce7f3;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 30px;
    font-size: 14px;
}
.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px dashed #fbcfe8;
}
.detail-row:last-child {
    border-bottom: none;
}
.detail-label {
    color: #8b3f52;
    font-weight: 600;
    width: 40%;
}
.detail-value {
    color: #374151;
    width: 60%;
    text-align: right;
    font-weight: 500;
}
.products-table {
    width: 100%;
    margin-top: 15px;
    border-collapse: collapse;
}
.products-table th {
    background: #fdf2f8;
    color: #9d174d;
    padding: 10px;
    font-size: 13px;
    text-align: left;
    border-radius: 8px;
}
.products-table td {
    padding: 10px;
    border-bottom: 1px solid #fce7f3;
}
.highlight-amount {
    font-size: 24px;
    color: #ec4899;
    font-weight: 800;
    text-align: center;
    margin-bottom: 25px;
}
.btn-pay {
    background: linear-gradient(135deg,#f7a6b8,#f28aa5);
    color: white;
    border: none;
    padding: 16px 30px;
    border-radius: 999px;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(247,166,184,0.45);
    transition: 0.3s;
    width: 100%;
    margin-bottom: 15px;
    box-sizing: border-box;
}
.btn-pay:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(247,166,184,0.55);
}
.btn-back {
    display: block;
    text-align: center;
    color: #8b3f52;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    margin-top: 15px;
}
.btn-back:hover {
    text-decoration: underline;
}
.status-badge {
    background: #fef08a;
    color: #854d0e;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.status-badge.lunas {
    background: #dcfce7;
    color: #166534;
}
.cash-payment-info {
    background: #ffffff;
    border: 2px solid #fef3c7;
    border-radius: 24px;
    padding: 40px 30px;
    text-align: center;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(217, 119, 6, 0.05);
}
.cash-payment-info .icon-box {
    width: 70px;
    height: 70px;
    background: #fffbeb;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: #d97706;
    font-size: 32px;
}
.cash-payment-info h3 {
    color: #92400e;
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 15px;
}
.cash-payment-info p {
    color: #7c3aed; /* Replaced with a more elegant tone if needed, but let's stick to theme */
    color: #b45309;
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 0;
}
.cash-payment-info .amount-highlight {
    display: block;
    font-size: 26px;
    color: #d97706;
    font-weight: 800;
    margin: 15px 0;
}
/* RESPONSIVE */
@media (max-width: 640px) {
    .pay-wrapper {
        margin: 20px auto;
        padding: 20px;
        border-radius: 16px;
    }
    .pay-title { font-size: 22px; }
    .pay-desc { font-size: 14px; margin-bottom: 20px; }
    
    .order-details { padding: 15px; border-radius: 12px; }
    .detail-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
        padding: 12px 0;
    }
    .detail-label, .detail-value {
        width: 100%;
        text-align: left;
    }
    .detail-value { font-size: 15px; }

    .products-table th, .products-table td {
        padding: 8px 5px;
        font-size: 12px;
    }
    
    .highlight-amount { font-size: 20px; }
    .btn-pay { padding: 14px 20px; font-size: 16px; }
    
    .cash-payment-info { padding: 30px 20px; }
    .cash-payment-info h3 { font-size: 18px; }
    .cash-payment-info .amount-highlight { font-size: 22px; }
}
</style>
@endsection

@section('content')
<div class="pay-wrapper">
    <div class="pay-icon">🧾</div>
    <h2 class="pay-title">Selesaikan Pembayaran</h2>
    <p class="pay-desc">
        Harap periksa kembali detail pesanan Anda sebelum melakukan pembayaran.<br>
        @if($pembayaran->metode_pembayaran != 'cash')
        <span style="color: #be185d; font-weight: 600; font-size: 13px; display: block; margin-top: 5px;">
            <i class="fa-solid fa-clock-rotate-left"></i> Pesanan otomatis dibatalkan jika tidak dibayar dalam 24 jam.
        </span>
        @endif
    </p>

    <div class="order-details">
        @php $step = 1; @endphp
        <div class="detail-row">
            <span class="detail-label">{{ $step++ }}. Nomor Pesanan</span>
            <span class="detail-value">#ORD-{{ str_pad($pesanan->pesanan_id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">{{ $step++ }}. Tanggal Pesanan</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y, H:i') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">{{ $step++ }}. Data Pemesan</span>
            <span class="detail-value">{{ $pesanan->user->name ?? 'User' }} <br> ({{ $pesanan->phone_pesanan }})</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">{{ $step++ }}. Waktu Pengambilan</span>
            <span class="detail-value">
                {{ \Carbon\Carbon::parse($pesanan->tanggal_pengambilan)->translatedFormat('d F Y') }} <br>
                Jam: {{ \Carbon\Carbon::parse($pesanan->tanggal_pengambilan)->translatedFormat('H:i') }} WIB
            </span>
        </div>
        
        <div style="margin: 20px 0;">
            <span class="detail-label">{{ $step++ }}. Detail Pesanan:</span>
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pesanan->paket)
                    <tr style="background: #fff1f5; font-weight: 700;">
                        <td><i class="fa-solid fa-box-open" style="color: #be185d;"></i> {{ $pesanan->paket->nama_paket }}</td>
                        <td style="text-align: center;">{{ $pesanan->jumlah_paket }}</td>
                        @php
                            $subtotalProduk = $pesanan->total_harga - $pesanan->biaya_wadah - ($pesanan->ongkir ?? 0);
                        @endphp
                        <td style="text-align: right;">Rp {{ number_format($subtotalProduk, 0, ',', '.') }}</td>
                    </tr>
                    @endif

                    @foreach($pesanan->detail as $item)
                    <tr>
                        <td style="{{ $pesanan->paket ? 'padding-left: 30px;' : '' }}">
                            @if($pesanan->paket)
                                <i class="fa-solid fa-cookie" style="font-size: 12px; color: #f472b6;"></i>
                            @endif
                            {{ $item->produk->nama_produk ?? 'Paket/Produk' }}
                        </td>
                        <td style="text-align: center;">{{ $item->jumlah }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="detail-row">
            <span class="detail-label">{{ $step++ }}. Metode Pengambilan</span>
            <span class="detail-value">
                {{ $pesanan->metode_pengambilan_id == 1 ? 'Ambil di Toko' : 'Dikirim' }}
            </span>
        </div>

        @if($pesanan->metode_pengambilan_id == 2)
        <div class="detail-row">
            <span class="detail-label">{{ $step++ }}. Alamat Pengiriman</span>
            <span class="detail-value">{{ $pesanan->alamat_pesanan }}</span>
        </div>
        @endif
        
        <div class="detail-row">
            <span class="detail-label">{{ $step++ }}. Jenis Pembayaran</span>
            <span class="detail-value" style="text-transform: uppercase; font-weight: 700; color: #db2777;">
                @php
                    $dpPaid = $pesanan->pembayaran->where('jenis_pembayaran', 'dp')->where('status_pembayaran', 'berhasil')->sum('jumlah_bayar');
                @endphp
                @if($dpPaid > 0 && $pembayaran->jenis_pembayaran == 'lunas')
                    Pelunasan (Sisa 50%)
                @else
                    {{ $pembayaran->jenis_pembayaran == 'dp' ? 'Bayar DP (50%)' : 'Bayar Lunas (100%)' }}
                @endif
            </span>
        </div>

        <div style="margin: 20px 0; padding-top: 15px; border-top: 2px solid #fbcfe8;">
            <span class="detail-label" style="display: block; margin-bottom: 10px; font-size: 16px;">{{ $step++ }}. Rincian Pembayaran:</span>
            
            <div class="detail-row" style="border-bottom: none; padding: 4px 0;">
                <span class="detail-label" style="font-weight: 500;">Total Produk</span>
                <span class="detail-value">Rp {{ number_format($pesanan->total_harga - $pesanan->biaya_wadah - ($pesanan->ongkir ?? 0), 0, ',', '.') }}</span>
            </div>
            
            @if($pesanan->biaya_wadah > 0)
            <div class="detail-row" style="border-bottom: none; padding: 4px 0;">
                <span class="detail-label" style="font-weight: 500;">Biaya Packaging</span>
                <span class="detail-value">Rp {{ number_format($pesanan->biaya_wadah, 0, ',', '.') }}</span>
            </div>
            @endif
            
            @if($pesanan->metode_pengambilan_id == 2)
            <div class="detail-row" style="border-bottom: none; padding: 4px 0;">
                <span class="detail-label" style="font-weight: 500;">Ongkos Kirim</span>
                <span class="detail-value">Rp {{ number_format($pesanan->ongkir ?? 0, 0, ',', '.') }}</span>
            </div>
            @endif

            @if($dpPaid > 0)
            <div class="detail-row" style="border-bottom: none; padding: 4px 0;">
                <span class="detail-label" style="font-weight: 500; color: #166534;">Sudah Dibayar (DP)</span>
                <span class="detail-value" style="color: #166534;">- Rp {{ number_format($dpPaid, 0, ',', '.') }}</span>
            </div>
            @endif

            <div class="detail-row" style="border-bottom: none; padding-top: 15px; font-size: 16px;">
                <span class="detail-label" style="color: #be185d;">{{ $dpPaid > 0 ? 'Sisa Pelunasan' : 'Total Pembayaran' }}</span>
                <span class="detail-value" style="color: #be185d; font-size: 18px; font-weight: 800;">
                    Rp {{ number_format($pesanan->total_harga - $dpPaid, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="detail-row">
            <span class="detail-label">{{ $step++ }}. Status Pembayaran</span>
            <span class="detail-value">
                <span class="status-badge {{ $pembayaran->status_pembayaran == 'lunas' ? 'lunas' : '' }}">
                    {{ str_replace('_', ' ', strtoupper($pembayaran->status_pembayaran)) }}
                </span>
            </span>
        </div>
    </div>
    
    @if($pembayaran->metode_pembayaran == 'cash')
        <div class="cash-payment-info">
            <div class="icon-box">
                <i class="fa-solid fa-store"></i>
            </div>
            <h3>Pemesanan Berhasil!</h3>
            <p>Silakan lakukan pembayaran tunai sebesar:</p>
            <span class="amount-highlight">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
            <p style="font-size: 14px; opacity: 0.8;">
                Pembayaran dilakukan langsung di toko kami saat Anda mengambil pesanan. Simpan nomor pesanan Anda untuk ditunjukkan kepada staff kami.
            </p>
        </div>
        
        <a href="{{ route('pesanan.saya') }}" class="btn-pay" style="text-decoration: none; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);">
            <i class="fa-solid fa-circle-check" style="margin-right: 10px;"></i> Selesai & Ke Pesanan Saya
        </a>
    @else
        <div class="highlight-amount">
            Akan Dibayar: Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
        </div>

        <!-- 10. Tombol Bayar Sekarang -->
        <button id="pay-button" class="btn-pay">Bayar Sekarang</button>
        
        <a href="{{ route('pesanan.saya') }}" class="btn-back">Bayar Nanti (Ke Menu Pesanan Saya)</a>

        @if($pesanan->status_pesanan == 'menunggu_pembayaran')
        <div style="margin-top: 30px; text-align: center; border-top: 1px solid #fce7f3; padding-top: 20px;">
            <p style="font-size: 13px; color: #9ca3af; margin-bottom: 15px;">Ingin membatalkan pesanan ini?</p>
            <form id="cancel-form" action="{{ route('pesanan.cancel', $pesanan->pesanan_id) }}" method="POST">
                @csrf
                <button type="button" id="btn-cancel-order" style="background: none; border: 1px solid #fca5a5; color: #ef4444; padding: 8px 20px; border-radius: 999px; font-size: 13px; font-weight: 600; cursor: pointer; transition: 0.3s;">
                    <i class="fa-solid fa-xmark" style="margin-right: 5px;"></i> Batalkan Pesanan
                </button>
            </form>
        </div>
        @endif
    @endif
</div>

<script type="text/javascript">
    const snapToken = "{{ $snapToken }}";
    const payButton = document.getElementById('pay-button');
    const cancelBtn = document.getElementById('btn-cancel-order');
    const cancelForm = document.getElementById('cancel-form');

    if (payButton) {
        payButton.addEventListener('click', function () {
            window.snap.pay(snapToken, {
                onSuccess: function(result) {
                    window.location.href = "{{ route('checkout.success') }}";
                },
                onPending: function(result) {
                    window.location.href = "{{ route('checkout.success') }}";
                },
                onError: function(result) {
                    PremiumConfirm.fire({
                        icon: 'error',
                        title: 'Pembayaran Gagal',
                        text: 'Terjadi kesalahan saat memproses pembayaran Anda.'
                    });
                },
                onClose: function () {
                    PremiumConfirm.fire({
                        icon: 'warning',
                        title: 'Pembayaran Belum Selesai',
                        text: 'Anda menutup jendela pembayaran. Pesanan Anda tetap tersimpan di menu Pesanan Saya.'
                    });
                }
            });
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            PremiumConfirm.fire({
                title: 'Batalkan Pesanan?',
                text: "Pesanan yang sudah dibatalkan tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Kembali',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    cancelForm.submit();
                }
            });
        });
    }
</script>
@endsection
