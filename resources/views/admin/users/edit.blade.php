@extends('layouts.admin')

@section('title', 'Edit Pengguna - ' . $user->name)

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
    
    .invalid-feedback-list {
        margin: 4px 0 0 0; padding-left: 16px; 
        font-size: 12px; color: #EF4444; font-weight: 500;
    }
    .invalid-feedback-list li { margin-bottom: 2px; }
    .form-hint { font-size: 12px; color: var(--text-secondary); line-height: 1.4; }

    /* Avatar */
    .avatar-upload { display: flex; align-items: center; gap: 20px; }
    .avatar-preview {
        width: 72px; height: 72px; border-radius: 16px; flex-shrink: 0;
        background: var(--bg-body); border: 2px dashed var(--border-color);
        display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;
    }
    .avatar-preview img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-actions { display: flex; flex-direction: column; gap: 8px; }
    .avatar-buttons { display: flex; gap: 8px; }
    
    .btn-upload {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: 8px; cursor: pointer;
        border: 1px solid var(--primary-color); background: rgba(76, 175, 80, 0.1);
        color: var(--primary-color); font-size: 13px; font-weight: 600; transition: 0.2s;
    }
    .btn-upload:hover { background: var(--primary-color); color: white; }

    /* Info Banner */
    .info-banner {
        display: flex; align-items: center; gap: 12px; padding: 16px; 
        background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.2); 
        border-radius: 12px; margin-bottom: 24px; font-size: 13px; color: #1E40AF;
        line-height: 1.5;
    }
    .info-banner i { font-size: 20px; color: #3B82F6; }

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
        <h1>Edit Data Pengguna</h1>
        <p>Memperbarui informasi profil dan keanggotaan untuk <strong>{{ $user->name }}</strong>.</p>
    </div>

    {{-- Banner Info Reset Password --}}
    <div class="info-banner">
        <i class="fas fa-shield-alt"></i>
        <div>
            Perlu mengganti password pengguna ini? Sistem kami memisahkan pengaturan privasi. Silakan gunakan menu <a href="{{ route('admin.users.reset-password.form', $user) }}" style="font-weight: 700; color: #1D4ED8; text-decoration: underline;">Reset Password Khusus</a>.
        </div>
    </div>

    {{-- Global Error Alert --}}
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

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="form-card">
        @csrf
        @method('PUT')

        {{-- Informasi Dasar --}}
        <div class="form-section">
            <div class="form-section-title">Informasi Dasar</div>
            <div class="form-grid">

                <div class="form-group full">
                    <label>Foto Profil</label>
                    <div class="avatar-upload">
                        <div class="avatar-preview">
                            <img id="avatarImg" src="{{ $user->avatarUrl() ?? asset('images/default-avatar.png') }}" alt="{{ $user->name }}">
                        </div>
                        <div class="avatar-actions">
                            <div class="avatar-buttons">
                                <input type="file" name="avatar" id="avatarInput" accept="image/jpeg,image/png,image/webp" style="display:none;" onchange="previewAvatar(event)">
                                <button type="button" class="btn-upload" onclick="document.getElementById('avatarInput').click()">
                                    <i class="fas fa-camera"></i> Ganti Foto Baru
                                </button>
                            </div>
                            <span class="form-hint">Biarkan kosong jika tidak ingin mengubah foto saat ini. <br>Format: JPG, PNG, WEBP (Maks 2MB).</span>
                        </div>
                    </div>
                    
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
                           value="{{ old('name', $user->name) }}">
                    
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
                           value="{{ old('email', $user->email) }}">
                           
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

        {{-- Konfigurasi Akun --}}
        <div class="form-section">
            <div class="form-section-title">Konfigurasi Hak Akses</div>
            <div class="toggles-wrap">
                
                <div class="toggle-group">
                    <div class="toggle-label">
                        <strong>Status Aktif</strong>
                        <span>Izinkan pengguna untuk login dan menggunakan platform ResuMate.</span>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="toggle-group">
                    <div class="toggle-label">
                        <strong style="color: #4338CA;">Keanggotaan Premium (PRO)</strong>
                        <span>Berikan akses penuh ke semua template CV premium dan fitur eksklusif.</span>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="is_premium" value="1" {{ old('is_premium', $user->is_premium) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn-cancel-link">Batal</a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarImg').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush