@extends('layouts.app')

@section('title', 'Dashboard User')

@push('styles')
    <style>
        :root {
            --primary-color: #10b981;
            --primary-hover: #059669;
            --primary-light: #ecfdf5;
            --bg-body: #f9fafb;
            --bg-card: #ffffff;
            --text-main: #111827;
            --text-secondary: #6b7280;
            --text-muted: #9ca3af;
            --border-color: #e5e7eb;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --accent-blue: #3b82f6;
            --accent-purple: #8b5cf6;
            --accent-orange: #f97316;
        }

        [data-theme="dark"] {
            --primary-color: #10b981;
            --primary-hover: #34d399;
            --primary-light: #134e4a;
            --bg-body: #111827;
            --bg-card: #1f2937;
            --text-main: #f9fafb;
            --text-secondary: #9ca3af;
            --text-muted: #6b7280;
            --border-color: #374151;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.4);
        }

        .dashboard-container { max-width: 1400px; margin: 0 auto; padding: 40px 32px; font-family: 'Inter', sans-serif; }
        .dashboard-header { margin-bottom: 40px; }
        .dashboard-title { font-family: 'Sora', sans-serif; font-size: 32px; font-weight: 800; color: var(--text-main); margin-bottom: 8px; }
        .dashboard-subtitle { color: var(--text-secondary); font-size: 16px; }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 40px; }
        .stat-card { background: var(--bg-card); border-radius: 16px; padding: 24px; box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); transition: all 0.3s ease; position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--accent-color), transparent); opacity: 0; transition: opacity 0.3s ease; }
        .stat-card:hover::before { opacity: 1; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
        .stat-card.blue { --accent-color: var(--accent-blue); }
        .stat-card.purple { --accent-color: var(--accent-purple); }
        .stat-card.orange { --accent-color: var(--accent-orange); }

        .stat-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; }
        .stat-badge { background: var(--primary-light); color: var(--primary-color); padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .stat-value { font-family: 'Sora', sans-serif; font-size: 36px; font-weight: 800; color: var(--text-main); margin-bottom: 4px; }
        .stat-label { color: var(--text-secondary); font-size: 14px; font-weight: 500; }

        .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 40px; align-items: start; }
        
        .left-column { display: flex; flex-direction: column; gap: 24px; }
        .right-column { display: flex; flex-direction: column; gap: 24px; }

        .card { background: var(--bg-card); border-radius: 16px; padding: 28px; box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); transition: all 0.3s ease; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); }
        .card-title { font-family: 'Sora', sans-serif; font-size: 20px; font-weight: 700; color: var(--text-main); }
        .card-action { color: var(--primary-color); text-decoration: none; font-size: 14px; font-weight: 600; transition: all 0.2s ease; }
        .card-action:hover { color: var(--primary-hover); text-decoration: underline; }

        .cv-list { display: flex; flex-direction: column; gap: 16px; }
        .cv-item { display: flex; gap: 16px; padding: 16px; border-radius: 12px; border: 1px solid var(--border-color); transition: all 0.3s ease; }
        .cv-item:hover { background: var(--bg-body); border-color: var(--primary-color); transform: translateX(4px); }
        .cv-preview { width: 80px; height: 100px; border-radius: 8px; background: linear-gradient(135deg, var(--primary-light) 0%, var(--bg-body) 100%); border: 2px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-size: 32px; color: var(--primary-color); flex-shrink: 0; overflow: hidden; }
        .cv-info { flex: 1; display: flex; flex-direction: column; justify-content: center; }
        .cv-name { font-weight: 600; font-size: 16px; color: var(--text-main); margin-bottom: 6px; }
        .cv-meta { display: flex; gap: 16px; font-size: 13px; color: var(--text-secondary); margin-bottom: 8px; flex-wrap: wrap;}
        .cv-meta span { display: flex; align-items: center; gap: 4px; }
        
        .cv-tags { display: flex; gap: 6px; flex-wrap: wrap; }
        .cv-tag { background: var(--primary-light); color: var(--primary-color); padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        
        .cv-actions { display: flex; flex-direction: column; gap: 8px; justify-content: center; }
        .cv-btn { padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; border: none; text-decoration: none; text-align: center; }
        .cv-btn-primary { background: var(--primary-color); color: white; }
        .cv-btn-primary:hover { background: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2); }
        .cv-btn-secondary { background: transparent; color: var(--text-secondary); border: 1px solid var(--border-color); }
        .cv-btn-secondary:hover { background: var(--bg-body); color: var(--text-main); border-color: var(--text-muted); }

        .templates-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 16px; }
        .template-card { background: var(--bg-card); border-radius: 12px; padding: 12px; border: 1px solid var(--border-color); text-align: center; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: block; }
        .template-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: var(--primary-color); }
        .template-preview { width: 100%; height: 120px; border-radius: 8px; margin-bottom: 12px; background: var(--bg-body); display: flex; align-items: center; justify-content: center; font-size: 28px; color: var(--text-muted); overflow: hidden; border: 1px solid var(--border-color); }
        .template-name { font-weight: 600; font-size: 13px; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        @media (max-width: 1024px) { .main-grid { grid-template-columns: 1fr; } }
        @media (max-width: 768px) {
            .dashboard-container { padding: 24px 16px; }
            .stats-grid { grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 16px; }
            .stat-value { font-size: 28px; }
            .card { padding: 20px; }
            .cv-item { flex-direction: column; }
            .cv-actions { flex-direction: row; }
            .cv-actions .cv-btn { flex: 1; }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Hai, {{ auth()->user()->name ?? 'Guest' }}! </h1>
            <p class="dashboard-subtitle">Cek perkembangan CV kamu hari ini, yuk!</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card blue">
                <div class="stat-header">
                    <div class="stat-icon" style="background: var(--accent-blue);"><i class="fas fa-file-alt"></i></div>
                    <span class="stat-badge">Total CV</span>
                </div>
                <div class="stat-value">{{ $totalMyCv ?? 0 }}</div>
                <div class="stat-label">Dokumen dibuat</div>
            </div>

            <div class="stat-card purple">
                <div class="stat-header">
                    <div class="stat-icon" style="background: var(--accent-purple);"><i class="fas fa-download"></i></div>
                    <span class="stat-badge">Aktivitas</span>
                </div>
               <div class="stat-value">
                    @php
                        $n = $totalMyDownloads ?? 0;
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
                </div>
                <div class="stat-label">Total diunduh</div>
            </div>

            <div class="stat-card orange">
                <div class="stat-header">
                    <div class="stat-icon" style="background: var(--accent-orange);"><i class="fas fa-palette"></i></div>
                    <span class="stat-badge">Katalog</span>
                </div>
                <div class="stat-value">{{ $availableTemplates ?? 0 }}</div>
                <div class="stat-label">Template Siap Pakai</div>
            </div>
        </div>

        <div class="main-grid">
            
            <div class="left-column">
                
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><i class="fas fa-check-circle" style="color: var(--primary-color); margin-right: 8px;"></i> Dokumen Selesai</h2>
                        <a href="{{ route('user.resumes', ['status' => 'completed'])}}" class="card-action">Lihat Semua →</a>
                    </div>

                    <div class="cv-list">
                        @forelse($completedCvs ?? [] as $cv)
                            <div class="cv-item">
                                <div class="cv-preview">
                                    @if($cv->template && $cv->template->thumbnail)
                                        <img src="{{ asset('storage/' . $cv->template->thumbnail) }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-file-invoice"></i>
                                    @endif
                                </div>
                                <div class="cv-info">
                                    <div class="cv-name">{{ $cv->title ?? 'Untitled CV' }}</div>
                                    <div class="cv-meta">
                                        <span><i class="fas fa-clock"></i> Diselesaikan {{ $cv->updated_at->diffForHumans() }}</span>
                                        <span>
                                            <i class="fas fa-download"></i> 
                                            @php
                                                $n = $cv->downloads ?? 0;
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
                                            {{ $formatted }} unduhan
                                        </span>
                                    </div>
                                    <div class="cv-tags">
                                        <span class="cv-tag">{{ $cv->template->category ?? 'Standard' }}</span>
                                        <span class="cv-tag" style="background: #E8F5E9; color: #16a34a;">Selesai</span>
                                    </div>
                                </div>
                                <div class="cv-actions">
                                    <a href="{{ route('resume.render', $cv->id) }}" target="_blank" class="cv-btn cv-btn-primary" style="display:inline-flex; align-items:center; gap:6px;">
                                        <i class="fas fa-download"></i> Unduh PDF
                                    </a>
                                    <a href="{{ route('resume.edit', $cv->id) }}" class="cv-btn cv-btn-secondary"><i class="fas fa-pen"></i> Edit Ulang</a>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                                <i class="fas fa-award" style="font-size: 32px; opacity: 0.3; margin-bottom: 12px;"></i>
                                <p style="font-size: 14px;">Belum ada CV yang diselesaikan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><i class="fas fa-edit" style="color: var(--accent-orange); margin-right: 8px;"></i> Draft Tersimpan</h2>
                        <a href="{{ route('user.resumes', ['status' => 'draft'])}}" class="card-action">Lihat Semua →</a>
                    </div>

                    <div class="cv-list">
                        @forelse($draftCvs ?? [] as $cv)
                            <div class="cv-item">
                                <div class="cv-preview" style="background: linear-gradient(135deg, #FFF3E0 0%, var(--bg-body) 100%); border-color: #FFE0B2; color: #FB8C00;">
                                    @if($cv->template && $cv->template->thumbnail)
                                        <img src="{{ asset('storage/' . $cv->template->thumbnail) }}" alt="Preview">
                                    @else
                                        <i class="fas fa-file-invoice"></i>
                                    @endif
                                </div>
                                <div class="cv-info">
                                    <div class="cv-name">{{ $cv->title ?? 'Untitled CV' }}</div>
                                    <div class="cv-meta">
                                        <span><i class="fas fa-clock"></i> Draft {{ $cv->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="cv-tags">
                                        <span class="cv-tag">{{ $cv->template->category ?? 'Standard' }}</span>
                                        <span class="cv-tag" style="background: #FFF3E0; color: #E65100;">Draft</span>
                                    </div>
                                </div>
                                <div class="cv-actions" style="justify-content: center;">
                                    <a href="{{ route('resume.edit', $cv->id) }}" class="cv-btn cv-btn-primary" style="background: var(--accent-orange); color: white;">
                                        <i class="fas fa-arrow-right"></i> Lanjut Edit
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                                <i class="fas fa-box-open" style="font-size: 32px; opacity: 0.3; margin-bottom: 12px;"></i>
                                <p style="font-size: 14px;">Tidak ada draft yang tersimpan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <div class="right-column">
                
                <div class="card">
                    <div class="card-header" style="margin-bottom: 16px; padding-bottom: 12px;">
                        <h2 class="card-title">Status Transaksi</h2>
                    </div>
                    @if($lastTransaction)
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:16px; background:var(--bg-body); border-radius:12px; border: 1px solid var(--border-color);">
                            <div>
                                <div style="font-weight:700; font-size:14px; color:var(--text-main); margin-bottom:4px;">
                                    {{ $lastTransaction->package_name ?? 'Premium Plan' }}
                                </div>
                                <div style="font-size:12px; color:var(--text-secondary);">
                                    <i class="far fa-calendar-alt"></i> {{ $lastTransaction->created_at->format('d M Y') }}
                                </div>
                            </div>
                            <span class="cv-tag" style="background: {{ $lastTransaction->status == 'approved' ? 'var(--primary-light)' : '#FFF3E0' }}; color: {{ $lastTransaction->status == 'approved' ? 'var(--primary-color)' : '#E65100' }}; font-size: 12px; padding: 6px 12px;">
                                {{ ucfirst($lastTransaction->status) }}
                            </span>
                        </div>
                    @else
                        <div style="text-align: center; padding: 10px;">
                            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 16px;">Belum ada riwayat transaksi akun Pro.</p>
                            <a href="{{ route('pricing') ?? '#' }}" class="cv-btn cv-btn-primary" style="display:block; padding: 10px;">Upgrade ke Pro</a>
                        </div>
                    @endif
                </div>

                <div class="card">
                    <div class="card-header" style="margin-bottom: 16px; padding-bottom: 12px;">
                        <h2 class="card-title">Template Populer</h2>
                        <a href="{{ route('templates') }}" class="card-action" style="font-size: 12px;">Lihat Semua</a>
                    </div>
                    <div class="templates-grid">
                        @forelse($popularTemplates ?? [] as $template)
                            <a href="{{ route('template-detail', $template->slug) }}" class="template-card">
                                <div class="template-preview">
                                    @if($template->thumbnail)
                                        <img src="{{ asset('storage/' . $template->thumbnail) }}" alt="{{ $template->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                                    @else
                                        <i class="fas fa-file-image"></i>
                                    @endif
                                </div>
                                <div class="template-name" style="margin-top: 8px;">{{ $template->name }}</div>
                                <div style="display: flex; justify-content: space-between; align-items: center; font-size:11px; color:var(--text-secondary); margin-top:4px; font-weight:600;">
                                    
                                    <div>
                                        @if($template->type == 'pro')
                                            <span style="color: #8b5cf6;"><i class="fas fa-crown"></i> Pro</span>
                                        @else
                                            <span style="color: var(--primary-color);">Free</span>
                                        @endif
                                    </div>

                                    <div style="color: #f59e0b; display: flex; align-items: center; gap: 4px;" title="{{ $template->rating_count }} Ulasan">
                                        <i class="fas fa-star"></i>
                                        @if($template->average_rating > 0)
                                            {{ number_format($template->average_rating, 1) }}
                                        @else
                                            <span style="color: var(--text-muted); font-weight: normal;">Baru</span>
                                        @endif
                                    </div>

                                </div>
                            </a>
                        @empty
                            <p style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); font-size: 12px;">Belum ada template tersedia.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection