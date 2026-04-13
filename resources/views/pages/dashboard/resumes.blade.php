@extends('layouts.app')

@section('title', 'Dokumen Saya - ResuMate')

@push('styles')
    <style>
        :root {
            --primary-color: #4CAF50;
            --primary-hover: #45a049;
            --primary-light: #ecfdf5;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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

        .page-container { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 40px 32px 80px; 
            font-family: 'Inter', sans-serif; 
        }
        
        .back-link { 
            display: inline-flex; align-items: center; gap: 8px; 
            color: var(--text-secondary); text-decoration: none; 
            font-size: 14px; font-weight: 600; margin-bottom: 24px; 
            transition: color 0.2s; 
        }
        .back-link:hover { color: var(--primary-color); }

        .page-header { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 32px; 
        }
        .page-title { 
            font-family: 'Sora', sans-serif; font-size: 32px; font-weight: 800; 
            color: var(--text-main); margin-bottom: 6px; letter-spacing: -0.02em;
        }
        .page-subtitle { color: var(--text-secondary); font-size: 15px; }

        .tabs-container { 
            display: flex; gap: 12px; margin-bottom: 32px; 
            border-bottom: 1px solid var(--border-color); padding-bottom: 16px; 
        }
        .tab-btn { 
            padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; 
            text-decoration: none; transition: all 0.2s; display: flex; align-items: center; gap: 8px;
        }
        .tab-btn.active { background: var(--primary-color); color: white; box-shadow: var(--shadow-sm); }
        .tab-btn.inactive { background: transparent; color: var(--text-secondary); }
        .tab-btn.inactive:hover { background: var(--bg-card); color: var(--text-main); border: 1px solid var(--border-color); padding: 9px 19px; }
        
        .badge-count { 
            background: rgba(0,0,0,0.08); padding: 2px 8px; 
            border-radius: 12px; font-size: 12px; color: inherit;
        }
        [data-theme="dark"] .badge-count { background: rgba(255,255,255,0.1); }
        .tab-btn.active .badge-count { background: rgba(255,255,255,0.2); color: white; }

        .cv-grid { 
            display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px; 
        }
        
        .cv-card { 
            background: var(--bg-card); border: 1px solid var(--border-color); 
            border-radius: 16px; padding: 24px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column; gap: 20px; box-shadow: var(--shadow-sm);
        }
        .cv-card:hover { 
            transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: var(--primary-color); 
        }
        
        .cv-card-top { display: flex; gap: 20px; align-items: flex-start; }
        .cv-preview { 
            width: 80px; height: 105px; border-radius: 8px; background: var(--primary-light); 
            display: flex; align-items: center; justify-content: center; font-size: 32px; 
            color: var(--primary-color); flex-shrink: 0; overflow: hidden; 
            border: 1px solid rgba(16, 185, 129, 0.2); box-shadow: var(--shadow-sm);
        }
        .cv-preview img { width: 100%; height: 100%; object-fit: cover; }
        
        .cv-info { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 6px; }
        .cv-name { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 16px; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.3;}
        .cv-meta { font-size: 13px; color: var(--text-secondary); display: flex; flex-direction: column; gap: 4px; }
        
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; width: fit-content; margin-top: 4px; }
        
        .badge-draft { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        [data-theme="dark"] .badge-draft { background: rgba(245, 158, 11, 0.15); color: #fcd34d; border-color: rgba(245, 158, 11, 0.3); }
        
        .badge-done { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        [data-theme="dark"] .badge-done { background: rgba(16, 185, 129, 0.15); color: #86efac; border-color: rgba(16, 185, 129, 0.3); }

        .cv-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: auto; }
        .btn { 
            padding: 10px; border-radius: 10px; font-size: 13px; font-weight: 600; 
            text-align: center; text-decoration: none; cursor: pointer; transition: 0.2s; 
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-primary { background: var(--primary-color); color: white; border: none; box-shadow: var(--shadow-sm); }
        .btn-primary:hover { background: var(--primary-hover); transform: translateY(-1px); }
        
        .btn-outline { background: transparent; border: 1px solid var(--border-color); color: var(--text-main); }
        
        .btn-full { grid-column: 1 / -1; }

        .pagination-wrap { margin-top: 40px; display: flex; justify-content: center; }

        @media (max-width: 768px) {
            .page-container { padding: 24px 16px; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
            .tabs-container { overflow-x: auto; white-space: nowrap; padding-bottom: 12px; border-bottom: none; }
            .cv-grid { grid-template-columns: 1fr; }
        }
    </style>
@endpush

@section('content')
    <div class="page-container">
        <a href="{{ route('user.dashboard') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <div class="page-header">
            <div>
                <h1 class="page-title">Dokumen Saya</h1>
                <p class="page-subtitle">Kelola seluruh riwayat Curriculum Vitae Anda di sini.</p>
            </div>
            <a href="{{ route('templates') }}" class="btn btn-primary" style="padding: 12px 24px; font-size: 14px;">
                <i class="fas fa-plus"></i> Buat CV Baru
            </a>
        </div>

        <div class="tabs-container">
            <a href="{{ route('user.resumes', ['status' => 'completed']) }}" class="tab-btn {{ $status == 'completed' ? 'active' : 'inactive' }}">
                <i class="fas fa-check-circle"></i> Dokumen Selesai 
                <span class="badge-count">{{ $completedCount ?? 0 }}</span>
            </a>
            <a href="{{ route('user.resumes', ['status' => 'draft']) }}" class="tab-btn {{ $status == 'draft' ? 'active' : 'inactive' }}">
                <i class="fas fa-file-signature"></i> Draft Tersimpan 
                <span class="badge-count">{{ $draftCount ?? 0 }}</span>
            </a>
        </div>

        <div class="cv-grid">
            @forelse($resumes as $cv)
                <div class="cv-card">
                    <div class="cv-card-top">
                        <div class="cv-preview">
                            @if($cv->template && $cv->template->thumbnail)
                                <img src="{{ asset('storage/' . $cv->template->thumbnail) }}" alt="Preview">
                            @else
                                <i class="fas fa-file-invoice"></i>
                            @endif
                        </div>
                        <div class="cv-info">
                            <div class="cv-name" title="{{ $cv->title }}">{{ $cv->title ?? 'Untitled Resume' }}</div>
                            <div class="cv-meta">
                                <span><i class="far fa-clock"></i> Diperbarui {{ $cv->updated_at->diffForHumans() }}</span>
                                <span><i class="fas fa-palette"></i> Template: {{ $cv->template->name ?? 'Custom' }}</span>
                            </div>
                            
                            @if($cv->status === 'completed')
                                <span class="badge badge-done"><i class="fas fa-check"></i> Selesai</span>
                            @else
                                <span class="badge badge-draft"><i class="fas fa-pen"></i> Draft</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="cv-actions">
                        @if($cv->status === 'completed')
                            <a href="{{ route('resume.edit', $cv->id) }}" class="btn btn-outline">
                                <i class="fas fa-pen"></i> Edit Ulang
                            </a>
                            <a href="{{ route('resume.render', $cv->id) }}" target="_blank" class="btn btn-primary" style="display: flex; justify-content: center; align-items: center;">
                                <i class="fas fa-download"></i> Unduh PDF
                            </a>

                            <div style="grid-column: 1 / -1; margin-top: 12px; padding-top: 16px; border-top: 1px dashed var(--border-color); text-align: center;">
                                <div class="rating-text" style="font-size: 12px; color: var(--text-secondary); margin-bottom: 8px; font-weight: 600;">
                                    {{ $cv->rating ? 'Nilai yang Anda berikan:' : 'Seberapa suka Anda dengan template ini?' }}
                                </div>
                                
                                <div class="star-rating-container" data-resume-id="{{ $cv->id }}" data-current-rating="{{ $cv->rating ?? 0 }}">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-star {{ ($cv->rating >= $i) ? 'fas' : 'far' }} rate-star" 
                                        data-val="{{ $i }}" 
                                        style="cursor: pointer; font-size: 22px; color: {{ ($cv->rating >= $i) ? '#f59e0b' : '#e5e7eb' }}; transition: all 0.2s; margin: 0 2px;"></i>
                                    @endfor
                                </div>
                                
                                <div class="rating-feedback" style="font-size: 12px; color: var(--primary-color); margin-top: 8px; font-weight: 700; display: none;">
                                    <i class="fas fa-check-circle"></i> Tersimpan!
                                </div>
                            </div>
                        @else
                            <a href="{{ route('resume.edit', $cv->id) }}" class="btn btn-primary btn-full">
                                Lanjut Edit Draft <i class="fas fa-arrow-right" style="margin-left: 4px;"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px; background: var(--bg-card); border-radius: 24px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                    <div style="width: 80px; height: 80px; background: var(--primary-light); color: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 20px;">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h3 style="font-family: 'Sora', sans-serif; font-size: 20px; color: var(--text-main); margin-bottom: 8px;">Tidak Ada Dokumen</h3>
                    <p style="color: var(--text-secondary); margin-bottom: 24px; font-size: 15px;">Anda belum memiliki {{ $status == 'completed' ? 'CV yang diselesaikan' : 'draft CV' }} di sini.</p>
                    <a href="{{ route('templates') }}" class="btn btn-primary" style="display: inline-flex; width: auto; padding: 12px 32px;">
                        Pilih Template Sekarang
                    </a>
                </div>
            @endforelse
        </div>

        @if($resumes->hasPages())
            <div class="pagination-wrap">
                {{ $resumes->appends(['status' => $status])->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.star-rating-container').forEach(container => {
            const stars = container.querySelectorAll('.rate-star');
            const resumeId = container.getAttribute('data-resume-id');
            let currentRating = parseInt(container.getAttribute('data-current-rating')) || 0;

            function highlightStars(rating) {
                stars.forEach(s => {
                    const val = parseInt(s.getAttribute('data-val'));
                    if (val <= rating) {
                        s.classList.remove('far');
                        s.classList.add('fas');
                        s.style.color = '#f59e0b'; 
                    } else {
                        s.classList.remove('fas');
                        s.classList.add('far');
                        s.style.color = '#e5e7eb'; 
                    }
                });
            }

            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    highlightStars(this.getAttribute('data-val'));
                });

                star.addEventListener('mouseout', function() {
                    highlightStars(currentRating);
                });

                star.addEventListener('click', function() {
                    const val = this.getAttribute('data-val');
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(`/resume/${resumeId}/rating`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ rating: val })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        if(data.success) {
                            currentRating = val;
                            container.setAttribute('data-current-rating', val);
                            highlightStars(val);

                            const feedback = container.parentElement.querySelector('.rating-feedback');
                            const ratingText = container.parentElement.querySelector('.rating-text');
                            
                            if(ratingText) ratingText.innerText = 'Nilai yang Anda berikan:';
                            if(feedback) {
                                feedback.style.display = 'block';
                                setTimeout(() => {
                                    feedback.style.display = 'none';
                                }, 2000);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Fetch Error:', error);
                        alert('Gagal menyimpan rating. Pastikan Anda terhubung ke internet.');
                    });
                });
            });
        });
    });
</script>
@endpush