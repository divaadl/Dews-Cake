@extends('layouts.user')

@section('title','Lokasi - Dew’s Cake')

@section('style')
<style>
/* ===== LOKASI PAGE ===== */
.lokasi-wrapper {
    max-width: 1100px;
    margin: 90px auto;
    padding: 0 20px;
}

/* TITLE */
.lokasi-title {
    text-align: center;
    margin-bottom: 70px;
}

.lokasi-title h1 {
    font-size: 38px;
    color: #6f2f40;
}

.lokasi-title p {
    color: #6b7280;
    margin-top: 8px;
    font-size: 15px;
}

/* GRID INFO */
.lokasi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

/* CARD INFO */
.lokasi-card {
    background: linear-gradient(180deg,#ffffff,#fff6f8);
    border-radius: 22px;
    padding: 28px 26px;
    box-shadow: 0 14px 32px rgba(0,0,0,0.08);
    transition: 0.35s ease;
    position: relative;
}

.lokasi-card::after {
    content: "";
    width: 40px;
    height: 4px;
    background: linear-gradient(90deg,#f7a6b8,#f28aa5);
    border-radius: 6px;
    position: absolute;
    bottom: 18px;
    left: 26px;
}

.lokasi-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
}

.lokasi-card h3 {
    font-size: 18px;
    margin-bottom: 12px;
    color: #6f2f40;
}

.lokasi-card p {
    font-size: 14px;
    line-height: 1.8;
    color: #6b7280;
}

/* MAP */
.map-wrapper {
    background: #fff;
    border-radius: 26px;
    overflow: hidden;
    box-shadow: 0 18px 38px rgba(0,0,0,0.12);
}

.map-wrapper iframe {
    width: 100%;
    height: 420px;
    border: none;
}

/* BUTTON MAP */
.btn-map {
    display: inline-block;
    margin-top: 18px;
    padding: 14px 26px;
    background: linear-gradient(135deg,#f7a6b8,#f28aa5);
    color: #fff;
    border-radius: 16px;
    font-size: 14px;
    text-decoration: none;
    transition: 0.3s ease;
}

.btn-map:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(242,138,165,0.45);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .lokasi-title h1 {
        font-size: 28px;
    }

    .lokasi-grid {
        gap: 20px;
    }

    .map-wrapper iframe {
        height: 300px;
    }
}
</style>
@endsection

@section('content')

<div class="lokasi-wrapper">

    <div class="lokasi-title">
        <h1>Lokasi <span class="brand">Dew’s Cake</span></h1>
        <p>Kunjungi toko kami atau hubungi kami untuk pemesanan 🍰</p>
    </div>

    <div class="lokasi-grid">

        <div class="lokasi-card">
            <h3>📍 Alamat Toko</h3>
            <p>
                Perumahan Bumi Asri Blok O No.1<br>
                Kaliombo, Kediri
            </p>
        </div>

        <div class="lokasi-card">
            <h3>⏰ Jam Operasional</h3>
            <p>
                Senin – Jumat : 08.00 – 20.00<br>
                Sabtu – Minggu : 09.00 – 21.00
            </p>
        </div>

        <div class="lokasi-card">
            <h3>📞 Kontak</h3>
            <p>
                WhatsApp : 085704910466<br>
                Instagram : @dews.cake
            </p>
        </div>

    </div>

    <div class="map-wrapper">
        <iframe
            src="https://www.google.com/maps?q=Dew's%20Cake@-7.8372602,112.0143104&z=17&output=embed"
            loading="lazy">
        </iframe>
    </div>

    <div style="text-align:center;">
        <a href="https://www.google.com/maps?q=Dew's%20Cake@-7.8372602,112.0143104"
           target="_blank"
           class="btn-map">
            📍 Lihat Lokasi Dew’s Cake di Google Maps
        </a>
    </div>

</div>

@endsection