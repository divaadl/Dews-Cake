@extends('layouts.admin')

@section('title', 'Data Produk Paket')

@section('content')

<style>
    /* WRAPPER TABLE */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        min-width: 900px; /* supaya tidak gepeng */
        border-collapse: collapse;
        font-size: 14px;
    }

    /* HARGA RATA KANAN */
    .text-right {
        text-align: right !important;
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

    /* STATUS RADIO */
    .status-box label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        cursor: pointer;
    }

    .status-box {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
    }

    /* AKSI BUTTON */
    .action-btn {
        display: flex;
        gap: 6px;
        justify-content: center;
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
        width: 100%;
        max-width: 900px;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 18px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.25);
        animation: fadeUp 0.25s ease;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 25px;
        border-bottom: 1px solid #eee;
    }

    .modal-body {
        padding: 25px;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 26px;
        cursor: pointer;
        color: #6b7280;
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

<div class="header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <h3>Data Produk Paket</h3>
    <a href="/admin/produk-paket/create" class="btn btn-add">
        + Tambah Paket
    </a>
</div>

@if(session('success'))
    <div style="margin-bottom:15px;padding:10px;background:#d1fae5;color:#065f46;border-radius:8px">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="margin-bottom:15px;padding:10px;background:#fee2e2;color:#b91c1c;border-radius:8px">
        {{ session('error') }}
    </div>
@endif


<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Paket</th>
                <th>Jenis Paket</th>
                <th>Minimal Budget</th>
                <th>Maksimal Budget</th>
                <th>Biaya Wadah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paket as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>

                {{-- KOLOM GAMBAR --}}
                <td>
                    @if($item->gambar)
                        <img src="{{ asset('storage/'.$item->gambar) }}"
                            style="width:60px;height:60px;object-fit:cover;border-radius:10px">
                    @else
                        <span style="font-size:12px;color:#9ca3af">Tidak ada</span>
                    @endif
                </td>

                {{-- NAMA PAKET --}}
                <td style="text-align:left">{{ $item->nama_paket }}</td>

                {{-- JENIS --}}
                <td>{{ ucfirst($item->jenis_paket) }}</td>

                {{-- BUDGET --}}
                <td class="text-right">Rp {{ number_format($item->minimal_budget) }}</td>
                <td class="text-right">Rp {{ number_format($item->maksimal_budget) }}</td>

                <td class="text-right">
                    Rp {{ number_format($item->biaya_wadah ?? 0) }}
                </td>

                {{-- STATUS --}}
                <td>
                    {{-- FORM STATUS --}}
                    <form method="POST" action="/admin/produk-paket/{{ $item->paket_id }}/status">
                        @csrf
                        @method('PUT')

                        <div class="status-box">
                            <label>
                                <input type="radio" name="status" value="aktif"
                                    {{ $item->status == 'aktif' ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                Aktif
                            </label>

                            <label>
                                <input type="radio" name="status" value="nonaktif"
                                    {{ $item->status == 'nonaktif' ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                Nonaktif
                            </label>
                        </div>
                    </form>
                </td>

                {{-- AKSI --}}
                <td>
                    <div class="action-btn">
                        <button class="btn btn-add" onclick="openDetail({{ $item->paket_id }})">
                            Detail
                        </button>

                        <a href="/admin/produk-paket/{{ $item->paket_id }}/edit"
                        class="btn btn-edit">Edit</a>

                        <button class="btn btn-delete"
                            onclick="openDeleteModal({{ $item->paket_id }}, '{{ $item->nama_paket }}')">
                            Hapus
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- ================= MODAL DETAIL PAKET ================= -->
            <div id="modalDetail" class="modal">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3>Detail Paket</h3>
                        <button class="close-btn" onclick="closeModal()">×</button>
                    </div>

                    <div class="modal-body" id="modalBody">
                        <!-- CONTENT DIISI VIA AJAX -->
                        <div style="text-align:center;padding:40px">Loading...</div>
                    </div>

                </div>
            </div>

            <!-- ================= MODAL HAPUS ================= -->
            <div id="modalDelete" class="modal">
                <div class="modal-content" style="max-width:480px">

                    <div class="modal-header">
                        <h3 style="color:#dc2626">⚠️ Konfirmasi Hapus</h3>
                        <button class="close-btn" onclick="closeDeleteModal()">×</button>
                    </div>

                    <div class="modal-body" style="text-align:center">
                        <p style="font-size:15px;color:#374151;margin-bottom:10px">
                            Apakah kamu yakin ingin menghapus paket:
                        </p>

                        <strong id="deleteName"
                                style="display:block;margin-bottom:20px;color:#111827">
                        </strong>

                        <p style="font-size:13px;color:#dc2626;margin-bottom:25px">
                            Data yang dihapus tidak dapat dikembalikan.
                        </p>

                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE') <!-- Penting: method DELETE -->
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

@push('scripts')
<script>
    const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-hapus-produk');
        if (!btn) return;

        console.log('TOMBOL HAPUS DIKLIK');
        const paketId = btn.dataset.paket;
        const produkId = btn.dataset.produk;

        Swal.fire({
            title: 'Hapus produk?',
            html: `
                <div style="font-size:14px">
                    Produk ini akan <b>dihapus</b> dari paket.<br>
                    Tindakan ini <span style="color:#dc2626">tidak dapat dibatalkan</span>.
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
        })
        .then((result) => {
            if (!result.isConfirmed) return;

            fetch(`/admin/produk-paket/${paketId}/hapus-produk/${produkId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                if (!data.success) {
                    Swal.fire('Gagal', data.message, 'error');
                    return;
                }

                const row = document.getElementById(`produk-${produkId}`);

                if (data.deleted) {
                    // kalau jumlah jadi 0 → hapus baris
                    row.remove();
                } else {
                    // kalau masih ada → update jumlah
                    row.querySelector('.jumlah-kue').textContent = data.new_jumlah;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Jumlah produk diperbarui',
                    timer: 1200,
                    showConfirmButton: false
                });
            });
        });
    });

    function openDetail(id) {
        document.getElementById('modalDetail').style.display = 'flex';

        fetch('/admin/produk-paket/' + id + '/detail')
            .then(res => res.text())
            .then(html => {
                document.getElementById('modalBody').innerHTML = html;
            });
    }

    function closeModal() {
        document.getElementById('modalDetail').style.display = 'none';
    }

    function openDetail(id) {
        document.getElementById('modalDetail').style.display = 'flex';
        document.body.style.overflow = 'hidden';

        fetch('/admin/produk-paket/' + id + '/detail')
            .then(res => res.text())
            .then(html => {
                document.getElementById('modalBody').innerHTML = html;
            });
    }

    function closeModal() {
        document.getElementById('modalDetail').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function openDeleteModal(id, name) {
        document.getElementById('modalDelete').style.display = 'flex';
        document.body.style.overflow = 'hidden';

        document.getElementById('deleteName').innerText = name;
        document.getElementById('deleteForm').action = '/admin/produk-paket/' + id;
    }

    function closeDeleteModal() {
        document.getElementById('modalDelete').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function tambahProduk(e, paketId) {
        e.preventDefault();
        let form = event.target;
        let produkId = form.querySelector('input[name="produk_id"]').value;

        const btn = e.target.querySelector('button');
        btn.disabled = true;
        btn.innerText = 'Menambahkan...';

        const formData = new FormData(e.target);

        fetch(`/admin/produk-paket/${paketId}/tambah-produk`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(() => fetch(`/admin/produk-paket/${paketId}/detail`))
        .then(res => res.text())
        .then(html => {
            document.getElementById('modalBody').innerHTML = html;
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerText = '+ Tambah';
        });
    }
</script>
@endpush