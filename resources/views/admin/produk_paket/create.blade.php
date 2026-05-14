<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk Paket</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #f7a6b8;
            --primary-dark: #f28aa5;
            --text-dark: #2f2f2f;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f4f6f8;
        }

        /* CENTER PAGE */
        .page-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        /* CARD CONTAINER */
        .container {
            width: 100%;
            max-width: 900px;
            padding: 45px 55px;
            background: #ffffff;
            border-radius: 22px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.08);
            border: 1px solid #f3e1e6;
        }

        h3 {
            margin-bottom: 32px;
            font-size: 22px;
            color: var(--text-dark);
            text-align: center;
        }

        /* FORM GROUP */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 13px 15px;
            border-radius: 12px;
            border: 1px solid #f3c2cd;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            transition: 0.2s;
        }

        textarea {
            resize: vertical;
            min-height: 110px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(247,166,184,0.25);
        }

        /* BUTTON */
        .form-action {
            display: flex;
            gap: 14px;
            margin-top: 35px;
        }

        .btn {
            flex: 1;
            padding: 13px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: 0.2s;
            text-align: center;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
        }

        .btn-back {
            background: #e5e7eb;
            color: #374151;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .container {
                padding: 35px 30px;
            }

            .form-action {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 25px 20px;
            }

            h3 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="container">

        <h3>Tambah Produk Paket</h3>

        <form action="/admin/produk-paket" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nama Paket</label>
                <input type="text" name="nama_paket" required>
            </div>

            <div class="form-group">
                <label>Jenis Paket</label>
                <select name="jenis_paket" required>
                    <option value="">-- Pilih Jenis Paket --</option>
                    <option value="kotak">Kotak</option>
                    <option value="nampan">Nampan</option>
                </select>
            </div>

            <div class="form-group">
                <label>
                    Biaya Kardus / Nampan
                    <small style="color:#9ca3af">(dihitung 1x per paket)</small>
                </label>

                <input
                    type="text"
                    name="biaya_wadah"
                    id="biaya_wadah"
                    value="{{ old('biaya_wadah', $paket->biaya_wadah ?? 0) }}"
                    required
                >

                <small style="color:#6b7280">
                    Otomatis dianggap:
                    <strong>Kardus</strong> untuk paket kotak,
                    <strong>Nampan</strong> untuk paket nampan
                </small>
            </div>

            <div class="form-group">
                <label>Jumlah Maksimal Kue</label>
                <input type="number" name="max_kue" min="1" required
                    value="{{ old('max_kue', 0) }}">
            </div>

            <div class="form-group">
                <label>Qty Per Jenis</label>
                <input type="number" name="qty_per_jenis" min="1"
                    value="{{ old('qty_per_jenis', $paket->qty_per_jenis ?? 1) }}"
                    required>
            </div>

            <div class="form-group">
                <label>Minimal Budget</label>
                <input type="text" name="minimal_budget" id="minimal_budget" required>
            </div>

            <div class="form-group">
                <label>Maksimal Budget</label>
                <input type="text" name="maksimal_budget" id="maksimal_budget" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi"></textarea>
            </div>

            <div class="form-group">
                <label>Gambar Paket</label>
                <input type="file" name="gambar" accept="image/*">
            </div>

            <div class="form-group">
                <label>Status Paket</label>
                <select name="status" required>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <div class="form-action">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
                <a href="/admin/produk-paket" class="btn btn-back">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>

<script>
    const priceFields = ['biaya_wadah', 'minimal_budget', 'maksimal_budget'];

    priceFields.forEach(id => {
        const input = document.getElementById(id);
        if (!input) return;

        // Format initial value
        if (input.value) {
            input.value = formatRupiah(input.value.replace(/[^0-9]/g, ''));
        }

        input.addEventListener('input', function(e) {
            let value = this.value.replace(/[^0-9]/g, '');
            this.value = value ? formatRupiah(value) : '';
        });
    });

    function formatRupiah(angka) {
        let number_string = angka.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return rupiah;
    }

    document.querySelector('form').addEventListener('submit', function() {
        priceFields.forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.value = input.value.replace(/\./g, '');
            }
        });
    });
</script>

</body>
</html>