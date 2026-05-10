@extends('layouts.admin')

@section('title', 'Data Pesanan - Admin Dew\'s Cake')

@push('style')
<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 240, 245, 0.8);
        --primary-gradient: linear-gradient(135deg, #f7a6b8, #f28aa5);
        --info-gradient: linear-gradient(135deg, #60a5fa, #3b82f6);
        --warning-gradient: linear-gradient(135deg, #f59e0b, #d97706);
        --primary-soft: #fde2e8;
    }

    .orders-container {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .orders-header { 
        margin-bottom: 30px; 
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .orders-header .title-area h2 { 
        font-size: 28px; 
        color: #8b3f52; 
        margin: 0; 
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .orders-header .title-area p {
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

    .icon-active { background: #eff6ff; color: #3b82f6; }
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
        min-width: 1200px;
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

    /* BADGES & SELECTS */
    .id-badge {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .ord-badge { background: #fff1f2; color: #be123c; }

    .status-select {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid #d1d5db;
        cursor: pointer;
        transition: 0.3s;
        outline: none;
    }

    .status-select:focus { border-color: #f7a6b8; box-shadow: 0 0 0 3px rgba(247, 166, 184, 0.2); }

    .action-btns {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .btn-action {
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 6px;
        color: #fff;
    }

    .btn-detail { background: var(--primary-gradient); }
    .btn-cancel { background: #ef4444; }
    .btn-action:hover { transform: scale(1.05); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

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

    /* MODAL REFINEMENT */
    .modal-backdrop {
        background: rgba(139, 63, 82, 0.2);
        backdrop-filter: blur(8px);
    }

    .premium-modal {
        background: #fff;
        border-radius: 28px;
        border: 1px solid #fce7f3;
        overflow: hidden;
        animation: modalIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes modalIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
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
        min-width: 200px;
    }
 
    .filter-group label {
        font-size: 12px;
        font-weight: 700;
        color: #8b3f52;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding-left: 5px;
    }
 
    .filter-input {
        background: #fff;
        border: 1px solid #f3c2cd;
        padding: 12px 16px;
        border-radius: 14px;
        font-size: 14px;
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
        padding: 12px 24px;
        border-radius: 14px;
        border: none;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 15px rgba(247, 166, 184, 0.3);
    }
 
    .btn-filter-clear {
        background: #f3f4f6;
        color: #6b7280;
        padding: 12px 20px;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
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
<div class="orders-container">
    <div class="orders-header">
        <div class="title-area">
            <h2>📦 Data Pesanan</h2>
            <p>Kelola semua pesanan pelanggan dari satu dasbor terpadu.</p>
        </div>
    </div>

    <!-- SUMMARY SECTION -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon icon-active">
                <i class="fa-solid fa-spinner"></i>
            </div>
            <div class="summary-info">
                <div class="label">Pesanan Aktif</div>
                <div class="value">{{ number_format($activeOrdersCount) }}</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon icon-pending">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div class="summary-info">
                <div class="label">Menunggu Pembayaran</div>
                <div class="value">{{ number_format($pendingPaymentCount) }}</div>
            </div>
        </div>
    </div>
    <!-- FILTER SECTION -->
    <div class="filter-section">
        <form action="{{ route('admin.pesanan.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label for="search"><i class="fa-solid fa-magnifying-glass"></i> Cari Pesanan</label>
                <input type="text" name="search" id="search" class="filter-input" 
                    placeholder="ID, Nama Pelanggan, atau No HP..." 
                    value="{{ request('search') }}">
            </div>
 
            <div class="filter-group">
                <label for="status"><i class="fa-solid fa-filter"></i> Status Pesanan</label>
                <select name="status" id="status" class="filter-input">
                    <option value="">Semua Status</option>
                    <option value="menunggu_pembayaran" {{ request('status') == 'menunggu_pembayaran' ? 'selected' : '' }}>⏳ Menunggu Pembayaran</option>
                    <option value="dp_dibayar" {{ request('status') == 'dp_dibayar' ? 'selected' : '' }}>💸 DP Dibayar</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>💰 Lunas</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>🥣 Diproses</option>
                    <option value="siap_diambil" {{ request('status') == 'siap_diambil' ? 'selected' : '' }}>🎂 Siap Diambil</option>
                    <option value="siap_dikirim" {{ request('status') == 'siap_dikirim' ? 'selected' : '' }}>🚚 Siap Dikirim</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>🏁 Selesai</option>
                    <option value="refund" {{ request('status') == 'refund' ? 'selected' : '' }}>💸 Refund</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>❌ Batal</option>
                </select>
            </div>
 
            <div class="filter-actions">
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.pesanan.index') }}" class="btn-filter-clear" title="Clear Filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
                <button type="submit" class="btn-filter-submit">
                    <i class="fa-solid fa-filter-list"></i> Filter Data
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
                        <th>Order ID</th>
                        <th>Tanggal Pesan</th>
                        <th>Customer</th>
                        <th>Metode Ambil</th>
                        <th>Tgl Ambil</th>
                        <th style="text-align: right;">Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $p)
                    <tr>
                        <td data-label="No">{{ ($pesanan->currentPage() - 1) * $pesanan->perPage() + $loop->iteration }}</td>
                        <td data-label="Order ID">
                            <span class="id-badge ord-badge">
                                <i class="fa-solid fa-box"></i>
                                #ORD-{{ str_pad($p->pesanan_id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td data-label="Tanggal Pesan">
                            <div style="font-weight: 600;">{{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('d/m/Y') }}</div>
                            <div style="font-size: 11px; color: #9ca3af;">{{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('H:i') }} WIB</div>
                        </td>
                        <td data-label="Customer" style="text-align: left;">
                            <div style="font-weight: 700; color: #1f2937;">{{ $p->user->name ?? 'N/A' }}</div>
                            <div style="font-size: 11px; color: #9ca3af;">{{ $p->phone_pesanan }}</div>
                        </td>
                        <td data-label="Metode Ambil">
                            @if($p->metode_pengambilan_id == 1)
                                <span style="color: #0369a1; font-weight: 700; font-size: 12px;"><i class="fa-solid fa-store"></i> AMBIL</span>
                            @else
                                <span style="color: #be185d; font-weight: 700; font-size: 12px;"><i class="fa-solid fa-truck"></i> KIRIM</span>
                            @endif
                        </td>
                        <td data-label="Tgl Ambil">
                            <div style="font-weight: 600;">{{ \Carbon\Carbon::parse($p->tanggal_pengambilan)->translatedFormat('d M Y') }}</div>
                        </td>
                        <td data-label="Total" style="text-align: right; font-weight: 800; color: #be185d;">
                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                        </td>
                        <td data-label="Status">
                            @if($p->status_pesanan == 'selesai')
                                <span class="badge" style="background:#f3f4f6; color:#1f2937; border: 1px solid #d1d5db; font-size: 11px;">SELESAI</span>
                            @elseif($p->status_pesanan == 'batal')
                                <span class="badge" style="background:#fee2e2; color:#b91c1c; font-size: 11px;">BATAL</span>
                            @elseif($p->status_pesanan == 'refund')
                                <span class="badge" style="background:#ffedd5; color:#9a3412; font-size: 11px;">REFUND</span>
                            @else
                                @php
                                    $firstPayment = $p->pembayaran->sortBy('pembayaran_id')->first();
                                    $isCash = ($firstPayment && $firstPayment->metode_pembayaran == 'cash');
                                    $canChangeStatus = $isCash || !in_array($p->status_pesanan, ['menunggu_pembayaran', 'dp_dibayar']);
                                    
                                    $statusColors = [
                                        'menunggu_pembayaran' => ['#fef3c7', '#92400e'],
                                        'dp_dibayar' => ['#dbeafe', '#1e40af'],
                                        'lunas' => ['#dcfce7', '#15803d'],
                                        'diproses' => ['#e0f2fe', '#0369a1'],
                                        'siap_diambil' => ['#f0fdf4', '#166534'],
                                        'siap_dikirim' => ['#f0fdf4', '#166534']
                                    ];
                                    $colors = $statusColors[$p->status_pesanan] ?? ['#fff', '#000'];
                                @endphp

                                @if($canChangeStatus)
                                    <form action="{{ route('admin.pesanan.updateStatus', $p->pesanan_id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="status-select" 
                                            style="background: {{ $colors[0] }}; color: {{ $colors[1] }}; border-color: transparent;">
                                            <option value="menunggu_pembayaran" {{ $p->status_pesanan == 'menunggu_pembayaran' ? 'selected' : '' }}>⏳ Menunggu Pembayaran</option>
                                            <option value="dp_dibayar" {{ $p->status_pesanan == 'dp_dibayar' ? 'selected' : '' }}>💸 DP Dibayar</option>
                                            <option value="lunas" {{ $p->status_pesanan == 'lunas' ? 'selected' : '' }}>💰 Lunas</option>
                                            <option value="diproses" {{ $p->status_pesanan == 'diproses' ? 'selected' : '' }}>🥣 Diproses</option>
                                            <option value="siap_diambil" {{ $p->status_pesanan == 'siap_diambil' ? 'selected' : '' }}>🎂 Siap Diambil</option>
                                            <option value="siap_dikirim" {{ $p->status_pesanan == 'siap_dikirim' ? 'selected' : '' }}>🚚 Siap Dikirim</option>
                                            <option value="selesai" {{ $p->status_pesanan == 'selesai' ? 'selected' : '' }}>🏁 Selesai</option>
                                        </select>
                                    </form>
                                @else
                                    <span class="badge" style="background: {{ $colors[0] }}; color: {{ $colors[1] }}; font-size: 11px;">
                                        {{ strtoupper(str_replace('_', ' ', $p->status_pesanan)) }}
                                    </span>
                                    <div style="font-size: 9px; color: #9ca3af; margin-top: 4px;"><i class="fa-solid fa-lock"></i> Auto Midtrans</div>
                                @endif
                            @endif
                        </td>
                        <td data-label="Aksi">
                            <div class="action-btns">
                                <button type="button" class="btn-action btn-detail" onclick="showOrderDetail({{ $p->pesanan_id }})" title="Detail Pesanan">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                                @if(!in_array($p->status_pesanan, ['batal', 'selesai', 'refund']))
                                    @php
                                        // Refund hanya untuk pesanan yang sudah bayar tapi belum masuk tahap 'Siap'
                                        $isRefundable = in_array($p->status_pesanan, ['dp_dibayar', 'lunas', 'diproses']);
                                        // Cancel hanya untuk pesanan yang belum bayar sama sekali
                                        $isCancellable = ($p->status_pesanan == 'menunggu_pembayaran');
                                    @endphp

                                    @if($isRefundable)
                                        <form id="refund-form-{{ $p->pesanan_id }}" action="{{ route('admin.pesanan.updateStatus', $p->pesanan_id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <input type="hidden" name="status" value="refund">
                                            <button type="button" class="btn-action" style="background: #f59e0b;" onclick="confirmRefund({{ $p->pesanan_id }})" title="Refund & Batalkan">
                                                <i class="fa-solid fa-money-bill-transfer"></i>
                                            </button>
                                        </form>
                                    @elseif($isCancellable)
                                        <form id="cancel-form-{{ $p->pesanan_id }}" action="{{ route('admin.pesanan.updateStatus', $p->pesanan_id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <input type="hidden" name="status" value="batal">
                                            <button type="button" class="btn-action btn-cancel" onclick="confirmCancel({{ $p->pesanan_id }})" title="Batalkan Pesanan">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>

                            {{-- Data Hidden for Modal --}}
                            <div id="data-pesanan-{{ $p->pesanan_id }}" style="display: none;">
                                <div style="display: flex; flex-direction: column; gap: 20px;">
                                    {{-- Order Info Header --}}
                                    <div style="padding-bottom: 15px; border-bottom: 2px dashed #fce7f3; display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <div style="color: #be185d; font-weight: 800; font-size: 18px;">ORD-{{ str_pad($p->pesanan_id, 5, '0', STR_PAD_LEFT) }}</div>
                                            <div style="font-size: 13px; color: #6b7280;">Dipesan pada {{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('d M Y, H:i') }}</div>
                                        </div>
                                        <div style="text-align: right;">
                                            <div style="font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase;">Status Pesanan</div>
                                            <div style="font-weight: 800; color: #be185d;">{{ strtoupper(str_replace('_', ' ', $p->status_pesanan)) }}</div>
                                        </div>
                                    </div>

                                    {{-- Two Columns: Customer & Pickup --}}
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                        <div style="background: #fdf2f8; padding: 15px; border-radius: 18px; border: 1px solid #fce7f3;">
                                            <div style="font-size: 10px; font-weight: 800; color: #be185d; margin-bottom: 5px;">PELANGGAN</div>
                                            <div style="font-weight: 700; font-size: 15px;">{{ $p->user->name ?? '-' }}</div>
                                            <div style="font-size: 13px; color: #6b7280;">{{ $p->phone_pesanan }}</div>
                                        </div>
                                        <div style="background: #fdf2f8; padding: 15px; border-radius: 18px; border: 1px solid #fce7f3;">
                                            <div style="font-size: 10px; font-weight: 800; color: #be185d; margin-bottom: 5px;">PENGAMBILAN</div>
                                            <div style="font-weight: 700; font-size: 15px;">{{ \Carbon\Carbon::parse($p->tanggal_pengambilan)->translatedFormat('d M Y, H:i') }}</div>
                                            <div style="font-size: 13px; color: #6b7280;">{{ $p->metode_pengambilan_id == 1 ? 'Ambil di Toko' : 'Dikirim Kurir' }}</div>
                                        </div>
                                    </div>

                                    {{-- Items List --}}
                                    <div>
                                        <div style="font-size: 13px; font-weight: 800; color: #8b3f52; margin-bottom: 10px;">DAFTAR BELANJA</div>
                                        @if($p->paket)
                                            <div style="background: var(--primary-gradient); color: #fff; padding: 12px 15px; border-radius: 15px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(247, 166, 184, 0.3);">
                                                <span style="font-weight: 800;"><i class="fa-solid fa-gift"></i> {{ $p->paket->nama_paket }}</span>
                                                <span style="background: rgba(255,255,255,0.2); padding: 3px 10px; border-radius: 8px; font-size: 12px; font-weight: 700;">{{ $p->jumlah_paket }} Qty</span>
                                            </div>
                                        @endif

                                        <div style="display: flex; flex-direction: column; gap: 8px;">
                                            @foreach($p->detail as $item)
                                            <div style="background: #fff; border: 1px solid #f3f4f6; padding: 12px; border-radius: 15px;">
                                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                                    <span style="font-weight: 600; color: #1f2937;">
                                                        {{ $item->jumlah }}x {{ $item->produk->nama_produk ?? 'Kue' }}
                                                    </span>
                                                    <span style="font-weight: 700; color: #be185d;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                                </div>
                                                @if($item->catatan)
                                                    <div style="margin-top: 6px; padding: 6px 10px; background: #fff5f7; border-radius: 8px; font-size: 11px; color: #be185d; font-style: italic;">
                                                        <i class="fa-solid fa-comment-dots"></i> Note: "{{ $item->catatan }}"
                                                    </div>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Costs Summary --}}
                                    <div style="background: #f9fafb; padding: 15px; border-radius: 20px; border: 1px solid #e5e7eb;">
                                        <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 5px;">
                                            <span style="color: #6b7280;">Subtotal Produk</span>
                                            <span style="font-weight: 600;">Rp {{ number_format($p->total_harga - $p->biaya_wadah - ($p->ongkir ?? 0), 0, ',', '.') }}</span>
                                        </div>
                                        @if($p->biaya_wadah > 0)
                                            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 5px;">
                                                <span style="color: #6b7280;">Packaging</span>
                                                <span style="font-weight: 600;">Rp {{ number_format($p->biaya_wadah, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                        @if($p->ongkir > 0)
                                            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 5px;">
                                                <span style="color: #6b7280;">Ongkos Kirim</span>
                                                <span style="font-weight: 600;">Rp {{ number_format($p->ongkir, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                        <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: 800; color: #be185d; border-top: 2px dashed #d1d5db; margin-top: 10px; padding-top: 10px;">
                                            <span>TOTAL AKHIR</span>
                                            <span>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    {{-- Address & Overall Note --}}
                                    <div style="padding: 15px; background: #fffbeb; border-radius: 18px; border: 1px solid #fef3c7;">
                                        <div style="font-size: 11px; font-weight: 800; color: #92400e; text-transform: uppercase;"><i class="fa-solid fa-location-dot"></i> Alamat & Pesan</div>
                                        <p style="margin: 5px 0 0 0; font-size: 13px; color: #4b5563;">{{ $p->alamat_pesanan ?? 'Ambil di Toko' }}</p>
                                        @if($p->catatan)
                                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #fde68a; color: #9d174d; font-style: italic; font-size: 13px;">
                                                "{{ $p->catatan }}"
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 60px;">
                            <div style="font-size: 40px; margin-bottom: 20px;">📂</div>
                            <div style="font-weight: 600; color: #9ca3af;">Belum ada data pesanan yang masuk.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pesanan->hasPages())
        <div class="custom-pagination">
            {{ $pesanan->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>

<!-- MODAL DETAIL PESANAN -->
<div id="modalDetailPesanan" class="modal-backdrop" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; justify-content: center; align-items: center; padding: 20px;">
    <div class="premium-modal" style="width: 100%; max-width: 600px; box-shadow: 0 25px 50px -12px rgba(139, 63, 82, 0.25);">
        <div style="background: var(--primary-gradient); padding: 20px 25px; color: #fff; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 800;">🍰 Detail Pesanan Lengkap</h3>
            <button onclick="closeOrderDetail()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        <div id="modalDetailBody" style="padding: 25px; max-height: 75vh; overflow-y: auto; background: #fff;">
            <!-- content dynamically filled -->
        </div>
        <div style="padding: 15px 25px; background: #f9fafb; border-top: 1px solid #f3f4f6; text-align: right;">
            <button onclick="closeOrderDetail()" style="background: #374151; color: #fff; border: none; padding: 12px 30px; border-radius: 12px; font-weight: 700; cursor: pointer;">Tutup Detail</button>
        </div>
    </div>
</div>

@push('script')
<script>
    function showOrderDetail(id) {
        const content = document.getElementById('data-pesanan-' + id).innerHTML;
        document.getElementById('modalDetailBody').innerHTML = content;
        document.getElementById('modalDetailPesanan').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeOrderDetail() {
        document.getElementById('modalDetailPesanan').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function confirmCancel(id) {
        PremiumConfirm.fire({
            title: 'Batalkan Pesanan?',
            text: "Pesanan yang dibatalkan tidak dapat diproses kembali ketersediaannya.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Jangan Dulu',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cancel-form-' + id).submit();
            }
        });
    }

    function confirmRefund(id) {
        PremiumConfirm.fire({
            title: 'Refund & Batalkan?',
            text: "Pesanan ini sudah dibayar. Membatalkannya akan mengubah status pembayaran menjadi REFUND. Anda harus mengembalikan dana secara manual kepada pelanggan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            confirmButtonText: 'Ya, Refund & Batal!',
            cancelButtonText: 'Jangan Dulu',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('refund-form-' + id).submit();
            }
        });
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('modalDetailPesanan')) {
            closeOrderDetail();
        }
    }
</script>
@endpush
@endsection
