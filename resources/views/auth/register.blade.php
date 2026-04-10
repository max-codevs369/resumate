<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ config('app.name', 'ResuMate') }}</title>
    
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
            --shadow-color: rgba(0, 0, 0, 0.1);
            
            --pwd-weak: #e74c3c;
            --pwd-medium: #f39c12;
            --pwd-strong: #2ecc71;
            --pwd-bg: #e5e5e5;
        }

        [data-theme="dark"] {
            --bg-body: #121212;
            --bg-card: #1E1E1E;
            --text-main: #E0E0E0;
            --text-secondary: #A0A0A0;
            --border-color: #333333;
            --input-bg: #2C2C2C;
            --shadow-color: rgba(0, 0, 0, 0.5);
            --pwd-bg: #444444;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-body); color: var(--text-main); line-height: 1.5; transition: background 0.3s, color 0.3s; }

        .register-page {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            padding: 40px 20px; position: relative;
            background: linear-gradient(135deg, var(--bg-body) 0%, var(--border-color) 100%);
        }

        .register-container {
            max-width: 1100px; width: 100%; display: grid; grid-template-columns: 1fr 1fr;
            background: var(--bg-card); border-radius: 20px; overflow: hidden;
            box-shadow: 0 20px 60px var(--shadow-color); position: relative; z-index: 1;
            border: 1px solid var(--border-color);
        }

        .register-form-container { padding: 60px 50px; display: flex; flex-direction: column; justify-content: center; }
        .register-header { margin-bottom: 40px; }
        .register-header h1 { font-size: 32px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; }
        .register-header p { color: var(--text-secondary); font-size: 15px; }

        .form-group { margin-bottom: 20px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-label { display: block; font-size: 14px; font-weight: 600; color: var(--text-main); margin-bottom: 8px; }
        .form-input {
            width: 100%; padding: 14px 16px; border: 2px solid var(--border-color);
            border-radius: 10px; font-size: 15px; color: var(--text-main); 
            background: var(--input-bg); transition: all 0.3s;
        }
        .form-input:focus {
            outline: none; border-color: var(--primary-color); background: var(--bg-card);
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
        }

        .password-meter { margin-top: 8px; display: none; }
        .meter-bars { display: flex; gap: 5px; height: 6px; margin-bottom: 6px; }
        .meter-bar { flex: 1; background: var(--pwd-bg); border-radius: 3px; transition: background 0.3s; }
        .meter-text { font-size: 12px; font-weight: 600; color: var(--text-secondary); }

        .btn-register {
            width: 100%; padding: 14px; background: var(--primary-color); color: white;
            border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer;
            transition: all 0.3s; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3); margin-top: 10px;
        }
        .btn-register:hover { background: var(--primary-hover); transform: translateY(-2px); }

        .register-branding {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2E7D32 100%);
            padding: 60px 50px; display: flex; flex-direction: column; justify-content: center; 
            align-items: center; text-align: center; color: white;
        }

        @media (max-width: 1024px) {
            .register-container { grid-template-columns: 1fr; max-width: 550px; }
            .register-branding { display: none; }
            .register-form-container { padding: 50px 30px; }
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper .form-input {
            padding-right: 40px; 
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .toggle-password:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>

    <div class="register-page">
        <div class="register-container">
            
            <div class="register-form-container">
                <div class="register-header">
                    <h1>Buat Akun Baru</h1>
                    <p>Mulai perjalanan karir Anda bersama ResuMate.</p>
                </div>

                <form action="{{ route('register.store') }}" method="POST">
                    @csrf

                    @if(session('success'))
                        <div style="background:#d4edda;color:#155724;padding:12px;border-radius:8px;margin-bottom:15px;border:1px solid #c3e6cb;font-size:14px;">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="Contoh: Budi Santoso" required>
                        @error('name')<small style="color:#e3342f;">{{ $message }}</small>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="nama@email.com" required>
                        @error('email')<small style="color:#e3342f;">{{ $message }}</small>@enderror
                    </div>

                    <button type="submit" class="btn-register">Daftar Sekarang</button>
                </form>

                <div style="text-align: center; margin-top: 30px; font-size: 14px; color: var(--text-secondary);">
                    Sudah punya akun? <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">Masuk di sini</a>
                </div>
            </div>

            <div class="register-branding">
                <div style="font-size: 60px; color: white; margin-bottom: 20px;">
                    <i class="fas fa-rocket"></i>
                </div>
                <h2 style="font-size: 32px; font-weight: 800; margin-bottom: 20px;">Bangun Karir Impian</h2>
                <p style="font-size: 16px; opacity: 0.9; line-height: 1.6;">
                    Bergabunglah dengan komunitas profesional kami dan buat CV yang memikat HRD dalam hitungan menit.
                </p>
            </div>

        </div>
    </div>
</body>
</html>