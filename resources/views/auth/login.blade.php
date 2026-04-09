<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name', 'ResuMate') }}</title>
    
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            background: linear-gradient(135deg, var(--bg-body) 0%, var(--border-color) 100%);
        }

        .login-container {
            max-width: 1100px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: var(--bg-card); /* Mengikuti tema */
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px var(--shadow-color);
            position: relative;
            z-index: 1;
            border: 1px solid var(--border-color);
        }

        /* --- LEFT SIDE: BRANDING (Static Green) --- */
        .login-branding {
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

        /* Features List */
        .branding-features { text-align: left; width: 100%; max-width: 320px; }
        .feature-item { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; font-size: 15px; color: white; }
        .feature-item i { 
            width: 24px; height: 24px; background: rgba(255,255,255,0.2); 
            border-radius: 50%; display: flex; align-items: center; justify-content: center; 
            font-size: 12px; flex-shrink: 0; 
        }

        /* --- RIGHT SIDE: FORM --- */
        .login-form-container {
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header { margin-bottom: 40px; }
        .login-header h1 { font-size: 32px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; }
        .login-header p { color: var(--text-secondary); font-size: 15px; }
        .login-header a { color: var(--primary-color); font-weight: 600; text-decoration: none; transition: 0.3s; }
        .login-header a:hover { color: var(--primary-hover); text-decoration: underline; }

        /* Form Elements */
        .form-group { margin-bottom: 24px; }
        
        .form-label {
            display: block; font-size: 14px; font-weight: 600; 
            color: var(--text-main); margin-bottom: 8px;
        }

        .form-input {
            width: 100%; padding: 14px 16px;
            border: 2px solid var(--border-color);
            border-radius: 10px; font-size: 15px;
            color: var(--text-main); 
            background: var(--input-bg); /* Mengikuti tema */
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none; border-color: var(--primary-color);
            background: var(--bg-card);
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
        }

        /* Options (Remember & Forgot) */
        .form-options {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 24px; font-size: 14px;
        }
        .remember-me {
            display: flex; align-items: center; gap: 8px; color: var(--text-secondary); cursor: pointer;
        }
        .remember-me input { width: 16px; height: 16px; accent-color: var(--primary-color); cursor: pointer; }
        
        .forgot-password { color: var(--primary-color); font-weight: 600; text-decoration: none; }
        .forgot-password:hover { color: var(--primary-hover); text-decoration: underline; }

        /* Button */
        .btn-login {
            width: 100%; padding: 14px; background: var(--primary-color);
            color: white; border: none; border-radius: 10px;
            font-size: 16px; font-weight: 600; cursor: pointer;
            transition: all 0.3s; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }
        .btn-login:hover { background: var(--primary-hover); transform: translateY(-2px); }

        /* Divider */
        .divider { position: relative; text-align: center; margin: 30px 0; }
        .divider::before {
            content: ''; position: absolute; top: 50%; left: 0; right: 0;
            height: 1px; background: var(--border-color);
        }
        .divider span {
            position: relative; background: var(--bg-card); /* Penting */
            padding: 0 16px; color: var(--text-secondary); font-size: 14px;
        }

        /* Social Buttons */
        .social-login { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .btn-social {
            padding: 12px; border: 2px solid var(--border-color);
            border-radius: 10px; 
            background: var(--bg-card); /* Mengikuti tema */
            color: var(--text-secondary); 
            font-weight: 600; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: 0.3s;
        }
        .btn-social:hover { border-color: var(--primary-color); color: var(--primary-color); }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .login-container { grid-template-columns: 1fr; max-width: 500px; }
            .login-branding { display: none; } /* Hide branding on mobile */
            .login-form-container { padding: 50px 30px; }
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

    <div class="login-page">
        <div class="login-container">
            
            <div class="login-branding">
                <div class="branding-content">
                    <div class="branding-logo">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h2>Selamat Datang Kembali!</h2>
                    <p>Lanjutkan perjalanan karir Anda dengan membuat CV profesional.</p>
                    
                    <div class="branding-features">
                        <div class="feature-item">
                            <i class="fas fa-check"></i> <span>500+ Template Premium</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i> <span>Auto Save & Cloud Storage</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i> <span>Export PDF Berkualitas Tinggi</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i> <span>ATS-Friendly Templates</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="login-form-container">
                <div class="login-header">
                    <h1>Login Akun</h1>
                    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
                </div>

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf

                    @if(session('success'))
                        <div style="background:#d4edda;color:#155724;padding:12px;border-radius:8px;margin-bottom:15px;border:1px solid #c3e6cb;font-size:14px;">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input 
                            type="email" 
                            name="email"
                            value="{{ old('email') }}"
                            class="form-input"
                            placeholder="nama@email.com"
                            required
                        >
                        @error('email')
                            <small style="color:#e3342f;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input 
                            type="password" 
                            name="password"
                            class="form-input"
                            placeholder="Masukkan password Anda"
                            required
                        >
                        @error('password')
                            <small style="color:#e3342f;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-options"> <label class="remember-me"> <input type="checkbox" name="remember"> <span>Ingat saya</span> </label> <a href="{{ route('password.request')}}" class="forgot-password">Lupa password?</a> </div>
                    
                    <button type="submit" class="btn-login">Masuk</button>
                </form>

                <div class="divider">
                    <span>Atau login lebih mudah</span>
                </div>

                <form id="magic-link-form" action="{{ route('login.magic') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" id="magic-email">
                    
                    <button type="button" onclick="submitMagicLink()" class="btn-social" style="width: 100%; border-color: var(--primary-color); color: var(--primary-color);">
                        <i class="fas fa-magic"></i> Masuk tanpa password
                    </button>
                </form>

                <div style="text-align: center; margin-top: 30px; font-size: 14px; color: var(--text-secondary);">
                    Masalah saat login? <a href="#" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">Hubungi Support</a>
                </div>
            </div>

        </div>
    </div>
    <script>
        function submitMagicLink() {
            const emailInput = document.querySelector('input[name="email"]');
            const mainEmail = emailInput.value;
            const magicEmailInput = document.getElementById('magic-email');
            
            if (!mainEmail) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Email Kosong',
                    text: 'Silakan masukkan alamat email Anda terlebih dahulu sebelum meminta link login.',
                    confirmButtonColor: '#4CAF50', // Sesuai --primary-color
                    background: document.documentElement.getAttribute('data-theme') === 'dark' ? '#1E1E1E' : '#FFFFFF',
                    color: document.documentElement.getAttribute('data-theme') === 'dark' ? '#E0E0E0' : '#333333',
                });
                emailInput.focus();
                return;
            }

            Swal.fire({
                title: 'Mengirim Link...',
                text: 'Harap tunggu sebentar, kami sedang mengirimkan link ajaib ke email Anda.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            magicEmailInput.value = mainEmail;
            document.getElementById('magic-link-form').submit();
        }
    </script>
</body>
</html>