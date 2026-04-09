@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stats-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;
        margin-bottom: 40px;
    }
    .stat-card {
        background: var(--bg-card); padding: 24px; border-radius: 16px;
        box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);
        display: flex; flex-direction: column; gap: 15px; transition: 0.3s;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); border-color: var(--primary-color); }
    
    .stat-header { display: flex; justify-content: space-between; align-items: flex-start; }
    .stat-icon {
        width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;
    }
    .icon-income { background: rgba(76, 175, 80, 0.1); color: var(--primary-color); }
    .icon-user { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
    .icon-pending { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
    
    .stat-val { font-size: 26px; font-weight: 800; color: var(--text-main); line-height: 1; }
    .stat-label { font-size: 13px; color: var(--text-muted); font-weight: 500; }
    
    .table-card {
        background: var(--bg-card); border-radius: 16px; 
        border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    .table-header {
        padding: 20px 24px; border-bottom: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
    }
    .table-header h3 { font-size: 16px; font-weight: 700; color: var(--text-main); }

    table { width: 100%; border-collapse: collapse; }
    th { text-align: left; padding: 14px 24px; font-size: 12px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; background: var(--bg-body); }
    td { padding: 16px 24px; font-size: 14px; border-bottom: 1px solid var(--border-color); color: var(--text-main); }
    tr:last-child td { border-bottom: none; }

    .status-badge {
        padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block;
    }
    .status-pending { background: rgba(245, 158, 11, 0.15); color: #D97706; }
    .status-approved { background: rgba(76, 175, 80, 0.15); color: var(--primary-color); }
    .status-rejected { background: rgba(239, 68, 68, 0.15); color: #DC2626; }

    .btn-xs {
        padding: 6px 12px; font-size: 12px; border-radius: 6px; 
        border: 1px solid var(--border-color); background: var(--bg-body);
        color: var(--text-main); cursor: pointer; transition: 0.2s; font-weight: 600; text-decoration: none;
    }
    .btn-xs:hover { border-color: var(--primary-color); color: var(--primary-color); }

    @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .stats-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div style="margin-bottom: 30px;">
    <h2 style="font-size: 24px; font-weight: 700; color: var(--text-main);">Dashboard</h2>
    <p style="color: var(--text-muted); font-size: 14px;">Ringkasan performa aplikasi hari ini.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-val">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pendapatan</div>
            </div>
            <div class="stat-icon icon-income"><i class="fas fa-wallet"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-val">{{ number_format($totalPengguna, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pengguna</div>
            </div>
            <div class="stat-icon icon-user"><i class="fas fa-users"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-val">{{ number_format($pendingVerifikasi, 0, ',', '.') }}</div>
                <div class="stat-label">Perlu Verifikasi</div>
            </div>
            <div class="stat-icon icon-pending"><i class="fas fa-clock"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-val">{{ number_format($totalTemplate, 0, ',', '.') }}</div>
                <div class="stat-label">Template Aktif</div>
            </div>
            <div class="stat-icon" style="background: rgba(124, 58, 237, 0.1); color: #7C3AED;"><i class="fas fa-layer-group"></i></div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-header">
        <h3>Pembayaran Terbaru</h3>
        <a href="{{ route('admin.transactions.index') }}" style="font-size: 13px; color: var(--primary-color); font-weight: 600; text-decoration: none;">Lihat Semua</a>
    </div>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Metode</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentTransactions as $trx)
                <tr>
                    <td>
                        <div style="font-weight: 600;">{{ $trx->user->name ?? 'User Terhapus' }}</div>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ $trx->created_at->diffForHumans() }}</div>
                    </td>
                    <td>{{ $trx->payment_method }}</td>
                    <td style="font-weight: 700;">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                    <td>
                        <span class="status-badge status-{{ $trx->status }}">
                            {{ ucfirst($trx->status == 'approved' ? 'Berhasil' : ($trx->status == 'pending' ? 'Menunggu' : 'Ditolak')) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.transactions.show', $trx->id) }}" class="btn-xs">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        Belum ada data transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection