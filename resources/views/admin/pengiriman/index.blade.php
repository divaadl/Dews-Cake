@extends('layouts.admin')

@section('title', 'Data Pengiriman - Admin Dew\'s Cake')

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

    .shipping-container {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .shipping-header { 
        margin-bottom: 30px; 
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .shipping-header .title-area h2 { 
        font-size: 28px; 
        color: #8b3f52; 
        margin: 0; 
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .shipping-header .title-area p {
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

    .icon-shipping { background: #eff6ff; color: #3b82f6; }
    .icon-delivered { background: #ecfdf5; color: #10b981; }

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

    /* BADGES & DECOR */
    .id-badge {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .ship-badge { background: #fee2e2; color: #991b1b; }
    .ord-badge { background: #fdf2f8; color: #be185d; }

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

    .btn-edit-ship {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: #f3f4f6;
        color: #4b5563;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-edit-ship:hover { background: var(--primary-gradient); color: #fff; transform: scale(1.1); }

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
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header {
        background: var(--primary-gradient);
        padding: 20px 25px;
        color: #fff;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #fce7f3;
        border-radius: 14px;
        font-size: 14px;
        transition: 0.3s;
    }

    .form-control:focus { border-color: #f7a6b8; outline: none; box-shadow: 0 0 0 4px rgba(247, 166, 184, 0.1); }

    .btn-save {
        background: var(--primary-gradient);
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(247, 166, 184, 0.3); }

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
<div class="shipping-container">
    <div class="shipping-header">
        <div class="title-area">
            <h2>🚚 Data Pengiriman</h2>
            <p>Kelola rincian logistik dan status paket pelanggan.</p>
        </div>
    </div>

    <!-- SUMMARY SECTION -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon icon-shipping">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div class="summary-info">
                <div class="label">Sedang Dikirim</div>
                <div class="value">{{ number_format($totalSedingDikirim) }} Paket</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon icon-delivered">
                <i class="fa-solid fa-house-circle-check"></i>
            </div>
            <div class="summary-info">
                <div class="label">Sudah Terkirim</div>
                <div class="value">{{ number_format($totalTerkirim) }} Paket</div>
            </div>
        </div>
    </div>
    <!-- FILTER SECTION -->
    <div class="filter-section">
        <form action="{{ route('admin.pengiriman.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label for="search"><i class="fa-solid fa-magnifying-glass"></i> Cari Pengiriman</label>
                <input type="text" name="search" id="search" class="filter-input" 
                    placeholder="Order ID, Nama, atau No HP..." 
                    value="{{ request('search') }}">
            </div>
 
            <div class="filter-group">
                <label for="status"><i class="fa-solid fa-truck-ramp-box"></i> Status</label>
                <select name="status" id="status" class="filter-input">
                    <option value="">Semua Status</option>
                    <option value="sedang_dikirim" {{ request('status') == 'sedang_dikirim' ? 'selected' : '' }}>🚢 Sedang Dikirim</option>
                    <option value="terkirim" {{ request('status') == 'terkirim' ? 'selected' : '' }}>✅ Terkirim</option>
                </select>
            </div>
 
            <div class="filter-group">
                <label for="kurir"><i class="fa-solid fa-user-gear"></i> Kurir</label>
                <input type="text" name="kurir" id="kurir" class="filter-input" placeholder="Nama Kurir..." value="{{ request('kurir') }}">
            </div>
 
            <div class="filter-group">
                <label for="date"><i class="fa-solid fa-calendar-day"></i> Tgl Kirim</label>
                <input type="date" name="date" id="date" class="filter-input" value="{{ request('date') }}">
            </div>
 
            <div class="filter-actions">
                @if(request('search') || request('status') || request('kurir') || request('date'))
                    <a href="{{ route('admin.pengiriman.index') }}" class="btn-filter-clear" title="Clear Filters">
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
                        <th>ID Pengiriman</th>
                        <th>Order ID</th>
                        <th>Penerima</th>
                        <th>Alamat</th>
                        <th>Kurir</th>
                        <th style="text-align: right;">Ongkir</th>
                        <th>Tgl Kirim</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengiriman as $p)
                    <tr>
                        <td data-label="No">{{ ($pengiriman->currentPage() - 1) * $pengiriman->perPage() + $loop->iteration }}</td>
                        <td data-label="ID Pengiriman">
                            <span class="id-badge ship-badge">
                                <i class="fa-solid fa-truck"></i>
                                #SHIP-{{ str_pad($p->pengiriman_id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td data-label="Order ID">
                            <span class="id-badge ord-badge">
                                <i class="fa-solid fa-box"></i>
                                #ORD-{{ str_pad($p->pesanan_id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td data-label="Penerima" style="text-align: left;">
                            <div style="font-weight: 700; color: #1f2937;">{{ $p->nama_penerima }}</div>
                            <div style="font-size: 11px; color: #9ca3af;">{{ $p->phone_penerima }}</div>
                        </td>
                        <td data-label="Alamat" style="text-align: left;">
                            <div style="font-size: 13px; color: #4b5563; max-width: 250px; white-space: normal;">{{ $p->alamat_pengiriman }}</div>
                        </td>
                        <td data-label="Kurir">
                            <span class="badge" style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; font-size: 11px;">
                                {{ $p->kurir ?? 'Belum Diatur' }}
                            </span>
                        </td>
                        <td data-label="Ongkir" style="text-align: right; font-weight: 700; color: #be185d;">
                            Rp {{ number_format($p->ongkir, 0, ',', '.') }}
                        </td>
                        <td data-label="Tgl Kirim">
                            @if($p->tanggal_kirim)
                                <div style="font-weight: 600;">{{ \Carbon\Carbon::parse($p->tanggal_kirim)->format('d/m/Y') }}</div>
                                <div style="font-size: 11px; color: #9ca3af;">{{ \Carbon\Carbon::parse($p->tanggal_kirim)->format('H:i') }} WIB</div>
                            @else
                                <div style="font-weight: 600;">-</div>
                            @endif
                        </td>
                        <td data-label="Status">
                            <form action="{{ route('admin.pengiriman.updateStatus', $p->pengiriman_id) }}" method="POST" style="margin: 0;">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="status-select" 
                                    style="background: {{ $p->status_pengiriman == 'terkirim' ? '#dcfce7' : '#e0f2fe' }}; color: {{ $p->status_pengiriman == 'terkirim' ? '#15803d' : '#0369a1' }}; border-color: transparent;">
                                    <option value="sedang_dikirim" {{ $p->status_pengiriman == 'sedang_dikirim' ? 'selected' : '' }}>🚢 Sedang Dikirim</option>
                                    <option value="terkirim" {{ $p->status_pengiriman == 'terkirim' ? 'selected' : '' }}>✅ Terkirim</option>
                                </select>
                            </form>
                        </td>
                        <td data-label="Aksi">
                            <button type="button" class="btn-edit-ship" onclick="editPengiriman({{ $p->pengiriman_id }}, '{{ $p->kurir }}', '{{ $p->tanggal_kirim }}')" title="Edit Info Pengiriman">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 60px;">
                            <div style="font-size: 40px; margin-bottom: 20px;">📦</div>
                            <div style="font-weight: 600; color: #9ca3af;">Belum ada data pengiriman yang dicatat.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengiriman->hasPages())
        <div class="custom-pagination">
            {{ $pengiriman->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>

<!-- MODAL EDIT PENGIRIMAN -->
<div id="modalEditPengiriman" class="modal-backdrop" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; justify-content: center; align-items: center; padding: 20px;">
    <div class="premium-modal" style="width: 100%; max-width: 450px; box-shadow: 0 25px 50px -12px rgba(139, 63, 82, 0.25);">
        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 800;">🛠️ Edit Info Pengiriman</h3>
            <button onclick="closeEditModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        <form id="formEditPengiriman" method="POST" style="padding: 25px;">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #8b3f52; text-transform: uppercase; margin-bottom: 8px; margin-left: 4px;">Kurir / Layanan</label>
                <input type="text" name="kurir" id="edit_kurir" class="form-control" placeholder="Contoh: Kurir Toko, J&T, Sicepat">
            </div>
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #8b3f52; text-transform: uppercase; margin-bottom: 8px; margin-left: 4px;">Waktu Kirim</label>
                <input type="datetime-local" name="tanggal_kirim" id="edit_tanggal_kirim" class="form-control">
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeEditModal()" style="background: #f3f4f6; color: #6b7280; border: none; padding: 12px 24px; border-radius: 14px; cursor: pointer; font-weight: 700;">Batal</button>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('script')
<script>
    function editPengiriman(id, kurir, tanggal) {
        document.getElementById('formEditPengiriman').action = `/admin/pengiriman/update-info/${id}`;
        document.getElementById('edit_kurir').value = kurir !== 'null' ? kurir : '';
        
        if (tanggal && tanggal !== 'null') {
            const date = new Date(tanggal);
            const offset = date.getTimezoneOffset() * 60000;
            const localDate = new Date(date.getTime() - offset);
            const formatted = localDate.toISOString().slice(0, 16);
            document.getElementById('edit_tanggal_kirim').value = formatted;
        } else {
            document.getElementById('edit_tanggal_kirim').value = '';
        }

        document.getElementById('modalEditPengiriman').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('modalEditPengiriman').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('modalEditPengiriman')) {
            closeEditModal();
        }
    }
</script>
@endpush
@endsection
