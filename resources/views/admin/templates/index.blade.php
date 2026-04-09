@extends('layouts.admin')

@section('title', 'Manajemen Template')

@push('styles')
<style>
    /* =========================================
       1. THEME VARIABLES (Light & Dark Support)
       ========================================= */
    :root {
        /* --- Light Mode Default --- */
        --primary-color: #4CAF50;
        --primary-soft: rgba(76, 175, 80, 0.1);
        --primary-hover-bg: rgba(76, 175, 80, 0.08);
        
        --bg-body: #f8fafc;
        --bg-card: #ffffff;
        --bg-input: #f8fafc;
        
        --text-main: #0f172a;     /* Slate 900 */
        --text-muted: #64748b;    /* Slate 500 */
        
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        
        /* Badge Specific */
        --badge-free-bg: #ffffff;
        --badge-free-text: #0f172a;
        --img-placeholder: #e2e8f0;
        --danger: #ef4444;
    }

    /* --- Dark Mode Overrides --- */
    html.dark, [data-theme="dark"] {
        --bg-body: #0f172a;       /* Slate 900 */
        --bg-card: #1e293b;       /* Slate 800 */
        --bg-input: #0f172a;      /* Darker Input */
        
        --text-main: #f8fafc;     /* Slate 50 */
        --text-muted: #94a3b8;    /* Slate 400 */
        
        --border-color: #334155;  /* Slate 700 */
        --primary-soft: rgba(76, 175, 80, 0.2); 
        --primary-hover-bg: rgba(76, 175, 80, 0.15);
        
        --shadow-sm: none;
        --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.3);

        /* Badge Specific */
        --badge-free-bg: #334155;
        --badge-free-text: #e2e8f0;
        --img-placeholder: #334155;
    }

    /* Auto Dark Mode based on System */
    @media (prefers-color-scheme: dark) {
        :root:not([data-theme="light"]) {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --bg-input: #0f172a;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --primary-soft: rgba(76, 175, 80, 0.2);
            --primary-hover-bg: rgba(76, 175, 80, 0.15);
            --shadow-sm: none;
            --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            --badge-free-bg: #334155;
            --badge-free-text: #e2e8f0;
            --img-placeholder: #334155;
        }
    }

    /* =========================================
       2. COMPONENT STYLES
       ========================================= */

    body { background-color: var(--bg-body); color: var(--text-main); }

    /* --- Page Header --- */
    .page-header { 
        display: flex; justify-content: space-between; align-items: end; 
        margin-bottom: 24px; gap: 16px; flex-wrap: wrap; 
    }
    .header-title h1 { 
        font-size: 24px; font-weight: 700; color: var(--text-main); 
        margin-bottom: 4px; letter-spacing: -0.02em; 
    }
    .header-title p { color: var(--text-muted); font-size: 14px; margin: 0; }

    .btn-primary { 
        background: var(--primary-color); color: white; border: none; 
        padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; 
        display: inline-flex; align-items: center; gap: 8px; cursor: pointer; 
        transition: transform 0.2s, box-shadow 0.2s; text-decoration: none; 
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.25);
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(76, 175, 80, 0.35); }

    .btn-danger {
        background: var(--danger); color: white; border: none;
        padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
        display: inline-flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer;
        transition: 0.2s;
    }
    .btn-danger:hover { filter: brightness(0.9); }

    .btn-secondary {
        background: transparent; color: var(--text-main); border: 1px solid var(--border-color);
        padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
        display: inline-flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer;
        transition: 0.2s;
    }
    .btn-secondary:hover { background: var(--border-color); }

    /* --- Stats Overview --- */
    .stats-grid { 
        display: grid; 
        grid-template-columns: repeat(4, 1fr); 
        gap: 16px; margin-bottom: 32px; 
    }
    .stat-card { 
        background: var(--bg-card); padding: 16px; border-radius: 12px; 
        border: 1px solid var(--border-color); 
        display: flex; align-items: center; gap: 14px; 
        transition: all 0.2s ease;
    }
    .stat-card:hover { border-color: var(--primary-color); }
    
    .stat-icon { 
        width: 42px; height: 42px; border-radius: 10px; 
        background: var(--primary-soft); color: var(--primary-color); 
        display: flex; align-items: center; justify-content: center; 
        font-size: 18px; flex-shrink: 0; 
    }
    .stat-info { display: flex; flex-direction: column; }
    .stat-info h4 { font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 2px; }
    .stat-info .val { font-size: 20px; font-weight: 700; color: var(--text-main); line-height: 1.2; }

    /* --- Filter Toolbar --- */
    .toolbar { 
        background: var(--bg-card); padding: 12px; border-radius: 12px; 
        border: 1px solid var(--border-color); margin-bottom: 24px; 
        display: flex; gap: 12px; align-items: center; flex-wrap: wrap; 
    }
    .search-group { position: relative; flex-grow: 1; min-width: 200px; }
    .search-group i { 
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%); 
        color: var(--text-muted); font-size: 14px; 
    }
    
    .form-control, .form-select { 
        width: 100%; padding: 10px 14px 10px 38px; border-radius: 8px; 
        border: 1px solid var(--border-color); background: var(--bg-input); 
        color: var(--text-main); outline: none; font-size: 13px; transition: 0.2s; 
    }
    .form-select { padding-left: 14px; min-width: 140px; cursor: pointer; }
    .form-control:focus, .form-select:focus { 
        border-color: var(--primary-color); background: var(--bg-card);
        box-shadow: 0 0 0 3px var(--primary-soft); 
    }
    /* Placeholder color fix */
    .form-control::placeholder { color: var(--text-muted); opacity: 0.7; }

    /* --- Template Grid --- */
    .templates-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); 
        gap: 24px; 
    }

    .template-card { 
        background: var(--bg-card); border-radius: 12px; 
        border: 1px solid var(--border-color); overflow: hidden; 
        display: flex; flex-direction: column; 
        transition: transform 0.3s, box-shadow 0.3s; 
        position: relative;
    }
    .template-card:hover { 
        transform: translateY(-5px); 
        box-shadow: var(--shadow-card); 
        border-color: var(--primary-color);
    }

    /* TALL CARD IMAGE */
    .card-img-top { 
        height: 260px; 
        background: var(--img-placeholder); 
        position: relative; overflow: hidden; 
        border-bottom: 1px solid var(--border-color);
    }
    .card-img-top img { 
        width: 100%; height: 100%; object-fit: cover; object-position: top; 
        transition: transform 0.5s ease; 
    }
    .template-card:hover .card-img-top img { transform: scale(1.05); }

    /* Badges */
    .badges-top { position: absolute; top: 10px; right: 10px; display: flex; flex-direction: column; gap: 5px; z-index: 2; }
    .badge { 
        padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 700; 
        text-transform: uppercase; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .badge-pro { background: #f59e0b; color: white; }
    .badge-new { background: #3b82f6; color: white; }
    .badge-free { 
        background: var(--badge-free-bg); 
        color: var(--badge-free-text); 
        border: 1px solid var(--border-color); 
    }

    /* Card Content */
    .card-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
    .card-title { 
        font-size: 16px; font-weight: 700; color: var(--text-main); 
        margin-bottom: 8px; line-height: 1.4; 
    }
    
    .card-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .category-label { 
        font-size: 11px; font-weight: 600; color: var(--primary-color); 
        background: var(--primary-hover-bg); padding: 3px 8px; border-radius: 4px; 
    }
    
    .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 4px; }
    .status-dot.active { background: #22c55e; }
    .status-dot.draft { background: #94a3b8; }
    .status-text { font-size: 11px; font-weight: 600; display: flex; align-items: center; color: var(--text-main); }

    .stats-row { 
        display: flex; gap: 12px; font-size: 12px; color: var(--text-muted); 
        padding-top: 12px; border-top: 1px dashed var(--border-color); margin-top: auto; 
    }
    .stats-row div { display: flex; align-items: center; gap: 4px; }

    /* Footer Buttons */
    .card-footer { 
        padding: 12px 16px; background: var(--bg-card); 
        border-top: 1px solid var(--border-color); 
        display: flex; justify-content: flex-end; gap: 8px; 
    }
    .btn-icon { 
        width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border-color); 
        background: var(--bg-input); color: var(--text-muted); font-size: 13px; 
        display: flex; align-items: center; justify-content: center; 
        cursor: pointer; transition: 0.2s; text-decoration: none; 
    }
    .btn-icon:hover { border-color: var(--primary-color); color: var(--primary-color); background: var(--primary-hover-bg); }
    .btn-icon.danger:hover { border-color: var(--danger); color: var(--danger); background: rgba(239, 68, 68, 0.1); }

    /* --- Modal Custom --- */
    .custom-modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 9999;
        display: flex; align-items: center; justify-content: center; backdrop-filter: blur(3px);
        opacity: 0; visibility: hidden; transition: 0.3s;
    }
    .custom-modal-overlay.active { opacity: 1; visibility: visible; }
    .custom-modal-content {
        background: var(--bg-card); color: var(--text-main); border-radius: 16px; padding: 30px 24px;
        width: 90%; max-width: 400px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        transform: translateY(20px); transition: 0.3s; border: 1px solid var(--border-color);
    }
    .custom-modal-overlay.active .custom-modal-content { transform: translateY(0); }
    .modal-icon { font-size: 50px; margin-bottom: 16px; }

    /* --- RESPONSIVE MEDIA QUERIES --- */
    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .btn-primary { width: 100%; justify-content: center; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .stat-card { padding: 12px; gap: 10px; }
        .stat-icon { width: 36px; height: 36px; font-size: 16px; }
        .stat-info .val { font-size: 18px; }
        .toolbar { flex-direction: column; align-items: stretch; }
        .search-group, .form-select { width: 100%; min-width: 100%; }
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="header-title">
        <h1>Manajemen Template</h1>
        <p>Kelola dan pantau desain CV yang tersedia.</p>
    </div>
    <a href="{{ route('admin.templates.create')}}" class="btn-primary">
        <i class="fas fa-plus"></i> Tambah Template
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
        <div class="stat-info"><h4>Total Template</h4><div class="val">{{ $templates->count() }}</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-crown"></i></div>
        <div class="stat-info"><h4>Premium</h4><div class="val">{{ $templates->where('type', 'pro')->count() }}</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-download"></i></div>
        <div class="stat-info"><h4>Unduhan</h4><div class="val">{{ number_format($templates->sum('total_downloads')) }}</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-star"></i></div>
        <div class="stat-info"><h4>Rating Avg</h4><div class="val">{{ number_format($templates->avg('rating'), 1) }}</div></div>
    </div>
</div>

<div class="toolbar">
    <div class="search-group">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" class="form-control" placeholder="Cari template...">
    </div>
    
    <select class="form-select" id="categoryFilter">
        <option value="all">Semua Kategori</option>
        <option value="Professional">Professional</option>
        <option value="Creative">Creative</option>
        <option value="Simple">Simple</option>
        <option value="Akademik">Akademik</option>
    </select>
    
    <select class="form-select" id="statusFilter">
        <option value="all">Semua Status</option>
        <option value="active">Aktif</option>
        <option value="draft">Draft</option>
    </select>
</div>

<div class="templates-grid" id="templatesContainer">
    @forelse($templates as $item)
    <div class="template-card" 
         data-category="{{ is_array($item->category) ? strtolower(implode(' ', $item->category)) : strtolower($item->category) }}" 
         data-status="{{ $item->is_active ? 'active' : 'draft' }}" 
         data-name="{{ strtolower($item->name) }}">
        
        <div class="card-img-top">
            <div class="badges-top">
                @if($item->is_new) <span class="badge badge-new">NEW</span> @endif
                @if($item->type == 'pro') <span class="badge badge-pro">PRO</span> @else <span class="badge badge-free">FREE</span> @endif
            </div>
            
            @if($item->thumbnail)
                <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->name }}">
            @else
                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color: var(--text-muted);">
                    <i class="fas fa-image" style="font-size: 48px; opacity:0.3;"></i>
                </div>
            @endif
        </div>

        <div class="card-body">
            <div class="card-title">{{ $item->name }}</div>
            
            <div class="card-meta">
                <span class="category-label">
                    {{ is_array($item->category) ? implode(', ', array_slice($item->category, 0, 2)) : $item->category }}
                </span>
                
                <div class="status-text" style="color: {{ $item->is_active ? '#22c55e' : 'var(--text-muted)' }}">
                    <span class="status-dot {{ $item->is_active ? 'active' : 'draft' }}"></span>
                    {{ $item->is_active ? 'Aktif' : 'Draft' }}
                </div>
            </div>
            
            <div class="stats-row">
                <div title="Unduhan"><i class="fas fa-download" style="font-size:10px;"></i> {{ $item->total_downloads }}</div>
                <div title="Rating"><i class="fas fa-star" style="color:#f59e0b; font-size:10px;"></i> {{ $item->rating }}</div>
                <div style="margin-left:auto; font-weight:700; color: var(--text-main);">
                    @if($item->price > 0)
                        Rp {{ \App\Helpers\Formatter::currency($item->price) }}
                    @else
                        Free
                    @endif
                </div>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('admin.templates.edit', $item->id) }}" class="btn-icon" title="Edit">
                <i class="fas fa-pen"></i>
            </a>
            
            <form action="{{ route('admin.templates.destroy', $item->id) }}" method="POST" onsubmit="confirmDelete(event, this);" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-icon danger" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
        <div style="grid-column: 1/-1; text-align:center; padding: 60px 20px; color: var(--text-muted);">
            <div style="background: var(--bg-card); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; border: 1px solid var(--border-color);">
                <i class="fas fa-folder-open" style="font-size: 24px; opacity: 0.5;"></i>
            </div>
            <p>Belum ada data template.</p>
        </div>
    @endforelse
</div>

<div id="emptyState" style="display: none; text-align: center; padding: 60px; color: var(--text-muted);">
    <i class="fas fa-search" style="font-size: 32px; margin-bottom: 12px; opacity: 0.3;"></i>
    <p>Template tidak ditemukan.</p>
</div>

<div id="successModal" class="custom-modal-overlay">
    <div class="custom-modal-content">
        <i class="fas fa-check-circle modal-icon" style="color: var(--primary-color);"></i>
        <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">Berhasil!</h2>
        <p id="successMessageText" style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;"></p>
        <button onclick="closeSuccessModal()" class="btn-primary" style="width: 100%; justify-content: center; padding: 12px;">Tutup</button>
    </div>
</div>

<div id="deleteModal" class="custom-modal-overlay">
    <div class="custom-modal-content">
        <i class="fas fa-exclamation-triangle modal-icon" style="color: var(--danger);"></i>
        <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">Konfirmasi Hapus</h2>
        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;">Apakah Anda yakin ingin menghapus template ini? Data yang terhapus tidak dapat dikembalikan.</p>
        <div style="display: flex; gap: 12px;">
            <button onclick="closeDeleteModal()" class="btn-secondary" style="flex: 1;">Batal</button>
            <button id="confirmDeleteBtn" class="btn-danger" style="flex: 1;">Ya, Hapus</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ============================================================
    // LOGIKA MODAL (SUCCESS & DELETE)
    // ============================================================
    
    // Tampilkan Modal Sukses Jika Ada Session
    @if(session('success'))
        document.getElementById('successMessageText').innerText = "{{ session('success') }}";
        document.getElementById('successModal').classList.add('active');
    @endif

    function closeSuccessModal() {
        document.getElementById('successModal').classList.remove('active');
    }

    // Logika Konfirmasi Hapus Custom
    let formToDelete = null;
    
    function confirmDelete(event, formElement) {
        event.preventDefault(); // Hentikan submit langsung
        formToDelete = formElement; // Simpan form yang menekan tombol hapus
        document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
        formToDelete = null; // Reset form jika dibatalkan
    }

    // Jika pengguna klik "Ya, Hapus" di modal
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if(formToDelete) {
            formToDelete.submit(); // Lanjutkan proses submit form
        }
    });


    // ============================================================
    // LOGIKA PENCARIAN & FILTER
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const catFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const cards = document.querySelectorAll('.template-card');
        const emptyState = document.getElementById('emptyState');

        function filterCards() {
            const search = searchInput.value.toLowerCase();
            const cat = catFilter.value.toLowerCase();
            const status = statusFilter.value;
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                const cCat = card.getAttribute('data-category'); 
                const cStatus = card.getAttribute('data-status');

                const matchSearch = name.includes(search);
                const matchCat = cat === 'all' || (cCat && cCat.includes(cat));
                const matchStatus = status === 'all' || status === cStatus;

                if (matchSearch && matchCat && matchStatus) {
                    card.style.display = 'flex';
                    card.style.animation = 'none';
                    card.offsetHeight; /* trigger reflow */
                    card.style.animation = 'fadeIn 0.5s ease-in-out';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        [searchInput, catFilter, statusFilter].forEach(el => el.addEventListener('input', filterCards));
    });
</script>
@endpush