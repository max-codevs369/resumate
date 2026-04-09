@extends('layouts.admin')

@section('title', 'Reset Password - ' . $user->name)

@push('styles')
<style>
    .page-header { margin-bottom: 32px; }
    .back-link { 
        display: inline-flex; align-items: center; gap: 8px; 
        font-size: 13px; font-weight: 600; color: var(--text-secondary); text-decoration: none; 
        margin-bottom: 12px; transition: 0.2s; 
    }
    .back-link:hover { color: var(--primary-color); transform: translateX(-4px); }
    .page-header h1 { font-size: 24px; font-weight: 800; color: var(--text-main); letter-spacing: -0.5px; }
    .page-header p { color: var(--text-secondary); font-size: 14px; margin-top: 4px; }

    .form-wrapper { max-width: 550px; }

    .form-card { 
        background: var(--bg-card); border-radius: 16px; 
        border: 1px solid var(--border-color); padding: 32px; 
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); 
    }

    /* User Info Banner */
    .user-info-card { 
        display: flex; align-items: center; gap: 16px; padding: 16px; 
        background: var(--bg-body); border-radius: 12px; 
        border: 1px solid var(--border-color); margin-bottom: 24px; 
    }
    .user-avatar { 
        width: 56px; height: 56px; border-radius: 12px; 
        object-fit: cover; border: 2px solid var(--bg-card); 
    }
    .user-meta { display: flex; flex-direction: column; gap: 2px; }
    .user-meta strong { font-size: 15px; font-weight: 700; color: var(--text-main); }
    .user-meta span { font-size: 13px; color: var(--text-secondary); }

    /* Warning Banner */
    .warning-banner { 
        display: flex; align-items: flex-start; gap: 12px; padding: 16px; 
        background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.2); 
        border-radius: 12px; margin-bottom: 28px; font-size: 13px; color: #B45309; 
        line-height: 1.5;
    }
    .warning-banner i { margin-top: 2px; flex-shrink: 0; font-size: 16px; color: #F59E0B; }

    /* Form Styles */
    .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 24px; }
    label { font-size: 13px; font-weight: 600; color: var(--text-main); }
    .required-mark { color: #EF4444; }
    
    .input-wrapper { position: relative; }
    .form-control { 
        padding: 12px 44px 12px 16px; border-radius: 10px; 
        border: 1px solid var(--border-color); background: var(--bg-body); 
        color: var(--text-main); font-size: 14px; outline: none; transition: 0.3s; width: 100%; 
    }
    .form-control:focus { border-color: var(--primary-color); background: var(--bg-card); box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1); }
    .form-control.is-invalid { border-color: #EF4444; background: rgba(239, 68, 68, 0.02); }
    
    .btn-eye { 
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%); 
        background: none; border: none; color: var(--text-secondary); 
        cursor: pointer; font-size: 14px; padding: 4px; transition: 0.2s;
    }
    .btn-eye:hover { color: var(--text-main); }

    /* Error Messages */
    .invalid-feedback-list {
        margin: 4px 0 0 0; padding-left: 16px; 
        font-size: 12px; color: #EF4444; font-weight: 500;
    }
    .invalid-feedback-list li { margin-bottom: 2px; }

    /* Password Strength Meter (Diseragamkan dengan Create & Edit) */
    .password-meter { margin-top: 4px; display: none; }
    .meter-bars { display: flex; gap: 4px; height: 4px; margin-bottom: 6px; }
    .meter-bar { flex: 1; background: var(--border-color); border-radius: 2px; transition: 0.3s; }
    .meter-text { font-size: 11px; font-weight: 600; color: var(--text-secondary); }

    /* Actions */
    .form-actions { 
        display: flex; gap: 12px; margin-top: 10px; 
        padding-top: 24px; border-top: 1px solid var(--border-color); 
    }
    .btn-submit { 
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 12px 28px; background: #EF4444; color: white; border: none; 
        border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; 
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }
    .btn-submit:hover { background: #DC2626; transform: translateY(-2px); }
    .btn-cancel-link { 
        display: inline-flex; align-items: center; justify-content: center;
        padding: 12px 24px; background: transparent; color: var(--text-main); 
        border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; 
        font-weight: 600; text-decoration: none; transition: 0.2s; 
    }
    .btn-cancel-link:hover { background: var(--bg-body); border-color: var(--text-secondary); }

    @media (max-width: 640px) { 
        .form-card { padding: 24px 20px; }
        .form-actions { flex-direction: column-reverse; }
        .btn-submit, .btn-cancel-link { width: 100%; }
    }
</style>
@endpush

@section('content')

<div class="form-wrapper">
    <div class="page-header">
        <a href="{{ route('admin.users.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1>Reset Password Akun</h1>
        <p>Ganti kata sandi untuk pengguna secara paksa jika diperlukan.</p>
    </div>

    {{-- Global Error Alert --}}
    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #DC2626; padding: 16px; border-radius: 12px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 600; margin-bottom: 8px;">
                <i class="fas fa-exclamation-circle"></i> Terdapat kesalahan pada form:
            </div>
            <ul style="margin: 0; padding-left: 24px; font-size: 13px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        {{-- User Info --}}
        <div class="user-info-card">
            <img src="{{ $user->avatarUrl() ?? asset('images/default-avatar.png') }}" alt="{{ $user->name }}" class="user-avatar">
            <div class="user-meta">
                <strong>{{ $user->name }}</strong>
                <span>{{ $user->email }}</span>
            </div>
        </div>

        {{-- Warning --}}
        <div class="warning-banner">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Perhatian:</strong> Mengubah kata sandi di sini akan langsung menimpa kata sandi lama. Pengguna akan segera <b>logout</b> dari semua sesi yang aktif dan wajib masuk menggunakan sandi baru ini.
            </div>
        </div>

        <form action="{{ route('admin.users.reset-password', $user) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="password">Password Baru <span class="required-mark">*</span></label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" required
                           class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                           placeholder="Ketik password baru yang kuat">
                    <button type="button" class="btn-eye" onclick="togglePassword('password', 'eyeIcon1')">
                        <i class="fas fa-eye" id="eyeIcon1"></i>
                    </button>
                </div>
                
                {{-- Password Meter --}}
                <div class="password-meter" id="passwordMeter">
                    <div class="meter-bars">
                        <div class="meter-bar" id="bar-1"></div>
                        <div class="meter-bar" id="bar-2"></div>
                        <div class="meter-bar" id="bar-3"></div>
                        <div class="meter-bar" id="bar-4"></div>
                    </div>
                    <span class="meter-text" id="strengthText">Kekuatan: Lemah</span>
                </div>

                {{-- Menampilkan SEMUA error rules password --}}
                @if($errors->has('password'))
                    <ul class="invalid-feedback-list">
                        @foreach($errors->get('password') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru <span class="required-mark">*</span></label>
                <div class="input-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="form-control" placeholder="Ketik ulang password baru">
                    <button type="button" class="btn-eye" onclick="togglePassword('password_confirmation', 'eyeIcon2')">
                        <i class="fas fa-eye" id="eyeIcon2"></i>
                    </button>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-key"></i> Ganti Password Sekarang
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn-cancel-link">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // 1. Toggle Show/Hide Password
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

    // 2. Password Strength Meter (Sistem 4 Bar)
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