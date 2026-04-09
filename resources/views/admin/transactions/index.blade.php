@extends('layouts.admin')

@section('title', 'Manajemen Transaksi')

@push('styles')
<style>
    .stats-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px; margin-bottom: 32px;
    }
    .stat-card {
        background: var(--bg-card); padding: 20px; border-radius: 16px;
        border: 1px solid var(--border-color); display: flex; align-items: center; gap: 16px;
    }
    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; font-size: 20px;
    }
    .stat-info h4 { font-size: 13px; color: var(--text-secondary); margin-bottom: 4px; font-weight: 500; }
    .stat-info div { font-size: 20px; font-weight: 800; color: var(--text-main); }

    .page-header {
        display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px;
        flex-wrap: wrap; gap: 16px;
    }
    .header-title h1 { font-size: 28px; font-weight: 800; color: var(--text-main); margin-bottom: 4px; letter-spacing: -0.5px; }
    .header-title p { color: var(--text-secondary); font-size: 14px; }

    .alert {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 20px; border-radius: 12px; margin-bottom: 20px;
        font-size: 14px; font-weight: 500;
    }
    .alert-success { background: rgba(34, 197, 94, 0.1); color: #16a34a; border: 1px solid rgba(34, 197, 94, 0.3); }
    .alert-error   { background: rgba(239, 68, 68, 0.1);  color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.3); }

    .filter-tabs {
        display: flex; gap: 25px; border-bottom: 1px solid var(--border-color); margin-bottom: 24px;
        overflow-x: auto; scrollbar-width: none;
    }
    .tab-item {
        padding-bottom: 12px; font-size: 14px; font-weight: 600; color: var(--text-secondary);
        cursor: pointer; position: relative; transition: 0.3s; white-space: nowrap; text-decoration: none;
        display: flex; align-items: center; gap: 8px;
    }
    .tab-item:hover, .tab-item.active { color: var(--primary-color); }
    .tab-item.active::after {
        content: ''; position: absolute; bottom: -1px; left: 0; width: 100%; height: 2px;
        background: var(--primary-color);
    }
    .badge-count {
        background: var(--bg-body); padding: 2px 8px; border-radius: 10px; font-size: 11px;
        color: var(--text-main); border: 1px solid var(--border-color);
    }
    .tab-item.active .badge-count { background: rgba(76, 175, 80, 0.1); color: var(--primary-color); border-color: var(--primary-color); }

    .filter-bar { display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; }
    .search-group { flex: 1; position: relative; min-width: 250px; }
    .search-group i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); }
    .search-input {
        width: 100%; padding: 12px 16px 12px 42px; border-radius: 12px;
        border: 1px solid var(--border-color); background: var(--bg-card);
        color: var(--text-main); outline: none; font-size: 14px;
    }

    .table-card {
        background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color);
        overflow: hidden;
    }
    .transaction-table { width: 100%; border-collapse: collapse; }
    .transaction-table th {
        text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600;
        text-transform: uppercase; color: var(--text-secondary); background: var(--bg-body);
        border-bottom: 1px solid var(--border-color);
    }
    .transaction-table td { padding: 16px 24px; border-bottom: 1px solid var(--border-color); font-size: 14px; }
    .transaction-table tr:last-child td { border-bottom: none; }
    .transaction-table tr:hover { background: rgba(var(--primary-rgb), 0.02); }

    .status-badge {
        display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px;
        border-radius: 20px; font-size: 12px; font-weight: 600;
    }
    .status-approved { background: rgba(34, 197, 94, 0.1); color: #16a34a; }
    .status-pending  { background: rgba(245, 158, 11, 0.1); color: #d97706; }
    .status-rejected { background: rgba(239, 68, 68, 0.1);  color: #dc2626; }
    .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .actions { display: flex; align-items: center; justify-content: flex-end; gap: 6px; }
    .btn-icon {
        width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border-color);
        display: inline-flex; align-items: center; justify-content: center; transition: 0.2s;
        color: var(--text-secondary); background: var(--bg-card); text-decoration: none; cursor: pointer;
    }
    .btn-icon:hover          { border-color: var(--primary-color); color: var(--primary-color); }
    .btn-verify:hover        { background: var(--primary-color); color: white; border-color: var(--primary-color); }
    .btn-reject-icon:hover   { background: #f59e0b; color: white; border-color: #f59e0b; }
    .btn-delete:hover        { background: #ef4444; color: white; border-color: #ef4444; }

    .pagination-wrapper { padding: 20px 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }

    .trx-modal {
        display: none; position: fixed; inset: 0; z-index: 9999;
        align-items: center; justify-content: center;
    }
    .trx-modal.open { display: flex; }
    .modal-backdrop {
        position: absolute; inset: 0;
        background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);
    }
    .modal-box {
        position: relative; background: var(--bg-card); border-radius: 20px; padding: 32px;
        width: 100%; margin: 16px; border: 1px solid var(--border-color);
        box-shadow: 0 25px 60px rgba(0,0,0,0.3); animation: modalIn 0.2s ease;
    }
    @keyframes modalIn {
        from { transform: scale(0.95) translateY(8px); opacity: 0; }
        to   { transform: scale(1) translateY(0);      opacity: 1; }
    }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(59,130,246,0.1); color:#3b82f6;">
            <i class="fas fa-wallet"></i>
        </div>
        <div class="stat-info">
            <h4>Total Pendapatan</h4>
            <div>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(245,158,11,0.1); color:#f59e0b;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h4>Perlu Verifikasi</h4>
            <div>{{ $counts['pending'] }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(34,197,94,0.1); color:#22c55e;">
            <i class="fas fa-check-double"></i>
        </div>
        <div class="stat-info">
            <h4>Transaksi Berhasil</h4>
            <div>{{ $counts['approved'] }}</div>
        </div>
    </div>
</div>

<div class="page-header">
    <div class="header-title">
        <h1>Riwayat Transaksi</h1>
        <p>Manajemen pembayaran user untuk akses <strong>Premium PRO</strong>.</p>
    </div>
</div>

<div class="filter-tabs">
    @foreach(['all' => 'Semua', 'pending' => 'Menunggu', 'approved' => 'Berhasil', 'rejected' => 'Ditolak'] as $key => $label)
        <a href="{{ route('admin.transactions.index', array_merge(request()->query(), ['filter' => $key])) }}"
           class="tab-item {{ $filter === $key ? 'active' : '' }}">
            {{ $label }} <span class="badge-count">{{ $counts[$key] }}</span>
        </a>
    @endforeach
</div>

<form method="GET" action="{{ route('admin.transactions.index') }}" class="filter-bar">
    <input type="hidden" name="filter" value="{{ $filter }}">
    <div class="search-group">
        <i class="fas fa-search"></i>
        <input type="text" name="search" class="search-input"
               value="{{ request('search') }}" placeholder="Cari Kode TRX, Nama, atau Email...">
    </div>
    <div style="display:flex; align-items:center; gap:8px; background:var(--bg-card); border:1px solid var(--border-color); padding:0 16px; border-radius:12px;">
        <i class="far fa-calendar-alt" style="color:var(--text-secondary);"></i>
        <input type="date" name="date_from" value="{{ request('date_from') }}"
               style="border:none; background:transparent; font-size:13px; color:var(--text-main); padding:10px 0;">
        <span style="color:var(--border-color);">|</span>
        <input type="date" name="date_to" value="{{ request('date_to') }}"
               style="border:none; background:transparent; font-size:13px; color:var(--text-main); padding:10px 0;">
    </div>
    <button type="submit" class="btn-icon"
            style="background:var(--primary-color); color:white; border:none; width:42px; height:42px;">
        <i class="fas fa-filter"></i>
    </button>
    @if(request()->anyFilled(['search', 'date_from', 'date_to']))
        <a href="{{ route('admin.transactions.index', ['filter' => $filter]) }}"
           class="btn-icon" style="width:42px; height:42px;" title="Reset Filter">
            <i class="fas fa-undo"></i>
        </a>
    @endif
</form>

<div class="table-card">
    <div style="overflow-x:auto;">
        <table class="transaction-table">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Kode &amp; Layanan</th>
                    <th>Metode</th>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $trx)
                <tr>
                    <td>
                        <div class="user-profile">
                            <div class="user-avatar" style="background-image:url('{{ $trx->user->avatarUrl() }}');"></div>
                            <div class="user-details">
                                <div>{{ $trx->user->name ?? 'User Terhapus' }}</div>
                                <small>{{ $trx->user->email ?? '-' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-family:monospace; font-weight:700;">{{ $trx->transaction_code }}</span><br>
                        <small class="text-primary" style="font-weight:600;">
                            {{ $trx->resume ? 'Template: '.$trx->resume->title : 'Paket PRO 1 Bulan' }}
                        </small>
                    </td>
                    <td>
                        <div style="display:flex; align-items:center; gap:6px; font-size:13px;">
                            <i class="fas fa-credit-card" style="color:var(--text-secondary);"></i>
                            {{ $trx->payment_method }}
                        </div>
                    </td>
                    <td style="color:var(--text-secondary); font-size:13px;">
                        {{ $trx->created_at->format('d M Y') }}<br>
                        <small>{{ $trx->created_at->format('H:i') }} WIB</small>
                    </td>
                    <td style="font-weight:700; color:var(--text-main);">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="status-badge status-{{ $trx->status }}">
                            <span class="dot"></span>
                            {{ $trx->status === 'approved' ? 'Berhasil' : ($trx->status === 'pending' ? 'Menunggu' : 'Ditolak') }}
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            @if($trx->status === 'pending')
                                {{-- Approve --}}
                                <form action="{{ route('admin.transactions.approve', $trx) }}" method="POST" class="approve-form">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button"
                                            class="btn-icon btn-verify approve-btn"
                                            data-code="{{ $trx->transaction_code }}"
                                            title="Setujui">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                <button type="button"
                                        class="btn-icon btn-reject-icon reject-btn"
                                        data-id="{{ $trx->id }}"
                                        data-code="{{ $trx->transaction_code }}"
                                        title="Tolak">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif

                            <a href="{{ route('admin.transactions.show', $trx) }}" class="btn-icon" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                            @if($trx->status !== 'approved')
                                <form class="delete-form" action="{{ route('admin.transactions.destroy', $trx) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn-icon btn-delete delete-btn"
                                            data-code="{{ $trx->transaction_code }}"
                                            title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:60px;">
                        <img src="{{ asset('images/empty-trx.svg') }}" alt=""
                             style="width:120px; opacity:0.5; margin-bottom:16px; display:block; margin-inline:auto;">
                        <p style="color:var(--text-secondary);">Tidak ada transaksi yang sesuai dengan filter.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        <div class="page-info">
            Data <strong>{{ $transactions->firstItem() ?? 0 }}</strong> –
            <strong>{{ $transactions->lastItem() ?? 0 }}</strong> dari
            <strong>{{ $transactions->total() }}</strong>
        </div>
        {{ $transactions->links() }}
    </div>
</div>


<div id="approveModal" class="trx-modal">
    <div class="modal-backdrop" data-close="approveModal"></div>
    <div class="modal-box" style="max-width:420px; text-align:center;">
        <div style="width:64px; height:64px; border-radius:50%; background:rgba(34,197,94,0.1);
                    display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="fas fa-check-circle" style="color:#22c55e; font-size:26px;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:700; color:var(--text-main); margin:0 0 8px;">Setujui Transaksi?</h3>
        <p style="font-size:13px; color:var(--text-secondary); margin:0 0 24px;">
            Transaksi <strong id="approveModalCode" style="color:var(--text-main);"></strong>
            akan disetujui dan user akan otomatis di-upgrade ke <strong>PRO</strong>.
        </p>
        <div style="display:flex; gap:12px;">
            <button data-close="approveModal"
                style="flex:1; padding:12px; border-radius:10px; border:1px solid var(--border-color);
                       background:var(--bg-body); color:var(--text-main); font-size:14px; font-weight:600; cursor:pointer;">
                Batal
            </button>
            <button id="approveSubmitBtn"
                style="flex:1; padding:12px; border-radius:10px; border:none;
                       background:var(--primary-color); color:white; font-size:14px; font-weight:600; cursor:pointer;">
                <i class="fas fa-check"></i> Ya, Setujui
            </button>
        </div>
    </div>
</div>


<div id="rejectModal" class="trx-modal">
    <div class="modal-backdrop" data-close="rejectModal"></div>
    <div class="modal-box" style="max-width:460px;">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
            <div style="width:44px; height:44px; border-radius:12px; background:rgba(239,68,68,0.1);
                        display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-ban" style="color:#ef4444; font-size:18px;"></i>
            </div>
            <div>
                <h3 style="font-size:17px; font-weight:700; color:var(--text-main); margin:0;">Tolak Transaksi</h3>
                <p id="rejectModalSubtitle" style="font-size:13px; color:var(--text-secondary); margin:0;"></p>
            </div>
        </div>

        <label style="display:block; font-size:13px; font-weight:600; color:var(--text-main); margin-bottom:8px;">
            Alasan Penolakan <span style="color:#ef4444;">*</span>
        </label>
        <textarea id="rejectReason" rows="4"
            placeholder="Contoh: Bukti pembayaran tidak valid, nominal tidak sesuai, dll."
            style="width:100%; padding:12px 16px; border-radius:12px; border:1px solid var(--border-color);
                   background:var(--bg-body); color:var(--text-main); font-size:14px; resize:none; outline:none;
                   transition:border-color 0.2s; box-sizing:border-box;"></textarea>
        <p id="rejectError" style="color:#ef4444; font-size:12px; margin-top:6px; display:none;">
            <i class="fas fa-exclamation-circle"></i> Alasan penolakan wajib diisi.
        </p>

        <div style="display:flex; gap:12px; margin-top:24px;">
            <button data-close="rejectModal"
                style="flex:1; padding:12px; border-radius:10px; border:1px solid var(--border-color);
                       background:var(--bg-body); color:var(--text-main); font-size:14px; font-weight:600; cursor:pointer;">
                Batal
            </button>
            <button id="rejectSubmitBtn"
                style="flex:1; padding:12px; border-radius:10px; border:none;
                       background:#ef4444; color:white; font-size:14px; font-weight:600; cursor:pointer;">
                <i class="fas fa-times-circle"></i> Tolak Transaksi
            </button>
        </div>
    </div>
</div>


<div id="deleteModal" class="trx-modal">
    <div class="modal-backdrop" data-close="deleteModal"></div>
    <div class="modal-box" style="max-width:420px; text-align:center;">
        <div style="width:64px; height:64px; border-radius:50%; background:rgba(239,68,68,0.1);
                    display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="fas fa-trash-alt" style="color:#ef4444; font-size:24px;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:700; color:var(--text-main); margin:0 0 8px;">Hapus Transaksi?</h3>
        <p style="font-size:13px; color:var(--text-secondary); margin:0 0 24px;">
            Transaksi <strong id="deleteModalCode" style="color:var(--text-main);"></strong>
            akan dihapus permanen dan tidak dapat dikembalikan.
        </p>
        <div style="display:flex; gap:12px;">
            <button data-close="deleteModal"
                style="flex:1; padding:12px; border-radius:10px; border:1px solid var(--border-color);
                       background:var(--bg-body); color:var(--text-main); font-size:14px; font-weight:600; cursor:pointer;">
                Batal
            </button>
            <button id="deleteSubmitBtn"
                style="flex:1; padding:12px; border-radius:10px; border:none;
                       background:#ef4444; color:white; font-size:14px; font-weight:600; cursor:pointer;">
                <i class="fas fa-trash-alt"></i> Hapus Permanen
            </button>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
function openModal(id)  { document.getElementById(id).classList.add('open');    }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('[data-close]').forEach(el => {
    el.addEventListener('click', () => closeModal(el.dataset.close));
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        ['approveModal', 'rejectModal', 'deleteModal'].forEach(closeModal);
    }
});


let pendingApproveForm = null;

document.querySelectorAll('.approve-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        pendingApproveForm = btn.closest('.approve-form');
        document.getElementById('approveModalCode').textContent = btn.dataset.code;
        openModal('approveModal');
    });
});

document.getElementById('approveSubmitBtn').addEventListener('click', () => {
    if (!pendingApproveForm) return;
    const btn = document.getElementById('approveSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    pendingApproveForm.submit();
});


let pendingRejectId = null;
const rejectReason  = document.getElementById('rejectReason');
const rejectError   = document.getElementById('rejectError');

document.querySelectorAll('.reject-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        pendingRejectId = btn.dataset.id;
        document.getElementById('rejectModalSubtitle').textContent = `Kode: ${btn.dataset.code}`;
        rejectReason.value = '';
        rejectError.style.display = 'none';
        rejectReason.style.borderColor = 'var(--border-color)';
        openModal('rejectModal');
        setTimeout(() => rejectReason.focus(), 150);
    });
});

rejectReason.addEventListener('input', () => {
    if (rejectReason.value.trim()) {
        rejectError.style.display = 'none';
        rejectReason.style.borderColor = 'var(--border-color)';
    }
});

document.getElementById('rejectSubmitBtn').addEventListener('click', () => {
    const reason = rejectReason.value.trim();
    if (!reason) {
        rejectError.style.display = 'block';
        rejectReason.style.borderColor = '#ef4444';
        rejectReason.focus();
        return;
    }

    const btn = document.getElementById('rejectSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ url('admin/transaksi') }}/${pendingRejectId}/reject`;
    form.innerHTML = `
        <input type="hidden" name="_token"  value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="admin_note" value="${reason.replace(/"/g, '&quot;')}">
    `;
    document.body.appendChild(form);
    form.submit();
});


let pendingDeleteForm = null;

document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        pendingDeleteForm = btn.closest('.delete-form');
        document.getElementById('deleteModalCode').textContent = btn.dataset.code;
        openModal('deleteModal');
    });
});

document.getElementById('deleteSubmitBtn').addEventListener('click', () => {
    if (!pendingDeleteForm) return;
    const btn = document.getElementById('deleteSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';
    pendingDeleteForm.submit();
});
</script>
@endpush