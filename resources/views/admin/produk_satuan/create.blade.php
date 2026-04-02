<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk Satuan</title>

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

        /* CONTAINER (LEGA) */
        .container {
            width: 100%;
            max-width: 900px;
            padding: 45px 55px;
            background: #ffffff;

            /* TAMBAHAN INI */
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
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
        }

        .btn-back {
            background: #e5e7eb;
            color: #374151;
            text-decoration: none;
            text-align: center;
            line-height: 44px;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .container {
                padding: 40px 45px;
            }
        }

        @media (max-width: 768px) {
            h3 {
                font-size: 20px;
            }

            .container {
                padding: 35px 30px;
            }

            .form-action {
                flex-direction: column;
            }

            .btn-back {
                line-height: normal;
                padding: 13px;
            }
        }

        @media (max-width: 480px) {
            h3 {
                font-size: 18px;
            }

            .container {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="container">

        <form method="POST" action="/admin/produk-satuan" enctype="multipart/form-data">
            @csrf

            <h3>Tambah Produk Satuan</h3>

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" required>
            </div>

            <div class="form-group">
                <label>Kategori Produk</label>
                <select name="kategori_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->kategori_id }}">
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi"></textarea>
            </div>

            <div class="form-group">
                <label>Gambar Produk</label>
                <input type="file" name="gambar" accept="image/*">
            </div>

            <div class="form-group">
                <label>Status Produk</label>
                <select name="status" required>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <div class="form-action">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="/admin/produk-satuan" class="btn btn-back">Kembali</a>
            </div>
        </form>

    </div>
</div>

</body>
</html>
