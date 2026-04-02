@extends('layouts.admin')

@section('title', 'Admin Dashboard - Dew\'s Cake')

@push('style')
<style>
    :root {
        --primary-pink: #f7a6b8;
        --secondary-pink: #f28aa5;
        --accent-pink: #be185d;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 250, 250, 0.8);
        --primary-soft: #fde2e8;
    }

    .dashboard-container {
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dashboard-header { 
        margin-bottom: 35px; 
    }

    .dashboard-header h2 { 
        font-size: 32px; 
        color: #8b3f52; 
        margin: 0; 
        font-weight: 800;
        letter-spacing: -0.7px;
    }

    .dashboard-header p { 
        color: #6b7280; 
        margin: 8px 0 0; 
        font-size: 15px; 
    }

    /* STAT CARDS */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 25px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: #fff;
        padding: 28px;
        border-radius: 28px;
        border: 1px solid #fce7f3;
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover { 
        transform: translateY(-8px); 
        border-color: var(--primary-pink);
        box-shadow: 0 15px 35px rgba(247, 166, 184, 0.15);
    }

    .stat-card .label { 
        font-size: 12px; 
        color: #6b7280; 
        font-weight: 700; 
        text-transform: uppercase; 
        letter-spacing: 0.5px;
    }

    .stat-card .value { 
        font-size: 32px; 
        font-weight: 900; 
        color: #1f2937; 
        line-height: 1;
    }

    .stat-card .icon { 
        position: absolute;
        right: 20px;
        bottom: 20px;
        font-size: 26px; 
        width: 55px;
        height: 55px;
        border-radius: 18px; 
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.9;
    }

    .icon-total { background: #eff6ff; color: #3b82f6; }
    .icon-waiting { background: #fff7ed; color: #f59e0b; }
    .icon-process { background: #fdf2f8; color: #be185d; }
    .icon-done { background: #ecfdf5; color: #10b981; }

    /* LAYOUT GRID */
    .dashboard-layout {
        display: grid;
        grid-template-columns: 1.8fr 1.2fr;
        gap: 30px;
        margin-bottom: 35px;
    }

    .glass-card { 
        background: #fff; 
        border-radius: 30px; 
        padding: 28px; 
        border: 1px solid #f3f4f6; 
        box-shadow: 0 10px 40px rgba(0,0,0,0.02);
    }

    .card-title { 
        font-size: 18px; 
        font-weight: 800; 
        color: #1f2937; 
        margin-bottom: 25px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center;
        letter-spacing: -0.3px;
    }

    .card-title i { margin-right: 10px; color: var(--primary-pink); }

    /* TABLES STYLE */
    .premium-table-wrapper {
        width: 100%;
        overflow-x: auto;
        border-radius: 18px;
    }

    .premium-table { 
        width: 100%; 
        border-collapse: collapse; 
        font-size: 14px;
        min-width: 400px;
    }

    .premium-table th { 
        text-align: center; 
        padding: 14px; 
        font-size: 11px; 
        text-transform: uppercase; 
        background: var(--primary-soft);
        color: #8b3f52;
        font-weight: 800;
        border: 1px solid #f3c2cd;
    }

    .premium-table td { 
        padding: 16px 14px; 
        border: 1px solid #f3c2cd;
        text-align: center;
        vertical-align: middle;
    }
    
    .premium-table tbody tr:hover { background: #fff5f7; }

    .empty-state { text-align: center; padding: 40px; color: #9ca3af; font-size: 14px; font-weight: 500; }

    .badge-status { 
        padding: 6px 12px; 
        border-radius: 10px; 
        font-size: 11px; 
        font-weight: 700; 
        display: inline-block;
        text-transform: uppercase;
    }

    .badge-blue { background: #e0f2fe; color: #0369a1; }
    .badge-green { background: #dcfce7; color: #15803d; }
    .badge-pink { background: #fff1f2; color: #be123c; }

    .id-tag {
        font-weight: 700;
        color: var(--accent-pink);
    }

    /* RESPONSIVE */
    @media (max-width: 1200px) {
        .dashboard-layout { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .dashboard-header h2 { font-size: 26px; }
        .stat-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h2>👋 Halo, Admin Dew's Cake!</h2>
        <p>Ringkasan performa dan operasional dapur Anda hari ini.</p>
    </div>

    <!-- 1. STATISTIK UTAMA -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="label">Total Pesanan</div>
            <div class="value">{{ number_format($stats['total']) }}</div>
            <div class="icon icon-total"><i class="fa-solid fa-receipt"></i></div>
        </div>
        <div class="stat-card" title="Pesanan yang belum melakukan pembayaran">
            <div class="label">Menunggu Bayar</div>
            <div class="value">{{ number_format($stats['waiting']) }}</div>
            <div class="icon icon-waiting"><i class="fa-solid fa-hourglass-half"></i></div>
        </div>
        <div class="stat-card" title="Pesanan yang sedang disiapkan/diproses">
            <div class="label">Diproses Dapur</div>
            <div class="value">{{ number_format($stats['processing']) }}</div>
            <div class="icon icon-process"><i class="fa-solid fa-fire-burner"></i></div>
        </div>
        <div class="stat-card" title="Seluruh pesanan yang sudah berhasil diselesaikan">
            <div class="label">Selesai</div>
            <div class="value">{{ number_format($stats['completed']) }}</div>
            <div class="icon icon-done"><i class="fa-solid fa-circle-check"></i></div>
        </div>
    </div>

    <div class="dashboard-layout">
        <!-- LEFT: REVENUE CHART -->
        <div class="glass-card">
            <div class="card-title">
                <span><i class="fa-solid fa-chart-line"></i> Analisis Performa Penjualan</span>
            </div>
            <div style="height: 420px; position: relative;">
                <canvas id="modernChart"></canvas>
            </div>
        </div>

        <!-- RIGHT: RECENT ACTIVITY LISTS -->
        <div style="display: flex; flex-direction: column; gap: 30px;">
            <!-- PENGIRIMAN HARI INI -->
            <div class="glass-card">
                <div class="card-title">
                    <span><i class="fa-solid fa-truck-fast"></i> Pengiriman Hari Ini</span>
                </div>
                <div class="premium-table-wrapper">
                    @if($todayShipments->count() > 0)
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Penerima</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayShipments as $ship)
                                <tr>
                                    <td class="id-tag">#ORD-{{ str_pad($ship->pesanan_id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td style="font-weight: 600;">{{ $ship->nama_penerima }}</td>
                                    <td>
                                        <span class="badge-status badge-blue">
                                            {{ ucwords(str_replace('_', ' ', $ship->status_pengiriman)) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="fa-solid fa-box-open" style="font-size: 30px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                            Tidak ada pengiriman yang dijadwalkan hari ini.
                        </div>
                    @endif
                </div>
            </div>

            <!-- PEMBAYARAN TERBARU -->
            <div class="glass-card">
                <div class="card-title">
                    <span><i class="fa-solid fa-credit-card"></i> Pembayaran Terbaru</span>
                </div>
                <div class="premium-table-wrapper">
                    @if($recentPayments->count() > 0)
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Jumlah</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPayments as $pay)
                                <tr>
                                    <td class="id-tag">#{{ str_pad($pay->pesanan_id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td style="font-weight: 800; color: #166534;">Rp {{ number_format($pay->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td style="color: #6b7280; font-weight: 500;">{{ $pay->tanggal_bayar->format('H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">Belum ada pembayaran masuk hari ini.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 2. DAFTAR PESANAN TERBARU -->
    <div class="glass-card">
        <div class="card-title">
            <span><i class="fa-solid fa-boxes-stacked"></i> Antrean Pesanan Terbaru</span>
            <a href="{{ route('admin.pesanan.index') }}" style="font-size: 13px; color: var(--accent-pink); font-weight: 700; text-decoration: none;">
                Lihat Semua <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
            </a>
        </div>
        <div class="premium-table-wrapper">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th width="150">No Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Tagihan</th>
                        <th>Status</th>
                        <th>Waktu Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="id-tag">#ORD-{{ str_pad($order->pesanan_id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td style="font-weight: 600; text-align: left;">{{ $order->user->name ?? 'User' }}</td>
                        <td style="font-weight: 800; color: var(--accent-pink);">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge-status {{ $order->status_pesanan == 'selesai' ? 'badge-green' : 'badge-pink' }}">
                                {{ strtoupper(str_replace('_', ' ', $order->status_pesanan)) }}
                            </span>
                        </td>
                        <td style="color: #6b7280;">{{ $order->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">Belum ada pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('modernChart').getContext('2d');
    
    const labels = @json($monthlyStats->pluck('month'));
    const revenueData = @json($monthlyStats->pluck('revenue'));
    const orderData = @json($monthlyStats->pluck('order_count'));

    // Create Gradients
    const revGradient = ctx.createLinearGradient(0, 0, 0, 400);
    revGradient.addColorStop(0, 'rgba(190, 24, 93, 0.4)');
    revGradient.addColorStop(1, 'rgba(190, 24, 93, 0)');

    const barGradient = ctx.createLinearGradient(0, 0, 0, 400);
    barGradient.addColorStop(0, '#f7a6b8');
    barGradient.addColorStop(1, '#f28aa5');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Jumlah Pesanan',
                    data: orderData,
                    backgroundColor: barGradient,
                    borderColor: '#f28aa5',
                    borderWidth: 0,
                    borderRadius: 12,
                    yAxisID: 'y1',
                    order: 2,
                    barPercentage: 0.6,
                },
                {
                    label: 'Pendapatan (Rp)',
                    data: revenueData,
                    type: 'line',
                    borderColor: '#be185d',
                    backgroundColor: revGradient,
                    borderWidth: 4,
                    fill: true,
                    tension: 0.45,
                    yAxisID: 'y',
                    order: 1,
                    pointRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#be185d',
                    pointBorderWidth: 3,
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: { 
                    position: 'top', 
                    align: 'end',
                    labels: { 
                        usePointStyle: true,
                        boxWidth: 8, 
                        font: { size: 12, weight: '700', family: "'Poppins', sans-serif" },
                        padding: 20
                    } 
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1f2937',
                    bodyColor: '#4b5563',
                    titleFont: { weight: '800' },
                    padding: 15,
                    cornerRadius: 15,
                    borderColor: '#fce7f3',
                    borderWidth: 1,
                    displayColors: true,
                    boxPadding: 6,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.datasetIndex === 1) {
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            } else {
                                label += context.parsed.y;
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: { color: '#f1f5f9', drawBorder: false },
                    border: { display: false },
                    ticks: {
                        font: { size: 10, weight: '600' },
                        color: '#94a3b8',
                        callback: function(value) { return 'Rp ' + (value >= 1000000 ? (value / 1000000) + 'jt' : (value / 1000) + 'k'); }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        font: { size: 10, weight: '600' },
                        color: '#94a3b8',
                    },
                    min: 0
                },
                x: { 
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        font: { size: 11, weight: '700' },
                        color: '#64748b'
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection