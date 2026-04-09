<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — ResuMate</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --green:       #4CAF50;
            --green-dark:  #2E7D32;
            --green-pale:  #f0f7f0;
            --ink:         #1c1c1c;
            --ink-mid:     #555;
            --ink-faint:   #999;
            --bg:          #f5f4f1;
            --white:       #fff;
            --rule:        #e2e2de;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
        }

        /* ── LOOSE HEADER — not centered, not full-width bar ── */
        .site-header {
            padding: 28px 48px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex; align-items: center; gap: 9px;
            text-decoration: none;
        }
        .logo-mark {
            width: 32px; height: 32px;
            background: var(--green);
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-mark i { color: #fff; font-size: 14px; }
        .logo-name {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            color: var(--ink);
            letter-spacing: -0.3px;
        }




        /* ── MAIN STAGE — intentionally off-center ── */
        .stage {
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            /* nudged left, not dead-center */
            padding: 60px 48px 60px 10vw;
            gap: 80px;
        }


        /* ── LEFT COLUMN — text-only, no box ── */
        .left-col {
            flex: 0 0 auto;
            width: 300px;
            padding-top: 8px; /* slight vertical mis-alignment — intentional */
        }

        .admin-eyebrow {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 600;
            letter-spacing: 0.14em; text-transform: uppercase;
            color: var(--green-dark);
            margin-bottom: 20px;
        }
        .admin-eyebrow::before {
            content: '';
            display: inline-block;
            width: 18px; height: 2px;
            background: var(--green);
        }

        .left-heading {
            font-family: 'Playfair Display', serif;
            font-size: 52px;
            line-height: 1.05;
            letter-spacing: -1.5px;
            color: var(--ink);
            margin-bottom: 18px;
        }
        .left-heading em {
            font-style: italic;
            color: var(--green-dark);
        }

        .left-desc {
            font-size: 14px;
            line-height: 1.7;
            color: var(--ink-mid);
            font-weight: 300;
            margin-bottom: 44px;
            max-width: 260px;
        }

        /* Little stats — uneven spacing feels human */
        .stat-stack { display: flex; flex-direction: column; gap: 18px; }

        .stat-row {
            display: flex; align-items: baseline; gap: 10px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--rule);
        }
        .stat-row:last-child { border-bottom: none; padding-bottom: 0; }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: var(--ink);
            letter-spacing: -1px;
            line-height: 1;
        }
        .stat-label {
            font-size: 13px;
            color: var(--ink-faint);
        }


        /* ── RIGHT COLUMN — the form, floated slightly ── */
        .form-col {
            flex: 0 0 auto;
            width: 400px;
            /* subtle drop shadow, no hard border */
            background: var(--white);
            border-radius: 14px;
            padding: 44px 44px 38px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04),
                        0 12px 40px rgba(0,0,0,0.09);
            /* slight rotation — signature human touch */
            /* removed rotation as it can feel gimmicky, instead use offset */
            position: relative;
            top: -12px; /* pulls it up, breaking perfect alignment */
        }

        /* Small accent blob behind the card */
        .form-col::before {
            content: '';
            position: absolute;
            top: -20px; right: -20px;
            width: 120px; height: 120px;
            border-radius: 50%;
            background: var(--green-pale);
            z-index: -1;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            letter-spacing: -0.8px;
            color: var(--ink);
            margin-bottom: 4px;
        }
        .form-sub {
            font-size: 13px;
            color: var(--ink-faint);
            margin-bottom: 34px;
        }

        /* ── INPUTS ── */
        .field { margin-bottom: 18px; }

        .field label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-mid);
            margin-bottom: 6px;
        }

        .field-inner { position: relative; }

        .field-icon {
            position: absolute;
            left: 12px; top: 50%; transform: translateY(-50%);
            color: #ccc;
            font-size: 12px;
            pointer-events: none;
            transition: color .2s;
        }

        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 11px 14px 11px 36px;
            border: 1.5px solid #e8e8e4;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            color: var(--ink);
            background: #fafaf8;
            transition: border-color .2s, box-shadow .2s, background .2s;
            appearance: none;
        }
        select { padding-left: 14px; cursor: pointer; }

        input:focus, select:focus {
            outline: none;
            border-color: var(--green);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(76,175,80,.1);
        }
        .field-inner:focus-within .field-icon { color: var(--green); }

        /* Select arrow */
        .select-wrap { position: relative; }
        .select-wrap::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 9px;
            color: #bbb;
            position: absolute;
            right: 13px; top: 50%; transform: translateY(-50%);
            pointer-events: none;
        }

        /* Two-col for password + role */

        /* Options */
        .field-options {
            display: flex; justify-content: space-between; align-items: center;
            margin: 16px 0 24px;
        }
        .check-label {
            display: flex; align-items: center; gap: 7px;
            font-size: 13px; color: var(--ink-mid); cursor: pointer;
        }
        .check-label input { width: 14px; height: 14px; accent-color: var(--green); }
        .link-forgot {
            font-size: 13px; font-weight: 500;
            color: var(--green-dark); text-decoration: none;
        }
        .link-forgot:hover { text-decoration: underline; }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: var(--green);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px; font-weight: 600;
            cursor: pointer;
            letter-spacing: 0.02em;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 4px 14px rgba(76,175,80,.35);
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover {
            background: var(--green-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(46,125,50,.4);
        }
        .btn-submit:active { transform: translateY(0); }

        /* Bottom notice — subtle, not a big box */
        .form-note {
            margin-top: 24px;
            font-size: 12px;
            color: var(--ink-faint);
            line-height: 1.6;
            text-align: center;
        }
        .form-note a { color: var(--green-dark); text-decoration: none; font-weight: 500; }
        .form-note a:hover { text-decoration: underline; }

        /* ── FOOTER — minimal, left-aligned ── */
        .site-footer {
            padding: 0 48px 28px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .footer-copy {
            font-size: 11px; color: var(--ink-faint);
        }
        .footer-links { display: flex; gap: 16px; }
        .footer-links a { font-size: 11px; color: var(--ink-faint); text-decoration: none; }
        .footer-links a:hover { color: var(--green-dark); }


        /* ── RESPONSIVE ── */
        @media (max-width: 860px) {
            .stage { flex-direction: column; padding: 40px 24px; gap: 32px; align-items: flex-start; }
            .left-col { width: 100%; }
            .form-col { width: 100%; top: 0; }
            .left-heading { font-size: 38px; }
            .site-header { padding: 20px 24px 0; }
            .site-footer { padding: 0 24px 24px; }
        }
    </style>
</head>
<body>

    <header class="site-header">
        <a href="/" class="logo">
            <div class="logo-mark"><i class="fas fa-file-alt"></i></div>
            <span class="logo-name">ResuMate</span>
        </a>

    </header>

    <main class="stage">

        <!-- LEFT -->
        <div class="left-col">
            <div class="admin-eyebrow">Admin Portal</div>

            <h1 class="left-heading">
                Dasbor<br><em>Kontrol</em><br>Platform.
            </h1>

            <p class="left-desc">
                Kelola pengguna, template CV, dan pantau performa ResuMate dari satu tempat.
            </p>

            <div class="stat-stack">
                <div class="stat-row">
                    <span class="stat-num">12,483</span>
                    <span class="stat-label">pengguna aktif</span>
                </div>
                <div class="stat-row">
                    <span class="stat-num">98k</span>
                    <span class="stat-label">CV telah dibuat</span>
                </div>
                <div class="stat-row">
                    <span class="stat-num">500+</span>
                    <span class="stat-label">template tersedia</span>
                </div>
            </div>
        </div>

        <!-- FORM -->
        <div class="form-col">
            <h2 class="form-title">Masuk, Admin.</h2>
            <p class="form-sub">Restricted access — tim internal ResuMate.</p>

            <form action="{{ route('admin.login.process') }}" method="POST">
                @csrf
                <div class="field">
                    <label>Email</label>
                    <div class="field-inner">
                        <i class="fas fa-envelope field-icon"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@resumate.com" required>
                    </div>
                    @error('email')
                            <small style="color:#e3342f;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>Password</label>
                        <div class="field-inner">
                            <i class="fas fa-lock field-icon"></i>
                            <input type="password" name="password" placeholder="••••••••" required>
                        </div>
                    </div>
                    @error('password')
                            <small style="color:#e3342f;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field-options">
                    <label class="check-label">
                        <input type="checkbox" name="remember">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-arrow-right-to-bracket"></i>
                    Masuk ke Dashboard
                </button>
            </form>
        </div>

    </main>

    <footer class="site-footer">
        <span class="footer-copy">© 2025 ResuMate</span>
        <div class="footer-links">
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Keamanan</a>
            <a href="#">Support</a>
        </div>
    </footer>
</body>
</html>