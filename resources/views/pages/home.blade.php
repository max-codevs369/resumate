@extends('layouts.app')

@push('styles')
<script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.11/dist/dotlottie-wc.js" type="module"></script>
<style>
    /* Hero Section */
    .hero-section { background: var(--bg-body); padding: 80px 0 100px; }
    .hero-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
    .hero-text h1 { font-size: 40px; font-weight: 600; line-height: 1.3; color: var(--text-main); margin-bottom: 20px; }
    .hero-text h1 .green-text { color: var(--primary-color); }
    .hero-text p { font-size: 16px; line-height: 1.7; color: var(--text-secondary); margin-bottom: 30px; }

    /* Stats Section */
    .stats-section { background: var(--bg-card); padding: 80px 0; position: relative; border-bottom: 1px solid var(--border-color); }
    .stats-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; }
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
    .stat-item { background: var(--bg-card); padding: 32px 24px; border-radius: 12px; border: 1px solid var(--border-color); position: relative; overflow: hidden; transition: all 0.3s ease; }
    .stat-item:hover { transform: translateY(-4px); border-color: var(--primary-color); box-shadow: 0 8px 24px rgba(76, 175, 80, 0.12); }
    .stat-icon { width: 48px; height: 48px; background: var(--feature-icon-bg); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; color: var(--primary-color); font-size: 20px; }
    .stat-item h3 { font-size: 42px; font-weight: 700; color: var(--text-main); margin-bottom: 4px; line-height: 1; }
    .stat-item h3 span { color: var(--primary-color); }
    .stat-item p { font-size: 15px; color: var(--text-secondary); font-weight: 500; }

    /* Popular Templates Section */
    .popular-templates-section { background: var(--bg-card); padding: 100px 0; }
    .templates-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; }
    .templates-header { text-align: center; margin-bottom: 60px; }
    .templates-header .section-tag { display: inline-block; background: var(--bg-card); padding: 8px 20px; border-radius: 20px; font-size: 14px; font-weight: 600; color: var(--primary-color); margin-bottom: 16px; border: 1px solid var(--border-color); }
    .templates-header h2 { font-size: 36px; font-weight: 600; color: var(--text-main); margin-bottom: 12px; }
    .templates-header p { font-size: 16px; color: var(--text-secondary); max-width: 600px; margin: 0 auto; }
    .templates-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
    .template-card { background: var(--bg-card); border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px var(--shadow-color); transition: all 0.3s ease; position: relative; cursor: pointer; border: 1px solid var(--border-color); display: flex; flex-direction: column; }
    .template-card:hover { transform: translateY(-8px); box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12); }
    
    /* PERBAIKAN: Tinggi (height) diubah dari 380px menjadi 460px agar lebih portrait */
    .template-preview { width: 100%; height: 460px; background: var(--template-preview-bg); position: relative; display: flex; align-items: center; justify-content: center; }
    .template-preview::before { content: ''; position: absolute; top: 20px; left: 20px; right: 20px; bottom: 20px; background: var(--bg-card); border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    
    .template-preview-text { position: relative; z-index: 1; font-size: 14px; color: var(--text-secondary); font-weight: 500; }
    .template-badge { position: absolute; top: 16px; right: 16px; background: var(--primary-color); color: white; padding: 6px 14px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; z-index: 2; }
    .template-badge.premium { background: linear-gradient(135deg, #FFB74D, #FF9800); }
    .template-badge.new { background: linear-gradient(135deg, #42A5F5, #2196F3); }
    .template-info { padding: 24px; flex: 1; display: flex; flex-direction: column; }
    .template-info h3 { font-size: 20px; font-weight: 600; color: var(--text-main); margin-bottom: 8px; }
    .template-info p { font-size: 14px; color: var(--text-secondary); margin-bottom: 16px; line-height: 1.5; flex: 1; }
    .template-meta { display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid var(--border-color); margin-top: auto; }
    .template-stats { display: flex; gap: 16px; font-size: 13px; color: var(--text-secondary); }
    .template-stats i { color: var(--primary-color); }
    .template-action { color: var(--primary-color); font-size: 14px; font-weight: 600; text-decoration: none; }
    .view-all-templates { text-align: center; margin-top: 48px; }

    /* Features Section */
    .features-section { background: var(--bg-body); padding: 80px 0; }
    .features-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; }
    .section-header h2 { color: var(--text-main); }
    .section-header p { color: var(--text-secondary); }
    .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; }
    .feature-card { background: var(--bg-card); padding: 40px 30px; border-radius: 8px; text-align: center; box-shadow: 0 2px 8px var(--shadow-color); transition: all 0.3s; border: 1px solid var(--border-color); }
    .feature-card:hover { transform: translateY(-5px); box-shadow: 0 4px 16px rgba(0,0,0,0.1); }
    .feature-icon { width: 80px; height: 80px; background: var(--feature-icon-bg); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 36px; color: var(--primary-color); }
    .feature-card h3 { font-size: 20px; font-weight: 600; color: var(--text-main); margin-bottom: 12px; }
    .feature-card p { font-size: 15px; line-height: 1.6; color: var(--text-secondary); }

    /* CTA Section */
    .cta-section { background: var(--primary-color); padding: 80px 0; text-align: center; color: white; }
    .cta-container { max-width: 800px; margin: 0 auto; padding: 0 40px; }
    .cta-section h2 { font-size: 40px; font-weight: 600; margin-bottom: 16px; color: white; }
    .cta-section p { font-size: 18px; margin-bottom: 30px; opacity: 0.95; color: white; }

    /* Responsive */
    @media (max-width: 968px) {
        .hero-container { grid-template-columns: 1fr; gap: 40px; text-align: center; }
        .hero-text { order: 1; }
        .hero-image { order: 0; }
        .stats-grid, .features-grid, .templates-grid { grid-template-columns: 1fr; }
        .hero-text h1 { font-size: 32px; }
        .section-header h2 { font-size: 28px; }
    }
</style>
@endpush

@section('content')
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-text">
            <h1>
                CV Profesional. Cepat. Mudah.<br>
                <span class="green-text">Buat CV online dengan template modern dan siap dikirim hari ini.</span>
            </h1>
            <p>
                Template CV standar yang kami sediakan tidak hanya menarik dan terlihat profesional di mata recruiter.
            </p>
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard.index') : route('user.dashboard') }}" class="btn-primary">Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn-primary">Buat CV Sekarang</a>
            @endauth
        </div>
        <div class="hero-image">
            <dotlottie-wc src="https://lottie.host/ee77332b-036d-4be7-9c09-4f003c7779e9/Ordur40Cqu.lottie" style="width: 300px;height: 300px" autoplay loop></dotlottie-wc>
        </div>
    </div>
</section>

<section class="stats-section">
    <div class="stats-container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <h3><span>{{ $userCount }}</span>+</h3>
                <p>Pengguna Terdaftar</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                <!-- DATA DINAMIS: JUMLAH TEMPLATE -->
                <h3><span>{{ $templateCount }}</span>+</h3>
                <p>Template Tersedia</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-smile"></i></div>
                <h3><span>{{ $userSatisfaction }}</span>%</h3>
                <p>Kepuasan User</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-headset"></i></div>
                <h3><span>24</span>/7</h3>
                <p>Customer Support</p>
            </div>
        </div>
    </div>
</section>

<section class="popular-templates-section" id="templates">
    <div class="templates-container">
        <div class="templates-header">
            <div class="section-tag"><i class="fas fa-star"></i> Template Populer</div>
            <h2>Template CV Paling Direkomendasikan</h2>
            <p>Pilih dari template yang telah terbukti meningkatkan peluang diterima kerja hingga 3x lipat</p>
        </div>

        <div class="templates-grid">
    @forelse($popularTemplates as $template)
    
    @php
        $isLocked = $template->type == 'pro' && (!auth()->check() || !auth()->user()->is_premium);
        
        $targetUrl = $isLocked ? route('pricing') : route('template-detail', $template->slug ?? $template->id);
    @endphp

    <div class="template-card" onclick="window.location.href='{{ $targetUrl }}'" style="cursor: pointer;">
            
            @if($template->type == 'pro')
                <div class="template-badge premium">Premium</div>
            @else
                <div class="template-badge new">Gratis</div>
            @endif

            <div class="template-preview">
                <img src="{{ asset('storage/' . $template->thumbnail) }}" alt="{{ $template->name }}" style="width: calc(100% - 40px); height: calc(100% - 40px); object-fit: contain; background-color: #ffffff; border-radius: 8px; position: relative; z-index: 1; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            </div>
            
            <div class="template-info">
                <h3>{{ $template->name }}</h3>
                <p>{{ Str::limit($template->description, 60) ?: 'Template profesional siap pakai.' }}</p>
                <div class="template-meta">
                    <div class="template-stats">
                        <span><i class="fas fa-tags"></i> {{ $template->category }}</span>
                    </div>
                    
                    @if($isLocked)
                        <a href="{{ $targetUrl }}" class="template-action" style="color: #F59E0B; font-weight: 600;">
                            Buka PRO <i class="fas fa-crown"></i>
                        </a>
                    @else
                        @if($template->type == 'pro' && auth()->check() && !auth()->user()->is_premium || $template->type == 'pro' && !auth()->check())
                            <a href="{{ $targetUrl }}" class="template-action" style="color: #F59E0B; font-weight: 600;">
                                Lihat PRO <i class="fas fa-crown"></i>
                            </a>
                        @else
                            <a href="{{ $targetUrl }}" class="template-action">
                                Lihat <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif
                    @endif
                    
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--text-secondary);">
            <i class="fas fa-box-open" style="font-size: 40px; margin-bottom: 15px; opacity: 0.5;"></i>
            <p>Belum ada template yang dipublish.</p>
        </div>
        @endforelse
    </div>

        <div class="view-all-templates">
            <a href="{{ route('templates') }}" class="btn-outline">Lihat Semua Template <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<section class="features-section" id="features">
    <div class="features-container">
        <div class="section-header" style="text-align: center; margin-bottom: 60px;">
            <h2>Kenapa Memilih CV Builder?</h2>
            <p>Fitur lengkap untuk membuat CV profesional dengan mudah</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-file-alt"></i></div>
                <h3>Template Modern</h3>
                <p>Ratusan template profesional yang dirancang khusus untuk berbagai industri.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                <h3>Cepat & Mudah</h3>
                <p>Buat CV dalam 10 menit dengan interface yang intuitif.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-palette"></i></div>
                <h3>Kustomisasi Penuh</h3>
                <p>Ubah warna, font, dan layout sesuai keinginan Anda.</p>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="cta-container">
        <h2>Siap Membuat CV Profesional?</h2>
        <p>Bergabunglah dengan ribuan profesional yang telah berhasil mendapatkan pekerjaan impian</p>
        @auth
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard.index') : route('user.dashboard') }}" class="btn-white">Mulai Sekarang →</a>
        @else
            <a href="{{ route('register') }}" class="btn-white">Mulai Sekarang →</a>
        @endauth
    </div>
</section>
@endsection