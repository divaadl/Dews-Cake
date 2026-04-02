@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@push('style')
<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 240, 245, 0.8);
        --primary-gradient: linear-gradient(135deg, #f7a6b8, #f28aa5);
        --secondary-gradient: linear-gradient(135deg, #10b981, #059669);
        --info-gradient: linear-gradient(135deg, #60a5fa, #3b82f6);
        --primary-soft: #fde2e8;
    }

    .report-container {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .report-header { 
        margin-bottom: 30px; 
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .report-header .title-area h2 { 
        font-size: 28px; 
        color: #8b3f52; 
        margin: 0; 
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .report-header .title-area p {
        color: #6b7280;
        margin: 5px 0 0;
        font-size: 14px;
    }

    /* FILTER SECTION */
    .filter-section {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        padding: 25px;
        border-radius: 24px;
        border: 1px solid var(--glass-border);
        box-shadow: 0 10px 30px rgba(247, 166, 184, 0.1);
        margin-bottom: 30px;
        transition: 0.3s;
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        align-items: flex-end;
    }

    .form-group { display: flex; flex-direction: column; gap: 8px; }
    .form-group label { 
        font-size: 12px; 
        font-weight: 700; 
        color: #8b3f52; 
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-left: 4px;
    }

    .form-control { 
        padding: 12px 16px; 
        border: 1px solid #fce7f3; 
        border-radius: 14px; 
        font-family: inherit;
        font-size: 14px;
        background: #fff;
        transition: 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #f7a6b8;
        box-shadow: 0 0 0 4px rgba(247, 166, 184, 0.1);
    }

    .action-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 12px 24px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        border: none;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        color: #fff;
    }

    .btn-action:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    .btn-action:active { transform: translateY(-1px); }

    .btn-filter { background: var(--primary-gradient); }
    .btn-export { background: var(--secondary-gradient); text-decoration: none; }
    .btn-print { background: var(--info-gradient); }

    /* SUMMARY CARDS */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .summary-card {
        background: #fff;
        padding: 24px;
        border-radius: 24px;
        border: 1px solid #fce7f3;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: 0.3s;
    }

    .summary-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .icon-revenue { background: #ecfdf5; color: #10b981; }
    .icon-orders { background: #eff6ff; color: #3b82f6; }

    .summary-info .label { font-size: 13px; color: #6b7280; font-weight: 600; text-transform: uppercase; }
    .summary-info .value { font-size: 28px; font-weight: 800; color: #1f2937; margin-top: 4px; }

    /* TABLE DESIGN (MATCHING PRODUK SATUAN) */
    .table-section {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #f3f4f6;
        padding: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        margin-bottom: 30px;
    }

    .table-header {
        margin-bottom: 20px;
    }

    .table-header h3 {
        margin: 0;
        font-size: 18px;
        color: #8b3f52;
        font-weight: 800;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 14px;
    }

    table {
        width: 100%;
        min-width: 1000px; 
        border-collapse: collapse;
        font-size: 14px;
        border-radius: 14px;
        overflow: hidden;
    }

    th, td {
        padding: 14px 16px;
        border: 1px solid #f3c2cd;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }

    th {
        background: var(--primary-soft);
        color: #374151;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    tbody tr {
        transition: 0.2s;
    }

    tbody tr:hover {
        background: #fff5f7;
    }

    .id-badge {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .pay-badge { background: #eff6ff; color: #2563eb; }
    .ord-badge { background: #fff1f2; color: #be123c; }

    .amount-text { font-weight: 700; color: #1f2937; }
    .total-highlight { color: #be185d; }

    /* PAGINATION STYLING */
    .custom-pagination {
        margin-top: 25px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 8px;
        list-style: none;
        padding: 0;
    }

    .page-item {
        display: inline-block;
    }

    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 14px;
        border-radius: 12px;
        background: #fff;
        border: 1px solid #fce7f3;
        color: #8b3f52;
        font-weight: 700;
        text-decoration: none;
        transition: 0.3s;
    }

    .page-item.active .page-link {
        background: var(--primary-gradient);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(247, 166, 184, 0.4);
    }

    .page-link:hover:not(.active) {
        background: var(--primary-soft);
        border-color: #f7a6b8;
    }

    .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f9fafb;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .report-header { flex-direction: column; align-items: flex-start; }
        .action-group { width: 100%; display: grid; grid-template-columns: 1fr 1fr; }
        .btn-action { justify-content: center; }
        .filter-section { padding: 15px; }
        .summary-grid { grid-template-columns: 1fr; }
    }

    /* PRINT REFINEMENTS */
    @media print {
        @page { size: landscape; margin: 1.5cm; }
        .sidebar, .filter-section, .no-print, nav { display: none !important; }
        .content { padding: 0 !important; margin: 0 !important; }
        table { min-width: auto !important; width: 100% !important; }
    }
</style>
@endpush

@section('content')
<div class="report-container">
    <div class="report-header">
        <div class="title-area">
            <h2>📊 Laporan Penjualan</h2>
            <p class="no-print">Analisis data transaksi dan pergerakan bisnis Dew's Cake.</p>
        </div>
        
        <div class="action-group no-print">
            <a href="{{ route('admin.laporan.export', request()->all()) }}" class="btn-action btn-export">
                <i class="fa-solid fa-file-excel"></i> Export Excel
            </a>
            <button type="button" onclick="window.print()" class="btn-action btn-print">
                <i class="fa-solid fa-file-pdf"></i> Cetak PDF
            </button>
        </div>
    </div>

    <!-- FILTER BOARD -->
    <div class="filter-section no-print">
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="filter-form">
            <div class="form-group">
                <label>Pilih Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}">
            </div>
            <div class="form-group">
                <label>Pilih Tanggal Selesai</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}">
            </div>
            <button type="submit" class="btn-action btn-filter">
                <i class="fa-solid fa-magnifying-glass"></i> Terapkan Filter
            </button>
        </form>
    </div>

    <!-- SUMMARY SECTION -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon icon-revenue">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div class="summary-info">
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon icon-orders">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div class="summary-info">
                <div class="label">Total Transaksi</div>
                <div class="value">{{ number_format($pesanan->total()) }}</div>
            </div>
        </div>
    </div>

    <!-- DATA TABLE -->
    <div class="table-section">
        <div class="table-header">
            <h3>📑 Rincian Transaksi ({{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }})</h3>
        </div>
        
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Pembayaran</th>
                        <th>Order ID</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Metode</th>
                        <th style="text-align: right;">Produk</th>
                        <th style="text-align: right;">Ongkir</th>
                        <th style="text-align: right;">Packaging</th>
                        <th style="text-align: right;">Total Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $p)
                    @php
                        $ongkir = $p->ongkir ?? 0;
                        $packaging = $p->biaya_wadah ?? 0;
                        $pureProductPrice = max(0, $p->total_harga - $ongkir - $packaging);
                        $lastPayment = $p->pembayaran->sortByDesc('pembayaran_id')->first();
                    @endphp
                    <tr>
                        <td>{{ ($pesanan->currentPage() - 1) * $pesanan->perPage() + $loop->iteration }}</td>
                        <td>
                            <span class="id-badge pay-badge">
                                <i class="fa-solid fa-receipt"></i>
                                {{ $lastPayment ? '#PAY-' . str_pad($lastPayment->pembayaran_id, 5, '0', STR_PAD_LEFT) : '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="id-badge ord-badge">
                                <i class="fa-solid fa-box"></i>
                                #ORD-{{ str_pad($p->pesanan_id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size: 13px; font-weight: 700;">{{ $p->tanggal_pesan->format('d/m/Y') }}</div>
                            <div style="font-size: 11px; color: #9ca3af;">{{ $p->tanggal_pesan->format('H:i') }} WIB</div>
                        </td>
                        <td style="text-align:left">
                            <div style="font-weight: 700;">{{ $p->user->name ?? 'Guest' }}</div>
                        </td>
                        <td>
                            @if($lastPayment && $lastPayment->metode_pembayaran)
                                <span class="badge badge-aktif" style="font-size: 11px;">{{ strtoupper($lastPayment->metode_pembayaran) }}</span>
                            @else
                                <span class="badge" style="background:#f3f4f6; color:#9ca3af; font-size: 11px;">N/A</span>
                            @endif
                        </td>
                        <td style="text-align: right;" class="amount-text">
                            Rp {{ number_format($pureProductPrice, 0, ',', '.') }}
                        </td>
                        <td style="text-align: right;" class="amount-text">
                            {{ $ongkir ? 'Rp ' . number_format($ongkir, 0, ',', '.') : '-' }}
                        </td>
                        <td style="text-align: right;" class="amount-text">
                            {{ $packaging ? 'Rp ' . number_format($packaging, 0, ',', '.') : '-' }}
                        </td>
                        <td style="text-align: right;" class="amount-text total-highlight">
                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 60px;">
                            <div style="font-size: 40px; margin-bottom: 20px;">📂</div>
                            <div style="font-weight: 600; color: #9ca3af;">Tidak ada data penjualan pada periode ini.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pesanan->hasPages())
        <div class="custom-pagination no-print">
            {{ $pesanan->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>

<style>
    /* Final Pagination Tweaks to force pink theme */
    .pagination .page-item .page-link {
        color: #8b3f52 !important;
        background-color: #fff !important;
        border: 1px solid #fce7f3 !important;
        padding: 8px 16px;
        font-weight: 600;
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #f7a6b8, #f28aa5) !important;
        color: #fff !important;
        border-color: transparent !important;
    }
    .pagination .page-item .page-link:hover {
        background-color: #fde2e8 !important;
    }
</style>
@endsection
