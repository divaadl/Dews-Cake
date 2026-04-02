<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori Produk</title>

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

        /* ===================== */
        /* FORM CONTAINER */
        /* ===================== */
        .form-box {
            max-width: 900px;
            width: 100%;
            margin: 60px auto;
            background: #fff;
            padding: 45px 55px;
            border-radius: 22px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.08);
        }

        h3 {
            margin-bottom: 30px;
            color: var(--text-dark);
            text-align: center;
            font-size: 22px;
        }

        /* ===================== */
        /* FORM GROUP */
        /* ===================== */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 13px 15px;
            border-radius: 10px;
            border: 1px solid #f3c2cd;
            font-size: 14px;
            transition: 0.25s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(247,166,184,0.25);
        }

        /* ===================== */
        /* BUTTON */
        /* ===================== */
        .btn {
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 14px;
            color: #fff;
            text-decoration: none;
            border: none;
            cursor: pointer;
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

        .btn-back {
            background: #9ca3af;
        }

        /* ===================== */
        /* ACTION */
        /* ===================== */
        .form-action {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 28px;
        }

        /* ===================== */
        /* RESPONSIVE */
        /* ===================== */
        @media (max-width: 1024px) {
            .form-box {
                margin: 50px 30px;
                padding: 40px 45px;
            }
        }

        @media (max-width: 768px) {
            .form-box {
                margin: 40px 20px;
                padding: 35px 30px;
            }

            h3 {
                font-size: 20px;
            }

            .form-action {
                flex-direction: column;
            }

            .form-action .btn {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .form-box {
                margin: 25px 15px;
                padding: 25px 20px;
                border-radius: 16px;
            }

            h3 {
                font-size: 18px;
                margin-bottom: 22px;
            }

            .form-group input,
            .form-group select {
                padding: 11px 13px;
                font-size: 13.5px;
            }
        }
    </style>
</head>
<body>

<form method="POST"
      action="/admin/kategori-produk/{{ $kategori->kategori_id }}"
      class="form-box">
    @csrf

    <h3>Edit Kategori Produk</h3>

    <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text"
               name="nama_kategori"
               value="{{ $kategori->nama_kategori }}"
               required>
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status">
            <option value="aktif" {{ $kategori->status == 'aktif' ? 'selected' : '' }}>
                Aktif
            </option>
            <option value="nonaktif" {{ $kategori->status == 'nonaktif' ? 'selected' : '' }}>
                Nonaktif
            </option>
        </select>
    </div>

    <div class="form-action">
        <a href="/admin/kategori-produk" class="btn btn-back">
            Kembali
        </a>
        <button type="submit" class="btn btn-add">
            Update
        </button>
    </div>
</form>

</body>
</html>