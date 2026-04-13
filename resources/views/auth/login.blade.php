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
        :root {
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

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-body); color: var(--text-main); line-height: 1.5; transition: background 0.3s, color 0.3s; }

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
            background: var(--bg-card); 
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px var(--shadow-color);
            position: relative;
            z-index: 1;
            border: 1px solid var(--border-color);
        }

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

        .branding-features { text-align: left; width: 100%; max-width: 320px; }
        .feature-item { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; font-size: 15px; color: white; }
        .feature-item i { 
            width: 24px; height: 24px; background: rgba(255,255,255,0.2); 
            border-radius: 50%; display: flex; align-items: center; justify-content: center; 
            font-size: 12px; flex-shrink: 0; 
        }

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
            background: var(--input-bg); 
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none; border-color: var(--primary-color);
            background: var(--bg-card);
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
        }

        .btn-login {
            width: 100%; padding: 16px; background: var(--primary-color);
            color: white; border: none; border-radius: 10px;
            font-size: 16px; font-weight: 600; cursor: pointer;
            transition: all 0.3s; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
            display: flex; justify-content: center; align-items: center; gap: 10px;
        }
        .btn-login:hover { background: var(--primary-hover); transform: translateY(-2px); }

        @media (max-width: 1024px) {
            .login-container { grid-template-columns: 1fr; max-width: 500px; }
            .login-branding { display: none; } 
            .login-form-container { padding: 50px 30px; }
        }

        .back-home-wrapper {
    text-align: center;
    margin-top: 40px;
}

.back-home-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-secondary);
    text-decoration: none;
    padding: 8px 16px;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.back-home-link:hover {
    color: var(--primary-color);
    background-color: var(--primary-light); 
}

.back-home-link .arrow-icon {
    transition: transform 0.3s ease;
}

.back-home-link:hover .arrow-icon {
    transform: translateX(-4px);
}
    </style>
</head>
<body>

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
                            <i class="fas fa-check"></i> <span>Akses Ratusan Template</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i> <span>Penyimpanan Cloud Aman</span>
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
                    <h1>Masuk ke Akun</h1>
                    <p>Login lebih aman tanpa password. Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                </div>

                <form action="{{ route('login.magic') }}" method="POST" id="magic-login-form">
                    @csrf

                    @if(session('success'))
                        <div style="background:#d4edda;color:#155724;padding:12px;border-radius:8px;margin-bottom:20px;border:1px solid #c3e6cb;font-size:14px;">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div style="background:#f8d7da;color:#721c24;padding:12px;border-radius:8px;margin-bottom:20px;border:1px solid #f5c6cb;font-size:14px;">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Alamat Email</label>
                        <input 
                            type="email" 
                            name="email"
                            id="email-input"
                            value="{{ old('email') }}"
                            class="form-input"
                            placeholder="nama@email.com"
                            required
                        >
                        @error('email')
                            <small style="color:#e3342f; margin-top: 5px; display: block;">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-login">
                        Kirim Tautan Akses
                    </button>
                </form>

                <div class="back-home-wrapper">
                    <a href="{{ route('home') }}" class="back-home-link">
                        <i class="fas fa-arrow-left arrow-icon"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('magic-login-form').addEventListener('submit', function(e) {
            const emailInput = document.getElementById('email-input').value;
            
            if (emailInput) {
                Swal.fire({
                    title: 'Mengirim Link...',
                    text: 'Harap tunggu sebentar, kami sedang mengirimkan link verifikasi ke email Anda.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
        });
    </script>
</body>
</html>