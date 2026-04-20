<style>
    /* ===============================
   SIDEBAR
=============================== */
.budget-sidebar {
    position: fixed;
    right: 0;
    top: 0;
    width: 400px;
    height: 100vh;
    background: #ffffff;
    box-shadow: -4px 0 30px rgba(190, 24, 93, 0.1);
    padding: 0;
    overflow-y: auto;
    z-index: 2000;
    border-left: 1px solid #fce7f3;
    
    /* Default state: invisible and non-interactive */
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateX(100%);

    will-change: transform, opacity;
    transition: transform 0.5s cubic-bezier(.22,1,.36,1),
                opacity 0.3s ease,
                visibility 0.5s;
}

@media (max-width: 480px) {
    .budget-sidebar {
        width: 100%;
        height: auto;
        max-height: 70vh; /* Mengcover 70% layar agar menu di belakang tetap terlihat */
        top: auto;
        bottom: 0;
        border-left: none;
        border-top: 2px solid #fce7f3;
        border-radius: 24px 24px 0 0;
        transform: translateY(100%); /* Slide dari bawah di HP */
        box-shadow: 0 -10px 40px rgba(190, 24, 93, 0.15);
    }
}

.budget-sidebar.active {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

@media (min-width: 481px) {
    .budget-sidebar.active {
        transform: translateX(0);
    }
}

@media (max-width: 480px) {
    .budget-sidebar.active {
        transform: translateY(0);
    }
}

.budget-sidebar h3 {
    font-size: 18px;
    font-weight: 700;
    color: #be185d;
    margin-bottom: 16px;
}

.sidebar-input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid #f1c0c7;
    margin-top: 6px;
    margin-bottom: 12px;
    font-size: 14px;
}

.sidebar-input:focus {
    outline: none;
    border-color: #ec4899;
    box-shadow: 0 0 0 2px rgba(236,72,153,0.15);
}

.btn-sidebar {
    width: 100%;
    padding: 12px;
    border-radius: 999px;
    border: none;
    background: linear-gradient(90deg,#f472b6,#ec4899);
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.btn-sidebar:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.card {
    background: #fff7fa;
    border: 1px solid #fbcfe8;
    border-radius: 12px;
    padding: 12px;
}

.produk-grid label {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 0;
    font-size: 13px;
}

.produk-grid input[type="checkbox"] {
    accent-color: #ec4899;
}

#pesanan-saya table {
    border: 1px solid #f3f4f6;
    border-radius: 8px;
    overflow: hidden;
}

#pesanan-saya th {
    background: #f9fafb;
    font-weight: 600;
    font-size: 12px;
}

#pesanan-saya td {
    border-top: 1px solid #f3f4f6;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media (max-width: 480px) {
    .info-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
}

.budget-sidebar::-webkit-scrollbar {
    width: 6px;
}

.budget-sidebar::-webkit-scrollbar-thumb {
    background: #f9a8d4;
    border-radius: 10px;
}

.paket-disabled {
    opacity: 0.4;
}

.info-paket {
    background:#fff7fa;
    border:1px solid #f9a8d4;
    color:#9d174d;
    padding:10px;
    border-radius:8px;
    font-size:14px;
}

/* ===============================
   PESANAN MODERN
=============================== */
.pesanan-card.modern {
    background: linear-gradient(180deg,#ffffff,#fff7fa);
    border-radius: 18px;
    border: 1px solid #fbcfe8;
    padding: 14px;
    animation: fadeUp 0.4s ease;
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* HEADER */
.pesanan-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.pesanan-header h4 {
    font-size: 15px;
    font-weight: 700;
    color: #be185d;
    margin: 0;
}

.pesanan-header small {
    font-size: 11px;
    color: #9ca3af;
}

.pesanan-chip {
    background: #fce7f3;
    color: #9d174d;
    font-size: 11px;
    font-weight: 600;
    padding: 6px 10px;
    border-radius: 999px;
}

/* PROGRESS */
.budget-progress {
    width: 100%;
    height: 8px;
    background: #fde2e8;
    border-radius: 999px;
    overflow: hidden;
    margin-top: 6px;
}

.budget-bar {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg,#f472b6,#ec4899);
    transition: width 0.4s ease;
}

.budget-info {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: #6b7280;
    margin-top: 4px;
}

/* TABLE */
.pesanan-table-wrapper {
    max-height: 260px;
    overflow-y: auto;
    overflow-x: auto;
    margin-top: 10px;
    border-radius: 12px;
    -webkit-overflow-scrolling: touch;
}

.pesanan-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}

.pesanan-table thead th {
    position: sticky;
    top: 0;
    background: #fdf2f8;
    padding: 8px;
    font-weight: 600;
    color: #9d174d;
    border-bottom: 1px solid #fbcfe8;
}

.pesanan-table tbody tr {
    transition: background 0.2s ease, transform 0.2s ease;
}

.pesanan-table tbody tr:hover {
    background: #fff1f6;
    transform: scale(1.01);
}

.pesanan-table td {
    padding: 8px;
    border-bottom: 1px dashed #fbcfe8;
}

.pesanan-table textarea {
    width: 100%;
    border-radius: 8px;
    border: 1px solid #f1c0c7;
    padding: 4px;
    font-size: 11px;
    resize: none;
    box-sizing: border-box;
}

/* FOOTER */
.pesanan-footer {
    margin-top: 12px;
    padding: 12px;
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 4px 12px rgba(236,72,153,0.12);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pesanan-footer strong {
    font-size: 17px;
    color: #be185d;
}

/* BADGE STATUS */
.total-badge {
    font-size: 11px;
    padding: 6px 10px;
    border-radius: 999px;
    font-weight: 600;
}

.total-badge.success {
    background: #dcfce7;
    color: #166534;
}

.total-badge.warning {
    background: #fff7ed;
    color: #92400e;
}

/* SIDEBAR HEADER & CONTENT */
.sidebar-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 12px 20px 20px;
    background: #fff;
    position: sticky;
    top: 0;
    z-index: 20;
    border-bottom: 1px solid #fdf2f8;
}

.sheet-handle {
    display: none;
    width: 40px;
    height: 4px;
    background: #e5e7eb;
    border-radius: 99px;
    margin-bottom: 12px;
}

@media (max-width: 480px) {
    .sheet-handle {
        display: block;
    }
}

.sidebar-header-content {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.sidebar-header h3 {
    font-size: 19px;
    font-weight: 800;
    color: #be185d;
    margin: 0;
    letter-spacing: -0.5px;
}

.sidebar-body {
    padding: 20px;
}

@media (max-width: 480px) {
    .sidebar-header { padding: 20px 16px 16px; }
    .sidebar-body { padding: 16px; }
    .sidebar-header h3 { font-size: 17px; }
}

/* ===============================
   SIDEBAR FOOTER BUTTON
=============================== */
.sidebar-footer {
    position: sticky;
    bottom: 0;
    background: #ffffff;
    padding-top: 14px;
    margin-top: 18px;
}

.btn-lanjut {
    width: 100%;
    padding: 14px;
    border-radius: 999px;
    border: none;
    background: linear-gradient(90deg,#ec4899,#be185d);
    color: white;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s ease;
    box-shadow: 0 8px 18px rgba(236,72,153,0.25);
}

.btn-lanjut:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(236,72,153,0.35);
}

.btn-lanjut:disabled {
    background: #e5e7eb;
    color: #9ca3af;
    cursor: not-allowed;
    box-shadow: none;
}
</style>
<div id="budget-sidebar" class="budget-sidebar">

    <div class="sidebar-header">
        <div class="sheet-handle"></div>
        <div class="sidebar-header-content">
            <h3>🎂 Atur Budget Paket</h3>
        </div>
    </div>

    <div class="sidebar-body">

    <div id="sidebar-paket-info">
        <p style="color:#9ca3af;font-size:14px">
            Pilih paket terlebih dahulu
        </p>
    </div>

    <div id="sidebar-budget-form" style="display:none">

        <p id="sidebar-paket-nama"
           style="font-weight:600;color:#be185d;margin-bottom:6px">
        </p>

        <p style="font-size:13px;color:#6b7280;margin-bottom:12px">
            Budget:
            <b>Rp <span id="budget-min"></span></b>
            –
            <b>Rp <span id="budget-max"></span></b>
        </p>

        <label style="font-size:13px;font-weight:600">
            Masukkan Budget
        </label>

        <input type="number"
               id="sidebar-budget-input"
               class="sidebar-input">

        <button type="button" class="btn-sidebar" onclick="submitBudget()">
            Lihat Rekomendasi
        </button>

        <div id="info-rekomendasi"
            style="display:none;
                    margin-top:12px;
                    padding:10px;
                    background:#fff7ed;
                    border:1px solid #fed7aa;
                    border-radius:8px;
                    font-size:13px;
                    color:#92400e;">
            ℹ️ Budget yang kamu masukkan belum dapat dikombinasikan
            dengan paket ini.
            Coba sesuaikan budget atau jumlah paket.
        </div>

        <!-- HASIL REKOMENDASI -->
        <div id="hasil-rekomendasi" style="display:none;margin-top:15px">
            <h4 style="font-size:14px">🎁 Rekomendasi Paket</h4>

            <ul id="list-rekomendasi" style="font-size:13px;padding-left:0"></ul>

            <div style="margin-top:10px">
                <label>
                    <input type="radio" name="mode_pesan" value="rekomendasi" checked>
                    Gunakan rekomendasi
                </label><br>

                <label>
                    <input type="radio" name="mode_pesan" value="manual">
                    Pilih sendiri
                </label>
            </div>

            <!-- MANUAL PRODUK -->
            <div class="card" id="manual-produk-card" style="display:none;margin-top:12px">
                <h4 style="font-size:14px;display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
                    <span>🧁 Pilih Produk Manual</span>
                    <span id="manual-count" style="font-size:12px;color:#be185d;font-weight:700"></span>
                </h4>

                <div class="produk-grid" id="manual-produk-list">

                </div>
            </div>

            <div id="info-kombinasi"
                class="info-paket"
                style="display:none;margin-top:10px">
                ℹ️ Kombinasi kue melebihi batas paket.
            </div>

            <!-- PESANAN SAYA -->
            <div id="pesanan-saya" class="pesanan-card modern" style="display:none;">

                <!-- HEADER -->
                <div class="pesanan-header">
                    <div>
                        <h4>🛒 Pesanan Saya</h4>
                        <small id="pesanan-status">Paket aktif</small>
                    </div>

                    <div class="pesanan-chip">
                        🎂 Paket
                    </div>
                </div>

                <!-- TABLE -->
                <div class="pesanan-table-wrapper">
                    <table class="pesanan-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody id="list-pesanan"></tbody>
                    </table>
                </div>

                <!-- FOOTER -->
                <div class="pesanan-footer">
                    <div>
                        <small>Total Harga</small>
                        <strong id="total-pesanan">Rp 0</strong>
                    </div>

                    <div class="total-badge success" id="status-budget">
                        ✔ Dalam Budget
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- ===============================
        BUTTON LANJUT PEMESANAN
    ================================ -->
    <form id="form-lanjut"
        action="{{ route('checkout.review') }}"
        method="POST">
        @csrf

        <input type="hidden" name="mode_pesan" id="input-mode-pesan">
        <input type="hidden" name="budget" id="input-budget">
        <input type="hidden" name="total_harga" id="input-total-harga">
        <input type="hidden" name="cart_data" id="input-cart-data">

        <button type="submit"
                id="btn-lanjut-checkout"
                class="btn-lanjut"
                >
            🛍️ Review Pesanan
        </button>
    </form>

    </div>

</div>

@push('script')
<script>
    // Sidebar close button removed per user request
</script>
@endpush