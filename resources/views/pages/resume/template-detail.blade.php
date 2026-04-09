@extends('layouts.app')

@section('title', $template->name)

@push('styles')
    <style>
        .detail-section { background: var(--bg-body); padding: 60px 0 120px; }
        .detail-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; display: grid; grid-template-columns: 1.3fr 1fr; gap: 80px; align-items: start; }

        .preview-wrapper { position: sticky; top: 100px; }
        .preview-canvas { background: var(--bg-card); border-radius: 24px; padding: 60px 40px; display: flex; justify-content: center; align-items: flex-start; border: 1px solid var(--border-color); box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05); position: relative; overflow: hidden; }
        .preview-canvas::before { content: ''; position: absolute; width: 100%; height: 100%; top: 0; left: 0; background-image: radial-gradient(var(--border-color) 1px, transparent 1px); background-size: 20px 20px; opacity: 0.5; z-index: 0; }

        .cv-mockup { width: 100%; max-width: 480px; aspect-ratio: 1 / 1.414; /* A4 */ background: white; box-shadow: 0 15px 35px rgba(0,0,0,0.1), 0 5px 15px rgba(0,0,0,0.05); border-radius: 4px; overflow: hidden; position: relative; z-index: 1; transition: transform 0.3s ease; cursor: pointer; /* Cursor pointer added */ }
        .cv-mockup:hover { transform: scale(1.02); }
        .cv-mockup img { width: 100%; height: 100%; object-fit: cover; object-position: top; }

        .mockup-skeleton { width: 100%; height: 100%; background: #fff; display: flex; flex-direction: column; }
        .sk-header { height: 12%; background: var(--primary-color); width: 100%; }
        .sk-body { padding: 25px; flex: 1; display: flex; gap: 20px; }
        .sk-col-left { width: 65%; display: flex; flex-direction: column; gap: 15px; }
        .sk-col-right { width: 35%; display: flex; flex-direction: column; gap: 15px; }
        .sk-line { background: #f0f0f0; border-radius: 4px; }

        .zoom-btn { position: absolute; bottom: 25px; right: 25px; width: 45px; height: 45px; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(8px); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #333; font-size: 18px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); cursor: pointer; transition: all 0.2s; z-index: 2; }
        .zoom-btn:hover { transform: scale(1.1); background: white; }

        .template-header { margin-bottom: 30px; }
        .tags-wrapper { display: flex; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
        .badge-pill { font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 30px; letter-spacing: 0.5px; text-transform: uppercase; }
        .badge-primary { background: rgba(76, 175, 80, 0.1); color: var(--primary-color); border: 1px solid rgba(76, 175, 80, 0.2); }
        .badge-new { background: rgba(59, 130, 246, 0.1); color: #3B82F6; border: 1px solid rgba(59, 130, 246, 0.2); }
        .badge-rating { background: rgba(255, 183, 77, 0.1); color: #F57C00; border: 1px solid rgba(255, 183, 77, 0.2); display: flex; align-items: center; gap: 5px; }

        .template-title { font-size: 40px; color: var(--text-main); font-weight: 800; line-height: 1.1; margin-bottom: 20px; }
        .template-desc { font-size: 16px; color: var(--text-secondary); line-height: 1.7; margin-bottom: 40px; }

        .specs-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px; }
        .spec-card { background: var(--bg-card); border: 1px solid var(--border-color); padding: 20px; border-radius: 16px; display: flex; align-items: flex-start; gap: 15px; transition: all 0.3s; }
        .spec-card:hover { border-color: var(--primary-color); transform: translateY(-3px); }
        .spec-icon { width: 40px; height: 40px; background: rgba(76, 175, 80, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-color); font-size: 18px; flex-shrink: 0; }
        .spec-content h5 { font-size: 13px; color: var(--text-secondary); margin-bottom: 4px; font-weight: 500; }
        .spec-content p { font-size: 15px; color: var(--text-main); font-weight: 700; margin: 0; }

        .action-area { background: var(--bg-card); border: 1px solid var(--border-color); padding: 30px; border-radius: 20px; text-align: center; }
        .btn-use-template { display: flex; align-items: center; justify-content: center; gap: 12px; width: 100%; padding: 18px; background: var(--primary-color); color: white; font-size: 18px; font-weight: 700; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 10px 25px rgba(76, 175, 80, 0.25); }
        .btn-use-template:hover { background: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 15px 30px rgba(76, 175, 80, 0.35); }
        .guarantee-text { margin-top: 15px; font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; justify-content: center; gap: 6px; }

        .pro-tip { margin-top: 30px; padding: 20px; background: var(--bg-body); border-left: 4px solid var(--primary-color); border-radius: 8px; }
        .pro-tip h6 { color: var(--primary-color); font-size: 14px; font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .pro-tip p { font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin: 0; }
        .lightbox {
            display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; 
            overflow: auto; background-color: rgba(0,0,0,0.9); backdrop-filter: blur(5px); animation: fadeIn 0.3s;
        }
        .lightbox-content {
            margin: auto; display: block; max-width: 90%; max-height: 90vh;
            object-fit: contain; position: absolute; top: 50%; left: 50%; 
            transform: translate(-50%, -50%); animation: zoomIn 0.3s;
        }
        .close-lightbox {
            position: absolute; top: 20px; right: 35px; color: #f1f1f1; 
            font-size: 40px; font-weight: bold; transition: 0.3s; cursor: pointer; z-index: 10000;
        }
        .close-lightbox:hover { color: #bbb; text-decoration: none; cursor: pointer; }

        @keyframes fadeIn { from {opacity: 0} to {opacity: 1} }
        @keyframes zoomIn { from {transform: translate(-50%, -50%) scale(0.9)} to {transform: translate(-50%, -50%) scale(1)} }

        @media (max-width: 992px) { 
            .detail-container { grid-template-columns: 1fr; gap: 50px; padding: 0 20px; }
            .preview-wrapper { position: relative; top: 0; }
            .template-title { font-size: 32px; }
            .specs-grid { grid-template-columns: 1fr; } 
        }
    </style>
@endpush

@section('content')
    <section class="detail-section">
        <div class="detail-container">
            
            <div class="preview-wrapper">
                <div class="preview-canvas">
                    <div class="cv-mockup" id="triggerZoom">
                        @if($template->thumbnail)
                            <img id="previewImage" src="{{ Storage::url($template->thumbnail) }}" alt="{{ $template->name }}">
                        @else
                            <div class="mockup-skeleton">
                                <div class="sk-header"></div>
                                <div class="sk-body">
                                    <div class="sk-col-left">
                                        <div class="sk-line" style="height: 30px; width: 80%;"></div>
                                        <div class="sk-line" style="height: 15px; width: 50%; margin-bottom: 20px;"></div>
                                        <div class="sk-line" style="height: 10px; width: 100%;"></div>
                                        <div class="sk-line" style="height: 10px; width: 90%;"></div>
                                        <div class="sk-line" style="height: 60px; width: 100%; margin-top: 20px;"></div>
                                    </div>
                                    <div class="sk-col-right">
                                        <div class="sk-line" style="height: 100px; width: 100%; margin-bottom: 15px;"></div>
                                        <div class="sk-line" style="height: 15px; width: 60%;"></div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="zoom-btn" title="Lihat Preview Full">
                            <i class="fas fa-expand"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="template-info">
                <div class="template-header">
                    <div class="tags-wrapper">
                        @if($template->is_new) <span class="badge-pill badge-new">NEW RELEASE</span> @endif
                        @if($template->type == 'pro') <span class="badge-pill badge-primary">PREMIUM</span> @else <span class="badge-pill" style="background:#f3f4f6; color:#1f2937;">GRATIS</span> @endif
                        <span class="badge-pill badge-rating">
                            <i class="fas fa-star"></i> {{ number_format($template->average_rating ?? 0, 1) }} 
                            (
                            @php
                                $n = $template->total_downloads ?? 0;
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
                            )
                        </span>
                    </div>
                    <h1 class="template-title">{{ $template->name }}</h1>
                    <p class="template-desc">{{ $template->description }}</p>
                </div>

                <div class="specs-grid">
                    <div class="spec-card">
                        <div class="spec-icon"><i class="fas fa-layer-group"></i></div>
                        <div class="spec-content">
                            <h5>Kategori</h5>
                            <p>
                                @php
                                    $categories = is_array($template->category) ? $template->category : [$template->category];
                                    echo implode(', ', $categories);
                                @endphp
                            </p>
                        </div>
                    </div>
                    <div class="spec-card">
                        <div class="spec-icon"><i class="fas fa-file-alt"></i></div>
                        <div class="spec-content"><h5>Format</h5><p>PDF Auto-Layout</p></div>
                    </div>
                </div>

                <div class="action-area">
                    {{-- <a href="{{ route('test-editor', $template->slug) }}" class="btn-use-template"><span>Gunakan Template Ini</span> <i class="fas fa-arrow-right"></i></a> --}}
                    <a href="{{ route('template-editor', $template->slug)}}" class="btn-use-template"><span>Isi data terlebih dahulu </span> <i class="fas fa-arrow-right"></i></a>
                    <div class="guarantee-text"><i class="fas fa-shield-alt"></i> 100% Data Privasi Terjamin</div>
                </div>

                <div class="pro-tip">
                    <h6><i class="fas fa-lightbulb"></i> Tips Karir</h6>
                    <p>Template jenis <strong>{{ is_array($template->category) ? $template->category[0] : 'ini' }}</strong> sangat cocok untuk menonjolkan pengalaman kerja Anda secara kronologis.</p>
                </div>
            </div>
        </div>
    </section>

    <div id="lightboxModal" class="lightbox">
        <span class="close-lightbox">&times;</span>
        <img class="lightbox-content" id="imgFull">
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('lightboxModal');
            const trigger = document.getElementById('triggerZoom');
            const sourceImg = document.getElementById('previewImage');
            const modalImg = document.getElementById('imgFull');
            const closeBtn = document.querySelector('.close-lightbox');

            if(trigger && sourceImg) {
                trigger.addEventListener('click', function() {
                    modal.style.display = "block";
                    modalImg.src = sourceImg.src;
                    document.body.style.overflow = "hidden"; 
                });
            }

            const closeModal = () => {
                modal.style.display = "none";
                document.body.style.overflow = "auto"; 
            };

            closeBtn.addEventListener('click', closeModal);

            modal.addEventListener('click', function(e) {
                if (e.target === modal) closeModal();
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === "Escape") closeModal();
            });
        });
    </script>
@endpush