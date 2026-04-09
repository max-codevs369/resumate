@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@push('styles')
    <style>
        .page-header {
            display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px;
            flex-wrap: wrap; gap: 16px;
        }
        .header-title h1 { font-size: 28px; font-weight: 800; color: var(--text-main); margin-bottom: 4px; letter-spacing: -0.5px; }
        .header-title p { color: var(--text-secondary); font-size: 14px; }

        .btn-add-user {
            background: var(--primary-color); border: none; color: white;
            padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 600;
            display: flex; align-items: center; gap: 8px; cursor: pointer; transition: 0.2s;
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.25); white-space: nowrap; text-decoration: none;
        }
        .btn-add-user:hover { background: var(--primary-hover); transform: translateY(-2px); }

        /* Alert */
        .alert { padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: rgba(34,197,94,0.1); color: #16A34A; border: 1px solid rgba(34,197,94,0.2); }
        .alert-error { background: rgba(239,68,68,0.1); color: #DC2626; border: 1px solid rgba(239,68,68,0.2); }

        /* Filter Tabs */
        .filter-tabs {
            display: flex; gap: 24px; border-bottom: 1px solid var(--border-color); margin-bottom: 24px;
            overflow-x: auto; white-space: nowrap; -ms-overflow-style: none; scrollbar-width: none;
        }
        .filter-tabs::-webkit-scrollbar { display: none; }
        .tab-item {
            padding-bottom: 14px; font-size: 14px; font-weight: 600; color: var(--text-secondary);
            cursor: pointer; position: relative; transition: 0.3s; display: flex; align-items: center; gap: 8px;
            text-decoration: none;
        }
        .tab-item:hover, .tab-item.active { color: var(--primary-color); }
        .tab-item.active::after {
            content: ''; position: absolute; bottom: -1px; left: 0; width: 100%; height: 2px;
            background: var(--primary-color); border-radius: 2px 2px 0 0;
        }
        .badge-count {
            background: var(--bg-body); padding: 2px 8px; border-radius: 12px;
            font-size: 11px; font-weight: 700; color: var(--text-main); border: 1px solid var(--border-color);
            transition: 0.3s;
        }
        .tab-item.active .badge-count { background: rgba(76, 175, 80, 0.1); color: var(--primary-color); border-color: var(--primary-color); }

        /* Filter Bar */
        .filter-bar { display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; }
        .search-group { flex: 1; position: relative; min-width: 250px; }
        .search-group i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 14px; }
        .search-input {
            width: 100%; padding: 12px 16px 12px 42px; border-radius: 12px;
            border: 1px solid var(--border-color); background: var(--bg-card);
            color: var(--text-main); outline: none; font-size: 14px; transition: 0.3s;
        }
        .search-input:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1); }
        .btn-filter-icon {
            padding: 12px 20px; border-radius: 12px; display: flex; align-items: center; gap: 8px;
            border: 1px solid var(--border-color); background: var(--bg-card);
            font-size: 13px; font-weight: 600; cursor: pointer; color: var(--text-main); white-space: nowrap; transition: 0.2s;
            text-decoration: none;
        }
        .btn-filter-icon:hover { border-color: var(--primary-color); color: var(--primary-color); }
        .btn-filter-icon.active-filter { border-color: #EF4444; color: #EF4444; background: rgba(239,68,68,0.05); }

        /* Table */
        .table-card {
            background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color);
            overflow: hidden; display: flex; flex-direction: column;
        }
        .table-responsive { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .user-table { width: 100%; border-collapse: collapse; min-width: 800px; }
        .user-table th {
            text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600;
            text-transform: uppercase; color: var(--text-secondary); background: var(--bg-body);
            border-bottom: 1px solid var(--border-color); letter-spacing: 0.5px; white-space: nowrap;
        }
        .user-table td { padding: 16px 24px; border-bottom: 1px solid var(--border-color); vertical-align: middle; font-size: 14px; color: var(--text-main); white-space: nowrap; }
        .user-table tr:hover { background: var(--bg-body); }
        .user-table tr:last-child td { border-bottom: none; }

        /* Components */
        .profile-group { display: flex; align-items: center; gap: 12px; }
        .avatar-circle { width: 40px; height: 40px; border-radius: 10px; background-size: cover; background-position: center; border: 1px solid var(--border-color); flex-shrink: 0; background-color: var(--bg-body); }
        .profile-info { display: flex; flex-direction: column; gap: 2px; }

        .level-tag { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800; text-transform: uppercase; display: inline-block; letter-spacing: 0.5px; }
        .level-pro  { background: #E0E7FF; color: #4338CA; border: 1px solid #C7D2FE; }
        .level-free { background: var(--bg-body); color: var(--text-secondary); border: 1px solid var(--border-color); }

        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-active   { background: rgba(34, 197, 94, 0.1); color: #16A34A; border: 1px solid rgba(34, 197, 94, 0.2); }
        .status-inactive { background: rgba(107, 114, 128, 0.1); color: #6B7280; border: 1px solid rgba(107, 114, 128, 0.2); }
        .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

        /* Actions */
        .actions { display: flex; gap: 8px; justify-content: flex-end; opacity: 0.7; transition: 0.2s; }
        .user-table tr:hover .actions { opacity: 1; }
        .btn-icon {
            width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border-color);
            background: var(--bg-card); color: var(--text-secondary); cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; text-decoration: none;
            padding: 0;
        }
        .btn-icon:hover { border-color: var(--primary-color); color: var(--primary-color); background: rgba(76, 175, 80, 0.05); }
        .btn-delete:hover { border-color: #EF4444; color: #EF4444; background: rgba(239, 68, 68, 0.05); }
        .btn-toggle-active:hover { border-color: #F59E0B; color: #F59E0B; background: rgba(245, 158, 11, 0.05); }
        .btn-toggle-pro:hover { border-color: #4338CA; color: #4338CA; background: rgba(67, 56, 202, 0.05); }

        /* Pagination */
        .pagination-wrapper {
            padding: 16px 24px; border-top: 1px solid var(--border-color);
            display: flex; justify-content: space-between; align-items: center; background: var(--bg-body);
        }
        .page-info { font-size: 13px; color: var(--text-secondary); }

        /* Empty State */
        .empty-state { padding: 60px 24px; text-align: center; color: var(--text-secondary); }
        .empty-state i { font-size: 48px; margin-bottom: 16px; opacity: 0.3; display: block; }
        .empty-state p { font-size: 15px; font-weight: 600; color: var(--text-main); margin-bottom: 6px; }
        .empty-state span { font-size: 13px; }

        /* Modal Confirm Delete */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
        .modal-overlay.show { display: flex; animation: fadeIn 0.2s ease-out forwards; }
        .modal-box { background: var(--bg-card); border-radius: 16px; padding: 32px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); transform: translateY(20px); transition: 0.3s; }
        .modal-overlay.show .modal-box { transform: translateY(0); }
        .modal-icon { font-size: 48px; color: #EF4444; margin-bottom: 16px; }
        .modal-box h3 { font-size: 18px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; }
        .modal-box p { font-size: 14px; color: var(--text-secondary); margin-bottom: 24px; line-height: 1.5; }
        .modal-actions { display: flex; gap: 12px; justify-content: center; }
        .btn-cancel { padding: 10px 24px; border-radius: 10px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-main); font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; }
        .btn-cancel:hover { background: var(--bg-body); }
        .btn-confirm-delete { padding: 10px 24px; border-radius: 10px; border: none; background: #EF4444; color: white; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2); }
        .btn-confirm-delete:hover { background: #DC2626; transform: translateY(-2px); }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        @media (max-width: 768px) {
            .page-header { flex-direction: column; align-items: flex-start; }
            .btn-add-user { width: 100%; justify-content: center; }
            .filter-bar { flex-direction: column; }
            .pagination-wrapper { flex-direction: column; gap: 16px; text-align: center; }
        }
    </style>
@endpush

@section('content')

{{-- Alert Messages --}}
@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif

{{-- Page Header --}}
<div class="page-header">
    <div class="header-title">
        <h1>Manajemen Pengguna</h1>
        <p>Terdapat <strong>{{ number_format($counts['all']) }}</strong> pengguna reguler terdaftar dalam sistem.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-add-user">
        <i class="fas fa-user-plus"></i> Tambah Pengguna Baru
    </a>
</div>

{{-- Filter Tabs --}}
<div class="filter-tabs">
    <a href="{{ route('admin.users.index', ['filter' => 'all', 'search' => request('search')]) }}"
       class="tab-item {{ $filter === 'all' ? 'active' : '' }}">
        Semua Pengguna <span class="badge-count">{{ number_format($counts['all']) }}</span>
    </a>
    <a href="{{ route('admin.users.index', ['filter' => 'premium', 'search' => request('search')]) }}"
       class="tab-item {{ $filter === 'premium' ? 'active' : '' }}">
        Premium (PRO) <span class="badge-count">{{ number_format($counts['premium']) }}</span>
    </a>
    <a href="{{ route('admin.users.index', ['filter' => 'free', 'search' => request('search')]) }}"
       class="tab-item {{ $filter === 'free' ? 'active' : '' }}">
        Gratis (FREE) <span class="badge-count">{{ number_format($counts['free']) }}</span>
    </a>
    <a href="{{ route('admin.users.index', ['filter' => 'new', 'search' => request('search')]) }}"
       class="tab-item {{ $filter === 'new' ? 'active' : '' }}">
        Pendaftar Baru <span class="badge-count">{{ number_format($counts['new']) }}</span>
    </a>
    <a href="{{ route('admin.users.index', ['filter' => 'inactive', 'search' => request('search')]) }}"
       class="tab-item {{ $filter === 'inactive' ? 'active' : '' }}">
        Nonaktif <span class="badge-count">{{ number_format($counts['inactive']) }}</span>
    </a>
</div>

{{-- Filter Search Bar --}}
<form method="GET" action="{{ route('admin.users.index') }}">
    <input type="hidden" name="filter" value="{{ $filter }}">
    <div class="filter-bar">
        <div class="search-group">
            <i class="fas fa-search"></i>
            <input type="text" name="search" class="search-input"
                   placeholder="Cari berdasarkan nama atau email..."
                   value="{{ request('search') }}">
        </div>
        <button type="submit" class="btn-filter-icon">
            <i class="fas fa-search"></i> Cari Data
        </button>
        @if(request('search'))
            <a href="{{ route('admin.users.index', ['filter' => $filter]) }}" class="btn-filter-icon active-filter" title="Hapus Filter Pencarian">
                <i class="fas fa-times"></i> Reset Pencarian
            </a>
        @endif
    </div>
</form>

{{-- Table --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="user-table">
            <thead>
                <tr>
                    <th>Identitas Pengguna</th>
                    <th>Status Akun</th>
                    <th>Paket Layanan</th>
                    <th>Bergabung Pada</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    {{-- Identitas --}}
                    <td>
                        <div class="profile-group">
                            <div class="avatar-circle"
                                 style="background-image: url('{{ $user->avatarUrl() ?? asset('images/default-avatar.png') }}');">
                            </div>
                            <div class="profile-info">
                                <span style="font-weight: 700; color: var(--text-main);">{{ $user->name }}</span>
                                <span style="font-size: 12px; color: var(--text-secondary);">{{ $user->email }}</span>
                            </div>
                        </div>
                    </td>

                    {{-- Status Aktif --}}
                    <td>
                        @if($user->is_active)
                            <span class="status-badge status-active"><span class="dot"></span> Aktif</span>
                        @else
                            <span class="status-badge status-inactive"><span class="dot"></span> Nonaktif</span>
                        @endif
                    </td>

                    {{-- Paket --}}
                    <td>
                        <span class="level-tag {{ $user->is_premium ? 'level-pro' : 'level-free' }}">
                            {{ $user->is_premium ? 'PRO' : 'FREE' }}
                        </span>
                    </td>

                    {{-- Tanggal --}}
                    <td style="font-size: 13px; color: var(--text-secondary);">
                        {{ $user->created_at->format('d M Y') }}
                        <div style="font-size: 11px; opacity: 0.7;">{{ $user->created_at->diffForHumans() }}</div>
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div class="actions">
                            {{-- Edit --}}
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon" title="Edit Data Pengguna">
                                <i class="fas fa-pen"></i>
                            </a>

                            {{-- Toggle Active --}}
                            <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" style="display: inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-icon btn-toggle-active"
                                        title="{{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                    <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                </button>
                            </form>

                            {{-- Toggle Premium --}}
                            <form action="{{ route('admin.users.toggle-premium', $user) }}" method="POST" style="display: inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-icon btn-toggle-pro" 
                                        title="{{ $user->is_premium ? 'Turunkan ke Paket FREE' : 'Upgrade ke Paket PRO' }}">
                                    <i class="fas fa-{{ $user->is_premium ? 'arrow-down' : 'crown' }}" style="color: {{ $user->is_premium ? 'var(--text-secondary)' : '#4338CA' }};"></i>
                                </button>
                            </form>

                            {{-- Reset Password --}}
                            <a href="{{ route('admin.users.reset-password.form', $user) }}" class="btn-icon" title="Reset Password Pengguna">
                                <i class="fas fa-key"></i>
                            </a>

                            {{-- Delete (Tanpa pengecekan auth()->id() karena ini list user reguler) --}}
                            <button type="button" class="btn-icon btn-delete" title="Hapus Pengguna Secara Permanen"
                                    onclick="confirmDelete('{{ route('admin.users.destroy', $user) }}', '{{ $user->name }}')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="fas fa-users-slash"></i>
                            <p>Data pengguna tidak ditemukan</p>
                            <span>Ubah kata kunci pencarian atau ganti filter tab di atas untuk melihat data lain.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrapper">
        <div class="page-info">
            Menampilkan data ke <strong>{{ $users->firstItem() ?? 0 }}</strong> - <strong>{{ $users->lastItem() ?? 0 }}</strong>
            dari total <strong>{{ number_format($users->total()) }}</strong> pengguna
        </div>
        <div>
            {{ $users->links() }}
        </div>
    </div>
</div>

{{-- Modal Confirm Delete --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Konfirmasi Penghapusan</h3>
        <p>Apakah Anda yakin ingin menghapus data pengguna <strong id="deleteUserName"></strong>? <br>Tindakan ini bersifat permanen dan tidak dapat dibatalkan.</p>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-confirm-delete">Ya, Hapus Permanen</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(url, name) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteUserName').textContent = name;
        document.getElementById('deleteModal').classList.add('show');
    }
    
    function closeModal() {
        document.getElementById('deleteModal').classList.remove('show');
    }
    
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endpush