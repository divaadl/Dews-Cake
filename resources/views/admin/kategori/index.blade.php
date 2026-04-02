<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kategori Produk</title>

    <style>
        :root {
            --primary: #f7a6b8;
            --primary-dark: #f28aa5;
            --primary-soft: #fde2e8;
            --text-dark: #2f2f2f;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }

        .container {
            padding: 40px;
            background: #fff;
            max-width: 1100px;
            margin: 40px auto;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        }

        h3 {
            margin: 0;
            color: var(--text-dark);
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        /* BUTTON */
        .btn {
            padding: 9px 16px;
            border-radius: 8px;
            color: #fff;
            text-decoration: none;
            font-size: 13.5px;
            transition: 0.2s;
            display: inline-block;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-add {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }

        .btn-edit {
            background: linear-gradient(135deg, #4ade80, #22c55e);
        }

        .btn-delete {
            background: linear-gradient(135deg, #f87171, #ef4444);
        }

        .btn-back {
            background: #9ca3af;
        }

        /* TABLE */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 800px;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 15px;
            border: 1px solid var(--primary-soft);
            border-radius: 14px;
            overflow: hidden;
        }

        thead th {
            padding: 14px 16px;
            background: var(--primary-soft);
            color: #374151;
            font-weight: 700;
            border-bottom: 1px solid #f3b6c5;
            text-align: center;
        }

        thead th:last-child {
            text-align: center;
        }

        tbody tr {
            transition: 0.25s ease;
        }

        tbody tr:hover {
            background: #fff5f7;
        }

        tbody td {
            padding: 16px;
            border-bottom: 1px solid #f3d0d9;
            border-right: 1px solid #f3d0d9;
            text-align: center;
        }

        tbody td:nth-child(2) {
            text-align: left;
        }

        tbody td:last-child {
            border-right: none;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* BADGE STATUS */
        .badge {
            padding: 7px 16px;
            border-radius: 999px;
            font-size: 12.5px;
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

        .footer {
            margin-top: 25px;
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-content {
            background: #fff;
            border-radius: 18px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
            animation: fadeUp 0.25s ease;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 22px;
            border-bottom: 1px solid #eee;
        }

        .modal-body {
            padding: 22px;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6b7280;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        /* ===================== */
        /* RESPONSIVE */
        /* ===================== */

        @media (max-width: 1024px) {
            .container {
                padding: 30px;
                margin: 30px 20px;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            table {
                min-width: 750px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
                border-radius: 14px;
            }

            h3 {
                font-size: 18px;
            }

            thead th,
            tbody td {
                padding: 12px 10px;
                font-size: 14px;
            }

            .footer .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <h3>Data Kategori Produk</h3>
        <a href="/admin/kategori-produk/create" class="btn btn-add">
            + Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div style="
            margin-bottom:20px;
            padding:14px 18px;
            background:#dcfce7;
            color:#15803d;
            border-radius:10px;
            font-size:14px;
            font-weight:500;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="
            margin-bottom:20px;
            padding:14px 18px;
            background:#fee2e2;
            color:#b91c1c;
            border-radius:10px;
            font-size:14px;
            font-weight:500;">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama Kategori</th>
                    <th>Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategori as $k)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $k->nama_kategori }}</td>
                    <td>
                        @if($k->status === 'aktif')
                            <span class="badge badge-aktif">Aktif</span>
                        @else
                            <span class="badge badge-nonaktif">Non Aktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="/admin/kategori-produk/{{ $k->kategori_id }}/edit"
                        class="btn btn-edit">
                            Edit
                        </a>

                        @if($k->produk_count > 0)
                            <button class="btn"
                                    style="background:#9ca3af;cursor:not-allowed"
                                    onclick="alert('Kategori tidak bisa dihapus karena masih digunakan')">
                                Hapus
                            </button>
                        @else
                            <button class="btn btn-delete"
                                    onclick="openDeleteModal({{ $k->kategori_id }}, '{{ $k->nama_kategori }}')">
                                Hapus
                            </button>
                        @endif
                    </td>

                </tr>
                @endforeach

                <script>
                function openDeleteModal(id, name) {
                    document.getElementById('modalDelete').style.display = 'flex';
                    document.body.style.overflow = 'hidden';

                    document.getElementById('deleteName').innerText = name;
                    document.getElementById('deleteForm').action =
                        '/admin/kategori-produk/' + id;
                }

                function closeDeleteModal() {
                    document.getElementById('modalDelete').style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
                </script>

            </tbody>
        </table>
        <!-- ================= MODAL HAPUS ================= -->
        <div id="modalDelete" class="modal">
            <div class="modal-content" style="max-width:460px">

                <div class="modal-header">
                    <h3 style="color:#dc2626">⚠️ Konfirmasi Hapus</h3>
                    <button class="close-btn" onclick="closeDeleteModal()">×</button>
                </div>

                <div class="modal-body" style="text-align:center">
                    <p style="color:#374151;margin-bottom:8px">
                        Kamu akan menghapus kategori:
                    </p>

                    <strong id="deleteName"
                            style="display:block;font-size:16px;color:#111827;margin-bottom:18px">
                    </strong>

                    <p style="font-size:13px;color:#b91c1c;margin-bottom:25px">
                        Tindakan ini tidak dapat dibatalkan.
                    </p>

                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div style="display:flex;gap:10px;justify-content:center">
                            <button type="button"
                                    onclick="closeDeleteModal()"
                                    class="btn"
                                    style="background:#e5e7eb;color:#374151">
                                Batal
                            </button>

                            <button type="submit" class="btn btn-delete">
                                Ya, Hapus
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>

    <div class="footer">
        <a href="/admin/dashboard" class="btn btn-back">Kembali</a>
    </div>

</div>

</body>
</html>
