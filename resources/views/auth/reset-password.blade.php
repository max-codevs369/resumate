<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - {{ config('app.name', 'ResuMate') }}</title>
    
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* --- 1. DEFINISI VARIABEL TEMA --- */
        :root {
            /* Default: LIGHT MODE */
            --primary-color: #4CAF50;
            --primary-hover: #45a049;
            --bg-body: #F7F7F7;       
            --bg-card: #FFFFFF;       
            --text-main: #333333;     
            --text-secondary: #666666; 
            --border-color: #E5E5E5;
            --input-bg: #FAFAFA;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --success-color: #4CAF50;
            --error-color: #f44336;
            --warning-color: #ff9800;
        }

        /* Override untuk DARK MODE */
        [data-theme="dark"] {
            --bg-body: #121212;       
            --bg-card: #1E1E1E;       
            --text-main: #E0E0E0;     
            --text-secondary: #A0A0A0;
            --border-color: #333333;
            --input-bg: #2C2C2C;
            --shadow-color: rgba(0, 0, 0, 0.5);
        }

        /* --- 2. BASE STYLES --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-body); color: var(--text-main); line-height: 1.5; transition: background 0.3s, color 0.3s; }

        /* --- 3. LAYOUT --- */
        .reset-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            background: linear-gradient(135deg, var(--bg-body) 0%, var(--border-color) 100%);
        }

        .reset-container {
            max-width: 1100px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: var(--bg-card);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px var(--shadow-color);
            position: relative;
            z-index: 1;
            border: 1px solid var(--border-color);
        }

        /* --- LEFT SIDE: BRANDING (Static Green) --- */
        .reset-branding {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2E7D32 100%);
            padding: 60px 50px;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            text-align: center; color: white; position: relative; overflow: hidden;
        }

        .branding-content { position: relative; z-index: 2; }
        .branding-logo {
            width: 80px; height: 80px; background: white;
            border-radius: 20px; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .branding-logo i { font-size: 40px; color: var(--primary-color); }

        .branding-content h2 { font-size: 32px; font-weight: 800; margin-bottom: 20px; line-height: 1.2; }
        .branding-content p { font-size: 16px; opacity: 0.9; margin-bottom: 40px; line-height: 1.6; }

        /* Icon Illustration */
        .reset-illustration {
            width: 120px;
            height: 120px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }
        .reset-illustration i {
            font-size: 60px;
            color: white;
        }

        /* Security Tips */
        .security-tips {
            text-align: left;
            width: 100%;
            max-width: 320px;
        }
        .security-tips h3 {
            font-size: 18px;
            margin-bottom: 16px;
            font-weight: 700;
        }
        .tip-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
            font-size: 14px;
            color: white;
            opacity: 0.9;
        }
        .tip-item i {
            font-size: 16px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* --- RIGHT SIDE: FORM --- */
        .reset-form-container {
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .reset-header { margin-bottom: 40px; }
        .reset-header h1 { font-size: 32px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; }
        .reset-header p { color: var(--text-secondary); font-size: 15px; line-height: 1.6; }

        /* Form Elements */
        .form-group { margin-bottom: 24px; position: relative; }
        
        .form-label {
            display: block; font-size: 14px; font-weight: 600; 
            color: var(--text-main); margin-bottom: 8px;
        }

        .password-input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%; padding: 14px 48px 14px 16px;
            border: 2px solid var(--border-color);
            border-radius: 10px; font-size: 15px;
            color: var(--text-main); 
            background: var(--input-bg);
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none; border-color: var(--primary-color);
            background: var(--bg-card);
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
        }

        .form-input.error {
            border-color: var(--error-color);
        }

        .form-input.success {
            border-color: var(--success-color);
        }

        /* Toggle Password Visibility */
        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 18px;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: var(--primary-color);
        }

        /* Password Strength Indicator */
        .password-strength {
            margin-top: 12px;
            display: none;
        }

        .password-strength.active {
            display: block;
        }

        .strength-bar {
            height: 4px;
            background: var(--border-color);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .strength-bar-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s;
            border-radius: 2px;
        }

        .strength-bar-fill.weak {
            width: 33%;
            background: var(--error-color);
        }

        .strength-bar-fill.medium {
            width: 66%;
            background: var(--warning-color);
        }

        .strength-bar-fill.strong {
            width: 100%;
            background: var(--success-color);
        }

        .strength-text {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .strength-text.weak { color: var(--error-color); }
        .strength-text.medium { color: var(--warning-color); }
        .strength-text.strong { color: var(--success-color); }

        /* Password Requirements */
        .password-requirements {
            margin-top: 12px;
            padding: 16px;
            background: var(--input-bg);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .requirement-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 10px;
        }

        .requirement-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .requirement-item i {
            font-size: 12px;
            width: 16px;
            color: var(--text-secondary);
        }

        .requirement-item.valid i {
            color: var(--success-color);
        }

        .requirement-item.valid {
            color: var(--success-color);
        }

        /* Error Message */
        .error-message {
            font-size: 13px;
            color: var(--error-color);
            margin-top: 8px;
            display: none;
        }

        .error-message.active {
            display: block;
        }

        /* Button */
        .btn-reset {
            width: 100%; padding: 14px; background: var(--primary-color);
            color: white; border: none; border-radius: 10px;
            font-size: 16px; font-weight: 600; cursor: pointer;
            transition: all 0.3s; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-reset:hover { background: var(--primary-hover); transform: translateY(-2px); }
        .btn-reset:disabled {
            background: var(--border-color);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-back {
            width: 100%; padding: 14px; background: transparent;
            color: var(--text-secondary); border: 2px solid var(--border-color);
            border-radius: 10px; font-size: 16px; font-weight: 600; 
            cursor: pointer; transition: all 0.3s; margin-top: 15px;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-back:hover { 
            border-color: var(--primary-color); 
            color: var(--primary-color); 
        }

        /* --- MODAL STYLES --- */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: var(--bg-card);
            border-radius: 20px;
            max-width: 480px;
            width: 90%;
            padding: 40px;
            position: relative;
            box-shadow: 0 20px 60px var(--shadow-color);
            transform: scale(0.9);
            animation: scaleIn 0.3s ease forwards;
            border: 1px solid var(--border-color);
        }

        @keyframes scaleIn {
            to { transform: scale(1); }
        }

        /* Success Icon Animation */
        .modal-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #45a049 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            position: relative;
            animation: bounceIn 0.6s ease;
        }

        @keyframes bounceIn {
            0% { transform: scale(0); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .modal-icon i {
            font-size: 50px;
            color: white;
        }

        /* Success Checkmark Animation */
        .modal-icon::after {
            content: '';
            position: absolute;
            width: 120px;
            height: 120px;
            border: 3px solid var(--primary-color);
            border-radius: 50%;
            opacity: 0.3;
            animation: ripple 1.5s infinite;
        }

        @keyframes ripple {
            0% { transform: scale(1); opacity: 0.3; }
            100% { transform: scale(1.3); opacity: 0; }
        }

        .modal-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-main);
            text-align: center;
            margin-bottom: 15px;
        }

        .modal-message {
            font-size: 15px;
            color: var(--text-secondary);
            text-align: center;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Redirect Info */
        .redirect-info {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 25px;
            text-align: center;
        }

        .redirect-info p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 10px;
        }

        .countdown {
            font-size: 32px;
            font-weight: 800;
            color: var(--primary-color);
            font-family: 'Courier New', Courier, monospace;
        }

        /* Modal Buttons */
        .modal-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-modal {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-modal-primary {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-modal-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .btn-modal-secondary {
            background: transparent;
            color: var(--text-secondary);
            border: 2px solid var(--border-color);
        }

        .btn-modal-secondary:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .reset-container { grid-template-columns: 1fr; max-width: 500px; }
            .reset-branding { display: none; }
            .reset-form-container { padding: 50px 30px; }
        }

        @media (max-width: 480px) {
            .modal-content {
                padding: 30px 25px;
            }
            .modal-title {
                font-size: 24px;
            }
            .modal-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>

    <div class="reset-page">
        <div class="reset-container">
            
            <!-- LEFT SIDE: BRANDING -->
            <div class="reset-branding">
                <div class="branding-content">
                    <div class="branding-logo">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    
                    <div class="reset-illustration">
                        <i class="fas fa-key"></i>
                    </div>
                    
                    <h2>Buat Password Baru</h2>
                    <p>Pastikan password baru Anda aman dan mudah diingat untuk akses akun di masa mendatang.</p>

                    <div class="security-tips">
                        <h3>Tips Keamanan:</h3>
                        <div class="tip-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Gunakan kombinasi huruf, angka & simbol</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-lock"></i>
                            <span>Minimal 8 karakter panjang</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-user-secret"></i>
                            <span>Hindari informasi pribadi yang mudah ditebak</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-ban"></i>
                            <span>Jangan gunakan password lama</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: FORM -->
            <div class="reset-form-container">
                <div class="reset-header">
                    <h1>Reset Password</h1>
                    <p>Masukkan password baru untuk akun Anda. Pastikan password memenuhi persyaratan keamanan.</p>
                </div>

                <!-- Div tambahan untuk error server -->
                <div class="error-message" id="serverError" style="text-align: center; margin-bottom: 20px; font-size: 14px;"></div>

                <!-- Action menggunakan route reset password (password.update) -->
                <form action="{{ route('password.update') }}" method="POST" id="resetForm">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token ?? '' }}">
                    <input type="hidden" name="email" value="{{ $email ?? '' }}">
                    
                    <!-- New Password -->
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <div class="password-input-wrapper">
                            <input 
                                type="password" 
                                name="password" 
                                id="newPassword" 
                                class="form-input" 
                                placeholder="Masukkan password baru" 
                                required
                            >
                            <i class="fas fa-eye toggle-password" id="toggleNew"></i>
                        </div>
                        
                        <!-- Password Strength Indicator -->
                        <div class="password-strength" id="strengthIndicator">
                            <div class="strength-bar">
                                <div class="strength-bar-fill" id="strengthBar"></div>
                            </div>
                            <div class="strength-text" id="strengthText">Masukkan password</div>
                        </div>

                        <!-- Password Requirements -->
                        <div class="password-requirements">
                            <div class="requirement-title">Password harus memiliki:</div>
                            <div class="requirement-item" id="req-length">
                                <i class="fas fa-circle"></i>
                                <span>Minimal 8 karakter</span>
                            </div>
                            <div class="requirement-item" id="req-uppercase">
                                <i class="fas fa-circle"></i>
                                <span>Minimal 1 huruf kapital (A-Z)</span>
                            </div>
                            <div class="requirement-item" id="req-lowercase">
                                <i class="fas fa-circle"></i>
                                <span>Minimal 1 huruf kecil (a-z)</span>
                            </div>
                            <div class="requirement-item" id="req-number">
                                <i class="fas fa-circle"></i>
                                <span>Minimal 1 angka (0-9)</span>
                            </div>
                            <div class="requirement-item" id="req-special">
                                <i class="fas fa-circle"></i>
                                <span>Minimal 1 karakter spesial (!@#$%^&*)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div class="password-input-wrapper">
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="confirmPassword" 
                                class="form-input" 
                                placeholder="Masukkan ulang password baru" 
                                required
                            >
                            <i class="fas fa-eye toggle-password" id="toggleConfirm"></i>
                        </div>
                        <div class="error-message" id="confirmError">Password tidak cocok</div>
                    </div>

                    <button type="submit" class="btn-reset" id="submitBtn" disabled>
                        <i class="fas fa-check-circle"></i> Reset Password
                    </button>

                    <a href="{{ route('login') }}" style="text-decoration: none;">
                        <button type="button" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Kembali ke Login
                        </button>
                    </a>
                </form>
            </div>

        </div>
    </div>

    <!-- SUCCESS MODAL -->
    <div class="modal-overlay" id="successModal">
        <div class="modal-content">
            <!-- Success Icon -->
            <div class="modal-icon">
                <i class="fas fa-check"></i>
            </div>

            <!-- Modal Title -->
            <h2 class="modal-title">Password Berhasil Direset!</h2>

            <!-- Modal Message -->
            <p class="modal-message">
                Password Anda telah berhasil diperbarui. Anda sekarang dapat login menggunakan password baru Anda.
            </p>

            <!-- Redirect Countdown -->
            <div class="redirect-info">
                <p>Anda akan dialihkan ke halaman login dalam</p>
                <div class="countdown" id="countdown">5</div>
            </div>

            <!-- Modal Buttons -->
            <div class="modal-buttons">
                <button type="button" class="btn-modal btn-modal-primary" id="loginNowBtn">
                    <i class="fas fa-sign-in-alt"></i> Login Sekarang
                </button>
                <button type="button" class="btn-modal btn-modal-secondary" id="closeModalBtn">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        const toggleNew = document.getElementById('toggleNew');
        const toggleConfirm = document.getElementById('toggleConfirm');
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');

        toggleNew.addEventListener('click', function() {
            const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            newPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        toggleConfirm.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Password strength checker
        const strengthIndicator = document.getElementById('strengthIndicator');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        const submitBtn = document.getElementById('submitBtn');

        // Requirements elements
        const reqLength = document.getElementById('req-length');
        const reqUppercase = document.getElementById('req-uppercase');
        const reqLowercase = document.getElementById('req-lowercase');
        const reqNumber = document.getElementById('req-number');
        const reqSpecial = document.getElementById('req-special');

        newPassword.addEventListener('input', function() {
            const password = this.value;
            
            if (password.length > 0) {
                strengthIndicator.classList.add('active');
            } else {
                strengthIndicator.classList.remove('active');
            }

            // Check requirements
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);

            // Update requirement indicators
            updateRequirement(reqLength, hasLength);
            updateRequirement(reqUppercase, hasUppercase);
            updateRequirement(reqLowercase, hasLowercase);
            updateRequirement(reqNumber, hasNumber);
            updateRequirement(reqSpecial, hasSpecial);

            // Calculate strength
            let strength = 0;
            if (hasLength) strength++;
            if (hasUppercase) strength++;
            if (hasLowercase) strength++;
            if (hasNumber) strength++;
            if (hasSpecial) strength++;

            // Update strength bar
            strengthBar.className = 'strength-bar-fill';
            strengthText.className = 'strength-text';

            if (strength <= 2) {
                strengthBar.classList.add('weak');
                strengthText.classList.add('weak');
                strengthText.textContent = 'Lemah';
            } else if (strength <= 4) {
                strengthBar.classList.add('medium');
                strengthText.classList.add('medium');
                strengthText.textContent = 'Sedang';
            } else {
                strengthBar.classList.add('strong');
                strengthText.classList.add('strong');
                strengthText.textContent = 'Kuat';
            }

            validateForm();
        });

        function updateRequirement(element, isValid) {
            const icon = element.querySelector('i');
            if (isValid) {
                element.classList.add('valid');
                icon.className = 'fas fa-check-circle';
            } else {
                element.classList.remove('valid');
                icon.className = 'fas fa-circle';
            }
        }

        // Confirm password validation
        const confirmError = document.getElementById('confirmError');

        confirmPassword.addEventListener('input', function() {
            validateForm();
        });

        function validateForm() {
            const password = newPassword.value;
            const confirm = confirmPassword.value;

            // Check if passwords match
            if (confirm.length > 0) {
                if (password === confirm) {
                    confirmPassword.classList.remove('error');
                    confirmPassword.classList.add('success');
                    confirmError.classList.remove('active');
                } else {
                    confirmPassword.classList.add('error');
                    confirmPassword.classList.remove('success');
                    confirmError.classList.add('active');
                }
            } else {
                confirmPassword.classList.remove('error', 'success');
                confirmError.classList.remove('active');
            }

            // Check all requirements
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            const passwordsMatch = password === confirm && confirm.length > 0;

            const allValid = hasLength && hasUppercase && hasLowercase && 
                           hasNumber && hasSpecial && passwordsMatch;

            submitBtn.disabled = !allValid;
        }

        // Modal functionality
        const successModal = document.getElementById('successModal');
        const loginNowBtn = document.getElementById('loginNowBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const countdownElement = document.getElementById('countdown');
        let countdownInterval;

        // Form submission dengan AJAX (Fetch API)
        document.getElementById('resetForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const originalBtnText = submitBtn.innerHTML;
            const serverError = document.getElementById('serverError');
            
            // Ubah tombol jadi loading
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            submitBtn.disabled = true;
            serverError.classList.remove('active');

            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Jika sukses, panggil modal buatan Anda!
                    showSuccessModal();
                } else {
                    // Jika gagal (token expired/validasi error), kembalikan tombol
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                    
                    // Ambil pesan error dari Laravel
                    let errorMsg = 'Terjadi kesalahan. Silakan coba lagi.';
                    if (data.errors) {
                        const firstErrorKey = Object.keys(data.errors)[0];
                        errorMsg = data.errors[firstErrorKey][0];
                    } else if (data.message) {
                        errorMsg = data.message;
                    }
                    
                    serverError.textContent = errorMsg;
                    serverError.classList.add('active');
                }
            } catch (error) {
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
                serverError.textContent = 'Gagal terhubung ke server.';
                serverError.classList.add('active');
            }
        });

        function showSuccessModal() {
            successModal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
            
            // Start countdown
            let timeLeft = 5;
            countdownElement.textContent = timeLeft;
            
            countdownInterval = setInterval(() => {
                timeLeft--;
                countdownElement.textContent = timeLeft;
                
                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    redirectToLogin();
                }
            }, 1000);
        }

        function closeModal() {
            successModal.classList.remove('active');
            document.body.style.overflow = ''; // Restore scrolling
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
        }

        function redirectToLogin() {
            window.location.href = '{{ route("login") }}';
        }

        // Button event listeners
        loginNowBtn.addEventListener('click', function() {
            clearInterval(countdownInterval);
            redirectToLogin();
        });

        closeModalBtn.addEventListener('click', function() {
            closeModal();
        });

        // Close modal when clicking outside
        successModal.addEventListener('click', function(e) {
            if (e.target === successModal) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && successModal.classList.contains('active')) {
                closeModal();
            }
        });
    </script>

</body>
</html>