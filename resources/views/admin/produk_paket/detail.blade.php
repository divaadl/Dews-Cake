<style>
/* ================= INFO PAKET ================= */
.info-box {
    display: grid;
    grid-template-columns: 160px 1fr;
    gap: 10px 18px;
    padding: 16px 18px;
    background: #fdf2f5;
    border-radius: 14px;
    border: 1px solid #f3c2cd;
    margin-bottom: 24px;
    font-size: 14px;
}

.info-box .label {
    color: #6b7280;
    font-weight: 600;
}

.info-box .value {
    color: #111827;
    font-weight: 500;
}

/* BADGE STATUS */
.badge {
    padding: 5px 14px;
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

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    font-size: 14px;
}

th, td {
    padding: 12px 14px;
    border: 1px solid #f3c2cd;
    text-align: center;
}

th {
    background: #fde2e8;
    font-weight: 600;
}

td:first-child {
    text-align: left;
}

hr {
    margin: 26px 0;
    border: none;
    border-top: 1px solid #f3c2cd;
}

.text-right {
    text-align: right !important;
    font-variant-numeric: tabular-nums;
}
</style>

<!-- ================= INFORMASI PAKET ================= -->
<h4 style="margin-bottom:12px">Informasi Paket</h4>

<div class="info-box">
    <div class="label">Nama Paket</div>
    <div class="value">{{ $paket->nama_paket }}</div>

    <div class="label">Jenis Paket</div>
    <div class="value">{{ ucfirst($paket->jenis_paket) }}</div>

    <div class="label">Kapasitas Paket</div>
    <div class="value">
        {{ $paket->max_kue }} kue
    </div>

    <div class="label">Detail Isi</div>
    <div class="value">
        {{ $paket->max_kue }} kue
        ({{ $jumlahJenis }} jenis × {{ $jumlahPerJenis }} pcs)
    </div>

    <div class="label">Total Kue Saat Ini</div>
    <div class="value">
        {{ $totalKue }} kue
    </div>

    <div class="label">Minimal Budget</div>
    <div class="value">Rp {{ number_format($paket->minimal_budget) }}</div>

    <div class="label">Maksimal Budget</div>
    <div class="value">Rp {{ number_format($paket->maksimal_budget) }}</div>

    <div class="label">
        Biaya {{ $paket->jenis_paket === 'nampan' ? 'Nampan' : 'Kardus' }}
    </div>
    <div class="value">
        Rp {{ number_format($paket->biaya_wadah ?? 0) }}
    </div>

    <div class="label">Deskripsi</div>
    <div class="value">{{ $paket->deskripsi ?? '-' }}</div>

    <div class="label">Status</div>
    <div class="value">
        <span class="badge {{ $paket->status == 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
            {{ ucfirst($paket->status) }}
        </span>
    </div>
</div>

<hr>

<!-- ================= PRODUK DALAM PAKET ================= -->
<h4 style="margin-bottom:12px">Produk dalam Paket</h4>

<table>
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th width="90">Jumlah</th>
            <th width="120">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($produkPaket as $row)
        <tr id="produk-{{ $row->produk_id }}">
            <td>{{ optional($row->produk)->nama_produk ?? '-' }}</td>
            <td class="text-right">Rp {{ number_format(optional($row->produk)->harga ?? 0) }}</td>
            <td class="jumlah-kue">{{ $row->jumlah_per_jenis }}</td>
            <td>
                <button
                    type="button"
                    class="btn btn-delete btn-hapus-produk"
                    data-paket="{{ $paket->paket_id }}"
                    data-produk="{{ $row->produk_id }}">
                    Hapus
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" style="color:#6b7280">Belum ada produk dalam paket</td>
        </tr>
        @endforelse
    </tbody>
</table>

<hr>

<!-- ================= TAMBAH PRODUK ================= -->
<h4 style="margin-bottom:12px">Tambah Produk ke Paket</h4>

<table>
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th width="120">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($produk as $item)
        <tr>
            <td>{{ $item->nama_produk }}</td>
            <td class="text-right">Rp {{ number_format($item->harga) }}</td>
            <td>
                <form onsubmit="tambahProduk(event, {{ $paket->paket_id }})">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $item->produk_id }}">
                    <input type="hidden" name="jumlah" value="1">
                    <button type="submit" class="btn btn-add">
                        Tambah
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>