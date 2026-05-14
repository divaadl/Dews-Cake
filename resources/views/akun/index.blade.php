@extends('layouts.user')

@section('title', 'Akun Saya - Dew’s Cake')

@section('style')
<style>
    :root {
        --primary-pink: #f7a6b8;
        --secondary-pink: #f28aa5;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.4);
    }

    .profile-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        width: 100%;
        max-width: 640px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .profile-header {
        background: linear-gradient(135deg, #f7a6b8, #f28aa5);
        padding: 40px;
        color: #fff;
        text-align: center;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .profile-header p {
        margin: 8px 0 0;
        font-size: 14px;
        opacity: 0.95;
    }

    .profile-body {
        padding: 40px;
    }

    .info-grid {
        display: grid;
        gap: 20px;
        margin-bottom: 35px;
    }

    .info-item {
        background: rgba(255, 255, 255, 0.6);
        border: 1px solid #fce7f3;
        border-radius: 20px;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: 0.3s;
    }

    .info-item:hover {
        transform: translateX(5px);
        border-color: var(--primary-pink);
        background: #fff;
    }

    .info-icon {
        width: 45px;
        height: 45px;
        background: #fff1f2;
        color: var(--primary-pink);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: #374151;
        line-height: 1.5;
    }

    .btn-edit {
        display: block;
        text-align: center;
        padding: 18px;
        border-radius: 22px;
        background: linear-gradient(135deg, #f7a6b8, #f28aa5);
        color: #fff;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 24px rgba(242, 138, 165, 0.4);
    }

    .btn-edit:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(242, 138, 165, 0.5);
    }

    /* RESPONSIVE */
    @media (max-width: 640px) {
        .profile-header {
            padding: 30px 20px;
        }
        
        .profile-body {
            padding: 30px 20px;
        }

        .info-item {
            padding: 15px;
            gap: 15px;
        }
        
        .info-icon {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }

        .info-value {
            font-size: 14px;
        }
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    <div class="glass-card">
        {{-- HEADER --}}
        <div class="profile-header">
            <h2>👤 Akun Saya</h2>
            <p>Informasi profil dan alamat pengiriman Anda</p>
        </div>

        <div class="profile-body">
            {{-- PROFILE INFO --}}
            <div class="info-grid">
                {{-- NAMA --}}
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Nama Lengkap</span>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                </div>

                {{-- EMAIL --}}
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Alamat Email</span>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                </div>

                {{-- NOMOR HP --}}
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Nomor WhatsApp</span>
                        <div class="info-value">{{ $user->phone ?: 'Belum diisi' }}</div>
                    </div>
                </div>

                {{-- ALAMAT --}}
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Alamat Pengiriman</span>
                        <div class="info-value">
                            @if($user->address)
                                {{ $user->address }}<br>
                                <span style="font-size: 13px; color: #6b7280; font-weight: 500;">
                                    {{ $user->district_name ? $user->district_name . ', ' : '' }}
                                    {{ $user->city_name ? $user->city_name . ', ' : '' }}
                                    {{ $user->province_name ? $user->province_name : '' }}
                                </span>
                            @else
                                Belum diisi
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACTION --}}
            <a href="{{ route('akun.edit') }}" class="btn-edit">
                ✍️ Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection
