@extends('layouts.app')

@section('title', 'Katalog Templates - CV Builder')

@push('styles')
<style>
    /* --- Page Header --- */
    .page-header { background: var(--bg-body); padding: 80px 0 60px; text-align: center; border-bottom: 1px solid var(--border-color); }
    .page-header h1 { font-size: 36px; font-weight: 700; color: var(--text-main); margin-bottom: 16px; }
    .page-header h1 span { color: var(--primary-color); }
    .page-header p { color: var(--text-secondary); font-size: 16px; max-width: 700px; margin: 0 auto; line-height: 1.6; }

    /* --- Filter Navigation --- */
    .filter-section { background: var(--bg-card); padding: 20px 0; position: sticky; top: 70px; z-index: 900; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border-bottom: 1px solid var(--border-color); backdrop-filter: blur(10px); }
    .filter-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }
    .filter-btn { padding: 10px 24px; border-radius: 30px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-secondary); font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
    .filter-btn:hover { border-color: var(--primary-color); color: var(--primary-color); }
    .filter-btn.active { background: var(--primary-color); color: white; border-color: var(--primary-color); box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2); }

    /* --- Templates Grid --- */
    .templates-section { background: var(--bg-body); padding: 60px 0 100px; min-height: 600px; }
    .templates-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; }
    .templates-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 32px; }

    /* --- Template Card --- */
    .template-card { background: var(--bg-card); border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); transition: all 0.3s ease; position: relative; border: 1px solid var(--border-color); animation: fadeIn 0.5s ease forwards; display: flex; flex-direction: column; }
    .template-card:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); border-color: var(--primary-color); }
    
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    /* Preview Image */
    .template-preview { width: 100%; height: 400px; background: #f1f5f9; position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid var(--border-color); }
    .template-preview img { width: 100%; height: 100%; object-fit: cover; object-position: top; transition: transform 0.5s ease; }
    .template-card:hover .template-preview img { transform: scale(1.05); }
    .template-preview-placeholder { display: flex; flex-direction: column; align-items: center; color: #cbd5e1; }

    /* --- BADGES SYSTEM --- */
    
    /* Wrapper Kanan Atas (Status New & Type) */
    .badges-right { 
        position: absolute; top: 16px; right: 16px; 
        display: flex; flex-direction: column; gap: 6px; 
        z-index: 2; align-items: flex-end; 
    }

    /* Badge Kiri Atas (Kategori) */
    .badge-category {
        position: absolute; top: 16px; left: 16px; z-index: 2;
        background: rgba(0, 0, 0, 0.6); color: white;
        padding: 6px 12px; border-radius: 8px;
        font-size: 11px; font-weight: 600; 
        text-transform: capitalize; /* Huruf depan besar */
        backdrop-filter: blur(4px);
    }

    /* Styling Badge Umum */
    .t-badge { 
        padding: 6px 14px; border-radius: 8px; font-size: 11px; font-weight: 700; 
        text-transform: uppercase; box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        backdrop-filter: blur(4px); letter-spacing: 0.5px;
    }
    
    .t-badge.new { background: #3B82F6; color: white; } /* Biru */
    .t-badge.premium { background: #F59E0B; color: white; } /* Orange */
    .t-badge.free { background: rgba(255, 255, 255, 0.95); color: #1e293b; } /* Putih */

    /* Info */
    .template-info { padding: 24px; flex-grow: 1; display: flex; flex-direction: column; }
    .template-info h3 { font-size: 18px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; }
    .template-info p { font-size: 14px; color: var(--text-secondary); margin-bottom: 20px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    /* Meta & Actions */
    .template-meta { display: flex; align-items: center; justify-content: space-between; padding-top: 16px; border-top: 1px solid var(--border-color); margin-top: auto; }
    .template-stats { display: flex; gap: 16px; font-size: 13px; color: var(--text-secondary); font-weight: 500; }
    .template-stats i { color: #94a3b8; margin-right: 4px; }
    
    .template-action { color: var(--primary-color); font-size: 14px; font-weight: 700; text-decoration: none; transition: 0.3s; display: flex; align-items: center; gap: 6px; padding: 8px 16px; background: rgba(76, 175, 80, 0.1); border-radius: 8px; }
    .template-action:hover { background: var(--primary-color); color: white; }

    @media (max-width: 1024px) { .templates-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) { .templates-grid { grid-template-columns: 1fr; } .filter-container { padding: 0 20px; gap: 8px; } .filter-btn { padding: 8px 16px; font-size: 13px; } }
</style>
@endpush

    @section('content')
    <header class="page-header">
        <div class="templates-container">
            <div style="display: inline-block; background: var(--bg-card); padding: 8px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; color: var(--primary-color); margin-bottom: 16px; border: 1px solid var(--border-color);">
                <i class="fas fa-th-large" style="margin-right: 6px;"></i> Katalog Template
            </div>
            <h1>Pilih Template <span>Terbaik Anda</span></h1>
            <p>Semua template kami dirancang agar ramah terhadap sistem ATS (Applicant Tracking System) dan mudah dibaca oleh rekruter.</p>
        </div>
    </header>

    <div class="filter-section">
        <div class="filter-container">
            <button class="filter-btn active" data-filter="all">Semua Desain</button>
            <button class="filter-btn" data-filter="Professional">Professional</button>
            <button class="filter-btn" data-filter="Creative">Creative</button>
            <button class="filter-btn" data-filter="Simple">Simple</button>
            <button class="filter-btn" data-filter="Akademik">Akademik</button>
        </div>
    </div>

    <section class="templates-section">
        <div class="templates-container">
            <div class="templates-grid" id="templatesGrid">
                
                @forelse($templates as $item)
                    @php
                        // Logic: Ambil nama kategori untuk badge (string)
                        $catName = is_array($item->category) ? ($item->category[0] ?? 'General') : $item->category;
                        
                        // Logic: Gabung kategori untuk filter data attribute
                        $catString = is_array($item->category) ? implode(' ', $item->category) : $item->category;

                        // LOGIKA PINTAR UNTUK REDIRECT URL
                        // Terkunci JIKA: Template ini PRO, DAN (User belum login ATAU User login tapi paketnya bukan premium)
                        $isLocked = $item->type == 'pro' && (!auth()->check() || !auth()->user()->is_premium);
                        
                        // Tentukan URL tujuan berdasarkan status terkunci atau tidak
                        $targetUrl = $isLocked ? route('pricing') : route('template-detail', $item->slug);
                    @endphp

                    <!-- Terapkan URL dinamis di onclick -->
                    <div class="template-card" data-category="{{ strtolower($catString) }}" onclick="window.location.href='{{ $targetUrl }}'" style="cursor: pointer;">
                        
                        <div class="badge-category">
                            {{ $catName }}
                        </div>

                        <div class="badges-right">
                            
                            @if($item->is_new)
                                <div class="t-badge new">Terbaru</div>
                            @endif

                            @if($item->type == 'pro')
                                <div class="t-badge premium"><i class="fas fa-crown"></i> Premium</div>
                            @else
                                <div class="t-badge free">Gratis</div>
                            @endif
                        </div>

                        <div class="template-preview">
                            @if($item->thumbnail)
                                <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->name }}">
                            @else
                                <div class="template-preview-placeholder">
                                    <i class="fas fa-image" style="font-size: 48px; margin-bottom: 10px;"></i>
                                    <span class="template-preview-text">Preview {{ $item->name }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="template-info">
                            <h3>{{ $item->name }}</h3>
                            <p>{{ Str::limit($item->description, 60) }}</p>
                            
                            <div class="template-meta">
                                <div class="template-stats">
                                    <span title="Total Download">
                                        <i class="fas fa-arrow-down"></i> 
                                        @php
                                            $n = $item->total_downloads ?? 0;
                                            if ($n >= 1000000000) {
                                                $formatted = round($n / 1000000000, 1) . 'B';
                                            } elseif ($n >= 1000000) {
                                                $formatted = round($n / 1000000, 1) . 'M';
                                            } elseif ($n >= 1000) {
                                                $formatted = round($n / 1000, 1) . 'k';
                                            } else {
                                                $formatted = $n;
                                            }
                                        @endphp
                                        {{ $formatted }}
                                    </span>
                                    
                                    <span title="Rating">
                                        <i class="fas fa-star" style="color:#f59e0b;"></i> 
                                        @if($item->average_rating > 0)
                                            {{ number_format($item->average_rating, 1) }} 
                                            <span style="color: var(--text-muted); font-size: 11px;">({{ $item->rating_count }})</span>
                                        @else
                                            Baru
                                        @endif
                                    </span>
                                </div>
                                
                                <!-- Terapkan URL dan gaya visual dinamis di tombol aksi -->
                                @if($isLocked)
                                    <a href="{{ $targetUrl }}" class="template-action" style="color: #F59E0B; font-weight: 600;">
                                        Buka PRO <i class="fas fa-crown"></i>
                                    </a>
                                @else
                                    <a href="{{ $targetUrl }}" class="template-action">
                                        Gunakan <i class="fas fa-arrow-right"></i>
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 80px 20px; color: var(--text-secondary);">
                        <div style="background: var(--bg-card); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                            <i class="fas fa-box-open" style="font-size: 32px; opacity: 0.5;"></i>
                        </div>
                        <h3 style="margin-bottom: 8px; color: var(--text-main);">Belum ada template</h3>
                        <p>Silakan cek kembali nanti untuk koleksi terbaru kami.</p>
                    </div>
                @endforelse

            </div>

            <div id="emptyState" style="display: none; text-align: center; padding: 80px 20px;">
                <i class="fas fa-search" style="font-size: 40px; color: #ccc; margin-bottom: 16px;"></i>
                <p style="color: var(--text-secondary); font-size: 16px;">Tidak ada template yang cocok dengan filter ini.</p>
            </div>
        </div>
    </section>
    @endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.template-card');
        const emptyState = document.getElementById('emptyState');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // 1. Hapus state active dari semua tombol, berikan ke tombol yang diklik
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // 2. Ambil nilai filter dan ubah jadi HURUF KECIL (toLowerCase)
                const filter = this.getAttribute('data-filter').toLowerCase();
                let found = 0;

                // 3. Looping semua kartu
                cards.forEach(card => {
                    const categories = card.getAttribute('data-category'); // ini sudah huruf kecil dari Blade
                    
                    // Reset animasi
                    card.style.animation = 'none';
                    card.offsetHeight; 
                    
                    // 4. Pencocokan (keduanya sekarang sudah sama-sama huruf kecil)
                    if (filter === 'all' || categories.includes(filter)) {
                        card.style.display = 'flex';
                        card.style.animation = 'fadeIn 0.5s ease forwards';
                        found++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // 5. Tampilkan Empty State jika tidak ada yang cocok
                if (found === 0) {
                    emptyState.style.display = 'block';
                } else {
                    emptyState.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush