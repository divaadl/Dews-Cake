@extends('layouts.admin')

@section('title', 'Data Produk Satuan')

@section('content')

<style>
    /* TABLE WRAPPER */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        min-width: 1000px; /* supaya tidak gepeng */
        border-collapse: collapse;
        font-size: 14px;
    }

    th, td {
        padding: 12px 14px;
        border: 1px solid #f3c2cd;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }

    th {
        background: var(--primary-soft);
        color: #374151;
        font-weight: 600;
    }

    /* GAMBAR */
    .product-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #f3c2cd;
    }

    /* STATUS */
    .status-box {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
        font-size: 13px;
    }

    .status-box label {
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    /* AKSI */
    .action-btn {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    /* HEADER */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
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


    /* RESPONSIVE */
    @media (max-width: 768px) {

        .header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .action-btn {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="header">
    <h3>Data Produk Satuan</h3>
    <a href="/admin/produk-satuan/create" class="btn btn-add">
        + Tambah Produk
    </a>
</div>

{{-- ALERT SESSION --}}
@if(session('success'))
    <div class="alert alert-success" style="margin-bottom:15px;padding:10px;background:#d1fae5;color:#065f46;border-radius:8px">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error" style="margin-bottom:15px;padding:10px;background:#fee2e2;color:#b91c1c;border-radius:8px">
        {{ session('error') }}
    </div>
@endif


<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Berat</th>
                <th>Masa Simpan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($produk as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    @if ($item->gambar)
                        <img 
                            src="{{ asset('storage/'.$item->gambar) }}" 
                            class="product-img"
                            alt="{{ $item->nama_produk }}">
                    @else
                        -
                    @endif
                </td>

                <td>{{ $item->kode_produk }}</td>
                <td style="text-align:left">{{ $item->nama_produk }}</td>

                <td>
                    {{ $item->kategori ? $item->kategori->nama_kategori : '-' }}
                </td>

                <td>Rp {{ number_format($item->harga) }}</td>
                <td>{{ $item->berat }} gr</td>
                <td>
                    @if($item->masa_simpan && is_array($item->masa_simpan))
                        <ul style="list-style: none; padding: 0; margin: 0; text-align: left; font-size: 14px;">
                            @foreach($item->masa_simpan as $ms)
                                @if(is_array($ms))
                                    <li>• {{ $ms['tempat'] }}: {{ $ms['durasi'] }}</li>
                                @elseif(!empty($ms))
                                    <li>• {{ $ms }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </td>
                <td>
                    <form action="/admin/produk-satuan/{{ $item->produk_id }}/status" method="POST">
                        @csrf
                        <div class="status-box">
                            <label>
                                <input type="radio" name="status" value="aktif"
                                    {{ $item->status == 'aktif' ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                Aktif
                            </label>
                            <label>
                                <input type="radio" name="status" value="tidak_aktif"
                                    {{ $item->status == 'tidak_aktif' ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                Tidak Aktif
                            </label>
                        </div>
                    </form>
                </td>

                <td>
                    <div class="action-btn">
                        <a href="/admin/produk-satuan/{{ $item->produk_id }}/edit"
                           class="btn btn-edit">Edit</a>

                        <button class="btn btn-delete"
                                onclick="openDeleteModal(
                                    {{ $item->produk_id }},
                                    '{{ $item->nama_produk }}'
                                )">
                            Hapus
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach

        <script>
        function openDeleteModal(id, name) {
            document.getElementById('modalDelete').style.display = 'flex';
            document.body.style.overflow = 'hidden';

            document.getElementById('deleteName').innerText = name;
            document.getElementById('deleteForm').action =
                '/admin/produk-satuan/' + id;
        }

        function closeDeleteModal() {
            document.getElementById('modalDelete').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        </script>
        </tbody>
    </table>
    <!-- ================= MODAL KONFIRMASI HAPUS ================= -->
    <div id="modalDelete" class="modal">
        <div class="modal-content" style="max-width:460px">

            <div class="modal-header">
                <h3 style="color:#dc2626">⚠️ Konfirmasi Hapus</h3>
                <button class="close-btn" onclick="closeDeleteModal()">×</button>
            </div>

            <div class="modal-body" style="text-align:center">
                <p style="color:#374151;margin-bottom:8px">
                    Kamu akan menghapus produk:
                </p>

                <strong id="deleteName"
                        style="display:block;font-size:16px;color:#111827;margin-bottom:18px">
                </strong>

                <p style="font-size:13px;color:#b91c1c;margin-bottom:25px">
                    Data produk akan dihapus permanen dan tidak dapat dikembalikan.
                </p>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE') <!-- Tambahkan ini -->
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

@endsection
