<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - {{ config('app.name', 'ResuMate') }}</title>
    
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
            --shadow-color: rgba(0,0,0,0.1);
            --error-color: #e53935;
        }
        [data-theme="dark"] {
            --bg-body: #121212; --bg-card: #1E1E1E; --text-main: #E0E0E0;
            --text-secondary: #A0A0A0; --border-color: #333333;
            --input-bg: #2C2C2C; --shadow-color: rgba(0,0,0,0.5);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-body); color: var(--text-main); line-height: 1.5; transition: background 0.3s, color 0.3s; }

        .forgot-page {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, var(--bg-body) 0%, var(--border-color) 100%);
        }
        .forgot-container {
            max-width: 1100px; width: 100%; display: grid; grid-template-columns: 1fr 1fr;
            background: var(--bg-card); border-radius: 20px; overflow: hidden;
            box-shadow: 0 20px 60px var(--shadow-color); border: 1px solid var(--border-color);
        }
        .forgot-branding {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2E7D32 100%);
            padding: 60px 50px; display: flex; flex-direction: column;
            justify-content: center; align-items: center; text-align: center; color: white;
        }
        .branding-logo {
            width: 80px; height: 80px; background: white; border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .branding-logo i { font-size: 40px; color: var(--primary-color); }
        .forgot-illustration {
            width: 120px; height: 120px; background: rgba(255,255,255,0.2);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 30px;
        }
        .forgot-illustration i { font-size: 60px; color: white; }
        .branding-content h2 { font-size: 32px; font-weight: 800; margin-bottom: 20px; line-height: 1.2; }
        .branding-content p { font-size: 16px; opacity: 0.9; margin-bottom: 40px; line-height: 1.6; }

        .forgot-form-container {
            padding: 60px 50px; display: flex; flex-direction: column; justify-content: center;
        }
        .forgot-header { margin-bottom: 32px; }
        .forgot-header h1 { font-size: 32px; font-weight: 700; margin-bottom: 8px; }
        .forgot-header p { color: var(--text-secondary); font-size: 15px; line-height: 1.6; }

        .alert {
            padding: 14px 16px; border-radius: 10px; font-size: 14px;
            margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px;
        }
        .alert-info { background: rgba(76,175,80,0.08); border-left: 4px solid var(--primary-color); }
        .alert-info i { color: var(--primary-color); font-size: 18px; flex-shrink: 0; margin-top: 2px; }
        .alert-info p { font-size: 14px; color: var(--text-secondary); margin: 0; }
        .alert-success { background: rgba(76,175,80,0.1); border-left: 4px solid var(--primary-color); color: #2E7D32; }
        .alert-success i { font-size: 18px; flex-shrink: 0; margin-top: 2px; }

        .form-group { margin-bottom: 24px; }
        .form-label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; }
        .input-wrapper { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: var(--text-secondary); font-size: 16px; pointer-events: none;
        }
        .form-input {
            width: 100%; padding: 14px 16px 14px 44px;
            border: 2px solid var(--border-color); border-radius: 10px;
            font-size: 15px; color: var(--text-main); background: var(--input-bg); transition: all 0.3s;
        }
        .form-input:focus {
            outline: none; border-color: var(--primary-color); background: var(--bg-card);
            box-shadow: 0 0 0 4px rgba(76,175,80,0.1);
        }
        .form-input.is-invalid { border-color: var(--error-color); box-shadow: 0 0 0 4px rgba(229,57,53,0.08); }
        .field-error { font-size: 12px; color: var(--error-color); margin-top: 6px; display: flex; align-items: center; gap: 5px; }

        .btn-submit {
            width: 100%; padding: 14px; background: var(--primary-color);
            color: white; border: none; border-radius: 10px; font-size: 16px; font-weight: 600;
            cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(76,175,80,0.3);
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover { background: var(--primary-hover); transform: translateY(-2px); }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        .btn-back {
            width: 100%; padding: 14px; background: transparent; color: var(--text-secondary);
            border: 2px solid var(--border-color); border-radius: 10px;
            font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-top: 12px;
            display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none;
        }
        .btn-back:hover { border-color: var(--primary-color); color: var(--primary-color); }

        .spinner {
            width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.4);
            border-top-color: white; border-radius: 50%;
            animation: spin 0.7s linear infinite; display: none;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .resend-section { text-align: center; margin-top: 24px; font-size: 14px; color: var(--text-secondary); }
        .resend-section a { color: var(--primary-color); font-weight: 600; text-decoration: none; }
        .resend-section a:hover { text-decoration: underline; }

        @media (max-width: 1024px) {
            .forgot-container { grid-template-columns: 1fr; max-width: 500px; }
            .forgot-branding { display: none; }
            .forgot-form-container { padding: 50px 30px; }
        }
    </style>
</head>
<body>
    <script>
        (function() {
            const t = localStorage.getItem('theme');
            if (t) document.documentElement.setAttribute('data-theme', t);
            else if (window.matchMedia('(prefers-color-scheme: dark)').matches)
                document.documentElement.setAttribute('data-theme', 'dark');
        })();
    </script>

    <div class="forgot-page">
        <div class="forgot-container">

            <div class="forgot-branding">
                <div class="branding-content">
                    <div class="branding-logo"><i class="fas fa-file-alt"></i></div>
                    <div class="forgot-illustration"><i class="fas fa-lock"></i></div>
                    <h2>Lupa Password?</h2>
                    <p>Jangan khawatir! Kami akan mengirimkan link verifikasi ke email Anda untuk reset password.</p>
                </div>
            </div>

            <div class="forgot-form-container">
                <div class="forgot-header">
                    <h1>Reset Password</h1>
                    <p>Masukkan alamat email Anda dan kami akan mengirimkan link untuk reset password.</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <p>Pastikan email yang Anda masukkan adalah email yang terdaftar di akun ResuMate Anda.</p>
                </div>

                <form action="{{ route('password.send-reset-link') }}" method="POST" id="forgotForm">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="email">Alamat Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input
                                type="email" name="email" id="email"
                                class="form-input @error('email') is-invalid @enderror"
                                placeholder="nama@email.com"
                                value="{{ old('email') }}"
                                required autofocus
                            >
                        </div>
                        @error('email')
                            <div class="field-error">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="spinner" id="spinner"></span>
                        <span id="submitText"><i class="fas fa-paper-plane"></i> Kirim link reset password</span>
                    </button>

                    <a href="{{ route('login') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali ke Login
                    </a>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('forgotForm').addEventListener('submit', function () {
            document.getElementById('spinner').style.display = 'block';
            document.getElementById('submitText').style.display = 'none';
            document.getElementById('submitBtn').disabled = true;
        });

        document.getElementById('email').addEventListener('input', function () {
            this.classList.remove('is-invalid');
        });

        document.getElementById('resendLink').addEventListener('click', function (e) {
            e.preventDefault();
            if (!document.getElementById('email').value.trim()) {
                document.getElementById('email').focus();
                return;
            }
            document.getElementById('forgotForm').submit();
        });
    </script>
</body>
</html>