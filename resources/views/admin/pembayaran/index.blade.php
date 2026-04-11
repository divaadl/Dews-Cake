@extends('layouts.admin')

@section('title', 'Data Pembayaran - Admin Dew\'s Cake')

@push('style')
<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 240, 245, 0.8);
        --primary-gradient: linear-gradient(135deg, #f7a6b8, #f28aa5);
        --success-gradient: linear-gradient(135deg, #10b981, #059669);
        --warning-gradient: linear-gradient(135deg, #f59e0b, #d97706);
        --primary-soft: #fde2e8;
    }

    .payment-container {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .payment-header { 
        margin-bottom: 30px; 
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .payment-header .title-area h2 { 
        font-size: 28px; 
        color: #8b3f52; 
        margin: 0; 
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .payment-header .title-area p {
        color: #6b7280;
        margin: 5px 0 0;
        font-size: 14px;
    }

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
        transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .summary-card:hover { 
        transform: translateY(-5px); 
        border-color: #f7a6b8;
        box-shadow: 0 15px 30px rgba(247, 166, 184, 0.1);
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

    .icon-success { background: #ecfdf5; color: #10b981; }
    .icon-pending { background: #fffbeb; color: #f59e0b; }

    .summary-info .label { font-size: 13px; color: #6b7280; font-weight: 600; text-transform: uppercase; }
    .summary-info .value { font-size: 28px; font-weight: 800; color: #1f2937; margin-top: 4px; }

    /* TABLE SECTION */
    .table-section {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #f3f4f6;
        padding: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
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
    }

    tbody tr:hover {
        background: #fff5f7;
    }

    /* BADGES */
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

    .status-badge {
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-berhasil { background: #dcfce7; color: #15803d; }
    .status-menunggu { background: #fef3c7; color: #92400e; }
    .status-gagal { background: #fee2e2; color: #b91c1c; }
    .status-refund { background: #ffedd5; color: #9a3412; }

    .type-badge {
        font-size: 10px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 6px;
    }

    .type-dp { background: #e0f2fe; color: #0369a1; }
    .type-lunas { background: #fdf2f8; color: #be185d; }

    /* PAGINATION STYLING */
    .custom-pagination {
        margin-top: 25px;
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .pagination {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
        gap: 5px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination .page-item {
        display: inline-block !important;
    }

    .pagination .page-item .page-link {
        color: #8b3f52 !important;
        background-color: #fff !important;
        border: 1px solid #fce7f3 !important;
        padding: 8px 16px;
        font-weight: 600;
        border-radius: 10px;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .pagination .page-item.active .page-link {
        background: var(--primary-gradient) !important;
        color: #fff !important;
        border-color: transparent !important;
        box-shadow: 0 4px 10px rgba(247, 166, 184, 0.4);
    }

    .pagination .page-item .page-link:hover:not(.active) {
        background-color: #fde2e8 !important;
    }

    /* FILTER SECTION */
    .filter-section {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 8px 32px rgba(139, 63, 82, 0.05);
    }
 
    .filter-form {
        display: flex;
        gap: 15px;
        align-items: flex-end;
        flex-wrap: wrap;
    }
 
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
        min-width: 180px;
    }
 
    .filter-group label {
        font-size: 11px;
        font-weight: 700;
        color: #8b3f52;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding-left: 5px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
 
    .filter-input {
        background: #fff;
        border: 1px solid #f3c2cd;
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 13px;
        color: #1f2937;
        transition: 0.3s;
        width: 100%;
        outline: none;
    }
 
    .filter-input:focus {
        border-color: #f7a6b8;
        box-shadow: 0 0 0 4px rgba(247, 166, 184, 0.15);
    }
 
    .filter-actions {
        display: flex;
        gap: 10px;
        min-width: fit-content;
    }
 
    .btn-filter-submit {
        background: var(--primary-gradient);
        color: #fff;
        padding: 10px 20px;
        border-radius: 12px;
        border: none;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(247, 166, 184, 0.3);
        font-size: 13px;
    }
 
    .btn-filter-clear {
        background: #f3f4f6;
        color: #6b7280;
        padding: 10px 16px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 13px;
    }
 
    .btn-filter-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(247, 166, 184, 0.4); }
    .btn-filter-clear:hover { background: #e5e7eb; color: #1f2937; }
 
    @media (max-width: 768px) {
        .filter-group { flex: 100%; }
        .filter-actions { width: 100%; }
        .btn-filter-submit, .btn-filter-clear { flex: 1; }
    }
 
    /* RESPONSIVE */
    @media (max-width: 1024px) {
        .summary-grid { grid-template-columns: 1fr; }
        .table-section { padding: 15px; }

        /* Mobile Table Card transformation */
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr { display: block; }
            thead tr { position: absolute; top: -9999px; left: -9999px; }
            tr { border: 1px solid #fce7f3; border-radius: 18px; margin-bottom: 15px; background: #fff; overflow: hidden; }
            td { border: none; border-bottom: 1px solid #f9fafb; position: relative; padding-left: 50%; text-align: right; white-space: normal; }
            td:last-child { border-bottom: none; }
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                text-align: left;
                font-weight: 700;
                color: #9ca3af;
                font-size: 11px;
                text-transform: uppercase;
            }
        }
    }
</style>
@endpush

@section('content')
<div class="payment-container">
    <div class="payment-header">
        <div class="title-area">
            <h2>💸 Data Pembayaran</h2>
            <p>Pantau semua arus kas dan status transaksi pelanggan.</p>
        </div>
    </div>

    <!-- SUMMARY SECTION -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon icon-success">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="summary-info">
                <div class="label">Total Berhasil</div>
                <div class="value">Rp {{ number_format($totalSuccess, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon icon-pending">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="summary-info">
                <div class="label">Menunggu Konfirmasi</div>
                <div class="value">{{ number_format($pendingCount) }}</div>
            </div>
        </div>
    </div>
    <!-- FILTER SECTION -->
    <div class="filter-section">
        <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label for="search"><i class="fa-solid fa-magnifying-glass"></i> Cari Transaksi</label>
                <input type="text" name="search" id="search" class="filter-input" 
                    placeholder="ID Bayar, Order ID, atau Nama..." 
                    value="{{ request('search') }}">
            </div>
 
            <div class="filter-group">
                <label for="method"><i class="fa-solid fa-credit-card"></i> Metode</label>
                <select name="method" id="method" class="filter-input">
                    <option value="">Semua Metode</option>
                    <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>💵 Cash</option>
                    <option value="bank_transfer" {{ request('method') == 'bank_transfer' ? 'selected' : '' }}>🏦 Bank Transfer</option>
                    <option value="online" {{ request('method') == 'online' ? 'selected' : '' }}>🌐 Online</option>
                    <option value="echannel" {{ request('method') == 'echannel' ? 'selected' : '' }}>📱 E-Channel</option>
                </select>
            </div>
 
            <div class="filter-group">
                <label for="status"><i class="fa-solid fa-circle-check"></i> Status</label>
                <select name="status" id="status" class="filter-input">
                    <option value="">Semua Status</option>
                    <option value="berhasil" {{ request('status') == 'berhasil' ? 'selected' : '' }}>✅ Berhasil</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                    <option value="gagal" {{ request('status') == 'gagal' ? 'selected' : '' }}>❌ Gagal</option>
                    <option value="refund" {{ request('status') == 'refund' ? 'selected' : '' }}>💸 Refund</option>
                </select>
            </div>
 
            <div class="filter-group">
                <label for="date"><i class="fa-solid fa-calendar-day"></i> Tanggal</label>
                <input type="date" name="date" id="date" class="filter-input" value="{{ request('date') }}">
            </div>
 
            <div class="filter-actions">
                @if(request('search') || request('method') || request('status') || request('date'))
                    <a href="{{ route('admin.pembayaran.index') }}" class="btn-filter-clear" title="Clear Filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
                <button type="submit" class="btn-filter-submit">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- DATA TABLE -->
    <div class="table-section">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>ID Pembayaran</th>
                        <th>Order ID</th>
                        <th>Pelanggan</th>
                        <th>Tipe</th>
                        <th>Metode</th>
                        <th style="text-align: right;">Jumlah Bayar</th>
                        <th>Tanggal Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaran as $pb)
                    <tr>
                        <td data-label="No">{{ ($pembayaran->currentPage() - 1) * $pembayaran->perPage() + $loop->iteration }}</td>
                        <td data-label="ID Pembayaran">
                            <span class="id-badge pay-badge">
                                <i class="fa-solid fa-receipt"></i>
                                PAY-{{ str_pad($pb->pembayaran_id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td data-label="Order ID">
                            <span class="id-badge ord-badge">
                                <i class="fa-solid fa-box"></i>
                                #ORD-{{ str_pad($pb->pesanan_id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td data-label="Pelanggan" style="text-align: left;">
                            <div style="font-weight: 700; color: #1f2937;">{{ $pb->pesanan->user->name ?? 'Guest' }}</div>
                            <div style="font-size: 11px; color: #9ca3af;">{{ $pb->pesanan->phone_pesanan ?? '-' }}</div>
                        </td>
                        <td data-label="Tipe">
                            @if($pb->jenis_pembayaran == 'dp')
                                <span class="type-badge type-dp">DP (50%)</span>
                            @else
                                <span class="type-badge type-lunas">LUNAS</span>
                            @endif
                        </td>
                        <td data-label="Metode">
                            <span style="font-weight: 600; font-size: 12px; text-transform: uppercase;">
                                {{ $pb->metode_pembayaran ?: '-' }}
                            </span>
                        </td>
                        <td data-label="Jumlah Bayar" style="text-align: right; font-weight: 800; color: #be185d;">
                            Rp {{ number_format($pb->jumlah_bayar, 0, ',', '.') }}
                        </td>
                        <td data-label="Tanggal Bayar">
                            @if($pb->tanggal_bayar)
                                <div style="font-weight: 600;">{{ \Carbon\Carbon::parse($pb->tanggal_bayar)->format('d/m/Y') }}</div>
                                <div style="font-size: 11px; color: #9ca3af;">{{ \Carbon\Carbon::parse($pb->tanggal_bayar)->format('H:i') }} WIB</div>
                            @else
                                <div style="font-weight: 600;">-</div>
                            @endif
                        </td>
                        <td data-label="Status">
                            @php
                                $statusMap = [
                                    'berhasil' => 'berhasil',
                                    'menunggu' => 'menunggu',
                                    'batal' => 'gagal',
                                    'refund' => 'refund'
                                ];
                                $statusClass = 'status-' . ($statusMap[$pb->status_pembayaran] ?? 'gagal');
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ $pb->status_pembayaran }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 60px;">
                            <div style="font-size: 40px; margin-bottom: 20px;">📂</div>
                            <div style="font-weight: 600; color: #9ca3af;">Belum ada data pembayaran yang tercatat.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pembayaran->hasPages())
        <div class="custom-pagination">
            {{ $pembayaran->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>
@endsection
