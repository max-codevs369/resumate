<style>
    .top-header {
        height: var(--header-height);
        background: var(--bg-card);
        border-bottom: 1px solid var(--border-color);
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 30px;
        position: sticky; top: 0; z-index: 40;
    }

    .header-left { display: flex; align-items: center; gap: 20px; }
    .toggle-sidebar { display: none; font-size: 20px; cursor: pointer; color: var(--text-main); }

    .header-right { display: flex; align-items: center; gap: 20px; }

    .theme-btn {
        background: none; border: none; cursor: pointer;
        font-size: 18px; color: var(--text-main);
        transition: transform 0.3s;
    }
    .theme-btn:hover { transform: rotate(15deg); color: var(--primary-color); }

    .admin-profile { display: flex; align-items: center; gap: 10px; cursor: pointer; }
    .admin-info { text-align: right; line-height: 1.2; }
    .admin-name { font-weight: 700; font-size: 14px; color: var(--text-main); }
    .admin-role { font-size: 11px; color: var(--text-muted); }
    .admin-img {
        width: 38px; height: 38px; border-radius: 50%; background: #E2E8F0;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; color: var(--text-muted);
    }

    @media (max-width: 768px) {
        .toggle-sidebar { display: block; }
    }
</style>

<header class="top-header">
    <div class="header-left">
        <i class="fas fa-bars toggle-sidebar" onclick="document.getElementById('sidebar').classList.toggle('open')"></i>
    </div>

    <div class="header-right">
        <div class="admin-profile">
            <div class="admin-info">
                <div class="admin-name">{{ Auth::user()->name }}</div>
                <div class="admin-role">Administrator</div>
            </div>
            <div class="admin-img">{{ collect(explode(' ', auth()->user()->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->implode('') }}</div>
        </div>
    </div>
</header>