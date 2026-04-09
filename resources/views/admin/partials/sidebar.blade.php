<style>
    :root {
        --sidebar-width: 260px;
        --header-height: 70px;
        --z-overlay: 40;
        --z-sidebar: 50;
    }

    .sidebar {
        width: var(--sidebar-width);
        background: var(--bg-sidebar);
        height: 100vh;
        position: fixed;
        top: 0; left: 0;
        padding: 24px;
        z-index: var(--z-sidebar);
        border-right: 1px solid var(--border-color);
        
        display: flex;
        flex-direction: column;
        
        transform: translateX(0);
        transition: transform 0.3s ease-in-out;
    }

    .brand {
        display: flex; 
        align-items: center; 
        justify-content: space-between;
        font-size: 20px; 
        font-weight: 800; 
        color: white;
        margin-bottom: 30px; 
        padding-left: 10px;
        flex-shrink: 0;
    }
    .brand-content { display: flex; align-items: center; gap: 12px; }
    .brand i { color: var(--primary-color); font-size: 24px; }

    .sidebar-close {
        display: none; 
        cursor: pointer;
        font-size: 20px;
        color: #94A3B8;
        transition: 0.2s;
        padding: 5px;
    }
    .sidebar-close:hover { color: #EF4444; }

    .nav-scrollable {
        flex: 1;
        overflow-y: auto;
        margin-right: -10px;
        padding-right: 10px;
    }
    .nav-scrollable::-webkit-scrollbar { width: 4px; }
    .nav-scrollable::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

    .menu-label {
        font-size: 11px; text-transform: uppercase; letter-spacing: 1px;
        color: var(--text-sidebar); margin-bottom: 10px; padding-left: 12px; font-weight: 700;
        margin-top: 20px;
    }
    .menu-label:first-child { margin-top: 0; }

    .nav-menu { list-style: none; padding: 0; margin: 0; }
    .nav-item { margin-bottom: 4px; }
    .nav-link {
        display: flex; align-items: center; gap: 12px;
        padding: 12px; border-radius: 10px;
        color: var(--text-sidebar); font-size: 14px; font-weight: 500;
        transition: 0.3s; text-decoration: none;
    }
    .nav-link:hover, .nav-link.active {
        background: rgba(255, 255, 255, 0.08);
        color: white;
    }
    .nav-link.active { border-left: 3px solid var(--primary-color); }
    .nav-link.active i { color: var(--primary-color); }

    .sidebar-footer {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.05);
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            box-shadow: none;
        }

        .sidebar.open {
            transform: translateX(0);
            box-shadow: 10px 0 30px rgba(0,0,0,0.5);
        }

        .sidebar-close { display: block; }
    }
</style>

<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="brand-content">
            <i class="fas fa-file-invoice"></i> 
            <span>ResuMate<span style="color:var(--primary-color)">.</span></span>
        </div>
        <i class="fas fa-times sidebar-close" onclick="toggleSidebar()"></i>
    </div>

    <div class="nav-scrollable">
        <div class="menu-label">Main Menu</div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{  route('admin.dashboard.index')}}" class="nav-link {{   request()->routeIs('admin.dashboard.*') ? 'active' : ''}}"><i class="fas fa-chart-pie"></i> <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a href="{{  route('admin.transactions.index')}} " class="nav-link {{   request()->routeIs('admin.transactions.*') ? 'active' : ''}}"><i class="fas fa-receipt"></i> <span>Transaksi</span></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index')}}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : ''}}"><i class="fas fa-users"></i> <span>Pengguna</span></a>
            </li>
        </ul>

        <div class="menu-label">Produk</div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.templates.index')}}" class="nav-link {{ request()->routeIs('admin.templates.*') ? 'active' : ''}}"><i class="fas fa-layer-group"></i> <span>Template CV</span></a>
            </li>
        </ul>

        <div class="menu-label">Setting</div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.settings.index')}}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : ''}}"><i class="fas fa-cogs"></i> <span>Pengaturan</span></a>
            </li>
    </div>
    
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link" style="color: #EF4444; background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                <i class="fas fa-sign-out-alt"></i> 
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        
        sidebar.classList.toggle('open');
        
        overlay.classList.toggle('show');
    }
</script>