@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<style>
    :root {
        --primary-color: #4CAF50;
        --primary-hover: #45a049;
        --primary-pale: #ecfdf5;
        --text-main: #111827;
        --text-muted: #6b7280;
        --border-color: #e5e7eb;
        --bg-card: #ffffff;
        --bg-body: #f9fafb;
        --danger: #ef4444;
        --danger-hover: #dc2626;
        --danger-pale: #fef2f2;
        --warning: #f59e0b;
        --warning-text: #d97706;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* Additional Profile Page Styles */
    .page {
        max-width: 960px;
        margin: 0 auto;
        padding: 40px 24px 80px;
        font-family: 'Inter', 'Outfit', sans-serif;
    }

    /* Profile Header */
    .profile-header {
        display: flex;
        align-items: center;
        gap: 32px;
        margin-bottom: 40px;
        padding: 32px;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
    }

    .avatar-wrap {
        position: relative;
        flex-shrink: 0;
    }

    .avatar-big {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: var(--primary-pale);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: bold;
        color: var(--primary-hover);
        border: 4px solid var(--bg-card);
        box-shadow: var(--shadow-md);
    }

    .avatar-edit {
        position: absolute;
        bottom: 0px;
        right: 0px;
        width: 32px;
        height: 32px;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 13px;
        color: var(--text-muted);
        box-shadow: var(--shadow-sm);
        transition: all 0.2s ease;
    }

    .avatar-edit:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: scale(1.05);
    }

    .profile-info {
        flex: 1;
    }

    .profile-info h1 {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.5px;
        color: var(--text-main);
        margin-bottom: 6px;
        margin-top: 0;
    }

    .profile-info .email {
        font-size: 15px;
        color: var(--text-muted);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .profile-badges {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.02em;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-plan {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
    }

    .badge-member {
        background: var(--bg-body);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 32px;
        align-items: start;
    }

    /* Section Label */
    .section-label {
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border-color);
    }

    /* Alerts (Notifikasi Sukses & Error) */
    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: var(--shadow-sm);
        animation: slideIn 0.4s ease-out;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-success {
        background: var(--primary-pale);
        color: var(--primary-hover);
        border: 1px solid #a7f3d0;
        border-left: 4px solid var(--primary-color);
    }

    .alert-danger {
        background: var(--danger-pale);
        color: var(--danger-hover);
        border: 1px solid #fecaca;
        border-left: 4px solid var(--danger);
    }

    /* Account Settings */
    .settings-block {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: var(--shadow-sm);
    }

    .settings-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        gap: 16px;
    }

    .settings-row:last-child {
        border-bottom: none;
    }

    .settings-row-left {
        flex: 1;
    }

    .settings-row-left .s-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-main);
        display: block;
        margin-bottom: 8px;
    }

    .settings-row-left .s-desc {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    /* Modern Input Form */
    .form-control {
        width: 100%;
        padding: 12px 16px;
        font-size: 14px;
        color: var(--text-main);
        background-color: var(--bg-body);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        transition: all 0.2s ease;
        outline: none;
    }

    .form-control:focus {
        background-color: var(--bg-card);
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    /* Password Strength Indicator */
    .pw-strength-container {
        display: none;
        margin-top: 12px;
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .pw-bars {
        display: flex;
        gap: 6px;
        margin-bottom: 6px;
    }

    .pw-bar {
        height: 5px;
        flex: 1;
        background-color: var(--border-color);
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .pw-text {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        display: flex;
        justify-content: space-between;
    }

    /* Level Weak */
    .strength-weak #bar-1 { background-color: var(--danger); }
    .strength-weak .pw-label { color: var(--danger); }

    /* Level Medium */
    .strength-medium #bar-1, .strength-medium #bar-2 { background-color: var(--warning); }
    .strength-medium .pw-label { color: var(--warning-text); }

    /* Level Strong */
    .strength-strong #bar-1, .strength-strong #bar-2, .strength-strong #bar-3 { background-color: var(--primary-color); }
    .strength-strong .pw-label { color: var(--primary-hover); }

    /* Buttons */
    .btn-primary {
        padding: 10px 24px;
        background: var(--primary-color);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: var(--primary-hover);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        transform: translateY(-1px);
    }

    .btn-setting {
        padding: 10px 16px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-card);
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-setting:hover {
        background: var(--bg-body);
        color: var(--text-main);
    }

    .btn-setting.danger {
        color: var(--danger);
        border-color: var(--danger-pale);
        background: var(--danger-pale);
    }

    .btn-setting.danger:hover {
        background: var(--danger);
        color: white;
        border-color: var(--danger);
    }

    /* Sidebar */
    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .side-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--shadow-sm);
    }

    .side-card-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px dashed var(--border-color);
        font-size: 14px;
    }

    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-row .key {
        color: var(--text-muted);
    }

    .info-row .val {
        color: var(--text-main);
        font-weight: 600;
    }

    .info-row .val.green {
        color: var(--primary-color);
    }

    .upgrade-box {
        background: linear-gradient(145deg, var(--primary-pale), #ffffff);
        border: 1px solid #a7f3d0;
        border-radius: 12px;
        padding: 24px;
        text-align: center;
    }

    .upgrade-box p {
        font-size: 14px;
        color: var(--primary-hover);
        line-height: 1.6;
        margin-bottom: 16px;
    }

    /* Placeholder Data CV (Untuk mempercantik tampilan list kosong) */
    .empty-cv-state {
        text-align: center;
        padding: 40px 20px;
        background: var(--bg-card);
        border: 1px dashed var(--border-color);
        border-radius: 12px;
        color: var(--text-muted);
    }

    .empty-cv-state i {
        font-size: 32px;
        color: var(--border-color);
        margin-bottom: 12px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page { padding: 24px 16px 60px; }
        .profile-header { flex-direction: column; text-align: center; }
        .profile-info .email { justify-content: center; }
        .profile-badges { justify-content: center; }
        .content-grid { grid-template-columns: 1fr; }
        .settings-row { flex-direction: column; align-items: flex-start; }
        .settings-row-left { width: 100%; }
        .settings-row-left input { width: 100%; }
    }
</style>

<div class="page">
    @php
        $user = auth()->user();
    @endphp

    <div class="profile-header">
        <div class="avatar-wrap">
            <div class="avatar-big" style="overflow: hidden;">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>
            <div class="avatar-edit" onclick="document.getElementById('avatarInput').click()" title="Ubah Foto Profil">
                <i class="fas fa-camera"></i>
            </div>
        </div>

        <div class="profile-info">
            <h1>{{ $user->name }}</h1>
            <p class="email"><i class="far fa-envelope"></i> {{ $user->email }}</p>
            <div class="profile-badges">
                @if($user->is_premium)
                    <span class="badge badge-plan"><i class="fas fa-crown"></i> Paket Pro</span>
                @else
                    <span class="badge badge-member">Paket Gratis</span>
                @endif
                <span class="badge badge-member"><i class="far fa-calendar-alt"></i> Anggota sejak {{ $user->created_at->format('M Y') }}</span>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div>
            <div class="settings-section">
                <div class="section-label"><i class="fas fa-cog"></i> Pengaturan Akun</div>

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle fa-lg"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle fa-lg"></i>
                        <div>Pastikan form terisi dengan benar. Mohon periksa kembali.</div>
                    </div>
                @endif

                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="settings-block">
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display: none;">

                        <div class="settings-row">
                            <div class="settings-row-left">
                                <label class="s-title">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="settings-row">
                            <div class="settings-row-left">
                                <label class="s-title">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="settings-row" style="justify-content: flex-end; background: var(--bg-body);">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>

                <div class="settings-block" style="margin-top: 24px; border-color: var(--danger-pale);">
                    <div class="settings-row">
                        <div class="settings-row-left">
                            <div class="s-title" style="color: var(--danger);">Keluar dari Akun</div>
                            <div class="s-desc">Akhiri sesi aktif Anda pada perangkat ini.</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn-setting danger">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar">
            <div class="side-card">
                <div class="side-card-title"><i class="fas fa-info-circle" style="color: var(--primary-color);"></i> Informasi Akun</div>
                
                <div class="info-row">
                    <span class="key">Paket Saat Ini</span>
                    <span class="val {{ $user->is_premium ? 'green' : '' }}">
                        {{ $user->is_premium ? 'Paket Pro' : 'Paket Gratis' }}
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="key">Bergabung Pada</span>
                    <span class="val">{{ $user->created_at->format('M Y') }}</span>
                </div>

                @if($user->is_premium)
                    <div style="margin-top: 20px; padding-top: 16px; border-top: 1px dashed var(--border-color); text-align: center;">
                        <form action="{{ route('user.profile.cancel-premium') }}" method="POST" id="formCancelPremium" style="margin: 0;">
                            @csrf
                            @method('PUT')
                            <button type="button" onclick="confirmCancellation()" class="btn-setting danger" style="width: 100%; justify-content: center;">
                                <i class="fas fa-times-circle" style="margin-right: 8px;"></i> Batalkan Langganan Pro
                            </button>
                        </form>
                        <p style="font-size: 12px; color: var(--text-muted); margin-top: 12px; line-height: 1.5;">
                            Tindakan ini akan menghentikan akses ke fitur eksklusif setelah periode aktif berakhir.
                        </p>
                    </div>
                @endif
            </div>

            @if(!$user->is_premium)
                <div class="side-card" style="padding: 0; border: none; background: transparent; box-shadow: none;">
                    <div class="upgrade-box">
                        <i class="fas fa-rocket fa-2x" style="color: var(--primary-color); margin-bottom: 12px;"></i>
                        <p>Akses template premium & unduhan tanpa batas dengan <strong>Paket Pro.</strong></p>
                        <a href="{{ route('pricing') ?? '#' }}" class="btn-primary" style="display: flex; justify-content: center; text-decoration: none; width: 100%;">
                            Tingkatkan ke Pro
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        const currentTheme = localStorage.getItem('theme') || 'light';
        darkModeToggle.checked = (currentTheme === 'dark');
        
        darkModeToggle.addEventListener('change', function() {
            const newTheme = this.checked ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            const themeIcon = document.querySelector('.theme-toggle-btn i');
            if (themeIcon) {
                if (newTheme === 'dark') {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                } else {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                }
            }
        });
    }

    document.getElementById('avatarInput').addEventListener('change', function(event) {
        if(event.target.files && event.target.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.avatar-big').innerHTML = '<img src="' + e.target.result + '" style="width: 100%; height: 100%; object-fit: cover;">';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    });

    function confirmCancellation() {
        Swal.fire({
            title: 'Konfirmasi Pembatalan',
            text: "Sayang sekali Anda ingin berhenti. Akses ke template premium dan fitur Pro lainnya akan dicabut setelah masa aktif berakhir. Anda yakin?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', 
            cancelButtonColor: '#6b7280', 
            confirmButtonText: 'Ya, Berhenti Langganan',
            cancelButtonText: 'Tetap di Paket Pro',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                popup: 'rounded-16', 
                confirmButton: 'btn-confirm-swal',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                document.getElementById('formCancelPremium').submit();
            }
        })
    }

    const passwordInput = document.getElementById('newPassword');
    const pwContainer = document.getElementById('pwStrengthContainer');
    const pwLabel = document.getElementById('pwLabel');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const val = this.value;
            
            if (val.length === 0) {
                pwContainer.style.display = 'none';
                return;
            }
            
            pwContainer.style.display = 'block';
            pwContainer.className = 'pw-strength-container'; 
            
            let strength = 0;
            if (val.length >= 8) strength += 1; 
            if (val.match(/[a-z]/) && val.match(/[A-Z]/)) strength += 1; 
            if (val.match(/\d/)) strength += 1; 
            if (val.match(/[^a-zA-Z\d]/)) strength += 1; 
            
            if (val.length < 6 || strength <= 1) {
                pwContainer.classList.add('strength-weak');
                pwLabel.innerText = 'Lemah';
            } else if (strength === 2 || strength === 3) {
                pwContainer.classList.add('strength-medium');
                pwLabel.innerText = 'Sedang';
            } else if (strength >= 4) {
                pwContainer.classList.add('strength-strong');
                pwLabel.innerText = 'Kuat';
            }
        });
    }
</script>
@endpush
@endsection