@extends('layouts.user')

@section('title', 'Pesanan Saya - Dew\'s Cake')

@section('style')
<style>
.pesanan-container {
    max-width: 900px;
    margin: 40px auto;
    padding: 20px;
}
.page-title {
    color: #be185d;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 30px;
    text-align: center;
}
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}
.order-card {
    background: #fff;
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    border: 1px solid #fce7f3;
}
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px dashed #fbcfe8;
    padding-bottom: 16px;
    margin-bottom: 16px;
}
.order-id {
    font-size: 18px;
    font-weight: 700;
    color: #9d174d;
}
.order-date {
    font-size: 13px;
    color: #6b7280;
}
.order-body {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
}
.order-details {
    flex: 2;
    min-width: 300px;
}
.order-summary {
    flex: 1;
    min-width: 280px;
    background: #fff9fb;
    padding: 18px;
    border-radius: 14px;
    border: 1px solid #fbcfe8;
    box-sizing: border-box;
}
.item-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
}
.status-badge {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    display: inline-block;
    margin-bottom: 10px;
}
.status-menunggu { background: #fef08a; color: #854d0e; }
.status-dp { background: #bfdbfe; color: #1e3a8a; }
.status-lunas { background: #dcfce7; color: #166534; }
.status-diproses { background: #e0f2fe; color: #0369a1; }
.status-siap { background: #f0fdf4; color: #15803d; border: 1px solid #166534; }
.status-selesai { background: #f3f4f6; color: #1f2937; border: 1px solid #d1d5db; }
.status-batal { background: #fecaca; color: #991b1b; }
.status-refund { background: #ffedd5; color: #9a3412; }

.btn-pelunasan {
    display: block;
    width: 100%;
    text-align: center;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 12px;
    border-radius: 12px;
    font-weight: 600;
    margin-top: 15px;
    transition: 0.3s;
}
.btn-pelunasan:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(37,99,235,0.3);
}
.btn-batal {
    display: block;
    width: 100%;
    text-align: center;
    background: #fff;
    color: #ef4444;
    padding: 10px;
    border-radius: 12px;
    font-weight: 600;
    margin-top: 10px;
    transition: 0.3s;
    border: 1.5px solid #fecaca;
    cursor: pointer;
}
.btn-batal:hover {
    background: #fef2f2;
    border-color: #ef4444;
}
.btn-reorder {
    display: block;
    width: 100%;
    text-align: center;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 12px;
    border-radius: 12px;
    font-weight: 600;
    margin-top: 15px;
    transition: 0.3s;
    border: none;
    cursor: pointer;
}
.btn-reorder:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(16,185,129,0.3);
}
.btn-detail {
    display: inline-block;
    color: #be185d;
    font-size: 14px;
    font-weight: 600;
    margin-top: 15px;
}
.btn-detail:hover { text-decoration: underline; }
/* RESPONSIVE ADJUSTMENTS */
@media (max-width: 768px) {
    .pesanan-container { padding: 15px; margin: 20px auto; }
    .page-title { font-size: 24px; margin-bottom: 20px; }
    .order-card { padding: 18px; border-radius: 16px; }
}

@media (max-width: 850px) {
    .order-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .order-date { font-size: 12px; }
    .status-badge { font-size: 11px; padding: 5px 10px; }
    
    .order-body { 
        gap: 20px; 
        flex-direction: column;
    }
    .order-details, .order-summary {
        min-width: 100%;
        width: 100%;
        flex: none;
    }
    
    .item-row { font-size: 13px; }
    .btn-pelunasan, .btn-reorder, .btn-batal { 
        padding: 14px; 
        font-size: 15px; 
        width: 100%;
        box-sizing: border-box;
    }
}

@media (max-width: 480px) {
    .order-card {
        padding: 15px;
    }
    .order-id { font-size: 16px; }
    .order-summary {
        padding: 15px;
    }
}
</style>
@endsection

@section('content')
<div class="pesanan-container">
    <h1 class="page-title">Pesanan Saya</h1>


    @if($pesanan->isEmpty())
        <div class="empty-state">
            <h3 style="color: #9d174d; margin-bottom: 10px;">Belum Ada Pesanan</h3>
            <p style="color: #6b7280; margin-bottom: 20px;">Anda belum membuat pesanan sama sekali.</p>
            <a href="{{ route('menu') }}" style="background: #ec4899; color: white; padding: 10px 25px; border-radius: 999px; font-weight: 600;">Lihat Menu</a>
        </div>
    @else
        @foreach($pesanan as $p)
        <div class="order-card">
            <div class="order-header">
                <div>
                    <div class="order-id">#ORD-{{ str_pad($p->pesanan_id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div class="order-date">{{ \Carbon\Carbon::parse($p->tanggal_pesan)->translatedFormat('d F Y, H:i') }}</div>
                </div>
                
                @php
                    $statusClass = 'status-menunggu';
                    $statusText = 'Menunggu Pembayaran';
                    
                    if($p->status_pesanan == 'dp_dibayar') { $statusClass = 'status-dp'; $statusText = 'DP Dibayar (Sisa 50%)'; }
                    elseif($p->status_pesanan == 'lunas') { $statusClass = 'status-lunas'; $statusText = 'Lunas'; }
                    elseif($p->status_pesanan == 'diproses') { $statusClass = 'status-diproses'; $statusText = 'Pesanan Sedang Diproses'; }
                    elseif($p->status_pesanan == 'siap_diambil') { $statusClass = 'status-siap'; $statusText = 'Pesanan Siap Diambil'; }
                    elseif($p->status_pesanan == 'siap_dikirim') { $statusClass = 'status-siap'; $statusText = 'Pesanan Siap Dikirim'; }
                    elseif($p->status_pesanan == 'selesai') { $statusClass = 'status-selesai'; $statusText = 'Pesanan Selesai'; }
                    elseif($p->status_pesanan == 'batal') { $statusClass = 'status-batal'; $statusText = 'Dibatalkan'; }
                    elseif($p->status_pesanan == 'refund') { $statusClass = 'status-refund'; $statusText = 'Dana Dikembalikan (Refund)'; }
                @endphp
                <div class="status-badge {{ $statusClass }}">
                    {{ $statusText }}
                </div>
            </div>

            <div class="order-body">
                <div class="order-details">
                    <strong style="color: #8b3f52; display: block; margin-bottom: 10px;">Detail Produk:</strong>
                    
                    @if($p->paket)
                        <div class="item-row" style="font-weight: 700; color: #be185d; border-bottom: 1px solid #fce7f3; padding-bottom: 8px; margin-bottom: 12px; display: flex;">
                            <span style="flex: 2;"><i class="fa-solid fa-box-open"></i> {{ $p->paket->nama_paket }}</span>
                            <span style="flex: 1; text-align: center;">{{ $p->jumlah_paket }}x</span>
                            <span style="flex: 1; text-align: right;">(Paket)</span>
                        </div>
                    @endif

                    @foreach($p->detail as $item)
                        <div class="item-row" style="{{ $p->paket ? 'padding-left: 20px;' : '' }} display: flex;">
                            <span style="flex: 2;">
                                @if($p->paket)
                                    <i class="fa-solid fa-cookie" style="font-size: 10px; color: #f472b6;"></i>
                                @endif
                                {{ $item->produk->nama_produk ?? 'Kue' }}
                            </span>
                            <span style="flex: 1; text-align: center;">{{ $item->jumlah }}x</span>
                            <span style="flex: 1; text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    <div style="margin-top: 20px; font-size: 13px; color: #6b7280;">
                        <strong>Waktu Pengambilan:</strong><br>
                        {{ \Carbon\Carbon::parse($p->tanggal_pengambilan)->translatedFormat('d F Y, H:i') }} WIB 
                        ({{ $p->metode_pengambilan_id == 1 ? 'Ambil Sendiri' : 'Dikirim' }})
                    </div>
                </div>

                <div class="order-summary">
                    <strong style="color: #8b3f52; display: block; margin-bottom: 15px;">Ringkasan Biaya:</strong>
                    
                    <div class="item-row" style="color: #6b7280;">
                        <span>Total Produk</span>
                        <span>Rp {{ number_format($p->total_harga - $p->biaya_wadah - ($p->ongkir ?? 0), 0, ',', '.') }}</span>
                    </div>

                    @if($p->biaya_wadah > 0)
                    <div class="item-row" style="color: #6b7280;">
                        <span>Biaya Packaging</span>
                        <span>Rp {{ number_format($p->biaya_wadah, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    @if($p->ongkir > 0)
                    <div class="item-row" style="color: #6b7280;">
                        <span>Ongkos Kirim</span>
                        <span>Rp {{ number_format($p->ongkir, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <div class="item-row" style="font-weight: 700; color: #4b5563; border-top: 1px solid #fbcfe8; padding-top: 10px; margin-top: 10px;">
                        <span>Total Pesanan</span>
                        <span>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                    </div>

                    @php
                        $firstPayment = $p->pembayaran->sortBy('pembayaran_id')->first();
                        $isDP = ($firstPayment && $firstPayment->jenis_pembayaran == 'dp');
                    @endphp

                    {{-- Info Jenis Pembayaran --}}
                    <div class="item-row" style="color: #ec4899; font-size: 13px; font-weight: 600; margin-top: 5px;">
                        <span>Tipe Pembayaran</span>
                        <span>{{ $isDP ? 'DP (50%)' : 'Lunas (100%)' }}</span>
                    </div>

                    <div class="item-row" style="color: #6b7280; font-size: 13px; font-weight: 600;">
                        <span>Metode</span>
                        <span>{{ ($firstPayment->metode_pembayaran ?? null) == 'cash' ? 'Tunai (Cash)' : 'Online / Transfer' }}</span>
                    </div>

                    {{-- Kondisi: Menunggu Pembayaran Awal --}}
                    @if($p->status_pesanan == 'menunggu_pembayaran')
                        <div style="margin-top: 15px; padding: 12px; background: #fffbeb; border-radius: 12px; border: 1px solid #fef3c7;">
                            <div style="display: flex; justify-content: space-between; color: #92400e; font-weight: 700; font-size: 14px;">
                                <span>Tagihan Sekarang:</span>
                                <span>Rp {{ number_format($firstPayment->jumlah_bayar ?? 0, 0, ',', '.') }}</span>
                            </div>
                            @if(($firstPayment->metode_pembayaran ?? null) != 'cash')
                            <div style="margin-top: 8px; font-size: 11px; color: #b45309; text-align: center; border-top: 1px dashed #fcd34d; padding-top: 8px;">
                                <i class="fa-solid fa-triangle-exclamation"></i> Pesanan otomatis dibatalkan jika tidak dibayar dalam 24 jam.
                            </div>
                            @endif
                        </div>

                        @if($firstPayment && in_array($firstPayment->status_pembayaran, ['menunggu', 'pending']))
                            <form action="{{ route('pesanan.lantutkanPembayaran', $p->pesanan_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-pelunasan" style="background: linear-gradient(135deg, #f59e0b, #d97706); border: none; cursor: pointer;">
                                    Bayar Sekarang (Rp {{ number_format($firstPayment->jumlah_bayar ?? 0, 0, ',', '.') }})
                                </button>
                            </form>
                        @endif

                        <form id="cancel-form-{{ $p->pesanan_id }}" action="{{ route('pesanan.cancel', $p->pesanan_id) }}" method="POST">
                            @csrf
                            <button type="button" class="btn-batal" onclick="confirmCancel({{ $p->pesanan_id }})">
                                <i class="fa-solid fa-xmark"></i> Batalkan Pesanan
                            </button>
                        </form>

                    {{-- Kondisi: Sudah Bayar DP, Menunggu Pelunasan --}}
                    @elseif($p->status_pesanan == 'dp_dibayar')
                        @php
                            $dpDibayarRecord = $p->pembayaran->where('jenis_pembayaran', 'dp')->where('status_pembayaran', 'berhasil')->first();
                            $sudahBayar = $dpDibayarRecord ? $dpDibayarRecord->jumlah_bayar : 0;
                            $sisaPay = $p->total_harga - $sudahBayar;
                            $firstPay = $p->pembayaran->sortBy('pembayaran_id')->first();
                        @endphp
                        
                        <div style="margin-top: 15px; padding: 12px; background: #f0fdf4; border-radius: 12px; border: 1px solid #dcfce7; font-size: 13px;">
                            <div style="display: flex; justify-content: space-between; color: #166534; margin-bottom: 4px;">
                                <span>DP Berhasil (50%):</span>
                                <strong>Rp {{ number_format($sudahBayar, 0, ',', '.') }}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Metode:</span>
                                <span style="font-weight: 700; color: #0369a1;">{{ ($firstPay->metode_pembayaran ?? null) == 'cash' ? 'Tunai (Cash)' : 'Online' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; color: #991b1b; font-weight: 700; border-top: 1px dashed #bbf7d0; padding-top: 5px; margin-top: 5px;">
                                <span>Sisa Pelunasan:</span>
                                <span>Rp {{ number_format($sisaPay, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('pesanan.pelunasan', $p->pesanan_id) }}" class="btn-pelunasan" style="border: none;">
                            Bayar Pelunasan (Rp {{ number_format($sisaPay, 0, ',', '.') }})
                        </a>

                    {{-- Kondisi: Lunas --}}
                    @elseif($p->status_pesanan == 'lunas')
                        <div style="margin-top: 15px; padding: 12px; background: #f0fdf4; border-radius: 12px; border: 1px solid #dcfce7; font-size: 14px; text-align: center; color: #166534; font-weight: 700;">
                            <i class="fa-solid fa-circle-check"></i> Pesanan Lunas
                        </div>
                    @elseif($p->status_pesanan == 'selesai')
                        <form action="{{ route('pesanan.reorder', $p->pesanan_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-reorder">
                                <i class="fa-solid fa-rotate-right"></i> Beli Lagi
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

<script>
    function confirmCancel(pesananId) {
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
                document.getElementById('cancel-form-' + pesananId).submit();
            }
        });
    }
</script>
@endsection
