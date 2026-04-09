@extends('layouts.app')

@section('title', 'Edit Profile — ResuMate')

@push('styles')
<style>
    :root {
        --primary-color: #4CAF50;
        --primary-hover: #45a049;
        --bg-body: #F7F7F7;
        --bg-card: #FFFFFF;
        --text-main: #333333;
        --text-secondary: #666666;
        --border-color: #E5E5E5;
        --shadow-color: rgba(0, 0, 0, 0.05);
        --green: #4CAF50;
        --green-dark: #2E7D32;
        --green-pale: #f0f7f0;
        --green-mid: #C8E6C9;
        --ink: #1c1c1c;
        --ink-mid: #555;
        --ink-faint: #999;
        --bg: #f5f4f1;
        --white: #fff;
        --rule: #e2e2de;
        --red-soft: #fff0f0;
        --red: #e53935;
        --danger-color: #EF4444;
        --secondary-color: #2196F3;
    }

    /* --- Dark Mode Variables (Opsional, disesuaikan dengan layout Anda) --- */
    html.dark, [data-theme="dark"] {
        --bg-body: #0F0F0F;
        --bg-card: #1A1A1A;
        --text-main: #F5F5F5;
        --text-secondary: #9CA3AF;
        --border-color: #2D2D2D;
        --ink: #F5F5F5;
        --ink-mid: #bbb;
        --ink-faint: #888;
        --bg: #1A1A1A;
        --white: #1A1A1A;
        --rule: #333;
        --shadow-color: rgba(0, 0, 0, 0.3);
    }

    body {
        font-family: 'Inter', 'Outfit', sans-serif;
        background-color: var(--bg-body);
        color: var(--text-main);
    }

    /* ============================================
        PAGE WRAPPER
    ============================================ */
    .page {
        max-width: 1040px;
        margin: 0 auto;
        padding: 48px 24px 80px;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--ink-faint);
        margin-bottom: 24px;
    }

    .breadcrumb a { color: var(--ink-mid); text-decoration: none; transition: color .2s; }
    .breadcrumb a:hover { color: var(--green-dark); }
    .breadcrumb .sep { color: var(--rule); }

    .page-header { margin-bottom: 40px; }

    .page-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 34px;
        letter-spacing: -0.9px;
        color: var(--ink);
        margin-bottom: 6px;
    }

    .page-header p { font-size: 14px; color: var(--ink-mid); line-height: 1.6; }

    /* ============================================
        FORM LAYOUT
    ============================================ */
    .form-wrapper {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 32px;
        align-items: start;
    }

    /* ============================================
        SIDEBAR TABS
    ============================================ */
    .form-nav {
        position: sticky;
        top: 90px;
        background: var(--white);
        border: 1.5px solid var(--border-color);
        border-radius: 12px;
        padding: 12px;
        box-shadow: 0 2px 8px var(--shadow-color);
    }

    .form-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: var(--ink-mid);
        cursor: pointer;
        transition: all .2s ease;
        border: none;
        background: transparent;
        width: 100%;
        text-align: left;
        margin-bottom: 4px;
    }

    .form-nav-item:last-child { margin-bottom: 0; }

    .form-nav-item i {
        font-size: 14px;
        width: 20px;
        color: var(--ink-faint);
        transition: color .2s;
    }

    .form-nav-item:hover { background: var(--green-pale); color: var(--green-dark); }
    .form-nav-item:hover i { color: var(--green-dark); }

    .form-nav-item.active {
        background: var(--green);
        color: #fff;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);
    }

    .form-nav-item.active i { color: #fff; }

    /* ============================================
        FORM CONTENT
    ============================================ */
    .form-content {
        background: var(--white);
        border: 1.5px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px var(--shadow-color);
    }

    .form-section { display: none; }

    .form-section.active {
        display: block;
        animation: fadeIn .3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .section-header {
        padding: 28px 32px;
        border-bottom: 1.5px solid var(--border-color);
        background: linear-gradient(to bottom, var(--white) 0%, var(--bg-body) 100%);
    }

    .section-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        letter-spacing: -0.6px;
        color: var(--ink);
        margin-bottom: 4px;
    }

    .section-header p { font-size: 13px; color: var(--ink-faint); }

    .section-body { padding: 32px; }

    /* ============================================
        AVATAR UPLOAD
    ============================================ */
    .avatar-upload {
        display: flex;
        align-items: center;
        gap: 24px;
        padding: 24px;
        background: var(--green-pale);
        border: 1px solid var(--green-mid);
        border-radius: 10px;
        margin-bottom: 32px;
    }

    .avatar-preview { position: relative; flex-shrink: 0; }

    .avatar-preview-img {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        background: var(--green-mid);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        color: var(--green-dark);
        border: 3px solid var(--white);
        box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        overflow: hidden;
        background-size: cover;
        background-position: center;
    }

    .avatar-badge {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 28px;
        height: 28px;
        background: var(--white);
        border: 1.5px solid var(--green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 11px;
        color: var(--green-dark);
        transition: all .2s;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .1);
    }

    .avatar-badge:hover { background: var(--green); color: white; }
    .avatar-badge input { display: none; }

    .avatar-info { flex: 1; }
    .avatar-info h3 { font-size: 14px; font-weight: 600; color: var(--ink); margin-bottom: 6px; }

    .avatar-info p {
        font-size: 12px;
        color: var(--ink-faint);
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .avatar-info .btn-group { display: flex; gap: 8px; }

    /* ============================================
        FORM FIELDS
    ============================================ */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    .form-grid.single { grid-template-columns: 1fr; }
    .form-grid.triple { grid-template-columns: 1fr 1fr 1fr; }

    .form-field { display: flex; flex-direction: column; }

    .field-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--ink-mid);
        margin-bottom: 9px;
    }

    .field-label .req { color: var(--red); margin-left: 2px; }

    .field-label .opt {
        color: var(--ink-faint);
        font-weight: 400;
        text-transform: none;
        letter-spacing: 0;
        font-size: 11px;
        margin-left: 4px;
    }

    .field-input,
    .field-textarea,
    .field-select {
        padding: 12px 14px;
        border: 1.5px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-body); /* Supaya beda dengan background card */
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        color: var(--ink);
        transition: all .2s;
        outline: none;
    }

    .field-input:focus,
    .field-textarea:focus,
    .field-select:focus {
        border-color: var(--green);
        box-shadow: 0 0 0 3px var(--green-pale);
        background: var(--white);
    }

    .field-textarea {
        resize: vertical;
        min-height: 100px;
        line-height: 1.6;
    }

    .field-hint {
        font-size: 12px;
        color: var(--ink-faint);
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .field-hint i { font-size: 10px; }

    /* ============================================
        DYNAMIC ITEMS (Education / Experience)
    ============================================ */
    .dynamic-item {
        background: var(--bg-body);
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 16px;
        border: 1.5px solid var(--border-color);
    }

    .dynamic-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border-color);
    }

    .dynamic-item-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--ink);
    }

    .btn-remove-item {
        background: var(--danger-color);
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .btn-remove-item:hover { background: #DC2626; }

    .btn-add-more {
        width: 100%;
        padding: 13px;
        background: transparent;
        border: 2px dashed var(--primary-color);
        color: var(--primary-color);
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 4px;
        font-family: 'Outfit', sans-serif;
    }

    .btn-add-more:hover { background: rgba(76, 175, 80, 0.08); }

    /* ============================================
        CHECKBOX
    ============================================ */
    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        margin-top: -4px;
    }

    .checkbox-wrapper input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: var(--primary-color);
    }

    .checkbox-wrapper label {
        font-size: 13px;
        color: var(--ink-mid);
        cursor: pointer;
    }

    /* ============================================
        TAGS INPUT
    ============================================ */
    .tags-input {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        padding: 10px;
        border: 1.5px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-body);
        min-height: 48px;
        cursor: text;
        transition: all .2s;
    }

    .tags-input:focus-within {
        border-color: var(--green);
        box-shadow: 0 0 0 3px var(--green-pale);
        background: var(--white);
    }

    .tag-item {
        background: var(--green);
        color: white;
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .tag-remove { cursor: pointer; font-size: 10px; opacity: .8; transition: opacity .2s; }
    .tag-remove:hover { opacity: 1; }

    .tag-input-field {
        border: none;
        background: transparent;
        padding: 5px;
        font-size: 14px;
        flex: 1;
        min-width: 120px;
        outline: none;
        color: var(--ink);
        font-family: 'Outfit', sans-serif;
    }

    /* ============================================
        TOGGLE SWITCH
    ============================================ */
    .toggle-field {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px;
        background: var(--bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 12px;
    }

    .toggle-label-wrap { flex: 1; }
    .toggle-title { font-size: 14px; font-weight: 500; color: var(--ink); }
    .toggle-desc { font-size: 12px; color: var(--ink-faint); margin-top: 2px; }

    .toggle { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
    .toggle input { opacity: 0; width: 0; height: 0; }

    .toggle-slider {
        position: absolute;
        inset: 0;
        background: var(--rule);
        border-radius: 24px;
        cursor: pointer;
        transition: background .2s;
    }

    .toggle-slider::before {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: white;
        left: 3px;
        top: 3px;
        transition: transform .2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
    }

    .toggle input:checked + .toggle-slider { background: var(--green); }
    .toggle input:checked + .toggle-slider::before { transform: translateX(20px); }

    /* ============================================
        DIVIDER & ACTION BUTTONS
    ============================================ */
    .divider { height: 1px; background: var(--border-color); margin: 28px 0; }

    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        padding: 24px 32px;
        border-top: 1.5px solid var(--border-color);
        background: var(--white);
    }

    .btn {
        padding: 11px 24px;
        border-radius: 8px;
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary {
        background: transparent;
        border: 1.5px solid var(--border-color);
        color: var(--ink-mid);
    }

    .btn-secondary:hover { border-color: var(--green); color: var(--green-dark); }

    .btn-primary {
        background: var(--green);
        color: white;
        border: 1.5px solid var(--green);
    }

    .btn-primary:hover {
        background: var(--green-dark);
        border-color: var(--green-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(76, 175, 80, .25);
    }

    .btn-small { padding: 7px 14px; font-size: 12px; }

    /* ============================================
        TOAST NOTIFICATION
    ============================================ */
    .toast {
        position: fixed;
        bottom: 32px;
        right: 32px;
        background: var(--white);
        border: 1.5px solid var(--green);
        border-radius: 10px;
        padding: 16px 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
        display: none;
        align-items: center;
        gap: 14px;
        z-index: 1000;
        min-width: 320px;
        animation: slideIn .3s ease;
    }

    .toast.show { display: flex; }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(100px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .toast-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--green-pale);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--green-dark);
        font-size: 14px;
        flex-shrink: 0;
    }

    .toast-content { flex: 1; }
    .toast-title { font-size: 14px; font-weight: 600; color: var(--ink); margin-bottom: 2px; }
    .toast-text { font-size: 12px; color: var(--ink-faint); }

    .toast-close {
        background: transparent;
        border: none;
        color: var(--ink-faint);
        cursor: pointer;
        font-size: 14px;
        padding: 4px;
        transition: color .2s;
    }

    .toast-close:hover { color: var(--ink); }

    /* ============================================
        RESPONSIVE
    ============================================ */
    @media (max-width: 900px) {
        .form-wrapper { grid-template-columns: 1fr; gap: 24px; }
        .form-nav { position: relative; top: 0; display: flex; overflow-x: auto; padding: 8px; gap: 8px; }
        .form-nav-item { white-space: nowrap; flex-shrink: 0; margin-bottom: 0; }
        .form-grid { grid-template-columns: 1fr; }
        .form-grid.triple { grid-template-columns: 1fr; }
    }

    @media (max-width: 600px) {
        .page { padding: 32px 16px 60px; }
        .section-body { padding: 24px; }
        .form-actions { flex-direction: column-reverse; padding: 20px; }
        .btn { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')
    <div class="page">
        <div class="breadcrumb">
            <a href="#">Profile</a>
            <span class="sep">/</span>
            <span>Edit Profile</span>
        </div>

        <div class="page-header">
            <h1>Edit Profile</h1>
            <p>Update your personal information and account settings</p>
        </div>

        <div class="form-wrapper">
            <nav class="form-nav">
                <button class="form-nav-item active" data-section="personal" onclick="switchSection('personal')">
                    <i class="fas fa-user"></i>
                    <span>Data Pribadi</span>
                </button>
                <button class="form-nav-item" data-section="education" onclick="switchSection('education')">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Pendidikan</span>
                </button>
                <button class="form-nav-item" data-section="experience" onclick="switchSection('experience')">
                    <i class="fas fa-briefcase"></i>
                    <span>Pengalaman</span>
                </button>
                <button class="form-nav-item" data-section="skills" onclick="switchSection('skills')">
                    <i class="fas fa-star"></i>
                    <span>Keterampilan</span>
                </button>
                <button class="form-nav-item" data-section="additional" onclick="switchSection('additional')">
                    <i class="fas fa-plus-circle"></i>
                    <span>Informasi Tambahan</span>
                </button>
                <button class="form-nav-item" data-section="preferences" onclick="switchSection('preferences')">
                    <i class="fas fa-sliders"></i>
                    <span>Preferensi</span>
                </button>
                <button class="form-nav-item" data-section="security" onclick="switchSection('security')">
                    <i class="fas fa-lock"></i>
                    <span>Keamanan</span>
                </button>
            </nav>

            <form class="form-content" id="profileForm" onsubmit="handleSubmit(event)">

                <div class="form-section active" data-section="personal">
                    <div class="section-header">
                        <h2>Data Pribadi</h2>
                        <p>Informasi dasar Anda yang akan tampil di profil dan CV</p>
                    </div>

                    <div class="section-body">
                        <div class="avatar-upload">
                            <div class="avatar-preview">
                                <div class="avatar-preview-img" id="avatarPreview">A</div>
                                <label class="avatar-badge">
                                    <input type="file" id="avatarInput" accept="image/*">
                                    <i class="fas fa-camera"></i>
                                </label>
                            </div>
                            <div class="avatar-info">
                                <h3>Foto Profil</h3>
                                <p>Format JPG atau PNG. Maksimal 2MB. Rekomendasi ukuran 400x400 piksel.</p>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary btn-small" onclick="document.getElementById('avatarInput').click()">
                                        <i class="fas fa-upload"></i> Upload
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-small" onclick="removeAvatar()">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="field-label">Nama Lengkap <span class="req">*</span></label>
                                <input type="text" class="field-input" name="full_name" value="Andi Pratama" placeholder="John Doe" required>
                            </div>
                            <div class="form-field">
                                <label class="field-label">Email <span class="req">*</span></label>
                                <input type="email" class="field-input" name="email" value="andi.pratama@email.com" placeholder="john@example.com" required>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="field-label">Nomor Telepon <span class="req">*</span></label>
                                <input type="tel" class="field-input" name="phone" value="+62 812 3456 7890" placeholder="+62 812 3456 7890" required>
                            </div>
                            <div class="form-field">
                                <label class="field-label">Tanggal Lahir <span class="req">*</span></label>
                                <input type="date" class="field-input" name="birth_date" value="1995-06-15" required>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="field-label">Kota <span class="req">*</span></label>
                                <input type="text" class="field-input" name="city" value="Jakarta" placeholder="Jakarta" required>
                            </div>
                            <div class="form-field">
                                <label class="field-label">Jenis Kelamin</label>
                                <select class="field-select" name="gender">
                                    <option>Pilih jenis kelamin</option>
                                    <option selected>Laki-laki</option>
                                    <option>Perempuan</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-grid single">
                            <div class="form-field">
                                <label class="field-label">Alamat Lengkap <span class="req">*</span></label>
                                <textarea class="field-textarea" name="address" placeholder="Jl. Contoh No. 123, Jakarta" required>Jl. Contoh No. 123, Jakarta Selatan</textarea>
                            </div>
                        </div>

                        <div class="form-grid single">
                            <div class="form-field">
                                <label class="field-label">Username</label>
                                <input type="text" class="field-input" name="username" value="andi_pratama" placeholder="username_anda">
                                <span class="field-hint">
                                    <i class="fas fa-info-circle"></i>
                                    URL profil Anda: resumate.com/u/andi_pratama
                                </span>
                            </div>
                        </div>

                        <div class="form-grid single">
                            <div class="form-field">
                                <label class="field-label">Ringkasan Profil <span class="req">*</span></label>
                                <textarea class="field-textarea" name="summary" placeholder="Ceritakan tentang diri Anda, keahlian, dan tujuan karir..." required>Software engineer dengan pengalaman 5+ tahun dalam pengembangan web. Bersemangat dalam membangun aplikasi yang skalabel dan membimbing developer junior.</textarea>
                                <span class="field-hint">
                                    <i class="fas fa-info-circle"></i>
                                    Tuliskan 2–3 kalimat yang menggambarkan diri Anda secara profesional
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

                <div class="form-section" data-section="education">
                    <div class="section-header">
                        <h2>Pendidikan</h2>
                        <p>Riwayat pendidikan Anda, mulai dari yang terbaru</p>
                    </div>

                    <div class="section-body">
                        <div id="educationContainer"></div>

                        <button type="button" class="btn-add-more" onclick="addEducation()">
                            <i class="fas fa-plus-circle"></i> Tambah Pendidikan
                        </button>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

                <div class="form-section" data-section="experience">
                    <div class="section-header">
                        <h2>Pengalaman Kerja</h2>
                        <p>Riwayat pekerjaan Anda, mulai dari yang terbaru</p>
                    </div>

                    <div class="section-body">
                        <div id="experienceContainer"></div>

                        <button type="button" class="btn-add-more" onclick="addExperience()">
                            <i class="fas fa-plus-circle"></i> Tambah Pengalaman
                        </button>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

                <div class="form-section" data-section="skills">
                    <div class="section-header">
                        <h2>Keterampilan</h2>
                        <p>Tambahkan keterampilan teknis dan soft skill yang Anda kuasai</p>
                    </div>

                    <div class="section-body">
                        <div class="form-grid single" style="margin-bottom: 0;">
                            <div class="form-field">
                                <label class="field-label">Keterampilan Teknis <span class="req">*</span></label>
                                <div class="tags-input" onclick="document.getElementById('technicalSkillInput').focus()">
                                    <span class="tag-item">JavaScript <i class="fas fa-times tag-remove" onclick="removeTag(this)"></i></span>
                                    <span class="tag-item">React <i class="fas fa-times tag-remove" onclick="removeTag(this)"></i></span>
                                    <span class="tag-item">Node.js <i class="fas fa-times tag-remove" onclick="removeTag(this)"></i></span>
                                    <span class="tag-item">Python <i class="fas fa-times tag-remove" onclick="removeTag(this)"></i></span>
                                    <input type="text" class="tag-input-field" id="technicalSkillInput" placeholder="Ketik skill, tekan Enter...">
                                </div>
                                <span class="field-hint">
                                    <i class="fas fa-info-circle"></i>
                                    Contoh: JavaScript, Python, Adobe Photoshop, Project Management
                                </span>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="form-grid single" style="margin-bottom: 0;">
                            <div class="form-field">
                                <label class="field-label">Soft Skills <span class="opt">(Opsional)</span></label>
                                <div class="tags-input" onclick="document.getElementById('softSkillInput').focus()">
                                    <span class="tag-item">Leadership <i class="fas fa-times tag-remove" onclick="removeTag(this)"></i></span>
                                    <span class="tag-item">Komunikasi <i class="fas fa-times tag-remove" onclick="removeTag(this)"></i></span>
                                    <input type="text" class="tag-input-field" id="softSkillInput" placeholder="Ketik skill, tekan Enter...">
                                </div>
                                <span class="field-hint">
                                    <i class="fas fa-info-circle"></i>
                                    Contoh: Leadership, Communication, Problem Solving, Teamwork
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

                <div class="form-section" data-section="additional">
                    <div class="section-header">
                        <h2>Informasi Tambahan</h2>
                        <p>Lengkapi profil Anda dengan informasi tambahan yang memperkuat CV</p>
                    </div>

                    <div class="section-body">
                        <div class="form-grid single">
                            <div class="form-field">
                                <label class="field-label">LinkedIn <span class="opt">(Opsional)</span></label>
                                <input type="url" class="field-input" name="linkedin" value="https://linkedin.com/in/andipratama" placeholder="https://linkedin.com/in/username">
                            </div>
                        </div>

                        <div class="form-grid single">
                            <div class="form-field">
                                <label class="field-label">Portfolio Website <span class="opt">(Opsional)</span></label>
                                <input type="url" class="field-input" name="portfolio" value="https://andipratama.dev" placeholder="https://yourwebsite.com">
                                <span class="field-hint">
                                    <i class="fas fa-info-circle"></i>
                                    Link ke website portfolio atau karya Anda
                                </span>
                            </div>
                        </div>

                        <div class="form-grid single">
                            <div class="form-field">
                                <label class="field-label">GitHub <span class="opt">(Opsional)</span></label>
                                <input type="url" class="field-input" name="github" value="https://github.com/andipratama" placeholder="https://github.com/username">
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="form-grid single">
                            <div class="form-field">
                                <label class="field-label">Sertifikat & Penghargaan <span class="opt">(Opsional)</span></label>
                                <textarea class="field-textarea" name="certifications" placeholder="Tuliskan sertifikat atau penghargaan yang pernah Anda dapatkan (pisahkan dengan enter)"></textarea>
                                <span class="field-hint">
                                    <i class="fas fa-info-circle"></i>
                                    Contoh: AWS Certified Solutions Architect, Google Analytics Certification
                                </span>
                            </div>
                        </div>

                        <div class="form-grid single">
                            <div class="form-field">
                                <label class="field-label">Bahasa yang Dikuasai <span class="opt">(Opsional)</span></label>
                                <textarea class="field-textarea" name="languages" placeholder="Bahasa Indonesia - Native&#10;English - Fluent&#10;Mandarin - Intermediate"></textarea>
                                <span class="field-hint">
                                    <i class="fas fa-info-circle"></i>
                                    Tuliskan bahasa dan tingkat kemahiran (Native, Fluent, Intermediate, Basic)
                                </span>
                            </div>
                        </div>

                        <div class="form-grid single">
                            <div class="form-field">
                                <label class="field-label">Hobi & Minat <span class="opt">(Opsional)</span></label>
                                <input type="text" class="field-input" name="hobbies" placeholder="Fotografi, Traveling, Blogging">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

                <div class="form-section" data-section="preferences">
                    <div class="section-header">
                        <h2>Preferensi Akun</h2>
                        <p>Kelola preferensi dan notifikasi akun Anda</p>
                    </div>

                    <div class="section-body">
                        <div class="toggle-field">
                            <div class="toggle-label-wrap">
                                <div class="toggle-title">Notifikasi Email</div>
                                <div class="toggle-desc">Terima tips karir dan update template terbaru</div>
                            </div>
                            <label class="toggle">
                                <input type="checkbox" checked>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <div class="toggle-field">
                            <div class="toggle-label-wrap">
                                <div class="toggle-title">Tampilkan Statistik</div>
                                <div class="toggle-desc">Tampilkan jumlah CV dan unduhan di profil</div>
                            </div>
                            <label class="toggle">
                                <input type="checkbox" checked>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <div class="toggle-field">
                            <div class="toggle-label-wrap">
                                <div class="toggle-title">Email Pemasaran</div>
                                <div class="toggle-desc">Terima penawaran spesial dan promosi</div>
                            </div>
                            <label class="toggle">
                                <input type="checkbox">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <div class="divider"></div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="field-label">Bahasa Antarmuka</label>
                                <select class="field-select" name="language">
                                    <option>Bahasa Indonesia</option>
                                    <option selected>English</option>
                                    <option>Español</option>
                                    <option>Français</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label class="field-label">Zona Waktu</label>
                                <select class="field-select" name="timezone">
                                    <option selected>Asia/Jakarta (GMT+7)</option>
                                    <option>Asia/Singapore (GMT+8)</option>
                                    <option>America/New York (GMT-5)</option>
                                    <option>Europe/London (GMT+0)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

                <div class="form-section" data-section="security">
                    <div class="section-header">
                        <h2>Keamanan</h2>
                        <p>Kelola password dan keamanan akun Anda</p>
                    </div>

                    <div class="section-body">
                        <div class="form-grid single">
                            <div class="form-field">
                                <label class="field-label">Password Saat Ini <span class="req">*</span></label>
                                <input type="password" class="field-input" placeholder="Masukkan password saat ini">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="field-label">Password Baru</label>
                                <input type="password" class="field-input" placeholder="Minimal 8 karakter">
                            </div>
                            <div class="form-field">
                                <label class="field-label">Konfirmasi Password</label>
                                <input type="password" class="field-input" placeholder="Ulangi password baru">
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="toggle-field">
                            <div class="toggle-label-wrap">
                                <div class="toggle-title">Autentikasi Dua Faktor (2FA)</div>
                                <div class="toggle-desc">Tambahkan lapisan keamanan ekstra pada akun Anda</div>
                            </div>
                            <label class="toggle">
                                <input type="checkbox">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="toast" id="toast">
        <div class="toast-icon"><i class="fas fa-check"></i></div>
        <div class="toast-content">
            <div class="toast-title">Profil Berhasil Diperbarui</div>
            <div class="toast-text">Perubahan Anda telah tersimpan</div>
        </div>
        <button class="toast-close" onclick="hideToast()"><i class="fas fa-times"></i></button>
    </div>
@endsection

@push('scripts')
    <script>
        // ============================================================
        // SECTION SWITCHING
        // ============================================================
        function switchSection(sectionName) {
            document.querySelectorAll('.form-nav-item').forEach(item => item.classList.remove('active'));
            document.querySelector(`[data-section="${sectionName}"].form-nav-item`).classList.add('active');
            document.querySelectorAll('.form-section').forEach(section => section.classList.remove('active'));
            document.querySelector(`.form-section[data-section="${sectionName}"]`).classList.add('active');
        }

        // ============================================================
        // AVATAR UPLOAD
        // ============================================================
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('avatarPreview');
                    preview.style.backgroundImage = `url(${event.target.result})`;
                    preview.textContent = '';
                };
                reader.readAsDataURL(file);
            }
        });

        function removeAvatar() {
            const preview = document.getElementById('avatarPreview');
            preview.style.backgroundImage = '';
            preview.textContent = 'A';
            document.getElementById('avatarInput').value = '';
        }

        // ============================================================
        // TAGS (SKILLS)
        // ============================================================
        document.getElementById('technicalSkillInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const skill = this.value.trim();
                if (skill) { addTag(skill, this); this.value = ''; }
            }
        });

        document.getElementById('softSkillInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const skill = this.value.trim();
                if (skill) { addTag(skill, this); this.value = ''; }
            }
        });

        function addTag(text, inputField) {
            const container = inputField.closest('.tags-input');
            const tag = document.createElement('span');
            tag.className = 'tag-item';
            tag.innerHTML = `${text} <i class="fas fa-times tag-remove" onclick="removeTag(this)"></i>`;
            container.insertBefore(tag, inputField);
        }

        function removeTag(element) {
            element.parentElement.remove();
        }

        // ============================================================
        // EDUCATION (DENGAN FIX BUG "SEKARANG")
        // ============================================================
        let educationCount = 0;

        function addEducation() {
            const container = document.getElementById('educationContainer');
            const index = educationCount++;
            const isFirst = index === 0;

            const html = `
                <div class="dynamic-item" data-edu-index="${index}">
                    <div class="dynamic-item-header">
                        <h3 class="dynamic-item-title">Pendidikan #${index + 1}</h3>
                        ${!isFirst ? `<button type="button" class="btn-remove-item" onclick="removeEducation(${index})"><i class="fas fa-trash"></i> Hapus</button>` : ''}
                    </div>
                    <div class="form-grid">
                        <div class="form-field">
                            <label class="field-label">Institusi <span class="req">*</span></label>
                            <input type="text" class="field-input" name="education_institution[]" placeholder="Universitas Indonesia" ${isFirst ? 'value="Universitas Indonesia"' : ''}>
                        </div>
                        <div class="form-field">
                            <label class="field-label">Gelar / Jurusan <span class="req">*</span></label>
                            <input type="text" class="field-input" name="education_degree[]" placeholder="S1 Teknik Informatika" ${isFirst ? 'value="S1 Teknik Informatika"' : ''}>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-field">
                            <label class="field-label">Tahun Mulai <span class="req">*</span></label>
                            <input type="number" class="field-input" name="education_start[]" placeholder="2013" min="1950" max="2030" ${isFirst ? 'value="2013"' : ''}>
                        </div>
                        <div class="form-field">
                            <label class="field-label">Tahun Selesai</label>
                            <input type="number" class="field-input" name="education_end[]" placeholder="2017" min="1950" max="2030" id="eduEnd${index}">
                        </div>
                    </div>
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="currentEdu${index}" onchange="toggleEduEnd(${index})" ${isFirst ? 'checked' : ''}>
                        <label for="currentEdu${index}">Saat ini masih berkuliah di sini</label>
                    </div>
                    <div class="form-grid single" style="margin-bottom:0;">
                        <div class="form-field">
                            <label class="field-label">Deskripsi <span class="opt">(Opsional)</span></label>
                            <textarea class="field-textarea" name="education_description[]" placeholder="IPK, prestasi, organisasi..." style="min-height:80px;">${isFirst ? 'IPK 3.8 / 4.0. Aktif di organisasi Himpunan Mahasiswa.' : ''}</textarea>
                        </div>
                    </div>
                </div>`;

            container.insertAdjacentHTML('beforeend', html);

            // Terapkan Fix Tipe Input "text" jika diceklis
            if (isFirst) {
                const input = document.getElementById(`eduEnd${index}`);
                input.type = 'text'; 
                input.value = 'Sekarang';
                input.disabled = true;
            }
        }

        function removeEducation(index) {
            document.querySelector(`#educationContainer .dynamic-item[data-edu-index="${index}"]`).remove();
        }

        function toggleEduEnd(index) {
            const cb = document.getElementById(`currentEdu${index}`);
            const input = document.getElementById(`eduEnd${index}`);
            
            if (cb.checked) {
                input.type = 'text'; // Ubah tipe input ke teks
                input.value = 'Sekarang';
                input.disabled = true;
            } else {
                input.type = 'number'; // Kembalikan ke angka
                input.value = '';
                input.disabled = false;
            }
        }

        // ============================================================
        // EXPERIENCE (DENGAN FIX BUG "SEKARANG")
        // ============================================================
        let experienceCount = 0;

        function addExperience() {
            const container = document.getElementById('experienceContainer');
            const index = experienceCount++;
            const isFirst = index === 0;

            const html = `
                <div class="dynamic-item" data-exp-index="${index}">
                    <div class="dynamic-item-header">
                        <h3 class="dynamic-item-title">Pengalaman #${index + 1}</h3>
                        ${!isFirst ? `<button type="button" class="btn-remove-item" onclick="removeExperience(${index})"><i class="fas fa-trash"></i> Hapus</button>` : ''}
                    </div>
                    <div class="form-grid">
                        <div class="form-field">
                            <label class="field-label">Perusahaan <span class="req">*</span></label>
                            <input type="text" class="field-input" name="experience_company[]" placeholder="PT. Teknologi Indonesia" ${isFirst ? 'value="Tech Indonesia"' : ''}>
                        </div>
                        <div class="form-field">
                            <label class="field-label">Posisi / Jabatan <span class="req">*</span></label>
                            <input type="text" class="field-input" name="experience_position[]" placeholder="Software Engineer" ${isFirst ? 'value="Software Engineer"' : ''}>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-field">
                            <label class="field-label">Bulan & Tahun Mulai <span class="req">*</span></label>
                            <input type="month" class="field-input" name="experience_start[]" ${isFirst ? 'value="2019-03"' : ''}>
                        </div>
                        <div class="form-field">
                            <label class="field-label">Bulan & Tahun Selesai</label>
                            <input type="month" class="field-input" name="experience_end[]" id="expEnd${index}">
                        </div>
                    </div>
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="currentWork${index}" onchange="toggleExpEnd(${index})" ${isFirst ? 'checked' : ''}>
                        <label for="currentWork${index}">Saat ini masih bekerja di sini</label>
                    </div>
                    <div class="form-grid single" style="margin-bottom:0;">
                        <div class="form-field">
                            <label class="field-label">Deskripsi Pekerjaan <span class="req">*</span></label>
                            <textarea class="field-textarea" name="experience_description[]" placeholder="Jelaskan tugas, tanggung jawab, dan pencapaian Anda..." style="min-height:120px;">${isFirst ? 'Mengembangkan dan memelihara aplikasi web skala besar menggunakan React dan Node.js. Memimpin tim 4 orang untuk menyelesaikan proyek migrasi sistem yang berhasil mengurangi waktu loading 40%.' : ''}</textarea>
                            <span class="field-hint"><i class="fas fa-info-circle"></i> Gunakan poin-poin untuk menjelaskan pencapaian Anda</span>
                        </div>
                    </div>
                </div>`;

            container.insertAdjacentHTML('beforeend', html);

            // Terapkan Fix Tipe Input "text" jika diceklis
            if (isFirst) {
                const input = document.getElementById(`expEnd${index}`);
                input.type = 'text'; 
                input.value = 'Sekarang';
                input.disabled = true;
            }
        }

        function removeExperience(index) {
            document.querySelector(`#experienceContainer .dynamic-item[data-exp-index="${index}"]`).remove();
        }

        function toggleExpEnd(index) {
            const cb = document.getElementById(`currentWork${index}`);
            const input = document.getElementById(`expEnd${index}`);
            
            if (cb.checked) {
                input.type = 'text'; // Ubah tipe input ke teks
                input.value = 'Sekarang';
                input.disabled = true;
            } else {
                input.type = 'month'; // Kembalikan ke format bulan
                input.value = '';
                input.disabled = false;
            }
        }

        // ============================================================
        // INIT
        // ============================================================
        window.addEventListener('DOMContentLoaded', () => {
            addEducation();
            addExperience();
        });

        // ============================================================
        // FORM SUBMISSION
        // ============================================================
        function handleSubmit(e) {
            e.preventDefault();
            showToast();
        }

        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('show');
            setTimeout(hideToast, 3000);
        }

        function hideToast() {
            document.getElementById('toast').classList.remove('show');
        }
    </script>
@endpush