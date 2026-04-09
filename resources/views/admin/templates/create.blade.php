<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buat Template CV - Admin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Roboto:wght@400;500;700&family=Merriweather:wght@400;700&family=Lora:wght@400;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --ink: #111827;         
    --ink2: #4b5563;        
    --muted: #9ca3af;       
    --line: #e5e7eb;        
    --bg: #f9fafb;          
    --panel: #ffffff;       
    --canvas-bg: #e5e5e5;   
    --item-card-bg: #f8fafc; 
    
    --accent: #16a34a; 
    --accent-soft: #f0fdf4;
    --accent-hover: #15803d;
    --danger: #e53e3e;
    --block-hover: rgba(22, 163, 74, 0.06);
    --block-active: rgba(22, 163, 74, 0.1);
  }

  body.dark-mode {
    --ink: #f9fafb;
    --ink2: #d1d5db;
    --muted: #9ca3af;
    --line: #374151;
    --bg: #111827;
    --panel: #1f2937;
    --canvas-bg: #030712;
    --item-card-bg: #111827; 
    
    --accent: #22c55e;
    --accent-soft: rgba(34, 197, 94, 0.1);
    --accent-hover: #16a34a;
    --block-hover: rgba(255, 255, 255, 0.06);
    --block-active: rgba(255, 255, 255, 0.12);
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--ink);
    overflow: hidden;
    height: 100vh;
    display: flex;
    flex-direction: column;
    transition: background 0.3s, color 0.3s;
  }

  .topbar {
    height: 56px; background: var(--panel); border-bottom: 1px solid var(--line);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 20px; flex-shrink: 0; gap: 12px; z-index: 100;
    transition: background 0.3s, border-color 0.3s;
  }
  .topbar-left { display: flex; align-items: center; gap: 14px; }
  .topbar-logo { font-weight: 700; font-size: 16px; letter-spacing: 0.5px; color: var(--accent); }
  .topbar-divider { width: 1px; height: 22px; background: var(--line); }
  
  .font-select {
    background: var(--bg); border: 1px solid var(--line);
    color: var(--ink); border-radius: 4px; padding: 6px 10px; font-size: 13px; outline: none; cursor: pointer;
  }

  .btn-icon {
    background: transparent; color: var(--ink); border: none; padding: 6px 10px; border-radius: 4px;
    cursor: pointer; font-size: 15px; transition: 0.2s; opacity: 0.7;
  }
  .btn-icon:hover:not(:disabled) { background: var(--accent-soft); opacity: 1; }
  .btn-icon:disabled { opacity: 0.3; cursor: not-allowed; }

  .topbar-right { display: flex; align-items: center; gap: 8px; }
  .btn-top {
    height: 34px; padding: 0 16px; border-radius: 6px; border: none; cursor: pointer;
    font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 7px; transition: all 0.2s;
  }
  .btn-ghost { background: var(--bg); color: var(--ink); border: 1px solid var(--line); }
  .btn-ghost:hover { background: var(--line); }
  .btn-primary { background: var(--accent); color: #ffffff; }
  .btn-primary:hover { background: var(--accent-hover); }
  .btn-danger { background: var(--danger); color: #ffffff; }
  .btn-danger:hover { filter: brightness(0.9); }

  .app-body { display: flex; flex: 1; overflow: hidden; }

  .panel-left { 
    background: var(--panel); border-right: 1px solid var(--line); 
    width: 280px; overflow-y: auto; display: flex; flex-direction: column; flex-shrink: 0;
    transition: margin-left 0.3s ease, opacity 0.2s ease;
  }
  .panel-left.hidden { margin-left: -280px; opacity: 0; }
  .panel-left::-webkit-scrollbar { width: 4px; }
  .panel-left::-webkit-scrollbar-thumb { background: var(--line); border-radius: 4px; }

  .sidebar-section { padding: 16px; border-bottom: 1px solid var(--line); }
  .sidebar-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--muted); margin-bottom: 10px; }

  .tool-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
  .tool-card {
    background: var(--bg); border: 1px solid var(--line); border-radius: 6px;
    padding: 12px 8px; cursor: grab; display: flex; flex-direction: column;
    align-items: center; gap: 8px; font-size: 11px; font-weight: 500;
    color: var(--ink); transition: all 0.2s; text-align: center; user-select: none;
  }
  .tool-card:hover { border-color: var(--accent); background: var(--accent-soft); }
  .tool-card i { font-size: 16px; color: var(--ink); opacity: 0.8; }
  .tool-card.full-width { grid-column: 1 / -1; flex-direction: row; justify-content: flex-start; gap: 12px; padding: 10px 14px; }

  .canvas-area { flex: 1; overflow: auto; padding: 40px 30px; background: var(--canvas-bg); display: flex; justify-content: center; align-items: flex-start; transition: background 0.3s; }
  .canvas-area::-webkit-scrollbar { width: 8px; height: 8px; }
  .canvas-area::-webkit-scrollbar-thumb { background: var(--muted); border-radius: 4px; }

  .paper {
    background: #ffffff; width: 210mm; min-height: 297mm;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); position: relative; overflow: visible;
    transition: font-family 0.3s ease;
    color: #000000; 
  }
  body.dark-mode .paper { box-shadow: 0 0 0 1px #333, 0 25px 50px -12px rgba(0,0,0,0.8); }

  .drop-zone { min-height: 40px; position: relative; transition: background 0.15s; }
  .drop-zone.drag-over { background: rgba(0,0,0,0.05); outline: 2px dashed #000; outline-offset: -2px; }
  .drop-zone-hint { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: #888; font-size: 12px; pointer-events: none; opacity: 0; transition: opacity 0.2s; }
  .drop-zone:empty .drop-zone-hint, .paper-dropzone:empty .drop-zone-hint { opacity: 1; }

  .cv-block { position: relative; cursor: pointer; transition: background 0.15s; }
  .cv-block:hover { background: rgba(0,0,0,0.03); }
  .cv-block.selected { background: rgba(0,0,0,0.05); outline: 2px solid #000; outline-offset: -1px; z-index: 5; }

  .block-toolbar { position: absolute; top: 0; right: 0; background: #000; border-radius: 0 0 0 6px; display: none; gap: 0; z-index: 20; overflow: hidden; }
  .cv-block:hover .block-toolbar, .cv-block.selected .block-toolbar { display: flex; }
  .btb { background: none; border: none; color: white; cursor: pointer; width: 28px; height: 26px; display: flex; align-items: center; justify-content: center; font-size: 11px; transition: background 0.1s; }
  .btb:hover { background: #333; }
  .btb.del:hover { background: #e53e3e; }

  .paper-dropzone { min-height: 297mm; padding: 20mm; position: relative; }
  .paper-dropzone.drag-over { background: rgba(0,0,0,0.05); }
  .paper-dropzone:empty::after { content: "Drag Element Disini"; position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: #888; font-size: 14px; pointer-events: none; }

  .two-col-block { display: grid; gap: 0; }
  .two-col-block .col-drop { min-height: 60px; border: 1px dashed #ccc; position: relative; padding: 4px; transition: background 0.15s; }
  .two-col-block .col-drop.drag-over { background: rgba(0,0,0,0.05); border-color: #000; }
  .two-col-block .col-drop:empty::after { content: "Drag Element Disini"; position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: #888; font-size: 11px; pointer-events: none; opacity: 0.6; }

  .cv-el { padding: 0; }

  .panel-right { width: 300px; flex-shrink: 0; background: var(--panel); border-left: 1px solid var(--line); overflow-y: auto; display: flex; flex-direction: column; transition: 0.3s; }
  .panel-right::-webkit-scrollbar { width: 4px; }
  .panel-right::-webkit-scrollbar-thumb { background: var(--line); border-radius: 4px; }

  .prop-header { padding: 14px 16px; border-bottom: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; }
  .prop-title { font-size: 13px; font-weight: 700; color: var(--ink); text-transform: uppercase; }
  .prop-body { padding: 14px 16px; flex: 1; }
  .prop-empty { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; padding: 30px; color: var(--muted); font-size: 13px; text-align: center; }
  .prop-empty i { font-size: 28px; opacity: 0.3; }

  .form-row { margin-bottom: 14px; }
  .form-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--muted); display: block; margin-bottom: 5px; }
  .form-input, .form-select, .form-textarea { width: 100%; padding: 8px 10px; border: 1px solid var(--line); border-radius: 4px; font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--ink); outline: none; transition: border 0.15s; background: var(--bg); }
  .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--accent); }
  .form-textarea { min-height: 70px; resize: vertical; }
  .form-color { height: 34px; padding: 2px 4px; cursor: pointer; }
  .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
  .prop-divider { border: none; border-top: 1px solid var(--line); margin: 16px 0; }

  .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; backdrop-filter: blur(3px); z-index: 9999; }
  .modal-content { background: var(--panel); border-radius: 8px; padding: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); max-height: 90vh; overflow-y: auto; border: 1px solid var(--line); position: relative; }

  .toast { position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%); background: var(--ink); color: var(--bg); padding: 12px 24px; border-radius: 6px; font-weight: 500; font-size: 13px; z-index: 10002; animation: toastIn 0.3s ease, toastOut 0.3s ease 2.2s forwards; pointer-events: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
  @keyframes toastIn { from { opacity: 0; transform: translateX(-50%) translateY(20px); } to { opacity: 1; transform: translateX(-50%) translateY(0); } }
  @keyframes toastOut { to { opacity: 0; } }

  .sortable-drag { opacity: 0.4; }
  .sortable-ghost { opacity: 0.3; background: #000 !important; }
</style>
</head>
<body>

@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let errorMsg = "Terdapat kesalahan:\n";
        @foreach ($errors->all() as $error)
            errorMsg += "- {{ $error }}\n";
        @endforeach
        customAlert(errorMsg);
    });
</script>
@endif

<div class="topbar">
  <div class="topbar-left">
    <button class="btn-icon" onclick="toggleSidebar()" title="Sembunyikan/Tampilkan Panel"><i class="fas fa-bars"></i></button>
    <span class="topbar-logo">Resumate <span style="font-weight:400; color:var(--muted); font-size:13px; margin-left:5px;">(Create Mode)</span></span>
    <div class="topbar-divider"></div>
    <button class="btn-icon" id="btnTheme" onclick="toggleTheme()" title="Dark/Light Mode"><i class="fas fa-moon" id="themeIcon"></i></button>
    <div class="topbar-divider"></div>
    <select id="globalFont" class="font-select" onchange="changeGlobalFont()">
      <option value="'DM Sans', sans-serif">DM Sans (Modern)</option>
      <option value="'Inter', sans-serif">Inter (Bersih)</option>
      <option value="Arial, sans-serif">Arial (Standar ATS)</option>
      <option value="'Roboto', sans-serif">Roboto (Tegas)</option>
      <option value="'Times New Roman', Times, serif">Times New Roman</option>
      <option value="'Merriweather', serif">Merriweather</option>
      <option value="'Lora', serif">Lora (Elegan)</option>
    </select>
  </div>
  
  <div class="topbar-center">
    <button class="btn-icon" id="btnUndo" onclick="undo()" title="Undo (Ctrl+Z)" disabled><i class="fas fa-undo"></i></button>
    <button class="btn-icon" id="btnRedo" onclick="redo()" title="Redo (Ctrl+Y)" disabled><i class="fas fa-redo"></i></button>
  </div>

  <div class="topbar-right">
    <button class="btn-top btn-ghost" onclick="promptClearCanvas()"><i class="fas fa-trash"></i> Bersihkan</button>
    <button class="btn-top btn-primary" onclick="openSaveModal()"><i class="fas fa-save"></i> Simpan Template</button>
  </div>
</div>

<div class="app-body">

  <div class="panel-left" id="sidebar">
    <div class="sidebar-section">
      <div class="sidebar-label">Layout Kolom</div>
      <div class="tool-grid">
        <div class="tool-card full-width" draggable="true" data-type="col1" ondragstart="onToolDrag(event)"><i class="fas fa-square"></i> <span>1 Kolom (Full)</span></div>
        <div class="tool-card full-width" draggable="true" data-type="col2_50_50" ondragstart="onToolDrag(event)"><i class="fas fa-columns"></i> <span>2 Kolom (50/50)</span></div>
        <div class="tool-card full-width" draggable="true" data-type="col2_30_70" ondragstart="onToolDrag(event)"><i class="fas fa-columns"></i> <span>2 Kolom (30/70)</span></div>
        <div class="tool-card full-width" draggable="true" data-type="col2_70_30" ondragstart="onToolDrag(event)"><i class="fas fa-columns" style="transform: scaleX(-1);"></i> <span>2 Kolom (70/30)</span></div>
      </div>
    </div>

    <div class="sidebar-section">
      <div class="sidebar-label">Identitas</div>
      <div class="tool-grid">
        <div class="tool-card full-width" draggable="true" data-type="header" ondragstart="onToolDrag(event)" title="Termasuk Nama, Posisi, dan Pas Foto">
          <i class="fas fa-id-badge"></i> Header & Foto
        </div>
        <div class="tool-card" draggable="true" data-type="photo" ondragstart="onToolDrag(event)" title="Hanya Pas Foto Saja">
          <i class="fas fa-camera"></i> Pas Foto
        </div>
        <div class="tool-card" draggable="true" data-type="contact" ondragstart="onToolDrag(event)">
          <i class="fas fa-address-card"></i> Kontak
        </div>
        <div class="tool-card full-width" draggable="true" data-type="summary" ondragstart="onToolDrag(event)">
          <i class="fas fa-align-left"></i> Profil Diri (Tentang Saya)
        </div>
      </div>
    </div>

    <div class="sidebar-section">
      <div class="sidebar-label">Riwayat ATS</div>
      <div class="tool-grid">
        <div class="tool-card" draggable="true" data-type="experience" ondragstart="onToolDrag(event)"><i class="fas fa-briefcase"></i> Pengalaman</div>
        <div class="tool-card" draggable="true" data-type="education" ondragstart="onToolDrag(event)"><i class="fas fa-graduation-cap"></i> Pendidikan</div>
        <div class="tool-card" draggable="true" data-type="project" ondragstart="onToolDrag(event)"><i class="fas fa-laptop-code"></i> Proyek</div>
        <div class="tool-card" draggable="true" data-type="certification" ondragstart="onToolDrag(event)"><i class="fas fa-certificate"></i> Sertifikat</div>
        <div class="tool-card" draggable="true" data-type="volunteer" ondragstart="onToolDrag(event)"><i class="fas fa-hands-helping"></i> Sukarelawan</div>
        <div class="tool-card" draggable="true" data-type="organization" ondragstart="onToolDrag(event)"><i class="fas fa-users"></i> Organisasi</div>
        <div class="tool-card" draggable="true" data-type="publication" ondragstart="onToolDrag(event)"><i class="fas fa-book-open"></i> Publikasi</div>
        <div class="tool-card" draggable="true" data-type="award" ondragstart="onToolDrag(event)"><i class="fas fa-trophy"></i> Penghargaan</div>
      </div>
    </div>

    <div class="sidebar-section">
      <div class="sidebar-label">Keahlian & Ekstra</div>
      <div class="tool-grid">
        <div class="tool-card" draggable="true" data-type="skills" ondragstart="onToolDrag(event)"><i class="fas fa-tools"></i> Keahlian</div>
        <div class="tool-card" draggable="true" data-type="languages" ondragstart="onToolDrag(event)"><i class="fas fa-language"></i> Bahasa</div>
        <div class="tool-card" draggable="true" data-type="interests" ondragstart="onToolDrag(event)"><i class="fas fa-heart"></i> Hobi/Minat</div>
        <div class="tool-card" draggable="true" data-type="social" ondragstart="onToolDrag(event)"><i class="fas fa-share-alt"></i> Sosial Media</div>
        <div class="tool-card full-width" draggable="true" data-type="portfolio" ondragstart="onToolDrag(event)"><i class="fas fa-link"></i> Link Portfolio</div>
      </div>
    </div>

    <div class="sidebar-section">
      <div class="sidebar-label">Dekorasi & Teks Bebas</div>
      <div class="tool-grid">
        <div class="tool-card" draggable="true" data-type="divider" ondragstart="onToolDrag(event)"><i class="fas fa-minus"></i> Garis</div>
        <div class="tool-card" draggable="true" data-type="spacer" ondragstart="onToolDrag(event)"><i class="fas fa-arrows-alt-v"></i> Spasi</div>
        <div class="tool-card" draggable="true" data-type="text_block" ondragstart="onToolDrag(event)"><i class="fas fa-paragraph"></i> Teks Bebas</div>
        <div class="tool-card" draggable="true" data-type="section_title" ondragstart="onToolDrag(event)"><i class="fas fa-heading"></i> Judul Seksi</div>
      </div>
    </div>
  </div>

  <div class="canvas-area" id="canvas-area">
    <div class="paper" id="cv-paper">
      <div class="paper-dropzone drop-zone" id="main-drop" ondragover="onDragOver(event, this)" ondragleave="onDragLeave(event, this)" ondrop="onDrop(event, this, null)"></div>
    </div>
  </div>

  <div class="panel-right" id="prop-panel">
    <div class="prop-empty" id="prop-empty">
      <i class="fas fa-mouse-pointer" style="margin-bottom: 10px;"></i>
      <span>Klik elemen di kanvas<br>untuk memodifikasi detailnya</span>
    </div>
    <div id="prop-content" style="display:none;">
      <div class="prop-header">
        <span class="prop-title" id="prop-title">Properti</span>
        <button class="btn-top btn-danger-soft" style="background:var(--danger); color:white; border:none; height:28px; font-size:12px; padding:0 10px;" onclick="deleteSelected()"><i class="fas fa-trash"></i> Hapus</button>
      </div>
      <div class="prop-body" id="prop-body"></div>
    </div>
  </div>

</div>


<div id="saveModal" class="modal-overlay" style="display: none; z-index: 9999;">
  <div class="modal-content" style="width: 480px;">
    <h2 style="margin-bottom: 5px; font-size: 20px; color: var(--ink);">Pengaturan Template</h2>
    <p style="font-size: 13px; color: var(--muted); margin-bottom: 24px;">Lengkapi data berikut sebelum disimpan ke database.</p>
    
    <form id="laravelSaveForm" action="{{ route('admin.templates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="layout_schema" id="hidden_schema">
        <input type="hidden" name="global_settings" id="hidden_global">
        
        <div class="form-row">
          <label class="form-label">Nama Template <span style="color:var(--danger);">*</span></label>
          <input type="text" name="name" id="metaName" class="form-input" placeholder="Misal: Clean & Professional" required>
        </div>
        
        <div class="form-row">
          <label class="form-label">Upload Thumbnail <span style="color:var(--danger);">*</span></label>
          <div style="display:flex; align-items:center; gap:15px; margin-bottom: 10px;">
              <div style="border: 1px solid var(--line); border-radius: 4px; padding: 5px; width: 100px; min-height: 120px; background: var(--canvas-bg); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                  <img id="thumbnailPreview" src="" alt="Preview" style="width: 100%; height: auto; display: none;">
                  <span id="thumbnailPlaceholder" style="font-size: 10px; color: var(--muted); text-align: center;">Belum ada gambar</span>
              </div>
              <button type="button" class="btn-top btn-ghost" onclick="captureThumbnail()" id="btnCapture" style="height: 38px;">
                  <i class="fas fa-camera"></i> Auto ScreenShot CV
              </button>
          </div>
          <input type="file" name="thumbnail" id="metaThumbnail" class="form-input" accept="image/*" onchange="previewManualUpload(this)" required>
          <small style="color: var(--muted); font-size: 11px; display:block; margin-top:4px;">Bisa upload manual atau klik "Auto Jepret CV".</small>
        </div>

        <div class="form-row-2">
          <div>
            <label class="form-label">Kategori <span style="color:var(--danger);">*</span></label>
            <select name="category" id="metaCategory" class="form-select" required>
              <option value="Professional">Professional</option>
              <option value="Creative">Creative</option>
              <option value="Simple">Simple</option>
              <option value="Akademik">Akademik</option>
            </select>
          </div>
          <div>
            <label class="form-label">Tipe Akses</label>
            <select name="type" id="metaType" class="form-select" onchange="togglePrice()" required>
              <option value="free">Free (Gratis)</option>
              <option value="pro">Pro (Berbayar)</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <label class="form-label">Deskripsi Singkat</label>
          <textarea name="description" id="metaDescription" class="form-textarea" style="min-height:50px;" placeholder="Cocok untuk pelamar Bank/BUMN..."></textarea>
        </div>

        <div class="form-row">
          <label class="form-label">Tags (Pencarian)</label>
          <input type="text" name="tags" id="metaTags" class="form-input" placeholder="minimalis, bumn, mahasiswa (Pisah koma)">
        </div>

        <div class="form-row" style="margin-top:15px; background: var(--bg); padding: 12px; border-radius: 6px; border: 1px solid var(--line);">
          <label style="font-size:13px; cursor:pointer; display:flex; align-items:center; gap:8px;">
              <input type="checkbox" name="is_active" value="1" checked> Status Publish (Aktif)
          </label>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px;">
          <button type="button" class="btn-top btn-ghost" onclick="closeSaveModal()">Batal</button>
          <button type="button" class="btn-top btn-primary" onclick="submitToLaravel()"><i class="fas fa-paper-plane"></i> Simpan Template</button>
        </div>
    </form>
  </div>
</div>

<div id="confirmModal" class="modal-overlay" style="display: none; z-index: 10000;">
  <div class="modal-content" style="width: 380px; text-align: center; padding: 30px 20px;">
    <i id="confirmIcon" class="fas fa-question-circle" style="font-size: 40px; color: var(--danger); margin-bottom: 15px;"></i>
    <h2 id="confirmTitle" style="margin-bottom: 10px; font-size: 18px; color: var(--ink);">Konfirmasi</h2>
    <p id="confirmMessage" style="font-size: 13px; color: var(--ink2); margin-bottom: 24px; line-height: 1.5;"></p>
    <div style="display: flex; gap: 10px; justify-content: center;">
      <button class="btn-top btn-ghost" onclick="closeConfirmModal()">Batal</button>
      <button id="confirmBtnYes" class="btn-top btn-danger" style="border: none;">Ya</button>
    </div>
  </div>
</div>

<div id="alertModal" class="modal-overlay" style="display: none; z-index: 10001;">
  <div class="modal-content" style="width: 350px; text-align: center; padding: 30px 20px;">
    <i class="fas fa-exclamation-circle" style="font-size: 40px; color: var(--danger); margin-bottom: 15px;"></i>
    <h2 style="margin-bottom: 10px; font-size: 18px; color: var(--ink);">Pemberitahuan</h2>
    <p id="alertMessage" style="font-size: 13px; color: var(--ink2); margin-bottom: 24px; line-height: 1.5; white-space: pre-wrap;"></p>
    <button class="btn-top btn-primary" onclick="closeAlertModal()" style="width: 100%; justify-content: center;">Tutup</button>
  </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

<script>
function parseItems(itemsData) {
    let items = [];
    try { items = typeof itemsData === 'string' ? JSON.parse(itemsData) : itemsData; } catch(e) {}
    return Array.isArray(items) ? items : [];
}

function safeText(val) {
    return String(val || '').replace(/\n/g, '<br>');
}

function esc(str) { 
    return String(str||'').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); 
}

function captureThumbnail() {
    const paper = document.getElementById('cv-paper');
    const btn = document.getElementById('btnCapture');
    
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    btn.disabled = true;

    const selectedBlock = document.querySelector('.cv-block.selected');
    if (selectedBlock) {
        selectedBlock.classList.remove('selected');
    }

    html2canvas(paper, { 
        scale: 1.5, 
        useCORS: true, 
        allowTaint: true,
        backgroundColor: "#ffffff" 
    }).then(canvas => {
        canvas.toBlob(function(blob) {
            const file = new File([blob], "thumbnail_auto.jpg", { type: "image/jpeg" });
            
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById('metaThumbnail').files = dataTransfer.files;
            
            const preview = document.getElementById('thumbnailPreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            document.getElementById('thumbnailPlaceholder').style.display = 'none';
            
            btn.innerHTML = '<i class="fas fa-check" style="color:var(--accent);"></i> Berhasil';
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 2000);
            
        }, "image/jpeg", 0.85);
    }).catch(err => {
        console.error(err);
        customAlert("Gagal mengambil gambar kanvas.");
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

function previewManualUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('thumbnailPreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
            document.getElementById('thumbnailPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function toggleTheme() {
  document.body.classList.toggle('dark-mode');
  const isDark = document.body.classList.contains('dark-mode');
  document.getElementById('themeIcon').className = isDark ? 'fas fa-sun' : 'fas fa-moon';
}

function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('hidden');
}

function customAlert(message) {
  document.getElementById('alertMessage').textContent = message;
  document.getElementById('alertModal').style.display = 'flex';
}
function closeAlertModal() {
  document.getElementById('alertModal').style.display = 'none';
}

let confirmActionCallback = null;

function customConfirm(title, message, iconClass, btnText, btnClass, callback) {
  document.getElementById('confirmTitle').textContent = title;
  document.getElementById('confirmMessage').textContent = message;
  document.getElementById('confirmIcon').className = iconClass;
  
  const btnYes = document.getElementById('confirmBtnYes');
  btnYes.textContent = btnText;
  btnYes.className = 'btn-top ' + btnClass;
  
  confirmActionCallback = callback;
  document.getElementById('confirmModal').style.display = 'flex';
}

function closeConfirmModal() {
  document.getElementById('confirmModal').style.display = 'none';
  confirmActionCallback = null;
}

document.getElementById('confirmBtnYes').addEventListener('click', function() {
  if(typeof confirmActionCallback === 'function') {
    confirmActionCallback();
  }
  closeConfirmModal();
});

function openSaveModal() {
  if(schema.length === 0) {
    customAlert("Kanvas kosong. Tambahkan elemen untuk disimpan.");
    return;
  }
  document.getElementById('saveModal').style.display = 'flex';
}

function closeSaveModal() {
  document.getElementById('saveModal').style.display = 'none';
}

function togglePrice() {
  const type = document.getElementById('metaType').value;
  const priceInput = document.getElementById('metaPrice');
  if(type === 'free') { 
      priceInput.value = 0; 
      priceInput.readOnly = true; 
      priceInput.style.opacity = 0.5;
  } else { 
      priceInput.readOnly = false; 
      priceInput.style.opacity = 1;
      if(priceInput.value == 0) priceInput.value = 25000; 
  }
}

function submitToLaravel() {
  const name = document.getElementById('metaName').value;
  const thumb = document.getElementById('metaThumbnail').files.length;
  
  if(!name.trim()) { customAlert("Nama template wajib diisi!"); return; }
  if(thumb === 0) { customAlert("Thumbnail template wajib diupload!\n(Atau klik tombol Auto Jepret CV)"); return; }

  document.getElementById('hidden_schema').value = JSON.stringify(schema);
  document.getElementById('hidden_global').value = JSON.stringify({ fontFamily: document.getElementById('globalFont').value });

  document.getElementById('laravelSaveForm').submit();
}

function promptClearCanvas() { 
  if (schema.length === 0) return;
  customConfirm('Konfirmasi Hapus', 'Apakah Anda yakin ingin menghapus semua elemen dari canvas?', 'fas fa-trash-alt', 'Ya, Hapus Semua', 'btn-danger', function() {
    schema = []; selectedId = null; renderAll(); hideProps(); saveState(); 
  });
}

let historyStack = [];
let historyIdx = -1;
let isHistoryAction = false;

function saveState() {
  if (isHistoryAction) return;
  if (historyIdx < historyStack.length - 1) historyStack = historyStack.slice(0, historyIdx + 1);
  const stateStr = JSON.stringify(schema);
  if (historyIdx >= 0 && historyStack[historyIdx] === stateStr) return; 
  historyStack.push(stateStr);
  historyIdx++;
  updateHistoryButtons();
}

function undo() {
  if (historyIdx > 0) {
    isHistoryAction = true; historyIdx--; schema = JSON.parse(historyStack[historyIdx]); renderAll();
    if (selectedId) { if (!findBlock(selectedId, schema)) { selectedId = null; hideProps(); } else showProps(selectedId); }
    updateHistoryButtons(); isHistoryAction = false;
  }
}

function redo() {
  if (historyIdx < historyStack.length - 1) {
    isHistoryAction = true; historyIdx++; schema = JSON.parse(historyStack[historyIdx]); renderAll();
    if (selectedId && findBlock(selectedId, schema)) showProps(selectedId);
    updateHistoryButtons(); isHistoryAction = false;
  }
}

function updateHistoryButtons() {
  document.getElementById('btnUndo').disabled = historyIdx <= 0;
  document.getElementById('btnRedo').disabled = historyIdx >= historyStack.length - 1;
}

document.addEventListener('keydown', function(e) {
  if (e.ctrlKey && e.key === 'z') { e.preventDefault(); undo(); }
  if (e.ctrlKey && e.key === 'y') { e.preventDefault(); redo(); }
});

let schema = [];         
let selectedId = null;   
let dragType = null;     
let dragSourceId = null; 
let idCounter = 0;

function genId() { return 'b_' + (++idCounter) + '_' + Date.now(); }
function changeGlobalFont() { document.getElementById('cv-paper').style.fontFamily = document.getElementById('globalFont').value; saveState(); }

const DEFAULTS = {
  col1: { isLayout: true, layoutType: 'col1', props: { marginTop: '0', marginBottom: '12' }, children: [] },
  col2_50_50: { isLayout: true, layoutType: 'col2', props: { marginTop: '0', marginBottom: '12', ratio: '50_50', gap: '16' }, columns: [[], []] },
  col2_30_70: { isLayout: true, layoutType: 'col2', props: { marginTop: '0', marginBottom: '12', ratio: '30_70', gap: '16' }, columns: [[], []] },
  col2_70_30: { isLayout: true, layoutType: 'col2', props: { marginTop: '0', marginBottom: '12', ratio: '70_30', gap: '16' }, columns: [[], []] },
  
  header: { props: { name: 'NAMA LENGKAP ANDA', title: 'Posisi / Jabatan Anda', nameSize: '28', nameColor: '#000000', nameBold: true, titleSize: '14', titleColor: '#333333', align: 'left', showPhoto: false, imageUrl: '', photoShape: 'circle', photoSize: '80', photoPos: 'right', border: false, borderColor: '#000000', marginTop: '0', marginBottom: '12' } },
  photo: { props: { shape: 'circle', size: '100', align: 'center', border: true, borderColor: '#000000', imageUrl: '', marginTop: '0', marginBottom: '12' } },
  contact: { props: { phone: '+62 812-3456-7890', email: 'email@contoh.com', address: 'Jakarta, Indonesia', website: 'linkedin.com/in/anda', layout: 'horizontal', iconColor: '#000000', fontSize: '11', marginTop: '0', marginBottom: '12' } },
  summary: { props: { heading: 'PROFIL DIRI', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', text: 'Profesional yang termotivasi dengan rekam jejak sukses dalam pencapaian target. Ahli dalam pemecahan masalah dan kerja sama tim.', textSize: '11', textAlign: 'justify', marginTop: '0', marginBottom: '12' } },
  experience: { props: { heading: 'PENGALAMAN KERJA', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', items: JSON.stringify([{ title: 'Senior Jabatan', company: 'Nama Perusahaan', period: 'Jan 2021 - Sekarang', location: 'Jakarta', desc: '• Memimpin tim dan meningkatkan efisiensi proses sebesar 40%.\n• Bertanggung jawab penuh atas KPI departemen.' }]), fontSize: '11', marginTop: '0', marginBottom: '12' } },
  volunteer: { props: { heading: 'PENGALAMAN SUKARELAWAN', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', items: JSON.stringify([{ role: 'Koordinator Acara', org: 'Yayasan Sosial', period: '2020 - 2021', desc: '• Mengorganisir acara penggalangan dana bulanan untuk masyarakat.' }]), fontSize: '11', marginTop: '0', marginBottom: '12' } },
  education: { props: { heading: 'PENDIDIKAN', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', items: JSON.stringify([{ degree: 'S1 Jurusan Anda', school: 'Universitas Terkemuka', period: '2016 - 2020', gpa: 'IPK: 3.85', desc: '' }]), fontSize: '11', marginTop: '0', marginBottom: '12' } },
  organization: { props: { heading: 'ORGANISASI', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', items: JSON.stringify([{ role: 'Ketua Divisi', org: 'Badan Eksekutif Mahasiswa', period: '2018 - 2019', desc: '• Bertanggung jawab atas pengelolaan dana divisi dan eksekusi program kerja.' }]), fontSize: '11', marginTop: '0', marginBottom: '12' } },
  project: { props: { heading: 'PROYEK UTAMA', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', items: JSON.stringify([{ name: 'Nama Sistem/Aplikasi', tech: 'Alat & Teknologi', period: '2023', link: 'link-proyek.com', desc: '• Membangun sistem yang mempercepat proses input data harian.' }]), fontSize: '11', marginTop: '0', marginBottom: '12' } },
  certification: { props: { heading: 'SERTIFIKASI', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', items: JSON.stringify([{ name: 'Nama Sertifikat Keahlian', issuer: 'Penerbit Internasional', year: '2023', link: '' }]), fontSize: '11', marginTop: '0', marginBottom: '12' } },
  award: { props: { heading: 'PENGHARGAAN', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', items: JSON.stringify([{ name: 'Karyawan Terbaik', org: 'Perusahaan Anda', year: '2022', desc: 'Penghargaan atas kinerja luar biasa.' }]), fontSize: '11', marginTop: '0', marginBottom: '12' } },
  publication: { props: { heading: 'PUBLIKASI', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', items: JSON.stringify([{ title: 'Judul Jurnal/Artikel', publisher: 'Nama Jurnal', year: '2022', link: '' }]), fontSize: '11', marginTop: '0', marginBottom: '12' } },
  skills: { props: { heading: 'KEAHLIAN', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', items: JSON.stringify([{ category: 'Teknis', list: 'Microsoft Office, Pemrograman, Desain Grafis' }, { category: 'Personal', list: 'Komunikasi, Manajemen Waktu, Problem Solving' }]), style: 'grouped', fontSize: '11', marginTop: '0', marginBottom: '12' } },
  languages: { props: { heading: 'BAHASA', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', items: JSON.stringify([{ lang: 'Bahasa Indonesia', level: 'Penutur Asli' }, { lang: 'Bahasa Inggris', level: 'Fasih Tingkat Lanjut' }]), fontSize: '11', marginTop: '0', marginBottom: '12' } },
  interests: { props: { heading: 'MINAT / HOBI', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', list: 'Membaca, Bersepeda, Menulis Blog', fontSize: '11', marginTop: '0', marginBottom: '12' } },
  social: { props: { heading: 'SOSIAL MEDIA', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', linkedin: 'linkedin.com/in/anda', github: '', twitter: '', instagram: '', fontSize: '11', marginTop: '0', marginBottom: '12' } },
  portfolio: { props: { heading: 'PORTFOLIO', headingSize: '12', headingColor: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', items: JSON.stringify([{ title: 'Kumpulan Desain UI/UX', url: 'behance.net/anda', desc: '' }]), fontSize: '11', marginTop: '0', marginBottom: '12' } },
  divider: { props: { color: '#000000', thickness: '1', marginTop: '8', marginBottom: '8' } },
  spacer: { props: { height: '20' } },
  text_block: { props: { text: 'Tuliskan teks bebas Anda di sini.', fontSize: '11', color: '#000000', align: 'left', bold: false, italic: false, marginTop: '0', marginBottom: '8' } },
  section_title: { props: { text: 'JUDUL SEKSI KUSTOM', fontSize: '12', color: '#000000', showLine: true, lineColor: '#000000', lineThickness: '1.5', align: 'left', marginTop: '0', marginBottom: '8' } }
};

function renderAll() {
  const container = document.getElementById('main-drop');
  container.innerHTML = '';
  try {
      schema.forEach(block => container.appendChild(renderBlock(block)));
      reattachDropZones(container, schema);
  } catch (err) {
      console.error(err);
  }
}

function renderBlock(block) {
  const wrapper = document.createElement('div');
  wrapper.className = 'cv-block' + (block.id === selectedId ? ' selected' : '');
  wrapper.id = 'block_' + block.id; wrapper.setAttribute('draggable', 'true'); wrapper.setAttribute('data-id', block.id);

  wrapper.addEventListener('click', e => { e.stopPropagation(); selectBlock(block.id); });
  
  wrapper.addEventListener('dragstart', e => { 
      dragSourceId = block.id; 
      dragType = null; 
      e.dataTransfer.effectAllowed = 'move'; 
      e.dataTransfer.setData('text/plain', block.id); 
  });
  
  wrapper.addEventListener('dragend', () => { dragSourceId = null; });

  const tb = document.createElement('div'); tb.className = 'block-toolbar';
  tb.innerHTML = `<button class="btb" onclick="moveBlock('${block.id}',-1,event)"><i class="fas fa-arrow-up"></i></button>
                  <button class="btb" onclick="moveBlock('${block.id}',1,event)"><i class="fas fa-arrow-down"></i></button>
                  <button class="btb del" onclick="deleteBlock('${block.id}',event)"><i class="fas fa-times"></i></button>`;
  wrapper.appendChild(tb);

  const inner = document.createElement('div'); inner.className = 'cv-el';
  if (block.isLayout) inner.appendChild(renderLayoutBlock(block));
  else inner.innerHTML = renderElementHTML(block);
  
  wrapper.appendChild(inner); return wrapper;
}

function renderLayoutBlock(block) {
  const p = block.props; const wrap = document.createElement('div');
  wrap.style.cssText = `margin-top:${p.marginTop||0}px; margin-bottom:${p.marginBottom||0}px;`;

  if (block.layoutType === 'col1') {
    const dz = document.createElement('div'); dz.className = 'drop-zone col-drop';
    dz.id = 'col_' + block.id + '_0'; dz.setAttribute('data-col', '0'); dz.setAttribute('data-parent', block.id);
    if (block.children && block.children.length) block.children.forEach(child => dz.appendChild(renderBlock(child)));
    else dz.innerHTML = '<span style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:11px;pointer-events:none;">Drag Element Disini</span>';
    reattachDropZones(dz, block.children || [], block.id, 0); wrap.appendChild(dz);
  } else {
    const [l, r] = (p.ratio || '50_50').split('_').map(Number);
    const grid = document.createElement('div'); grid.style.cssText = `display:grid; grid-template-columns:${l}fr ${r}fr; gap:${p.gap||16}px;`;

    block.columns.forEach((col, ci) => {
      const dz = document.createElement('div'); dz.className = 'drop-zone col-drop';
      dz.id = 'col_' + block.id + '_' + ci; dz.setAttribute('data-col', ci); dz.setAttribute('data-parent', block.id);
      if (col.length) col.forEach(child => dz.appendChild(renderBlock(child)));
      else dz.innerHTML = `<span style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:11px;pointer-events:none;">Drag Element Disini</span>`;
      reattachDropZones(dz, col, block.id, ci); grid.appendChild(dz);
    });
    wrap.appendChild(grid);
  }
  return wrap;
}

function renderElementHTML(block) {
  const p = block.props; const wrap = (inner) => `<div style="margin-top:${p.marginTop||0}px;margin-bottom:${p.marginBottom||0}px;">${inner}</div>`;
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
        let photoHtml = '';
        if (p.imageUrl && p.imageUrl.trim() !== '') {
            photoHtml = `<div style="width:${s}; height:${s}; border-radius:${br}; background: url('${p.imageUrl}') center/cover no-repeat; flex-shrink:0; box-sizing: border-box; ${borderStyle}"></div>`;
        } else {
            photoHtml = `<div style="width:${s}; height:${s}; border-radius:${br}; background:#e2e8f0; flex-shrink:0; display:flex; align-items:center; justify-content:center; color:#94a3b8; box-sizing: border-box; ${borderStyle} overflow:hidden;"><i class="fas fa-camera" style="font-size:${Math.round(parseInt(s)*0.4)}px;"></i></div>`;
        }
        const alignRule = p.photoPos === 'left' ? 'flex-direction:row;' : 'flex-direction:row-reverse;';
        return wrap(`<div style="display:flex; justify-content:space-between; align-items:center; gap:20px; ${alignRule}">${textHtml}${photoHtml}</div>`);
      }
      return wrap(textHtml);
    }
    case 'photo': {
      const br = p.shape==='circle' ? '50%' : (p.shape==='rounded' ? '10px' : '0');
      const border = (p.border===true||p.border==='true') ? `border:2px solid ${p.borderColor||'#e4e4e4'};` : '';
      const s = (p.size||100)+'px';
      let photoHtml = '';
      if (p.imageUrl && p.imageUrl.trim() !== '') {
          photoHtml = `<div style="display:inline-block; width:${s}; height:${s}; border-radius:${br}; background: url('${p.imageUrl}') center/cover no-repeat; box-sizing: border-box; ${border}"></div>`;
      } else {
          photoHtml = `<div style="display:inline-block; width:${s}; height:${s}; border-radius:${br}; background:#d1d5db; ${border} box-sizing: border-box; display:inline-flex; align-items:center; justify-content:center; color:#9ca3af;"><i class="fas fa-user" style="font-size:${Math.round(parseInt(s)*0.4)}px;"></i></div>`;
      }
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
      const rows = items.map(it => `<div style="margin-bottom:8px;"><div style="display:flex; justify-content:space-between;"><div style="font-size:${p.fontSize||11}px; font-weight:700; color:#0d0d0d;">${esc(it.name)} ${it.link?`<span style="color:#000000; font-weight:400; font-size:10px;">${esc(it.link)}</span>`:''}</div><div style="font-size:${(parseInt(p.fontSize||11)-1)}px; color:#555;">${esc(it.period)}</div></div><div style="font-size:${p.fontSize||11}px; color:#333;">${esc(it.tech)}</div>${it.desc ? `<div style="font-size:${p.fontSize||11}px; color:#222; margin-top:2px; line-height:1.5;">${safeText(it.desc)}</div>` : ''}</div>`).join('');
      return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
    }
    case 'publication': {
      const items = parseItems(p.items);
      const rows = items.map(it => `<div style="margin-bottom:6px; font-size:${p.fontSize||11}px; color:#000;"><strong>${esc(it.title)}</strong> — <span style="font-style:italic; color:#333;">${esc(it.publisher)}</span> (${esc(it.year)})${it.link ? `<br><span style="color:#000; font-size:10px;">${esc(it.link)}</span>` : ''}</div>`).join('');
      return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
    }
    case 'certification': case 'award': {
      const items = parseItems(p.items);
      const rows = items.map(it => `<div style="display:flex; justify-content:space-between; margin-bottom:4px; font-size:${p.fontSize||11}px; color:#000;"><div><strong>${esc(it.name)}</strong> — ${esc(it.issuer||it.org)}${it.desc?' · '+esc(it.desc):''}</div><div style="color:#555;">${esc(it.year)}</div></div>`).join('');
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
    case 'references': case 'portfolio': {
      const items = parseItems(p.items);
      const rows = items.map(it=>`<div style="margin-bottom:8px; font-size:${p.fontSize||11}px; color:#000;"><div style="font-weight:700;">${esc(it.name||it.title)} <span style="color:#000000; font-weight:400; font-size:10px;">${esc(it.url||'')}</span></div><div style="color:#333;">${esc(it.title||it.desc||'')}</div>${it.phone?`<div style="color:#333;">${esc(it.phone)} · ${esc(it.email)}</div>`:''}</div>`).join('');
      return wrap(`${heading(p.heading,p.headingSize,p.headingColor,p.showLine,p.lineColor,p.lineThickness)}${rows}`);
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

    default: return '<div>...</div>';
  }
}

function onDragOver(e, el) {
  e.preventDefault(); 
  e.stopPropagation();
  el.classList.add('drag-over');
}

function onDragLeave(e, el) {
  if (!el.contains(e.relatedTarget)) {
    el.classList.remove('drag-over');
  }
}

function reattachDropZones(container, arr, parentId=null, colIndex=null) {
  container.ondragover = e => { e.preventDefault(); e.stopPropagation(); container.classList.add('drag-over'); };
  container.ondragleave = e => { if (!container.contains(e.relatedTarget)) container.classList.remove('drag-over'); };
  container.ondrop = e => { onDrop(e, container, arr, parentId, colIndex); };
}

function onToolDrag(e) { 
    dragType = e.currentTarget.getAttribute('data-type'); 
    dragSourceId = null; 
    e.dataTransfer.effectAllowed = 'copy'; 
    e.dataTransfer.setData('text/plain', dragType); 
}

function onDrop(e, container, targetArr, parentId, colIndex) {
  e.preventDefault(); e.stopPropagation(); container.classList.remove('drag-over');
  
  let currentDragType = dragType;
  if (!currentDragType && e.dataTransfer) {
      currentDragType = e.dataTransfer.getData('text/plain');
  }

  if (currentDragType) {
    const def = DEFAULTS[currentDragType]; if (!def) return;
    const newBlock = JSON.parse(JSON.stringify(def)); newBlock.id = genId(); newBlock.type = currentDragType;
    const idx = getDropIndex(e, container, targetArr);
    if (targetArr) targetArr.splice(idx, 0, newBlock); else schema.splice(idx, 0, newBlock);
    dragType = null; renderAll(); selectBlock(newBlock.id); saveState();
  } else if (dragSourceId) {
    const srcBlock = findBlock(dragSourceId, schema); if (!srcBlock) return;
    const srcArr = findParentArray(dragSourceId, schema); if (!srcArr) return;
    const destArr = targetArr || schema;
    if (srcArr === destArr && !parentId) {
      const fromIdx = srcArr.findIndex(b=>b.id===dragSourceId); const toIdx = getDropIndex(e, container, destArr);
      if (fromIdx === toIdx) return; srcArr.splice(fromIdx, 1);
      destArr.splice((toIdx > fromIdx ? toIdx - 1 : toIdx), 0, srcBlock);
    } else {
      srcArr.splice(srcArr.findIndex(b=>b.id===dragSourceId), 1);
      destArr.splice(getDropIndex(e, container, destArr), 0, srcBlock);
    }
    dragSourceId = null; renderAll(); selectBlock(srcBlock.id); saveState();
  }
}

function getDropIndex(e, container, arr) {
  const children = [...container.children].filter(el => el.classList.contains('cv-block'));
  if (!children.length) return (arr||schema).length;
  for (let i = 0; i < children.length; i++) {
    const rect = children[i].getBoundingClientRect();
    if (e.clientY < rect.top + rect.height / 2) return i;
  }
  return (arr||schema).length;
}

function findBlock(id, arr) {
  for (const b of arr) { if (b.id === id) return b; if (b.isLayout) { if (b.layoutType === 'col1') { const f = findBlock(id, b.children||[]); if(f) return f; } else { for (const col of b.columns||[]) { const f = findBlock(id, col); if(f) return f; } } } } return null;
}
function findParentArray(id, arr) {
  for (const b of arr) { if (b.id === id) return arr; if (b.isLayout) { if (b.layoutType === 'col1') { const f = findParentArray(id, b.children||[]); if (f) return f; } else { for (const col of b.columns||[]) { const f = findParentArray(id, col); if (f) return f; } } } } return null;
}

function selectBlock(id) { selectedId = id; renderAll(); showProps(id); }
function deleteBlock(id, e) { 
    if (e) e.stopPropagation(); 
    customConfirm('Hapus Elemen?', 'Apakah Anda yakin ingin menghapus elemen ini dari design?', 'fas fa-trash-alt', 'Ya, Hapus', 'btn-danger', function() {
        const arr = findParentArray(id, schema); 
        if (arr) arr.splice(arr.findIndex(b=>b.id===id), 1); 
        if (selectedId === id) { selectedId = null; hideProps(); } 
        renderAll(); 
        saveState();
    });
}
function deleteSelected() { if (selectedId) deleteBlock(selectedId); }
function moveBlock(id, dir, e) { if (e) e.stopPropagation(); const arr = findParentArray(id, schema); if (!arr) return; const idx = arr.findIndex(b=>b.id===id); const newIdx = idx + dir; if (newIdx < 0 || newIdx >= arr.length) return; const tmp = arr[idx]; arr[idx] = arr[newIdx]; arr[newIdx] = tmp; renderAll(); selectBlock(id); saveState(); }

document.getElementById('canvas-area').addEventListener('click', e => { if (e.target.closest('.cv-block')) return; selectedId = null; renderAll(); hideProps(); });

function hideProps() { document.getElementById('prop-empty').style.display = 'flex'; document.getElementById('prop-content').style.display = 'none'; }
function showProps(id) {
  const block = findBlock(id, schema); if (!block) return hideProps();
  document.getElementById('prop-empty').style.display = 'none'; document.getElementById('prop-content').style.display = 'block';
  const names = { header:'Header & Foto', contact:'Kontak', summary:'Ringkasan', experience:'Pengalaman', education:'Pendidikan', volunteer:'Sukarelawan', project:'Proyek', award:'Penghargaan', skills:'Keahlian', languages:'Bahasa', interests:'Minat', publication:'Publikasi', certification:'Sertifikasi', divider:'Garis', spacer:'Spasi', text_block:'Teks Bebas', section_title:'Judul Seksi', col1:'1 Kolom', col2_50_50:'2 Kolom (50/50)', col2_30_70:'2 Kolom (30/70)', col2_70_30:'2 Kolom (70/30)' };
  document.getElementById('prop-title').textContent = names[block.type] || block.type;
  buildPropFields(block);
}

function buildPropFields(block) {
  const body = document.getElementById('prop-body'); const p = block.props; const id = block.id;

  const f = (label, html) => `<div class="form-row"><label class="form-label">${label}</label>${html}</div>`;
  const inp = (key, val, type='text') => `<input type="${type}" class="form-input ${type==='color'?'form-color':''}" value="${esc(val)}" oninput="setPropUi('${id}','${key}',this.value)" onchange="saveState()">`;
  const sel = (key, val, opts) => `<select class="form-select" onchange="setPropUi('${id}','${key}',this.value); saveState();">${opts.map(([v,l])=>`<option value="${v}" ${val==v?'selected':''}>${l}</option>`).join('')}</select>`;
  const ta = (key, val) => `<textarea class="form-textarea" oninput="setPropUi('${id}','${key}',this.value)" onchange="saveState()">${esc(val)}</textarea>`;
  const chk = (key, val, label) => `<label style="display:flex;align-items:center;gap:6px;font-size:12px;cursor:pointer;"><input type="checkbox" ${val===true||val==='true'?'checked':''} onchange="setPropUi('${id}','${key}',this.checked); saveState();"> ${label}</label>`;
  
  const marginGroup = () => `<hr class="prop-divider"><div class="sidebar-label" style="color:var(--muted);margin-bottom:8px;">JARAK / MARGIN</div><div class="form-row-2"><div>${f('Atas (px)', inp('marginTop', p.marginTop))}</div><div>${f('Bawah (px)', inp('marginBottom', p.marginBottom))}</div></div>`;

  let html = '';

  switch(block.type) {
    case 'header':
      html = `
        ${f('Nama Lengkap', inp('name', p.name))}
        ${f('Judul / Posisi', inp('title', p.title))}
        <div class="form-row-2">${f('Ukuran Nama', inp('nameSize', p.nameSize))} ${f('Warna Nama', inp('nameColor', p.nameColor, 'color'))}</div>
        <div class="form-row-2">${f('Ukuran Judul', inp('titleSize', p.titleSize))} ${f('Warna Judul', inp('titleColor', p.titleColor, 'color'))}</div>
        ${f('Rata Teks', sel('align', p.align, [['left','Kiri'],['center','Tengah'],['right','Kanan']]))}
        <hr class="prop-divider">
        <div class="sidebar-label" style="color:var(--accent);">PENGATURAN FOTO</div>
        ${f('', chk('showPhoto', p.showPhoto, 'Tampilkan Pas Foto'))}
        ${f('Upload Foto', '<input type="file" class="form-input" accept="image/*" onchange="uploadPhoto(\'' + id + '\', this)">')}
        <div class="form-row-2">
          ${f('Posisi Foto', sel('photoPos', p.photoPos, [['right','Di Kanan'],['left','Di Kiri']]))}
          ${f('Bentuk', sel('photoShape', p.photoShape, [['circle','Bulat'],['square','Kotak']]))}
        </div>
        <div class="form-row-2">
          ${f('Ukuran Foto (px)', inp('photoSize', p.photoSize))}
          ${f('Warna Border', inp('borderColor', p.borderColor || '#000000', 'color'))}
        </div>
        ${f('', chk('border', p.border, 'Tampilkan Border Foto'))}
        ${marginGroup()}`;
      break;

    case 'photo':
      html = `
        ${f('Upload Foto', '<input type="file" class="form-input" accept="image/*" onchange="uploadPhoto(\'' + id + '\', this)">')}
        ${f('Bentuk', sel('shape', p.shape, [['circle','Lingkaran'],['rounded','Bulat (Rounded)'],['square','Persegi']]))}
        ${f('Ukuran (px)', inp('size', p.size))}
        ${f('Posisi', sel('align', p.align, [['left','Kiri'],['center','Tengah'],['right','Kanan']]))}
        ${f('', chk('border', p.border, 'Tampilkan Border'))}
        ${f('Warna Border', inp('borderColor', p.borderColor, 'color'))}
        ${marginGroup()}`;
      break;

    case 'contact':
      html = `${f('No. Telepon', inp('phone', p.phone))} ${f('Email', inp('email', p.email))} ${f('Alamat', inp('address', p.address))} ${f('LinkedIn / Web', inp('website', p.website||''))}
        ${f('Tata Letak', sel('layout', p.layout, [['vertical','Vertikal (Menurun)'],['horizontal','Horizontal (Sejajar)']]))}
        <div class="form-row-2">${f('Warna Ikon', inp('iconColor', p.iconColor, 'color'))} ${f('Ukuran Teks', inp('fontSize', p.fontSize))}</div>
        ${f('Rata Teks', sel('align', p.align, [['left','Kiri'],['center','Tengah'],['right','Kanan']]))}
        ${marginGroup()}`;
      break;

    case 'summary':
      html = `${f('Judul Bagian', inp('heading', p.heading))} ${f('Isi Teks Profil', ta('text', p.text))}
        <div class="form-row-2">${f('Ukuran Teks', inp('textSize', p.textSize))} ${f('Rata Teks', sel('textAlign', p.textAlign, [['left','Kiri'],['justify','Rata Kanan-Kiri'],['center','Tengah'],['right','Kanan']]))}</div>
        <div class="form-row-2">${f('Ukuran Judul', inp('headingSize', p.headingSize))} ${f('Warna Judul', inp('headingColor', p.headingColor, 'color'))}</div>
        ${f('', chk('showLine', p.showLine, 'Garis Bawah Judul'))} 
        <div class="form-row-2">
          ${f('Warna Garis', inp('lineColor', p.lineColor, 'color'))}
          ${f('Tebal Garis (px)', inp('lineThickness', p.lineThickness || '1.5'))}
        </div>
        ${marginGroup()}`;
      break;

    case 'experience': case 'volunteer': case 'project': case 'organization':
      html = buildListProps(id, p, block.type) + marginGroup(); break;
    case 'education': case 'certification': case 'award': case 'publication': case 'portfolio': case 'references':
      html = buildListProps(id, p, block.type) + marginGroup(); break;

    case 'skills':
      html = `${f('Judul Bagian', inp('heading', p.heading))} 
        ${f('Gaya Tampilan', sel('style', p.style, [['grouped','Berkelompok (Kategori)'],['plain','Polos (Teks Biasa)']]))} 
        <div class="form-row-2">${f('Ukuran Judul', inp('headingSize', p.headingSize))} ${f('Ukuran Teks', inp('fontSize', p.fontSize))}</div>
        ${f('', chk('showLine', p.showLine, 'Tampilkan Garis Bawah'))}
        <div class="form-row-2">
          ${f('Warna Garis', inp('lineColor', p.lineColor || '#0d0d0d', 'color'))}
          ${f('Tebal Garis (px)', inp('lineThickness', p.lineThickness || '1.5'))}
        </div>
        <hr class="prop-divider"><div class="sidebar-label">DAFTAR KEAHLIAN</div> ${buildSkillsEditor(id, p)} ${marginGroup()}`; break;

    case 'languages':
      html = `${f('Judul Bagian', inp('heading', p.heading))} 
        <div class="form-row-2">${f('Ukuran Judul', inp('headingSize', p.headingSize))} ${f('Ukuran Teks', inp('fontSize', p.fontSize))}</div>
        ${f('', chk('showLine', p.showLine, 'Tampilkan Garis Bawah'))}
        <div class="form-row-2">
          ${f('Warna Garis', inp('lineColor', p.lineColor || '#0d0d0d', 'color'))}
          ${f('Tebal Garis (px)', inp('lineThickness', p.lineThickness || '1.5'))}
        </div>
        <hr class="prop-divider"><div class="sidebar-label">DAFTAR BAHASA</div> ${buildLangEditor(id, p)} ${marginGroup()}`; break;

    case 'interests':
      html = `${f('Judul Bagian', inp('heading', p.heading))} ${f('Daftar (pisah koma)', ta('list', p.list))} 
        <div class="form-row-2">${f('Ukuran Judul', inp('headingSize', p.headingSize))} ${f('Ukuran Teks', inp('fontSize', p.fontSize))}</div>
        ${f('', chk('showLine', p.showLine, 'Tampilkan Garis Bawah'))} 
        <div class="form-row-2">
          ${f('Warna Garis', inp('lineColor', p.lineColor || '#0d0d0d', 'color'))}
          ${f('Tebal Garis (px)', inp('lineThickness', p.lineThickness || '1.5'))}
        </div>
        ${marginGroup()}`; break;

    case 'social':
      html = `${f('Judul Bagian', inp('heading', p.heading))} ${f('LinkedIn URL', inp('linkedin', p.linkedin||''))} ${f('GitHub URL', inp('github', p.github||''))} ${f('Instagram URL', inp('instagram', p.instagram||''))} 
        <div class="form-row-2">${f('Ukuran Judul', inp('headingSize', p.headingSize))} ${f('Ukuran Teks', inp('fontSize', p.fontSize))}</div>
        ${f('', chk('showLine', p.showLine, 'Tampilkan Garis Bawah'))} 
        <div class="form-row-2">
          ${f('Warna Garis', inp('lineColor', p.lineColor || '#0d0d0d', 'color'))}
          ${f('Tebal Garis (px)', inp('lineThickness', p.lineThickness || '1.5'))}
        </div>
        ${marginGroup()}`; break;

    case 'divider':
      html = `${f('Warna Garis', inp('color', p.color, 'color'))} ${f('Ketebalan (px)', inp('thickness', p.thickness))} ${marginGroup()}`; break;

    case 'spacer':
      html = f('Tinggi Spasi (px)', inp('height', p.height)); break;

    case 'text_block':
      html = `
        ${f('Isi Teks', ta('text', p.text))}
        <div class="form-row-2">
          ${f('Ukuran (px)', inp('fontSize', p.fontSize))}
          ${f('Warna', inp('color', p.color, 'color'))}
        </div>
        ${f('Rata Teks', sel('align', p.align, [['left','Kiri'],['center','Tengah'],['right','Kanan'],['justify','Justify']]))}
        <div class="form-row-2">
          ${f('', chk('bold', p.bold, 'Tebal (Bold)'))}
          ${f('', chk('italic', p.italic, 'Miring (Italic)'))}
        </div>
        ${marginGroup()}`;
      break;

    case 'section_title':
      html = `
        ${f('Teks Judul', inp('text', p.text))}
        <div class="form-row-2">
          ${f('Ukuran (px)', inp('fontSize', p.fontSize))}
          ${f('Warna', inp('color', p.color, 'color'))}
        </div>
        ${f('', chk('showLine', p.showLine, 'Tampilkan Garis Bawah'))}
        <div class="form-row-2">
          ${f('Warna Garis', inp('lineColor', p.lineColor, 'color'))}
          ${f('Tebal Garis (px)', inp('lineThickness', p.lineThickness || '1.5'))}
        </div>
        ${f('Rata Teks', sel('align', p.align, [['left','Kiri'],['center','Tengah'],['right','Kanan']]))}
        ${marginGroup()}`;
      break;

    default:
      if (block.isLayout) html = `<div class="form-row-2">${f('Margin Atas', inp('marginTop', p.marginTop))} ${f('Margin Bawah', inp('marginBottom', p.marginBottom))}</div>`;
      else html = '<p style="font-size:12px;color:var(--muted);">Tidak ada properti tambahan.</p>';
  }
  body.innerHTML = html;
}

function uploadPhoto(id, input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      setPropUi(id, 'imageUrl', e.target.result); 
      saveState(); 
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function buildListProps(id, p, type) {
  const lm = {
    experience: {h:'Judul Bagian', b:'+ Tambah Pengalaman'}, volunteer: {h:'Judul Bagian', b:'+ Tambah Sukarelawan'},
    project: {h:'Judul Bagian', b:'+ Tambah Proyek'}, education: {h:'Judul Bagian', b:'+ Tambah Pendidikan'},
    certification: {h:'Judul Bagian', b:'+ Tambah Sertifikat'}, award: {h:'Judul Bagian', b:'+ Tambah Penghargaan'},
    publication: {h:'Judul Bagian', b:'+ Tambah Publikasi'}, portfolio: {h:'Judul Bagian', b:'+ Tambah Portfolio'},
    organization: {h:'Judul Bagian', b:'+ Tambah Organisasi'}, references: {h:'Judul Bagian', b:'+ Tambah Referensi'}
  }[type] || {h:'Judul', b:'+ Tambah'};
  
  let items = parseItems(p.items);
  let rows = items.map((it, idx) => `
    <div class="list-item-card" style="background:var(--item-card-bg); border:1px solid var(--line); border-radius:6px; padding:10px; margin-bottom:8px; position:relative;">
      <button onclick="removeItem('${id}','${type}',${idx})" style="position:absolute;top:6px;right:6px;background:none;border:none;color:#e53e3e;cursor:pointer;font-size:11px;"><i class="fas fa-times"></i></button>
      ${buildItemFields(type, id, idx, it)}
    </div>`).join('');

  return `<div class="form-row"><label class="form-label">${lm.h}</label><input type="text" class="form-input" value="${esc(p.heading)}" oninput="setPropUi('${id}','heading',this.value)" onchange="saveState()"></div>
    <div class="form-row-2">
      <div><label class="form-label">Ukuran Judul</label><input type="text" class="form-input" value="${esc(p.headingSize||11)}" oninput="setPropUi('${id}','headingSize',this.value)" onchange="saveState()"></div>
      <div><label class="form-label">Ukuran Teks</label><input type="text" class="form-input" value="${esc(p.fontSize||11)}" oninput="setPropUi('${id}','fontSize',this.value)" onchange="saveState()"></div>
    </div>
    <div class="form-row" style="margin-top:10px;"><label style="display:flex;align-items:center;gap:6px;font-size:12px;cursor:pointer;"><input type="checkbox" ${p.showLine===true||p.showLine==='true'?'checked':''} onchange="setPropUi('${id}','showLine',this.checked); saveState();"> Garis Bawah Judul</label></div>
    <div class="form-row-2">
      <div><label class="form-label">Warna Garis</label><input type="color" class="form-input form-color" value="${esc(p.lineColor||'#0d0d0d')}" onchange="setPropUi('${id}','lineColor',this.value); saveState();"></div>
      <div><label class="form-label">Tebal (px)</label><input type="text" class="form-input" value="${esc(p.lineThickness||'1.5')}" oninput="setPropUi('${id}','lineThickness',this.value)" onchange="saveState()"></div>
    </div>
    <hr class="prop-divider"><div class="sidebar-label">DAFTAR ITEM</div>${rows}
    <button onclick="addItem('${id}','${type}')" style="width:100%;padding:7px;background:var(--accent-soft);border:1px dashed var(--accent);border-radius:6px;color:var(--accent);font-size:12px;cursor:pointer;font-weight:600;">${lm.b}</button>`;
}

function buildItemFields(type, blockId, idx, it) {
  const inp = (key, label, val) => `<div class="form-row" style="margin-bottom:6px;"><label class="form-label">${label}</label><input type="text" class="form-input" value="${esc(val)}" oninput="setItemProp('${blockId}',${idx},'${key}',this.value)" onchange="saveState()"></div>`;
  const ta = (key, label, val) => `<div class="form-row" style="margin-bottom:6px;"><label class="form-label">${label}</label><textarea class="form-textarea" style="min-height:40px;" oninput="setItemProp('${blockId}',${idx},'${key}',this.value)" onchange="saveState()">${esc(val)}</textarea></div>`;

  switch(type) {
    case 'experience': return inp('title','Jabatan',it.title) + inp('company','Perusahaan',it.company) + inp('period','Periode',it.period) + ta('desc','Deskripsi Tugas',it.desc||'');
    case 'volunteer': return inp('role','Peran',it.role) + inp('org','Organisasi',it.org) + inp('period','Periode',it.period) + ta('desc','Deskripsi',it.desc||'');
    case 'education': return inp('degree','Gelar',it.degree) + inp('school','Universitas',it.school) + inp('period','Periode',it.period) + inp('gpa','IPK',it.gpa||'');
    case 'certification': return inp('name','Nama Sertifikat',it.name) + inp('issuer','Penerbit',it.issuer) + inp('year','Tahun',it.year);
    
    case 'project': return inp('name','Nama Proyek',it.name) + inp('link','Link/URL (Opsional)',it.link) + inp('tech','Teknologi',it.tech) + inp('period','Tahun',it.period) + ta('desc','Deskripsi Singkat',it.desc||'');
    
    case 'award': return inp('name','Penghargaan',it.name) + inp('org','Penyelenggara',it.org) + inp('year','Tahun',it.year);
    case 'publication': return inp('title','Judul Publikasi',it.title) + inp('publisher','Penerbit',it.publisher) + inp('year','Tahun',it.year);
    case 'organization': return inp('role','Peran / Jabatan',it.role) + inp('org','Nama Organisasi',it.org) + inp('period','Periode',it.period) + ta('desc','Deskripsi',it.desc||'');
    case 'portfolio': return inp('title','Nama Portfolio',it.title) + inp('url','URL/Link',it.url) + ta('desc','Deskripsi',it.desc||'');
    case 'references': return inp('name','Nama Orang',it.name) + inp('title','Jabatan',it.title) + inp('phone','Telepon',it.phone) + inp('email','Email',it.email);
    default: return '';
  }
}

function buildSkillsEditor(id, p) {
  let items = parseItems(p.items);
  let rows = items.map((it,idx) => `
    <div class="list-item-card" style="background:var(--item-card-bg); border:1px solid var(--line); border-radius:6px; padding:8px; margin-bottom:6px; position:relative;">
      <button onclick="removeItem('${id}','skills',${idx})" style="position:absolute;top:6px;right:6px;background:none;border:none;color:#e53e3e;cursor:pointer;"><i class="fas fa-times"></i></button>
      <div class="form-row" style="margin-bottom:4px;"><label class="form-label">Kategori</label><input class="form-input" value="${esc(it.category)}" oninput="setItemProp('${id}',${idx},'category',this.value)" onchange="saveState()"></div>
      <div class="form-row"><label class="form-label">Daftar (pisah koma)</label><input class="form-input" value="${esc(it.list)}" oninput="setItemProp('${id}',${idx},'list',this.value)" onchange="saveState()"></div>
    </div>`).join('');
  return `${rows}<button onclick="addItem('${id}','skills')" style="width:100%;padding:7px;background:var(--accent-soft);border:1px dashed var(--accent);border-radius:6px;color:var(--accent);font-size:12px;cursor:pointer;font-weight:600;">+ Tambah Kategori</button>`;
}

function buildLangEditor(id, p) {
  let items = parseItems(p.items);
  let rows = items.map((it,idx) => `
    <div class="list-item-card" style="background:var(--item-card-bg); border:1px solid var(--line); border-radius:6px; padding:8px; margin-bottom:6px; position:relative;">
      <button onclick="removeItem('${id}','languages',${idx})" style="position:absolute;top:6px;right:6px;background:none;border:none;color:#e53e3e;cursor:pointer;"><i class="fas fa-times"></i></button>
      <div class="form-row-2">
        <div><label class="form-label">Bahasa</label><input class="form-input" value="${esc(it.lang)}" oninput="setItemProp('${id}',${idx},'lang',this.value)" onchange="saveState()"></div>
        <div><label class="form-label">Tingkat</label><input class="form-input" value="${esc(it.level)}" oninput="setItemProp('${id}',${idx},'level',this.value)" onchange="saveState()"></div>
      </div>
    </div>`).join('');
  return `${rows}<button onclick="addItem('${id}','languages')" style="width:100%;padding:7px;background:var(--accent-soft);border:1px dashed var(--accent);border-radius:6px;color:var(--accent);font-size:12px;cursor:pointer;font-weight:600;">+ Tambah Bahasa</button>`;
}

function setPropUi(id, key, value) {
  const block = findBlock(id, schema); if (!block) return; block.props[key] = value;
  const el = document.getElementById('block_' + id);
  if (el) { const inner = el.querySelector('.cv-el'); if (inner) { if (block.isLayout) renderAll(); else inner.innerHTML = renderElementHTML(block); } }
}

function setItemProp(blockId, idx, key, value) {
  const block = findBlock(blockId, schema); if (!block) return;
  let items = parseItems(block.props.items);
  if (!items[idx]) return; items[idx][key] = value; block.props.items = JSON.stringify(items);
  const el = document.getElementById('block_' + blockId);
  if (el) { const inner = el.querySelector('.cv-el'); if (inner) inner.innerHTML = renderElementHTML(block); }
}

function addItem(blockId, type) {
  const block = findBlock(blockId, schema); if (!block) return;
  let items = parseItems(block.props.items);
  const newItems = {
    experience: { title:'Posisi Baru', company:'Perusahaan', period:'2024', desc:'' },
    volunteer: { role:'Peran', org:'Organisasi', period:'2024', desc:'' },
    education: { degree:'Gelar', school:'Instansi', period:'2024' },
    organization: { role:'Peran', org:'Organisasi', period:'2024', desc:'' },
    certification: { name:'Nama Sertifikat', issuer:'Penerbit', year:'2024' },
    project: { name:'Nama Proyek', tech:'Alat', period:'2024', link:'', desc:'' }, // Penambahan default key link
    award: { name:'Nama Penghargaan', org:'Penyelenggara', year:'2024' },
    publication: { title:'Judul', publisher:'Penerbit', year:'2024' },
    portfolio: { title:'Judul', url:'Link', desc:'' },
    references: { name:'Nama', title:'Jabatan', phone:'', email:'' },
    skills: { category:'Kategori Baru', list:'Skill 1, Skill 2' },
    languages: { lang:'Bahasa', level:'Menengah' }
  };
  items.push(newItems[type] || {}); block.props.items = JSON.stringify(items);
  showProps(blockId);
  const el = document.getElementById('block_' + blockId); if (el) { const inner = el.querySelector('.cv-el'); if (inner) inner.innerHTML = renderElementHTML(block); }
  saveState();
}

function removeItem(blockId, type, idx) {
  const block = findBlock(blockId, schema); if (!block) return;
  let items = parseItems(block.props.items);
  items.splice(idx, 1); block.props.items = JSON.stringify(items);
  showProps(blockId);
  const el = document.getElementById('block_' + blockId); if (el) { const inner = el.querySelector('.cv-el'); if (inner) inner.innerHTML = renderElementHTML(block); }
  saveState();
}

function promptClearCanvas() { 
  if (schema.length === 0) return;
  customConfirm('Konfirmasi Hapus', 'Apakah Anda yakin ingin menghapus semua elemen dari canvas?', 'fas fa-trash-alt', 'Ya, Hapus Semua', 'btn-danger', function() {
    schema = []; selectedId = null; renderAll(); hideProps(); saveState(); 
  });
}

window.onload = function() {
  renderAll();
  saveState();
}
</script>
</body>
</html>