@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru')

@push('styles')
<style>
    .page-header { margin-bottom: 28px; }
    .back-link {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 13px; font-weight: 600; color: var(--text-secondary); text-decoration: none;
        margin-bottom: 12px; transition: 0.2s;
    }
    .back-link:hover { color: var(--primary-color); transform: translateX(-4px); }
    .page-header h1 { font-size: 24px; font-weight: 800; color: var(--text-main); letter-spacing: -0.5px; }
    .page-header p { color: var(--text-secondary); font-size: 14px; margin-top: 4px; }

    .form-wrapper { max-width: 700px; }

    .form-card {
        background: var(--bg-card); border-radius: 16px;
        border: 1px solid var(--border-color); padding: 32px;
        width: 100%; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .form-section { margin-bottom: 32px; }
    .form-section-title {
        font-size: 12px; font-weight: 800; text-transform: uppercase;
        letter-spacing: 1px; color: var(--text-secondary);
        margin-bottom: 16px; padding-bottom: 10px;
        border-bottom: 2px solid var(--bg-body);
    }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { display: flex; flex-direction: column; gap: 8px; position: relative; }
    .form-group.full { grid-column: 1 / -1; }

    label { font-size: 13px; font-weight: 600; color: var(--text-main); }
    .required-mark { color: #EF4444; }
    
    .form-control {
        padding: 12px 16px; border-radius: 10px;
        border: 1px solid var(--border-color);
        background: var(--bg-body); color: var(--text-main);
        font-size: 14px; outline: none; transition: 0.3s; width: 100%;
    }
    .form-control:focus { border-color: var(--primary-color); background: var(--bg-card); box-shadow: 0 0 0 3px rgba(76,175,80,0.1); }
    .form-control.is-invalid { border-color: #EF4444; background: rgba(239, 68, 68, 0.02); }
    
    /* MODIFIKASI: Styling list error agar rapi */
    .invalid-feedback-list {
        margin: 4px 0 0 0; padding-left: 16px; 
        font-size: 12px; color: #EF4444; font-weight: 500;
    }
    .invalid-feedback-list li { margin-bottom: 2px; }
    
    .form-hint { font-size: 12px; color: var(--text-secondary); line-height: 1.4; }

    /* Password Field */
    .password-wrapper { position: relative; }
    .btn-toggle-password {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        background: none; border: none; color: var(--text-secondary);
        cursor: pointer; padding: 4px; font-size: 14px; transition: 0.2s;
    }
    .btn-toggle-password:hover { color: var(--text-main); }

    /* Password Meter */
    .password-meter { margin-top: 8px; display: none; }
    .meter-bars { display: flex; gap: 4px; height: 4px; margin-bottom: 6px; }
    .meter-bar { flex: 1; background: var(--border-color); border-radius: 2px; transition: 0.3s; }
    .meter-text { font-size: 11px; font-weight: 600; color: var(--text-secondary); }

    /* Avatar */
    .avatar-upload { display: flex; align-items: center; gap: 20px; }
    .avatar-preview {
        width: 72px; height: 72px; border-radius: 16px; flex-shrink: 0;
        background: var(--bg-body); border: 2px dashed var(--border-color);
        display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;
    }
    .avatar-preview img { width: 100%; height: 100%; object-fit: cover; display: none; }
    .avatar-preview i { font-size: 24px; color: var(--text-secondary); opacity: 0.5; }
    .avatar-actions { display: flex; flex-direction: column; gap: 8px; }
    .avatar-buttons { display: flex; gap: 8px; }
    
    .btn-upload {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: 8px; cursor: pointer;
        border: 1px solid var(--primary-color); background: rgba(76, 175, 80, 0.1);
        color: var(--primary-color); font-size: 13px; font-weight: 600; transition: 0.2s;
    }
    .btn-upload:hover { background: var(--primary-color); color: white; }
    
    .btn-remove-avatar {
        display: none; align-items: center; justify-content: center;
        padding: 8px 12px; border-radius: 8px; cursor: pointer;
        border: 1px solid #EF4444; background: rgba(239, 68, 68, 0.1);
        color: #EF4444; font-size: 13px; font-weight: 600; transition: 0.2s;
    }
    .btn-remove-avatar:hover { background: #EF4444; color: white; }

    /* Toggle */
    .toggles-wrap { display: flex; flex-direction: column; gap: 12px; }
    .toggle-group {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px; border-radius: 12px;
        border: 1px solid var(--border-color); background: var(--bg-body);
        transition: 0.2s;
    }
    .toggle-group:hover { border-color: var(--primary-color); }
    .toggle-label { display: flex; flex-direction: column; gap: 4px; }
    .toggle-label strong { font-size: 14px; font-weight: 700; color: var(--text-main); }
    .toggle-label span { font-size: 12px; color: var(--text-secondary); line-height: 1.4; }
    
    .toggle-switch { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; inset: 0; background: var(--border-color);
        border-radius: 24px; cursor: pointer; transition: 0.3s;
    }
    .toggle-slider::before {
        content: ''; position: absolute; width: 18px; height: 18px;
        border-radius: 50%; background: white; top: 3px; left: 3px; 
        transition: 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .toggle-switch input:checked + .toggle-slider { background: var(--primary-color); }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(20px); }

    /* Actions */
    .form-actions {
        display: flex; gap: 12px; margin-top: 10px;
        padding-top: 24px; border-top: 1px solid var(--border-color);
    }
    .btn-submit {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 28px; background: var(--primary-color); color: white;
        border: none; border-radius: 10px; font-size: 14px; font-weight: 600;
        cursor: pointer; transition: 0.2s; box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
    }
    .btn-submit:hover { background: var(--primary-hover); transform: translateY(-2px); }
    .btn-cancel-link {
        display: inline-flex; align-items: center;
        padding: 12px 24px; background: transparent; color: var(--text-main);
        border: 1px solid var(--border-color); border-radius: 10px;
        font-size: 14px; font-weight: 600; text-decoration: none; transition: 0.2s;
    }
    .btn-cancel-link:hover { background: var(--bg-body); border-color: var(--text-secondary); }

    @media (max-width: 640px) {
        .form-card { padding: 24px 20px; }
        .form-grid { grid-template-columns: 1fr; gap: 16px; }
        .form-actions { flex-direction: column-reverse; }
        .btn-submit, .btn-cancel-link { justify-content: center; width: 100%; }
        .avatar-upload { flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush

@section('content')

<div class="form-wrapper">

    <div class="page-header">
        <a href="{{ route('admin.users.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h1>Tambah Pengguna Baru</h1>
        <p>Daftarkan akun pengguna reguler baru ke dalam sistem aplikasi.</p>
    </div>

    {{-- MODIFIKASI: Menambahkan tampilan global error (Opsional tapi sangat membantu) --}}
    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #DC2626; padding: 16px; border-radius: 12px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 600; margin-bottom: 8px;">
                <i class="fas fa-exclamation-circle"></i> Mohon periksa kembali form Anda:
            </div>
            <ul style="margin: 0; padding-left: 24px; font-size: 13px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="form-card">
        @csrf

        {{-- Informasi Dasar --}}
        <div class="form-section">
            <div class="form-section-title">Informasi Dasar</div>
            <div class="form-grid">

                <div class="form-group full">
                    <label>Foto Profil <span style="color:var(--text-secondary);font-weight:400">(Opsional)</span></label>
                    <div class="avatar-upload">
                        <div class="avatar-preview">
                            <img id="avatarImg" src="" alt="Preview">
                            <i class="fas fa-user" id="avatarIcon"></i>
                        </div>
                        <div class="avatar-actions">
                            <div class="avatar-buttons">
                                <input type="file" name="avatar" id="avatarInput" accept="image/jpeg,image/png,image/webp" style="display:none;" onchange="previewAvatar(event)">
                                <button type="button" class="btn-upload" onclick="document.getElementById('avatarInput').click()">
                                    <i class="fas fa-camera"></i> Pilih Foto
                                </button>
                                <button type="button" class="btn-remove-avatar" id="btnRemoveAvatar" onclick="removeAvatar()">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <span class="form-hint">Format yang diizinkan: JPG, PNG, WEBP. Ukuran maksimal 2MB.</span>
                        </div>
                    </div>
                    
                    {{-- MODIFIKASI: Error list untuk Avatar --}}
                    @if($errors->has('avatar'))
                        <ul class="invalid-feedback-list">
                            @foreach($errors->get('avatar') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">Nama Lengkap <span class="required-mark">*</span></label>
                    <input type="text" name="name" id="name" required
                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           placeholder="Contoh: Budi Santoso" value="{{ old('name') }}">
                    
                    {{-- MODIFIKASI: Error list untuk Nama --}}
                    @if($errors->has('name'))
                        <ul class="invalid-feedback-list">
                            @foreach($errors->get('name') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email <span class="required-mark">*</span></label>
                    <input type="email" name="email" id="email" required
                           class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                           placeholder="nama@email.com" value="{{ old('email') }}">
                           
                    {{-- MODIFIKASI: Error list untuk Email --}}
                    @if($errors->has('email'))
                        <ul class="invalid-feedback-list">
                            @foreach($errors->get('email') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>
        </div>

        {{-- Keamanan --}}
        <div class="form-section">
            <div class="form-section-title">Keamanan Akun</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="password">Password <span class="required-mark">*</span></label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" required
                               class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Buat password baru">
                        <button type="button" class="btn-toggle-password" onclick="togglePassword('password', 'eyeIcon1')">
                            <i class="fas fa-eye" id="eyeIcon1"></i>
                        </button>
                    </div>
                    
                    <div class="password-meter" id="passwordMeter">
                        <div class="meter-bars">
                            <div class="meter-bar" id="bar-1"></div>
                            <div class="meter-bar" id="bar-2"></div>
                            <div class="meter-bar" id="bar-3"></div>
                            <div class="meter-bar" id="bar-4"></div>
                        </div>
                        <span class="meter-text" id="strengthText">Kekuatan: Lemah</span>
                    </div>

                    {{-- MODIFIKASI: Error list untuk Password (PENTING untuk menampilkan banyak error sekaligus) --}}
                    @if($errors->has('password'))
                        <ul class="invalid-feedback-list">
                            @foreach($errors->get('password') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password <span class="required-mark">*</span></label>
                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="form-control" placeholder="Ketik ulang password">
                        <button type="button" class="btn-toggle-password" onclick="togglePassword('password_confirmation', 'eyeIcon2')">
                            <i class="fas fa-eye" id="eyeIcon2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Konfigurasi Akun --}}
        <div class="form-section">
            <div class="form-section-title">Konfigurasi Akun</div>
            <div class="toggles-wrap">
                
                <div class="toggle-group">
                    <div class="toggle-label">
                        <strong>Status Aktif</strong>
                        <span>Izinkan pengguna untuk login dan menggunakan platform ResuMate.</span>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="toggle-group">
                    <div class="toggle-label">
                        <strong style="color: #4338CA;">Keanggotaan Premium (PRO)</strong>
                        <span>Berikan akses penuh ke semua template CV premium dan fitur eksklusif.</span>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="is_premium" value="1" {{ old('is_premium') ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Simpan Pengguna
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn-cancel-link">Batal</a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    // 1. Preview & Remove Avatar
    const avatarInput = document.getElementById('avatarInput');
    const avatarImg = document.getElementById('avatarImg');
    const avatarIcon = document.getElementById('avatarIcon');
    const btnRemoveAvatar = document.getElementById('btnRemoveAvatar');

    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarImg.src = e.target.result;
                avatarImg.style.display = 'block';
                avatarIcon.style.display = 'none';
                btnRemoveAvatar.style.display = 'inline-flex';
            }
            reader.readAsDataURL(file);
        }
    }

    function removeAvatar() {
        avatarInput.value = '';
        avatarImg.src = '';
        avatarImg.style.display = 'none';
        avatarIcon.style.display = 'block';
        btnRemoveAvatar.style.display = 'none';
    }

    // 2. Toggle Show/Hide Password
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // 3. Password Strength Meter
    document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        const meter = document.getElementById('passwordMeter');
        const bars = [
            document.getElementById('bar-1'),
            document.getElementById('bar-2'),
            document.getElementById('bar-3'),
            document.getElementById('bar-4')
        ];
        const strengthText = document.getElementById('strengthText');

        if(password.length > 0) {
            meter.style.display = 'block';
        } else {
            meter.style.display = 'none';
            return;
        }

        let score = 0;
        if (password.length >= 8) score++; 
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++; 
        if (/\d/.test(password)) score++; 
        if (/[^a-zA-Z\d]/.test(password)) score++; 

        // Reset
        bars.forEach(bar => bar.style.background = 'var(--border-color)');

        if (score === 1 || score === 2) {
            bars[0].style.background = '#EF4444';
            if(score === 2) bars[1].style.background = '#EF4444';
            strengthText.textContent = 'Kekuatan: Lemah';
            strengthText.style.color = '#EF4444';
        } else if (score === 3) {
            bars[0].style.background = '#F59E0B';
            bars[1].style.background = '#F59E0B';
            bars[2].style.background = '#F59E0B';
            strengthText.textContent = 'Kekuatan: Sedang';
            strengthText.style.color = '#F59E0B';
        } else if (score === 4) {
            bars.forEach(bar => bar.style.background = '#10B981');
            strengthText.textContent = 'Kekuatan: Sangat Kuat';
            strengthText.style.color = '#10B981';
        }
    });
</script>
@endpush