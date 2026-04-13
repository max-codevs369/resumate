<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit CV - ResuMate</title>
    
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Inter:wght@400;500;600;700&family=Sora:wght@600;700&family=Merriweather:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #fafafa; color: #1f2937; overflow: hidden; }
        .editor-layout { display: flex; height: 100vh; background: #fafafa; }
        
        .sidebar { width: 380px; background: white; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; overflow: hidden; z-index: 10; }
        .sidebar-top { padding: 24px 20px 20px; border-bottom: 1px solid #f3f4f6; background: white; }
        .back-link { display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; font-size: 14px; margin-bottom: 20px; font-weight: 500; transition: color 0.2s; }
        .back-link:hover { color: #1f2937; }
        .sidebar-title { font-family: 'Sora', sans-serif; font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 8px; letter-spacing: -0.02em; }
        .sidebar-subtitle { font-size: 14px; color: #6b7280; margin-bottom: 24px; }
        
        .tabs { display: flex; gap: 0; background: #f9fafb; padding: 4px; border-radius: 10px; }
        .tab { flex: 1; padding: 10px 12px; background: transparent; border: none; border-radius: 7px; font-size: 12px; font-weight: 600; color: #6b7280; cursor: pointer; transition: all 0.15s; display: flex; flex-direction: column; align-items: center; gap: 4px; }
        .tab i { font-size: 16px; }
        .tab.active { background: white; color: #16a34a; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        
        .sidebar-content { flex: 1; overflow-y: auto; padding: 24px 20px; }
        .sidebar-content::-webkit-scrollbar { width: 5px; }
        .sidebar-content::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
        .section { display: none; animation: fadeIn 0.3s ease; }
        .section.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        
        .section-label { display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #16a34a; margin-bottom: 16px; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px; }
        .field { margin-bottom: 16px; }
        .label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .input, .textarea { width: 100%; padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-family: inherit; color: #111827; background: white; transition: all 0.2s; }
        .input:focus, .textarea:focus { outline: none; border-color: #16a34a; box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.08); }
        .textarea { min-height: 80px; resize: vertical; }
        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        
        .card { background: #fdfdfd; border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px; margin-bottom: 16px; transition: all 0.2s; position: relative; }
        .card:hover { border-color: #d1d5db; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
        .icon-btn.delete { position: absolute; top: 12px; right: 12px; width: 28px; height: 28px; background: white; border: 1px solid #e5e7eb; border-radius: 6px; color: #ef4444; cursor: pointer; transition: all 0.2s; display: flex; justify-content: center; align-items: center; }
        .icon-btn.delete:hover { background: #fef2f2; border-color: #fecaca; }
        .add-btn { width: 100%; padding: 10px; background: white; border: 1.5px dashed #d1d5db; border-radius: 8px; font-size: 13px; font-weight: 600; color: #16a34a; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.2s; margin-top: 12px; margin-bottom: 24px; }
        .add-btn:hover { background: #f0fdf4; border-color: #16a34a; }
        
        .preview-area { flex: 1; background: #e5e5e5; display: flex; flex-direction: column; overflow: hidden; }
        .preview-header { background: white; border-bottom: 1px solid #e5e7eb; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; z-index: 5; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .preview-actions { display: flex; gap: 10px; }
        .action-btn { padding: 9px 18px; border: 1px solid #d1d5db; background: white; border-radius: 8px; font-size: 13px; font-weight: 600; color: #374151; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .action-btn:hover { background: #f9fafb; }
        .action-btn.primary { background: #16a34a; border-color: #16a34a; color: white; }
        .action-btn.primary:hover { background: #15803d; box-shadow: 0 2px 8px rgba(22, 163, 74, 0.2); }
        .zoom-tools { display: flex; align-items: center; gap: 8px; padding: 6px 8px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb; }
        .zoom-btn { width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #e5e7eb; border-radius: 6px; color: #4b5563; cursor: pointer; }
        .zoom-value { font-size: 13px; font-weight: 600; color: #374151; min-width: 44px; text-align: center; }
        
        .preview-canvas { flex: 1; overflow: auto; padding: 40px; display: flex; justify-content: center; align-items: flex-start; }
        .preview-canvas::-webkit-scrollbar { width: 8px; height: 8px; }
        .preview-canvas::-webkit-scrollbar-thumb { background: #9ca3af; border-radius: 4px; }
        
        .cv-sheet { 
            width: 210mm; 
            min-height: 297mm; 
            height: max-content; 
            background: #ffffff; 
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); 
            position: relative;
            transform-origin: top center; 
            transition: transform 0.2s;
            color: #000000; 
        }

        #main-drop {
            min-height: 297mm; 
            height: max-content; 
            padding: 20mm; 
            position: relative;
        }

        .notify { position: fixed; bottom: 24px; right: 24px; display: flex; align-items: center; gap: 12px; padding: 14px 20px; background: white; border-left: 4px solid #16a34a; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); transform: translateY(120px); opacity: 0; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); z-index: 1000; }
        .notify.show { transform: translateY(0); opacity: 1; }
        .notify i { font-size: 18px; color: #16a34a; }
        .notify span { font-size: 14px; font-weight: 600; color: #111827; }

        .btn-back {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f1f5f9;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid #e2e8f0;
        }

        .btn-back:hover {
            background: #10b981;
            color: white;
            border-color: #10b981;
            transform: translateX(-3px);
        }

        .swal-custom-popup {
            border-radius: 24px !important;
            padding: 10px !important;
        }

        .swal-btn-confirm {
            padding: 14px 28px !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            border-radius: 14px !important;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3) !important;
            transition: all 0.3s ease !important;
        }

        .swal-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4) !important;
        }

        .swal-btn-cancel {
            background-color: #f3f4f6 !important;
            color: #4b5563 !important;
            font-weight: 600 !important;
            padding: 14px 24px !important;
            border-radius: 14px !important;
            transition: all 0.3s ease !important;
        }

        .swal-btn-cancel:hover {
            background-color: #e5e7eb !important;
        }

        @media screen and (max-width: 992px) {
            body { 
                overflow: auto; 
            }
            
            .editor-layout { 
                flex-direction: column; 
                height: auto; 
                min-height: 100vh;
            }

            .sidebar { 
                width: 100%; 
                height: auto; 
                border-right: none; 
                border-bottom: 4px solid #e5e7eb;
                overflow: visible; 
            }
            
            .sidebar-content {
                overflow-y: visible; 
                padding: 20px 16px;
            }

            .field-row {
                grid-template-columns: 1fr; 
            }

            .tabs { 
                flex-wrap: wrap; 
                gap: 4px;
            }
            
            .tab { 
                flex: 1 1 calc(50% - 4px);
                margin-bottom: 2px;
            }

            .preview-area { 
                width: 100%; 
                height: 85vh; 
                position: relative;
            }

            .preview-header { 
                flex-direction: column; 
                gap: 12px; 
                padding: 16px;
            }

            .zoom-tools, .preview-actions { 
                width: 100%; 
                justify-content: center; 
            }

            .preview-actions {
                flex-wrap: wrap;
            }

            .action-btn { 
                flex: 1; 
                justify-content: center; 
                font-size: 13px;
                padding: 10px 12px;
                white-space: nowrap;
            }

            .preview-canvas { 
                padding: 16px; 
                align-items: flex-start;
            }

            .notify {
                left: 50%;
                right: auto;
                transform: translate(-50%, 120px);
                width: 90%;
                max-width: 400px;
                justify-content: center;
            }
            
            .notify.show {
                transform: translate(-50%, -24px);
            }
            
            .icon-btn.delete {
                width: 34px;
                height: 34px;
                top: 8px;
                right: 8px;
            }
        }

        @keyframes modalPop {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

<div class="editor-layout">
    
    <div class="sidebar">
        <div class="sidebar-top">
            @auth
                <a href="{{ route('user.dashboard') }}" class="back-link"><i class="fas fa-arrow-left"></i> Keluar</a>
            @endauth

            @guest
                <a href="{{ route('templates') }}" class="back-link"><i class="fas fa-arrow-left"></i> Keluar</a>
            @endguest

            <h1 class="sidebar-title">Edit Resume</h1>
            <p class="sidebar-subtitle">Isi data Anda dengan lengkap</p>

            <div style="margin-bottom: 20px;">
                <label style="font-size: 12px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Nama Dokumen</label>
                <input type="text" id="documentTitle" class="input" style="padding: 8px 12px; font-size: 13px;" value="{{ $resume->title ?? 'Resume Baru' }}" placeholder="Contoh: CV Lamaran Kerja PT ABC">
            </div>
            
            <div class="tabs">
                <button class="tab active" data-section="personal"><i class="fas fa-user"></i> <span>Pribadi</span></button>
                <button class="tab" data-section="experience"><i class="fas fa-briefcase"></i> <span>Riwayat</span></button>
                <button class="tab" data-section="education"><i class="fas fa-graduation-cap"></i> <span>Edukasi</span></button>
                <button class="tab" data-section="skills"><i class="fas fa-star"></i> <span>Keahlian</span></button>
            </div>
        </div>

        <div class="sidebar-content">
            <div class="section active" id="section-personal"></div>
            <div class="section" id="section-experience"></div>
            <div class="section" id="section-education"></div>
            <div class="section" id="section-skills"></div>
        </div>
    </div>

    <div class="preview-area">
        <div class="preview-header">
            <div class="zoom-tools">
                <button class="zoom-btn" onclick="zoomOut()"><i class="fas fa-minus"></i></button>
                <span id="zoomVal" class="zoom-value">100%</span>
                <button class="zoom-btn" onclick="zoomIn()"><i class="fas fa-plus"></i></button>
            </div>
                <div class="preview-actions">
                    <button class="action-btn" onclick="downloadPDF()"><i class="fas fa-file-pdf" style="color: #dc2626;"></i> Unduh PDF</button>
                    @auth
                        @if(Auth::user()->is_premium)
                            <button class="action-btn" type="button" onclick="checkAtsScore()" id="btn-check-ats">
                                <i class="fas fa-chart-line" style="color: #3b82f6;"></i> Skor ATS
                            </button>
                        @endif
                        <button class="action-btn" onclick="saveData('draft')" id="btnDraft"><i class="fas fa-save"></i> Simpan Draft</button>
                        <button class="action-btn primary" onclick="saveData('completed')" id="btnDone"><i class="fas fa-check-circle"></i> Selesai</button>
                    @endauth    
                </div>
        </div>

        @auth
            @if(Auth::user()->is_premium)
                <div id="ats-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(17, 24, 39, 0.75); z-index: 9999; justify-content: center; align-items: center; backdrop-filter: blur(4px);">
                    <div style="background: white; width: 90%; max-width: 480px; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); overflow: hidden; animation: modalPop 0.3s ease-out;">
                        
                        <div style="background: #eff6ff; padding: 20px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #bfdbfe;">
                            <h3 style="font-size: 18px; font-weight: 700; color: #1e3a8a; margin: 0;">
                                Hasil Analisis ATS
                            </h3>
                            <button onclick="document.getElementById('ats-modal').style.display = 'none'" style="background: white; border: none; width: 32px; height: 32px; border-radius: 50%; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: all 0.2s;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div style="padding: 24px;">
                            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 24px;">
                                <div style="position: relative; width: 84px; height: 84px; display: flex; justify-content: center; align-items: center; background: white; border: 5px solid #3b82f6; border-radius: 50%; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2);">
                                    <span id="ats-score-display" style="font-size: 34px; font-weight: 800; color: #2563eb;">0</span>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-size: 15px; font-weight: 700; color: #374151; margin-bottom: 4px;">Skor Kelayakan CV</div>
                                    <p style="font-size: 13px; color: #6b7280; line-height: 1.5; margin: 0;">Semakin tinggi skor, semakin besar peluang CV Anda lolos seleksi otomatis sistem HRD.</p>
                                </div>
                            </div>

                            <div style="font-size: 14px; font-weight: 700; color: #111827; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-clipboard-list text-blue-500"></i> Detail Evaluasi:
                            </div>
                            
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; max-height: 200px; overflow-y: auto;">
                                <ul id="ats-feedback-list" style="font-size: 13px; color: #ef4444; padding-left: 20px; line-height: 1.6; margin: 0;">
                                    </ul>
                            </div>
                        </div>
                        
                        <div style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: right;">
                            <button onclick="document.getElementById('ats-modal').style.display = 'none'" style="background: #3b82f6; color: white; border: none; padding: 10px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: background 0.2s; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);">
                                Tutup
                            </button>
                        </div>
                        
                    </div>
                </div>
            @endif
        @endauth

        <div class="preview-canvas">
            <div class="cv-sheet" id="cv-paper">
                <div id="main-drop"></div>
            </div>
        </div>
    </div>
</div>

<div class="notify" id="notifyBox">
    <i class="fas fa-check-circle"></i>
    <span id="notifyMsg">Tersimpan!</span>
</div>
<script>
    const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
</script>
<script>
    let rawSchema = {!! json_encode($resume->layout_schema ?? $resume->template->layout_schema ?? []) !!};
    let rawGlobal = {!! json_encode($resume->global_settings ?? $resume->template->global_settings ?? []) !!};
    const cvTemplateId = "{{ $resume->cv_template_id ?? $resume->template->id }}";
    let resumeId = "{{ $resume->id ?? '' }}";

    let schema = [];
    try { schema = typeof rawSchema === 'string' ? JSON.parse(rawSchema) : rawSchema; } catch(e) {}
    if (!Array.isArray(schema)) schema = typeof schema === 'object' && schema !== null ? Object.values(schema) : [];

    let globalSettings = { fontFamily: "'DM Sans', sans-serif" };
    try { globalSettings = typeof rawGlobal === 'string' ? JSON.parse(rawGlobal) : rawGlobal; } catch(e) {}
    if (globalSettings && globalSettings.fontFamily) {
        document.getElementById('cv-paper').style.fontFamily = globalSettings.fontFamily;
    }

    function esc(str) { return String(str||'').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
    function safeText(val) { return String(val || '').replace(/\n/g, '<br>'); }
    function parseItems(itemsData) {
        let items = [];
        try { items = typeof itemsData === 'string' ? JSON.parse(itemsData) : itemsData; } catch(e) {}
        return Array.isArray(items) ? items : [];
    }
    function findBlock(id, arr) {
        for (const b of arr) { 
            if (b.id === id) return b; 
            if (b.isLayout) { 
                if (b.layoutType === 'col1') { const f = findBlock(id, b.children||[]); if(f) return f; } 
                else { for (const col of b.columns||[]) { const f = findBlock(id, col); if(f) return f; } } 
            } 
        } 
        return null;
    }

    function renderCanvas() {
        const container = document.getElementById('main-drop');
        container.innerHTML = '';
        schema.forEach(block => container.appendChild(renderLayoutNode(block)));
    }

    function renderLayoutNode(block) {
        const wrapper = document.createElement('div');
        const p = block.props;
        
        if (block.isLayout) {
            wrapper.style.cssText = `margin-top:${p.marginTop||0}px; margin-bottom:${p.marginBottom||0}px;`;
            if (block.layoutType === 'col1') {
                if (block.children && block.children.length) block.children.forEach(child => wrapper.appendChild(renderLayoutNode(child)));
            } else {
                const [l, r] = (p.ratio || '50_50').split('_').map(Number);
                const grid = document.createElement('div'); 
                grid.style.cssText = `display:grid; grid-template-columns:${l}fr ${r}fr; gap:${p.gap||16}px;`;
                block.columns.forEach(col => {
                    const colDiv = document.createElement('div');
                    if (col.length) col.forEach(child => colDiv.appendChild(renderLayoutNode(child)));
                    grid.appendChild(colDiv);
                });
                wrapper.appendChild(grid);
            }
        } else {
            wrapper.innerHTML = renderElementHTML(block);
        }
        return wrapper;
    }

    function renderElementHTML(block) {
        const p = block.props; 
        const wrap = (inner) => `<div style="margin-top:${p.marginTop||0}px;margin-bottom:${p.marginBottom||0}px;">${inner}</div>`;
        const heading = (t, sz, c, sl, lc, lt='1.5', al='left') => `<div style="margin-bottom:6px; padding-bottom:3px; ${(sl===true||sl==='true')?`border-bottom:${lt}px solid ${lc||'#0d0d0d'};`:''}"><span style="font-size:${sz||12}px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:${c||'#0d0d0d'}; text-align:${al}; display:block;">${esc(t)}</span></div>`;

        switch(block.type) {
            case 'header': {
                const fw = (p.nameBold===true||p.nameBold==='true') ? '700' : '400';
                const textHtml = `<div style="text-align:${p.align||'left'}; flex:1;">
                    <div style="font-size:${p.nameSize||28}px; font-weight:${fw}; color:${p.nameColor||'#0d0d0d'}; line-height:1.1; letter-spacing:-0.5px;">${esc(p.name)}</div>
                    <div style="font-size:${p.titleSize||14}px; color:${p.titleColor||'#555'}; margin-top:4px;">${esc(p.title)}</div>
                    </div>`;
                if(p.showPhoto === true || p.showPhoto === 'true') {
                    const br = p.photoShape==='circle' ? '50%' : '8px'; const s = (p.photoSize||80)+'px';
                    const borderStyle = (p.border===true||p.border==='true') ? `border:2px solid ${p.borderColor||'#000'};` : '';
                    let photoHtml = p.imageUrl && p.imageUrl.trim() !== '' ? 
                        `<div style="width:${s}; height:${s}; border-radius:${br}; background: url('${p.imageUrl}') center/cover no-repeat; flex-shrink:0; box-sizing: border-box; ${borderStyle}"></div>` : 
                        `<div style="width:${s}; height:${s}; border-radius:${br}; background:#e2e8f0; flex-shrink:0; display:flex; align-items:center; justify-content:center; color:#94a3b8; box-sizing: border-box; ${borderStyle} overflow:hidden;"><i class="fas fa-camera" style="font-size:${Math.round(parseInt(s)*0.4)}px;"></i></div>`;
                    const alignRule = p.photoPos === 'left' ? 'flex-direction:row;' : 'flex-direction:row-reverse;';
                    return wrap(`<div style="display:flex; justify-content:space-between; align-items:center; gap:20px; ${alignRule}">${textHtml}${photoHtml}</div>`);
                }
                return wrap(textHtml);
            }
            case 'photo': {
                const br = p.shape==='circle' ? '50%' : (p.shape==='rounded' ? '10px' : '0');
                const border = (p.border===true||p.border==='true') ? `border:2px solid ${p.borderColor||'#e4e4e4'};` : '';
                const s = (p.size||100)+'px';
                let photoHtml = p.imageUrl && p.imageUrl.trim() !== '' ? 
                    `<div style="display:inline-block; width:${s}; height:${s}; border-radius:${br}; background: url('${p.imageUrl}') center/cover no-repeat; box-sizing: border-box; ${border}"></div>` : 
                    `<div style="display:inline-block; width:${s}; height:${s}; border-radius:${br}; background:#d1d5db; ${border} box-sizing: border-box; display:inline-flex; align-items:center; justify-content:center; color:#9ca3af;"><i class="fas fa-user" style="font-size:${Math.round(parseInt(s)*0.4)}px;"></i></div>`;
                return wrap(`<div style="text-align:${p.align||'center'};">${photoHtml}</div>`);
            }
            case 'contact': {
                const fs = (p.fontSize||11)+'px'; const ic = p.iconColor||'#000000'; const items = [];
                if (p.phone) items.push(`<i class="fas fa-phone" style="color:${ic}; width:14px;"></i> ${esc(p.phone)}`);
                if (p.email) items.push(`<i class="fas fa-envelope" style="color:${ic}; width:14px;"></i> ${esc(p.email)}`);
                if (p.address) items.push(`<i class="fas fa-map-marker-alt" style="color:${ic}; width:14px;"></i> ${esc(p.address)}`);
                if (p.website) items.push(`<i class="fas fa-globe" style="color:${ic}; width:14px;"></i> ${esc(p.website)}`);
                if (p.layout === 'horizontal') return wrap(`<div style="display:flex; flex-wrap:wrap; gap:14px; font-size:${fs}; color:#000000; justify-content:${p.align==='center'?'center':(p.align==='right'?'flex-end':'flex-start')};">${items.map(i=>`<span>${i}</span>`).join('')}</div>`);
                return wrap(`<div style="font-size:${fs}; line-height:2; color:#000000; text-align:${p.align};">${items.map(i=>`<div>${i}</div>`).join('')}</div>`);
            }
            case 'summary':
                return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}<p style="font-size:${p.textSize||11}px; line-height:1.6; color:#000000; text-align:${p.textAlign||'justify'}; margin:0;">${safeText(p.text)}</p>`);
            
            case 'experience': case 'volunteer': case 'organization': {
                const items = parseItems(p.items);
                const rows = items.map(it => `<div style="margin-bottom:10px;"><div style="display:flex; justify-content:space-between; align-items:flex-start;"><div><div style="font-size:${p.fontSize||11}px; font-weight:700; color:#0d0d0d;">${esc(it.title||it.role)}</div><div style="font-size:${p.fontSize||11}px; color:#333;">${esc(it.company||it.org)}${it.location?' · '+esc(it.location):''}</div></div><div style="font-size:${(parseInt(p.fontSize||11)-1)}px; color:#555; white-space:nowrap; margin-left:8px;">${esc(it.period)}</div></div>${it.desc ? `<div style="font-size:${p.fontSize||11}px; color:#222; margin-top:3px; line-height:1.5;">${safeText(it.desc)}</div>` : ''}</div>`).join('');
                return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
            }
            case 'education': {
                const items = parseItems(p.items);
                const rows = items.map(it => `<div style="margin-bottom:8px;"><div style="display:flex; justify-content:space-between; align-items:flex-start;"><div><div style="font-size:${p.fontSize||11}px; font-weight:700; color:#0d0d0d;">${esc(it.degree)}</div><div style="font-size:${p.fontSize||11}px; color:#333;">${esc(it.school)}${it.gpa?' · '+esc(it.gpa):''}</div></div><div style="font-size:${(parseInt(p.fontSize||11)-1)}px; color:#555; white-space:nowrap; margin-left:8px;">${esc(it.period)}</div></div>${it.desc ? `<div style="font-size:${p.fontSize||11}px; color:#222; margin-top:2px; line-height:1.5;">${safeText(it.desc)}</div>` : ''}</div>`).join('');
                return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
            }
            case 'project': {
                const items = parseItems(p.items);
                const rows = items.map(it => `<div style="margin-bottom:8px;"><div style="display:flex; justify-content:space-between;"><div style="font-size:${p.fontSize||11}px; font-weight:700; color:#0d0d0d;">${esc(it.name)} ${it.link?`<span style="color:#16a34a; font-weight:400; font-size:10px;">${esc(it.link)}</span>`:''}</div><div style="font-size:${(parseInt(p.fontSize||11)-1)}px; color:#555;">${esc(it.period)}</div></div><div style="font-size:${p.fontSize||11}px; color:#333;">${esc(it.tech)}</div>${it.desc ? `<div style="font-size:${p.fontSize||11}px; color:#222; margin-top:2px; line-height:1.5;">${safeText(it.desc)}</div>` : ''}</div>`).join('');
                return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
            }
            case 'certification': case 'award': {
                const items = parseItems(p.items);
                const rows = items.map(it => `<div style="display:flex; justify-content:space-between; margin-bottom:4px; font-size:${p.fontSize||11}px; color:#000;"><div><strong>${esc(it.name)}</strong> — ${esc(it.issuer||it.org)}${it.desc?' · '+esc(it.desc):''}${it.link?` <span style="color:#16a34a; font-size:10px;">(${esc(it.link)})</span>`:''}</div><div style="color:#555;">${esc(it.year)}</div></div>`).join('');
                return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
            }
            case 'publication': {
                const items = parseItems(p.items);
                const rows = items.map(it => `<div style="margin-bottom:6px; font-size:${p.fontSize||11}px; color:#000;"><strong>${esc(it.title)}</strong> — <span style="font-style:italic; color:#333;">${esc(it.publisher)}</span> (${esc(it.year)})${it.link ? `<br><span style="color:#16a34a; font-size:10px;">${esc(it.link)}</span>` : ''}</div>`).join('');
                return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
            }
            case 'portfolio': case 'references': {
                const items = parseItems(p.items);
                const rows = items.map(it=>`<div style="margin-bottom:8px; font-size:${p.fontSize||11}px; color:#000;"><div style="font-weight:700;">${esc(it.name||it.title)} <span style="color:#16a34a; font-weight:400; font-size:10px;">${esc(it.url||'')}</span></div><div style="color:#333;">${esc(it.title||it.desc||'')}</div>${it.phone?`<div style="color:#333;">${esc(it.phone)} · ${esc(it.email)}</div>`:''}</div>`).join('');
                return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
            }
            case 'skills': {
                const items = parseItems(p.items);
                let body = p.style === 'grouped' ? items.map(it => `<div style="margin-bottom:4px; font-size:${p.fontSize||11}px; color:#000;"><strong>${esc(it.category)}:</strong> ${esc(it.list)}</div>`).join('') : `<div style="font-size:${p.fontSize||11}px; color:#000000;">${items.map(it=>esc(it.list)).join(', ')}</div>`;
                return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${body}`);
            }
            case 'languages': {
                const items = parseItems(p.items);
                const rows = items.map(it=>`<div style="display:flex; justify-content:space-between; font-size:${p.fontSize||11}px; margin-bottom:3px; color:#000;"><span>${esc(it.lang)}</span><span style="color:#333;">${esc(it.level)}</span></div>`).join('');
                return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
            }
            case 'interests': {
                const tags = (p.list||'').split(',').map(s=>s.trim()).filter(Boolean);
                const body = `<div style="display:flex; flex-wrap:wrap; gap:6px;">${tags.map(t=>`<span style="font-size:${p.fontSize||11}px; background:#f1f5f9; padding:2px 10px; border-radius:20px; color:#000000; border:1px solid #ccc;">${esc(t)}</span>`).join('')}</div>`;
                return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${body}`);
            }
            case 'social': {
                const items = [];
                if (p.linkedin) items.push(`<div><i class="fab fa-linkedin" style="color:#000; width:14px;"></i> ${esc(p.linkedin)}</div>`);
                if (p.github) items.push(`<div><i class="fab fa-github" style="color:#000; width:14px;"></i> ${esc(p.github)}</div>`);
                if (p.twitter) items.push(`<div><i class="fab fa-twitter" style="color:#000; width:14px;"></i> ${esc(p.twitter)}</div>`);
                if (p.instagram) items.push(`<div><i class="fab fa-instagram" style="color:#000; width:14px;"></i> ${esc(p.instagram)}</div>`);
                return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}<div style="font-size:${p.fontSize||11}px; line-height:2; color:#000000;">${items.join('')}</div>`);
            }
            case 'divider': return wrap(`<hr style="border:none; border-top:${p.thickness||1}px solid ${p.color||'#000000'}; margin:0;">`);
            case 'spacer': return wrap(`<div style="height:${p.height||20}px;"></div>`);
            case 'text_block': {
                const fw = (p.bold===true||p.bold==='true') ? 'bold' : 'normal';
                const fi = (p.italic===true||p.italic==='true') ? 'italic' : 'normal';
                return wrap(`<div style="font-size:${p.fontSize||11}px; color:${p.color||'#000000'}; text-align:${p.align||'left'}; font-weight:${fw}; font-style:${fi}; line-height:1.6;">${safeText(p.text)}</div>`);
            }
            case 'section_title': {
                const border = (p.showLine===true||p.showLine==='true') ? `border-bottom:${p.lineThickness||'1.5'}px solid ${p.lineColor||'#0d0d0d'};` : '';
                return wrap(`<div style="padding-bottom:3px; margin-bottom:4px; ${border}"><span style="font-size:${p.fontSize||12}px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:${p.color||'#0d0d0d'}; text-align:${p.align||'left'}; display:block;">${esc(p.text)}</span></div>`);
            }
            default: return '';
        }
    }

    window.updateProp = function(blockId, key, value) {
        const block = findBlock(blockId, schema);
        if(block) { block.props[key] = value; renderCanvas(); }
    }
    
    window.updateItemProp = function(blockId, idx, key, value) {
        const block = findBlock(blockId, schema);
        if(block) {
            let items = parseItems(block.props.items);
            if(items[idx]) { items[idx][key] = value; block.props.items = JSON.stringify(items); renderCanvas(); }
        }
    }

    window.uploadUserPhoto = function(id, input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) { updateProp(id, 'imageUrl', e.target.result); };
            reader.readAsDataURL(input.files[0]);
        }
    }

    window.addUserItem = function(blockId, type) {
        const block = findBlock(blockId, schema); if (!block) return;
        let items = parseItems(block.props.items);
        const newItems = {
            experience: { title:'Posisi', company:'Perusahaan', location:'', period:'2024', desc:'' },
            volunteer: { role:'Peran', org:'Organisasi', period:'2024', desc:'' },
            education: { degree:'Gelar', school:'Instansi', gpa:'', period:'2024', desc:'' },
            organization: { role:'Peran', org:'Organisasi', period:'2024', desc:'' },
            project: { name:'Proyek Baru', link:'', tech:'Alat', period:'2024', desc:'' },
            certification: { name:'Sertifikat', issuer:'Penerbit', year:'2024', link:'' },
            award: { name:'Penghargaan', org:'Penyelenggara', year:'2024', desc:'' },
            publication: { title:'Judul', publisher:'Penerbit', year:'2024', link:'' },
            portfolio: { title:'Judul', url:'', desc:'' },
            references: { name:'Nama', title:'Jabatan', phone:'', email:'' },
            skills: { category:'Kategori', list:'Skill 1, Skill 2' },
            languages: { lang:'Bahasa', level:'Menengah' }
        };
        items.push(newItems[type] || {}); 
        block.props.items = JSON.stringify(items);
        renderCanvas(); buildSidebarForms(); 
    }

    window.removeUserItem = function(blockId, idx) {
        const block = findBlock(blockId, schema); if (!block) return;
        let items = parseItems(block.props.items);
        items.splice(idx, 1); block.props.items = JSON.stringify(items);
        renderCanvas(); buildSidebarForms(); 
    }

    const tabMapping = {
        'header': 'personal', 'photo': 'personal', 'contact': 'personal', 'summary': 'personal', 'text_block': 'personal',
        'experience': 'experience', 'volunteer': 'experience', 'organization': 'experience', 'project': 'experience',
        'education': 'education', 'certification': 'education', 'award': 'education', 'publication': 'education',
        'skills': 'skills', 'languages': 'skills', 'interests': 'skills', 'social': 'skills', 'portfolio': 'skills', 'references': 'skills'
    };

    function buildSidebarForms() {
        document.getElementById('section-personal').innerHTML = '';
        document.getElementById('section-experience').innerHTML = '';
        document.getElementById('section-education').innerHTML = '';
        document.getElementById('section-skills').innerHTML = '';
        traverseForForms(schema);
    }

    function traverseForForms(arr) {
        arr.forEach(block => {
            if(block.isLayout) {
                if(block.layoutType === 'col1') traverseForForms(block.children || []);
                else (block.columns || []).forEach(col => traverseForForms(col));
            } else {
                createFormHTML(block);
            }
        });
    }

    function createFormHTML(block) {
        const targetTab = tabMapping[block.type] || 'personal';
        const section = document.getElementById('section-' + targetTab);
        if(!section) return;

        let html = ''; const p = block.props; const id = block.id;

        const input = (label, key, val, type='text') => `<div class="field"><label class="label">${label}</label><input type="${type}" class="input" value="${esc(val)}" oninput="updateProp('${id}', '${key}', this.value)"></div>`;
        const textarea = (label, key, val) => `<div class="field"><label class="label">${label}</label><textarea class="textarea" oninput="updateProp('${id}', '${key}', this.value)">${esc(val)}</textarea></div>`;
        const itemInput = (idx, label, key, val) => `<div class="field"><label class="label">${label}</label><input type="text" class="input" value="${esc(val)}" oninput="updateItemProp('${id}', ${idx}, '${key}', this.value)"></div>`;
        const itemTextarea = (idx, label, key, val) => `<div class="field"><label class="label">${label}</label><textarea class="textarea" oninput="updateItemProp('${id}', ${idx}, '${key}', this.value)">${esc(val)}</textarea></div>`;

        if(block.type === 'spacer' || block.type === 'divider' || block.type === 'section_title') return;

        html += `<div class="section-label">${p.heading || block.type.toUpperCase()}</div>`;

        if(block.type === 'header') {
            html += input('Nama Lengkap', 'name', p.name) + input('Posisi / Profesi', 'title', p.title);
            if(p.showPhoto === true || p.showPhoto === 'true') html += `<div class="field"><label class="label">Upload Foto</label><input type="file" class="input" accept="image/*" onchange="uploadUserPhoto('${id}', this)"></div>`;
        } 
        else if(block.type === 'photo') {
            html += `<div class="field"><label class="label">Upload Foto</label><input type="file" class="input" accept="image/*" onchange="uploadUserPhoto('${id}', this)"></div>`;
        }
        else if(block.type === 'contact') {
            html += input('Nomor Telepon', 'phone', p.phone) + input('Email', 'email', p.email) + input('Alamat', 'address', p.address) + input('Website / LinkedIn', 'website', p.website);
        }
        else if(block.type === 'summary') { html += textarea('Profil Diri', 'text', p.text); }
        else if(block.type === 'text_block') { html += textarea('Teks', 'text', p.text); }
        else if(block.type === 'interests') { html += textarea('Daftar Minat (Pisah Koma)', 'list', p.list); }
        else if(block.type === 'social') {
            html += input('LinkedIn', 'linkedin', p.linkedin) + input('GitHub', 'github', p.github) + input('Twitter', 'twitter', p.twitter) + input('Instagram', 'instagram', p.instagram);
        }
        else {
            const labelMap = { experience: 'Pengalaman', volunteer: 'Sukarelawan', project: 'Proyek', education: 'Pendidikan', certification: 'Sertifikasi', award: 'Penghargaan', publication: 'Publikasi', portfolio: 'Portfolio', organization: 'Organisasi', references: 'Referensi', skills: 'Keahlian', languages: 'Bahasa' };
            if(!labelMap[block.type]) return;

            let items = parseItems(p.items);
            items.forEach((it, idx) => {
                html += `<div class="card"><button class="icon-btn delete" onclick="removeUserItem('${id}', ${idx})"><i class="fas fa-trash-alt"></i></button><div style="margin-bottom: 12px; font-weight: 600;">Item #${idx+1}</div>`;
                switch(block.type) {
                    case 'experience': html += itemInput(idx, 'Jabatan', 'title', it.title) + itemInput(idx, 'Perusahaan', 'company', it.company) + itemInput(idx, 'Lokasi', 'location', it.location) + itemInput(idx, 'Periode', 'period', it.period) + itemTextarea(idx, 'Deskripsi', 'desc', it.desc); break;
                    case 'volunteer': html += itemInput(idx, 'Peran', 'role', it.role) + itemInput(idx, 'Organisasi', 'org', it.org) + itemInput(idx, 'Periode', 'period', it.period) + itemTextarea(idx, 'Deskripsi', 'desc', it.desc); break;
                    case 'education': html += itemInput(idx, 'Gelar', 'degree', it.degree) + itemInput(idx, 'Institusi', 'school', it.school) + itemInput(idx, 'Periode', 'period', it.period) + itemInput(idx, 'IPK/Nilai', 'gpa', it.gpa) + itemTextarea(idx, 'Catatan Tambahan', 'desc', it.desc); break;
                    case 'certification': html += itemInput(idx, 'Sertifikat', 'name', it.name) + itemInput(idx, 'Penerbit', 'issuer', it.issuer) + itemInput(idx, 'Tahun', 'year', it.year) + itemInput(idx, 'Link URL', 'link', it.link); break;
                    case 'project': html += itemInput(idx, 'Nama Proyek', 'name', it.name) + itemInput(idx, 'Link URL', 'link', it.link) + itemInput(idx, 'Teknologi', 'tech', it.tech) + itemInput(idx, 'Periode', 'period', it.period) + itemTextarea(idx, 'Deskripsi', 'desc', it.desc); break;
                    case 'award': html += itemInput(idx, 'Penghargaan', 'name', it.name) + itemInput(idx, 'Penyelenggara', 'org', it.org) + itemInput(idx, 'Tahun', 'year', it.year) + itemTextarea(idx, 'Deskripsi', 'desc', it.desc); break;
                    case 'publication': html += itemInput(idx, 'Judul', 'title', it.title) + itemInput(idx, 'Penerbit', 'publisher', it.publisher) + itemInput(idx, 'Tahun', 'year', it.year) + itemInput(idx, 'Link URL', 'link', it.link); break;
                    case 'organization': html += itemInput(idx, 'Peran', 'role', it.role) + itemInput(idx, 'Organisasi', 'org', it.org) + itemInput(idx, 'Periode', 'period', it.period) + itemTextarea(idx, 'Deskripsi', 'desc', it.desc); break;
                    case 'portfolio': html += itemInput(idx, 'Judul', 'title', it.title) + itemInput(idx, 'Link URL', 'url', it.url) + itemTextarea(idx, 'Deskripsi', 'desc', it.desc); break;
                    case 'references': html += itemInput(idx, 'Nama', 'name', it.name) + itemInput(idx, 'Jabatan', 'title', it.title) + itemInput(idx, 'Telepon', 'phone', it.phone) + itemInput(idx, 'Email', 'email', it.email); break;
                    case 'skills': html += itemInput(idx, 'Kategori', 'category', it.category) + itemInput(idx, 'Keahlian (Pisah Koma)', 'list', it.list); break;
                    case 'languages': html += itemInput(idx, 'Bahasa', 'lang', it.lang) + itemInput(idx, 'Tingkat', 'level', it.level); break;
                }
                html += `</div>`;
            });
            html += `<button class="add-btn" onclick="addUserItem('${id}', '${block.type}')"><i class="fas fa-plus"></i> Tambah ${labelMap[block.type]}</button>`;
        }

        section.innerHTML += html;
    }

    const tabs = document.querySelectorAll('.tab');
    const sections = document.querySelectorAll('.section');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            sections.forEach(s => s.classList.remove('active'));
            tab.classList.add('active');
            document.getElementById('section-' + tab.dataset.section).classList.add('active');
        });
    });

    let zoomLevel = 100;
    window.zoomIn = () => { if(zoomLevel < 150) { zoomLevel += 10; applyZoom(); } }
    window.zoomOut = () => { if(zoomLevel > 50) { zoomLevel -= 10; applyZoom(); } }
    function applyZoom() {
        document.getElementById('zoomVal').innerText = zoomLevel + '%';
        document.getElementById('cv-paper').style.transform = `scale(${zoomLevel/100})`;
    }

    window.saveData = function(statusType) {
        const btnId = statusType === 'completed' ? 'btnDone' : 'btnDraft';
        const btn = document.getElementById(btnId);
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;

        const docTitle = document.getElementById('documentTitle').value || 'Untitled Resume';

        const payload = { cv_template_id: cvTemplateId, resume_id: resumeId, title: docTitle, layout_schema: schema, global_settings: globalSettings, status: statusType };

        fetch('{{ route("resume.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', 'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        }).then(res => res.json())
        .then(data => {
            btn.innerHTML = originalText; btn.disabled = false;
            if(data.success) {
                const notify = document.getElementById('notifyBox');
                document.getElementById('notifyMsg').innerText = statusType === 'completed' ? 'CV Berhasil Diselesaikan!' : 'Draft Tersimpan!';
                notify.classList.add('show'); setTimeout(() => notify.classList.remove('show'), 3000);
                if(!resumeId && data.resume_id) resumeId = data.resume_id;
            } else { alert('Gagal menyimpan: ' + (data.message || 'Error tidak diketahui')); }
        }).catch(err => {
            btn.innerHTML = originalText; btn.disabled = false;
            console.error('Error:', err); alert('Terjadi kesalahan jaringan.');
        });
    }

    window.downloadPDF = async function() {
        const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};

        if (!isAuthenticated) {
            const resumeData = {
                cv_template_id: cvTemplateId, 
                layout_schema: schema, 
                global_settings: globalSettings, 
                status: 'draft',
                title: document.getElementById('documentTitle') ? document.getElementById('documentTitle').value : 'Untitled Resume',
                resume_id: typeof resumeId !== 'undefined' ? resumeId : null
            };

            const btn = document.querySelector('button[onclick="downloadPDF()"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            btn.disabled = true;

            try {
                const response = await fetch("{{ route('resume.save') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(resumeData)
                });

                const result = await response.json();

                if (result.success) {

                    Swal.fire({
                        html: `
                            <div style="text-align: center; padding: 10px 10px 0;">
                                <div style="background: #ecfdf5; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                    <i class="fas fa-lock" style="font-size: 36px; color: #10b981;"></i>
                                </div>
                                
                                <h3 style="font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 12px; letter-spacing: -0.5px;">
                                    Desain CV Anda Sudah Siap! 
                                </h3>
                                
                                <p style="font-size: 15px; color: #4b5563; line-height: 1.6; margin-bottom: 24px;">
                                    Kerja bagus! Data CV Anda telah kami simpan dengan aman.
                                </p>
                                
                                <div style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 16px; border-radius: 16px; font-size: 14px; color: #6b7280; text-align: left; display: flex; align-items: flex-start; gap: 14px;">
                                    <div style="margin-top: 2px;">
                                        <i class="fas fa-info-circle" style="font-size: 20px; color: #3b82f6;"></i>
                                    </div>
                                    <div style="line-height: 1.5;">
                                        Silakan <b>Masuk</b> atau <b>Buat Akun</b> gratis sekarang untuk menyimpan permanen dan mengunduh versi PDF berkualitas tinggi.
                                    </div>
                                </div>
                            </div>
                        `,
                        width: 480,
                        showCloseButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Akses Akun Sekarang <i class="fas fa-arrow-right" style="margin-left: 6px;"></i>',
                        cancelButtonText: 'Kembali Edit',
                        confirmButtonColor: '#10b981', 
                        backdrop: `rgba(17, 24, 39, 0.7)`, 
                        allowOutsideClick: false,
                        customClass: {
                            popup: 'swal-custom-popup',
                            confirmButton: 'swal-btn-confirm',
                            cancelButton: 'swal-btn-cancel'
                        }
                    }).then((res) => {
                        if (res.isConfirmed) {
                            Swal.showLoading(); 
                            window.location.href = "{{ route('login') }}";
                        }
                    });
                } else {
                    Swal.fire('Error', 'Gagal menyimpan data sementara.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }

            return; 
        }

        const element = document.getElementById('cv-paper');
        
        const titleInput = document.getElementById('documentTitle');
        const fileName = (titleInput && titleInput.value.trim() !== '') ? titleInput.value.trim() : 'My_Resume';
        
        const originalTransform = element.style.transform;
        element.style.transform = 'scale(1)';

        const opt = {
            margin:       0,
            filename:     `${fileName}.pdf`,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { 
                scale: 2, 
                useCORS: true, 
                allowTaint: true
            },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        const btn = document.querySelector('button[onclick="downloadPDF()"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="color: #dc2626;"></i> Memproses...';
        btn.disabled = true;

        html2pdf().set(opt).from(element).save().then(() => {
            element.style.transform = originalTransform; 
            btn.innerHTML = originalText;
            btn.disabled = false;

            if(typeof resumeId !== 'undefined' && resumeId) {
                fetch(`/resume/${resumeId}/increment-download`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => console.log("Statistik berhasil diupdate:", data))
                .catch(err => console.error("Gagal update statistik:", err));
            }

            if (typeof showNotify === 'function') {
                showNotify('PDF berhasil diunduh!');
            } else {
                Swal.fire('Sukses', 'PDF berhasil diunduh!', 'success');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderCanvas();
        buildSidebarForms();

        if (window.innerWidth <= 992) {
            zoomLevel = 100;
            applyZoom();
        }
    });

    window.checkAtsScore = function() {
        const btn = document.getElementById('btn-check-ats');
        const resultContainer = document.getElementById('ats-modal');
        const scoreDisplay = document.getElementById('ats-score-display');
        const feedbackList = document.getElementById('ats-feedback-list');

        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="color: #3b82f6;"></i> Memproses...';
        btn.disabled = true;

        setTimeout(() => {
            let score = 0;
            let feedback = [];
            
            let blocks = [];
            function extractBlocks(arr) {
                arr.forEach(b => {
                    if (b.isLayout) {
                        if (b.layoutType === 'col1') extractBlocks(b.children || []);
                        else (b.columns || []).forEach(col => extractBlocks(col));
                    } else {
                        blocks.push(b);
                    }
                });
            }
            extractBlocks(schema);

            let hasContact = false, hasSummary = false, hasExperience = false, hasSkills = false;

            blocks.forEach(b => {
                const p = b.props;
                if (b.type === 'contact') {
                    hasContact = true;
                    if (p.email && p.phone) { score += 15; }
                    else { feedback.push("Lengkapi Email dan Nomor Telepon di bagian Kontak."); score += 5; }
                }
                if (b.type === 'summary') {
                    hasSummary = true;
                    if (p.text && p.text.split(' ').length >= 15) { score += 15; }
                    else { feedback.push("Profil Diri terlalu pendek. Buat minimal 15 kata."); score += 5; }
                }
                if (b.type === 'experience') {
                    hasExperience = true;
                    let items = parseItems(p.items);
                    if (items && items.length > 0) { 
                        score += 40; 
                        let descText = items.map(i => i.desc).join(' ').toLowerCase();
                        if(!descText.includes('mengembangkan') && !descText.includes('membuat') && !descText.includes('mengelola')) {
                            feedback.push("Gunakan kata kerja aktif di deskripsi pengalaman (misal: 'mengelola').");
                            score -= 5;
                        }
                    } else {
                        feedback.push("Tambahkan riwayat Pengalaman Kerja Anda.");
                    }
                }
                if (b.type === 'skills') {
                    hasSkills = true;
                    let items = parseItems(p.items);
                    if (items && items.length > 0 && items[0].list.split(',').length >= 3) {
                        score += 30;
                    } else {
                        feedback.push("Tambahkan minimal 3 keahlian/skills yang relevan.");
                        score += 10;
                    }
                }
            });

            if(!hasContact) feedback.push("CV Anda belum memiliki bagian Kontak (Email/Telepon).");
            if(!hasSummary) feedback.push("Tambahkan Profil Diri (Summary).");
            if(!hasExperience) feedback.push("Pengalaman kerja sangat penting untuk dinilai oleh ATS.");
            if(!hasSkills) feedback.push("Jangan lupa tambahkan bagian Keahlian (Skills).");

            let finalScore = Math.min(score, 100);
            if (finalScore === 0) finalScore = 15;

            resultContainer.style.display = 'flex';
            
            let currentScore = 0;
            let interval = setInterval(() => {
                if(currentScore >= finalScore) {
                    clearInterval(interval);
                    scoreDisplay.innerText = finalScore;
                } else {
                    currentScore++;
                    scoreDisplay.innerText = currentScore;
                }
            }, 15);

            feedbackList.innerHTML = '';
            if(finalScore >= 95) {
                feedbackList.innerHTML = '<li style="color: #16a34a; font-weight: 600; list-style: none;"><i class="fas fa-check-circle"></i> Sempurna! CV Anda sangat ATS-Friendly.</li>';
            } else {
                feedback.forEach(item => {
                    let li = document.createElement('li');
                    li.innerText = item;
                    feedbackList.appendChild(li);
                });
            }

            btn.innerHTML = '<i class="fas fa-chart-line" style="color: #3b82f6;"></i> Skor ATS';
            btn.disabled = false;

        }, 800);
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</body>
</html>