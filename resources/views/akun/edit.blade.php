@extends('layouts.user')

@section('title', 'Edit Profil - Dew’s Cake')

@section('style')
<style>
    :root {
        --primary-pink: #f7a6b8;
        --secondary-pink: #f28aa5;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.4);
    }

    .edit-profile-container {
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
        padding: 40px;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
    }

    .edit-profile-title {
        text-align: center;
        margin-bottom: 30px;
    }

    .edit-profile-title h2 {
        font-size: 28px;
        font-weight: 700;
        color: #8b3f52;
        margin: 0;
    }

    .edit-profile-title p {
        color: #6b7280;
        font-size: 14px;
        margin-top: 8px;
    }

    .form-group {
        margin-bottom: 24px;
        position: relative;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #8b3f52;
        margin-bottom: 10px;
        margin-left: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-pink);
        font-size: 16px;
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 15px 15px 15px 50px;
        border-radius: 18px;
        border: 2px solid #fce7f3;
        background: rgba(255, 255, 255, 0.9);
        font-family: inherit;
        font-size: 14px;
        color: #1f2937;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-pink);
        box-shadow: 0 0 0 4px rgba(247, 166, 184, 0.15);
        background: #fff;
    }

    .form-control:disabled {
        background: #f9f9f9;
        border-color: #e5e7eb;
        color: #9ca3af;
        cursor: not-allowed;
    }

    textarea.form-control {
        padding-top: 15px;
        resize: none;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 35px;
    }

    .btn {
        flex: 1;
        padding: 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-back {
        background: #f3f4f6;
        color: #4b5563;
    }

    .btn-save {
        background: linear-gradient(135deg, #f7a6b8, #f28aa5);
        color: #fff;
        box-shadow: 0 10px 24px rgba(242, 138, 165, 0.4);
    }

    .btn:hover {
        transform: translateY(-3px);
    }

    .btn-save:hover {
        box-shadow: 0 15px 30px rgba(242, 138, 165, 0.5);
    }

    .btn-back:hover {
        background: #e5e7eb;
    }

    /* RESPONSIVE */
    @media (max-width: 640px) {
        .glass-card {
            padding: 30px 20px;
            border-radius: 25px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            order: 1;
        }
        
        .btn-back {
            order: 2;
        }
    }
</style>
@endsection

@section('content')
<div class="edit-profile-container">
    <div class="glass-card">
        <div class="edit-profile-title">
            <h2>🍰 Edit Profil</h2>
            <p>Pastikan data diri Anda akurat untuk kemudahan pengiriman.</p>
        </div>

        <form method="POST" action="{{ route('akun.update') }}">
            @csrf

            {{-- NAMA --}}
            <div class="form-group">
                <label>Nama Lengkap</label>
                <div class="input-wrapper">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" name="name" 
                           value="{{ old('name', $user->name) }}" 
                           class="form-control" 
                           placeholder="Masukkan nama lengkap Anda"
                           required>
                </div>
            </div>

            {{-- EMAIL --}}
            <div class="form-group">
                <label>Alamat Email</label>
                <div class="input-wrapper">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" value="{{ $user->email }}" class="form-control" disabled>
                </div>
                <small style="color: #9ca3af; font-size: 11px; margin-left: 5px; display: block; margin-top: 5px;">
                    Email tidak dapat diubah karena alasan keamanan.
                </small>
            </div>

            {{-- NOMOR HP --}}
            <div class="form-group">
                <label>Nomor WhatsApp</label>
                <div class="input-wrapper">
                    <i class="fa-brands fa-whatsapp"></i>
                    <input type="text" name="phone" 
                           value="{{ old('phone', $user->phone) }}" 
                           class="form-control" 
                           placeholder="Contoh: 08123456789"
                           required>
                </div>
            </div>

            {{-- ALAMAT DETAIL --}}
            <div class="form-group">
                <label>Alamat Lengkap (Jalan, No Rumah, RT/RW)</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-location-dot" style="top: 20px; transform: none;"></i>
                    <textarea name="address" rows="3" class="form-control" 
                              placeholder="Contoh: Jl. Sudirman No 10, RT 01/RW 02, Patokan samping minimarket"
                              required>{{ old('address', $user->address) }}</textarea>
                </div>
            </div>

            {{-- RAJAONGKIR FIELDS --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Provinsi</label>
                    <select id="province_id" name="province_id" class="form-control" style="padding-left: 15px;">
                        <option value="">Pilih Provinsi</option>
                    </select>
                    <input type="hidden" id="province_name" name="province_name" value="{{ $user->province_name }}">
                </div>
                <div class="form-group">
                    <label>Kota/Kabupaten</label>
                    <select id="city_id" name="city_id" class="form-control" style="padding-left: 15px;" disabled>
                        <option value="">Pilih Kota/Kabupaten</option>
                    </select>
                    <input type="hidden" id="city_name" name="city_name" value="{{ $user->city_name }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Kecamatan</label>
                    <select id="district_id" name="district_id" class="form-control" style="padding-left: 15px;" disabled>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    <input type="hidden" id="district_name" name="district_name" value="{{ $user->district_name }}">
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const provinceSelect = document.getElementById('province_id');
                    const citySelect = document.getElementById('city_id');
                    const districtSelect = document.getElementById('district_id');

                    const provinceNameInput = document.getElementById('province_name');
                    const cityNameInput = document.getElementById('city_name');
                    const districtNameInput = document.getElementById('district_name');

                    const userProv = "{{ $user->province_id }}";
                    const userCity = "{{ $user->city_id }}";
                    const userDist = "{{ $user->district_id }}";

                    // Load Provinces
                    fetch('{{ route("api.provinces") }}')
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(p => {
                                const opt = document.createElement('option');
                                opt.value = p.id;
                                opt.textContent = p.name;
                                if(p.id == userProv) opt.selected = true;
                                provinceSelect.appendChild(opt);
                            });
                            if(userProv) provinceSelect.dispatchEvent(new Event('change'));
                        });

                    provinceSelect.addEventListener('change', function() {
                        const provId = this.value;
                        const provName = this.options[this.selectedIndex].text;
                        provinceNameInput.value = provId ? provName : '';

                        citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                        citySelect.disabled = true;
                        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                        districtSelect.disabled = true;
                        
                        cityNameInput.value = '';
                        districtNameInput.value = '';

                        if (provId) {
                            fetch(`/api/cities/${provId}`)
                                .then(res => res.json())
                                .then(data => {
                                    citySelect.disabled = false;
                                    data.forEach(c => {
                                        const opt = document.createElement('option');
                                        opt.value = c.id;
                                        opt.textContent = c.name;
                                        if(c.id == userCity) opt.selected = true;
                                        citySelect.appendChild(opt);
                                    });
                                    if(userCity) citySelect.dispatchEvent(new Event('change'));
                                });
                        }
                    });

                    citySelect.addEventListener('change', function() {
                        const cityId = this.value;
                        const cityName = this.options[this.selectedIndex].text;
                        cityNameInput.value = cityId ? cityName : '';

                        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                        districtSelect.disabled = true;
                        districtNameInput.value = '';

                        if (cityId) {
                            fetch(`/api/districts/${cityId}`)
                                .then(res => res.json())
                                .then(data => {
                                    districtSelect.disabled = false;
                                    data.forEach(d => {
                                        const opt = document.createElement('option');
                                        opt.value = d.id;
                                        opt.textContent = d.name;
                                        if(d.id == userDist) opt.selected = true;
                                        districtSelect.appendChild(opt);
                                    });
                                    if(userDist) districtSelect.dispatchEvent(new Event('change'));
                                });
                        }
                    });

                    districtSelect.addEventListener('change', function() {
                        const distId = this.value;
                        const distName = this.options[this.selectedIndex].text;
                        districtNameInput.value = distId ? distName : '';
                    });
                });
            </script>

            {{-- BUTTONS --}}
            <div class="action-buttons">
                <a href="{{ route('akun.index') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="fa-solid fa-check"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection