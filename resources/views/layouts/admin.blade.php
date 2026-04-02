<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin')</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #f7a6b8;
            --primary-dark: #f28aa5;
            --primary-soft: #fde2e8;
            --sidebar-bg: #fde2e8;
            --text-dark: #2f2f2f;
            --text-muted: #6b7280;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f6f7fb;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .swal2-container {
            z-index: 20000 !important;
        }

        /* === SWEETALERT CUSTOM THEME === */
        .swal2-popup {
            border-radius: 18px !important;
            padding: 28px 24px !important;
            font-family: 'Poppins', sans-serif;
        }

        .swal2-title {
            font-size: 20px !important;
            color: #111827 !important;
        }

        .swal2-html-container {
            font-size: 14px !important;
            color: #374151 !important;
        }

        .swal2-confirm {
            background: #ec4899 !important;   /* pink */
            border-radius: 10px !important;
            padding: 10px 22px !important;
            font-weight: 600;
        }

        .swal2-cancel {
            background: #e5e7eb !important;
            color: #374151 !important;
            border-radius: 10px !important;
            padding: 10px 22px !important;
            font-weight: 500;
        }

        .swal2-icon.swal2-warning {
            border-color: #ec4899 !important;
            color: #ec4899 !important;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #fde2e8, #fbe8ed);
            padding: 25px 18px;
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }

        /* LOGO */
        .sidebar .logo {
            text-align: center;
            margin-bottom: 35px;
        }

        .sidebar .logo img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid var(--primary);
            background: var(--white);
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
        }

        .sidebar .logo h3 {
            margin-top: 12px;
            font-size: 18px;
            color: var(--text-dark);
            letter-spacing: 1px;
        }

        /* MENU */
        .sidebar a {
            position: relative;
            display: flex;
            align-items: center;
            padding: 12px 14px;
            margin-bottom: 10px;
            background: var(--white);
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .sidebar a:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
            transform: translateX(4px);
        }

        /* ACTIVE */
        .sidebar a.active {
            background: var(--primary);
            color: var(--white);
            box-shadow: 0 6px 14px rgba(247,166,184,0.6);
        }

        .sidebar a.active::before {
            content: "";
            position: absolute;
            left: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 60%;
            background: var(--primary-dark);
            border-radius: 6px;
        }

        /* LOGOUT */
        .sidebar .logout {
            margin-top: auto;
        }

        .sidebar .logout button {
            width: 100%;
            display: flex;
            align-items: center;
            padding: 12px 14px;
            background: linear-gradient(135deg, #f87171, #ef4444);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all .25s ease;
        }

        .sidebar .logout button:hover {
            box-shadow: 0 8px 18px rgba(239,68,68,0.45);
            transform: translateX(4px);
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 35px;
            background: #fdfdfd;
            overflow-y: auto;
        }

        /* CARD */
        .card {
            background: var(--white);
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }

        /* ===== MODERN TABLE ===== */
        .table-wrapper {
            background: #ffffff;
            padding: 20px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        }

        table {
            border-collapse: collapse;
        }

        table thead th {
            border: none;
            text-align: center;
        }

        /* ROW */
        table tbody tr {
            background: #ffffff;
            transition: 0.25s ease;
        }

        table tbody td.harga,
        table tbody td:nth-child(6) {
            text-align: right;
            font-weight: 500;
        }

        /* HOVER */
        table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(247,166,184,0.25);
        }

        /* CELL */
        table tbody td {
            border-bottom: 1px solid #f4cfd8;
        }

        /* ROUND CORNER */
        table tbody td:first-child {
            border-left: 1px solid #f1f1f1;
            border-radius: 12px 0 0 12px;
        }

        table tbody td:last-child {
            border-right: 1px solid #f1f1f1;
            border-radius: 0 12px 12px 0;
        }

        /* STATUS BADGE */
        .badge {
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-aktif {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-nonaktif {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* ACTION BUTTON */
        .table-action a {
            margin: 0 3px;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 12px;
            text-decoration: none;
            color: #fff;
            transition: 0.2s;
        }

        .table-action a:hover {
            transform: scale(1.05);
        }

        .btn-edit {
            background: linear-gradient(135deg, #4ade80, #22c55e);
        }

        .btn-delete {
            background: linear-gradient(135deg, #f87171, #ef4444);
        }


        /* BUTTON */
        .btn {
            padding: 7px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            color: #fff;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-add {
            background: linear-gradient(135deg, #f7a6b8, #f28aa5);
        }

        .btn-edit {
            background: linear-gradient(135deg, #4ade80, #22c55e);
        }

        .btn-delete {
            background: linear-gradient(135deg, #f87171, #ef4444);
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

    </style>

    @stack('style')
</head>
<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
            <h3>ADMIN</h3>
        </div>
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/kategori-produk">Data Kategori Produk Satuan</a>
        <a href="/admin/produk-satuan">Data Produk Satuan</a>
        <a href="/admin/produk-paket">Data Produk Paket</a>
        <a href="/admin/pesanan">Data Pesanan</a>
        <a href="/admin/pembayaran">Data Pembayaran</a>
        <a href="/admin/pengiriman">Data Pengiriman</a>
        <a href="/admin/laporan-penjualan">Laporan Penjualan</a>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}" class="logout">
            @csrf
            <button type="submit">
                Logout
            </button>
        </form>
    </div>

    <!-- CONTENT -->
    <div class="content">
        @yield('content')
    </div>

</div>

@stack('script')
<script>
    // Global SweetAlert Confirm Mixin
    const PremiumConfirm = Swal.mixin({
        customClass: {
            confirmButton: 'swal2-confirm',
            cancelButton: 'swal2-cancel'
        },
        buttonsStyling: false,
        borderRadius: '28px'
    });

    // Global Success/Error Listeners
    @if(session('success'))
        PremiumConfirm.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        PremiumConfirm.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}"
        });
    @endif

    let hapusProdukData = {
            paketId: null,
            produkId: null
        };

        function hapusProduk(paketId, produkId, namaProduk = '') {
            console.log('hapusProduk terpanggil', paketId, produkId);

            hapusProdukData.paketId = paketId;
            hapusProdukData.produkId = produkId;

            document.getElementById('hapusProdukNama').innerText =
                namaProduk || 'produk ini';

            document.getElementById('modalHapusProduk').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeHapusProduk() {
            document.getElementById('modalHapusProduk').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function confirmHapusProduk() {
            const { paketId, produkId } = hapusProdukData;

            fetch(`/admin/produk-paket/${paketId}/hapus-produk/${produkId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(() => fetch(`/admin/produk-paket/${paketId}/detail`))
            .then(res => res.text())
            .then(html => {
                document.getElementById('modalBody').innerHTML = html;
                closeHapusProduk();
            })
            .catch(err => {
                alert('Gagal menghapus produk');
                console.error(err);
            });
        }
    </script>
</body>
</html>
