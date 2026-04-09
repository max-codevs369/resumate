@extends('layouts.admin')

@section('title', 'Detail Transaksi #' . $transaction->transaction_code)

@push('styles')
<style>
    /* --- Layout --- */
    .detail-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 32px;
        align-items: start;
    }

    /* --- Cards --- */
    .main-card {
        background: var(--bg-card);
        border-radius: 24px;
        border: 1px solid var(--border-color);
        overflow: hidden;
    }
    .card-section {
        padding: 32px;
        border-bottom: 1px solid var(--border-color);
    }
    .card-section:last-child { border-bottom: none; }

    .section-title {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-secondary);
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* --- Bukti Transfer --- */
    .payment-proof-wrapper {
        background: var(--bg-body);
        border-radius: 16px;
        padding: 16px;
        border: 2px dashed var(--border-color);
        text-align: center;
        cursor: zoom-in;
        transition: 0.3s;
    }
    .payment-proof-wrapper:hover { border-color: var(--primary-color); background: rgba(76,175,80,0.05); }
    .payment-proof-wrapper img {
        max-width: 100%;
        max-height: 500px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    /* --- Sidebar --- */
    .sidebar-card {
        background: var(--bg-card);
        border-radius: 24px;
        padding: 32px;
        border: 1px solid var(--border-color);
        position: sticky;
        top: 24px;
    }
    .status-box {
        text-align: center;
        padding: 24px;
        border-radius: 20px;
        background: var(--bg-body);
        margin-bottom: 24px;
        border: 1px solid var(--border-color);
    }
    .amount-display {
        font-size: 32px;
        font-weight: 800;
        color: var(--text-main);
        letter-spacing: -1px;
        margin-top: 12px;
    }

    /* --- Info List --- */
    .info-list { list-style: none; padding: 0; margin: 0; }
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
        gap: 16px;
    }
    .info-item:last-child { border-bottom: none; }
    .info-label { color: var(--text-secondary); flex-shrink: 0; }
    .info-value { font-weight: 600; color: var(--text-main); text-align: right; }

    /* --- Status Badges --- */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }
    .status-approved { background: rgba(34,197,94,0.1);  color: #16a34a; }
    .status-pending  { background: rgba(245,158,11,0.1); color: #d97706; }
    .status-rejected { background: rgba(239,68,68,0.1);  color: #dc2626; }

    /* --- Action Buttons --- */
    .btn-approve {
        width: 100%;
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 16px;
        border-radius: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 15px;
    }
    .btn-approve:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(76,175,80,0.25);
    }
    .btn-reject-full {
        width: 100%;
        background: transparent;
        color: #e11d48;
        border: 1px solid #fecdd3;
        padding: 14px;
        border-radius: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
        margin-top: 12px;
        font-size: 14px;
    }
    .btn-reject-full:hover { background: #fff1f2; border-color: #e11d48; }

    /* --- Modal Shared --- */
    .trx-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .trx-modal.open { display: flex; }
    .modal-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.55);
        backdrop-filter: blur(4px);
    }
    .modal-box {
        position: relative;
        background: var(--bg-card);
        border-radius: 20px;
        padding: 32px;
        width: 100%;
        margin: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 25px 60px rgba(0,0,0,0.3);
        animation: modalIn 0.2s ease;
    }
    @keyframes modalIn {
        from { transform: scale(0.95) translateY(8px); opacity: 0; }
        to   { transform: scale(1)    translateY(0);   opacity: 1; }
    }

    /* --- Reason Options --- */
    .reason-option {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: 0.2s;
        font-size: 14px;
        color: var(--text-main);
    }
    .reason-option:hover    { border-color: #fda4af; background: rgba(225,29,72,0.03); }
    .reason-option.selected { border-color: #e11d48; background: #fff1f2; color: #e11d48; }
    .reason-option input[type="radio"] { accent-color: #e11d48; flex-shrink: 0; }

    /* --- Lightbox --- */
    #lightbox {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(0,0,0,0.92);
        align-items: center;
        justify-content: center;
        cursor: zoom-out;
    }
    #lightbox img {
        max-width: 90%;
        max-height: 90vh;
        border-radius: 8px;
        box-shadow: 0 0 80px rgba(0,0,0,0.5);
    }

    /* --- Alert --- */
    .alert {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 20px; border-radius: 12px; margin-bottom: 24px;
        font-size: 14px; font-weight: 500;
    }
    .alert-success { background: rgba(34,197,94,0.1);  color: #16a34a; border: 1px solid rgba(34,197,94,0.3); }
    .alert-error   { background: rgba(239,68,68,0.1);  color: #dc2626; border: 1px solid rgba(239,68,68,0.3); }

    @media (max-width: 992px) {
        .detail-container { grid-template-columns: 1fr; }
        .sidebar-card { position: static; }
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
<div style="margin-bottom:32px; display:flex; align-items:center; gap:16px;">
    <a href="{{ route('admin.transactions.index') }}"
       style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;
              border-radius:10px; border:1px solid var(--border-color); color:var(--text-main);
              text-decoration:none; transition:0.2s; flex-shrink:0;"
       onmouseover="this.style.borderColor='var(--primary-color)'; this.style.color='var(--primary-color)'"
       onmouseout="this.style.borderColor='var(--border-color)'; this.style.color='var(--text-main)'">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 style="font-size:24px; font-weight:800; letter-spacing:-0.5px; color:var(--text-main); margin:0 0 4px;">
            Detail Transaksi #{{ $transaction->transaction_code }}
        </h1>
        <p style="color:var(--text-secondary); font-size:14px; margin:0;">
            Dibuat pada {{ $transaction->created_at->format('d F Y • H:i:s') }} WIB
        </p>
    </div>
</div>

<div class="detail-container">

    {{-- ══ MAIN COLUMN ══ --}}
    <div class="main-card">

        {{-- Bukti Pembayaran --}}
        <div class="card-section">
            <div class="section-title"><i class="fas fa-image"></i> Bukti Pembayaran</div>
            @php
                $proofUrl = $transaction->proof_of_payment
                    ? Storage::url($transaction->proof_of_payment)
                    : asset('images/no-proof.png');
            @endphp
            <div class="payment-proof-wrapper" onclick="openLightbox('{{ $proofUrl }}')">
                @if($transaction->proof_of_payment)
                    <img src="{{ $proofUrl }}" alt="Bukti Transfer">
                @else
                    <div style="padding:40px; color:var(--text-secondary);">
                        <i class="fas fa-receipt fa-3x" style="margin-bottom:12px; opacity:0.3; display:block;"></i>
                        <p style="margin:0;">Tidak ada bukti yang diunggah</p>
                    </div>
                @endif
                <p style="margin-top:12px; font-size:13px; color:var(--text-secondary); font-weight:500;">
                    <i class="fas fa-search-plus"></i> Klik untuk memperbesar
                </p>
            </div>
        </div>

        {{-- Informasi Pembeli --}}
        <div class="card-section">
            <div class="section-title"><i class="fas fa-user-circle"></i> Informasi Pembeli</div>
            <div class="info-list">
                <div class="info-item">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ $transaction->user->name ?? 'User Terhapus' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email Terdaftar</span>
                    <span class="info-value">{{ $transaction->user->email ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status Akun</span>
                    <span class="info-value">
                        @if($transaction->user?->is_premium)
                            <span style="color:#16a34a; font-weight:700;">
                                <i class="fas fa-crown" style="font-size:11px;"></i> PRO Member
                            </span>
                        @else
                            <span style="color:var(--text-secondary);">FREE Member</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Catatan Admin --}}
        @if($transaction->admin_note)
        <div class="card-section" style="background:rgba(var(--primary-rgb),0.02);">
            <div class="section-title"><i class="fas fa-comment-alt"></i> Catatan Admin</div>
            <p style="font-size:14px; color:var(--text-main); line-height:1.7; margin:0;">
                {{ $transaction->admin_note }}
            </p>
            @if($transaction->verified_at)
            <small style="color:var(--text-secondary); display:block; margin-top:10px;">
                <i class="fas fa-clock"></i>
                Diverifikasi pada: {{ $transaction->verified_at->format('d M Y, H:i') }} WIB
            </small>
            @endif
        </div>
        @endif

    </div>

    {{-- ══ SIDEBAR ══ --}}
    <div class="sidebar-card">

        {{-- Status & Nominal --}}
        <div class="status-box">
            <span class="status-badge status-{{ $transaction->status }}">
                <span style="width:6px; height:6px; border-radius:50%; background:currentColor;"></span>
                {{ $transaction->status === 'approved' ? 'Berhasil' : ($transaction->status === 'pending' ? 'Menunggu' : 'Ditolak') }}
            </span>
            <div class="amount-display">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</div>
            <p style="font-size:12px; color:var(--text-secondary); margin-top:8px;">
                Metode: <strong>{{ strtoupper($transaction->payment_method) }}</strong>
            </p>
        </div>

        {{-- Info Detail --}}
        <div class="info-list"
             style="background:var(--bg-body); padding:20px; border-radius:16px;
                    border:1px solid var(--border-color); margin-bottom:24px;">
            <div class="info-item">
                <span class="info-label">Tujuan</span>
                <span class="info-value">Akses PRO 1 Bulan</span>
            </div>
            <div class="info-item">
                <span class="info-label">Item</span>
                <span class="info-value">
                    {{ $transaction->resume ? $transaction->resume->title : 'Membership Upgrade' }}
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Kode Transaksi</span>
                <span class="info-value" style="font-family:monospace; font-size:12px;">
                    {{ $transaction->transaction_code }}
                </span>
            </div>
            @if($transaction->verified_at)
            <div class="info-item">
                <span class="info-label">Verifikasi</span>
                <span class="info-value">{{ $transaction->verified_at->diffForHumans() }}</span>
            </div>
            @endif
        </div>

        {{-- Action Buttons (hanya jika pending) --}}
        @if($transaction->status === 'pending')
        <div>
            <button type="button" class="btn-approve" id="openApproveModalBtn">
                <i class="fas fa-check-circle"></i> Verifikasi Sekarang
            </button>

            <button type="button" class="btn-reject-full" id="openRejectModalBtn">
                <i class="fas fa-times-circle"></i> Tolak Pembayaran
            </button>

            <div style="background:rgba(245,158,11,0.05); padding:14px; border-radius:12px;
                        margin-top:16px; border:1px solid rgba(245,158,11,0.15);">
                <p style="font-size:11px; color:#92400e; line-height:1.6; margin:0; text-align:center;">
                    <i class="fas fa-exclamation-triangle"></i>
                    Periksa mutasi rekening sebelum menyetujui untuk menghindari bukti transfer palsu.
                </p>
            </div>
        </div>
        @endif

    </div>
</div>


{{-- ══════════════════════════════════════════
     MODAL: APPROVE
══════════════════════════════════════════ --}}
<div id="approveModal" class="trx-modal">
    <div class="modal-backdrop" data-close="approveModal"></div>
    <div class="modal-box" style="max-width:420px; text-align:center;">
        <div style="width:64px; height:64px; border-radius:50%; background:rgba(34,197,94,0.1);
                    display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="fas fa-check-circle" style="color:#22c55e; font-size:26px;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:700; color:var(--text-main); margin:0 0 10px;">
            Verifikasi Pembayaran?
        </h3>
        <p style="font-size:13px; color:var(--text-secondary); margin:0 0 24px; line-height:1.6;">
            Transaksi <strong style="color:var(--text-main);">{{ $transaction->transaction_code }}</strong>
            akan disetujui dan user akan otomatis di-upgrade ke <strong>PRO</strong> selama 1 bulan.
        </p>
        <div style="display:flex; gap:12px;">
            <button data-close="approveModal"
                style="flex:1; padding:12px; border-radius:10px; border:1px solid var(--border-color);
                       background:var(--bg-body); color:var(--text-main); font-size:14px; font-weight:600; cursor:pointer;">
                Batal
            </button>
            <form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST" style="flex:2;">
                @csrf
                @method('PATCH')
                <button type="submit" id="approveSubmitBtn"
                    style="width:100%; padding:12px; border-radius:10px; border:none;
                           background:var(--primary-color); color:white; font-size:14px; font-weight:700; cursor:pointer;">
                    <i class="fas fa-check"></i> Ya, Verifikasi
                </button>
            </form>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════
     MODAL: REJECT
══════════════════════════════════════════ --}}
<div id="rejectModal" class="trx-modal">
    <div class="modal-backdrop" data-close="rejectModal"></div>
    <div class="modal-box" style="max-width:500px;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="width:40px; height:40px; border-radius:10px; background:rgba(225,29,72,0.1);
                            display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fas fa-ban" style="color:#e11d48;"></i>
                </div>
                <div>
                    <h3 style="font-size:17px; font-weight:700; color:var(--text-main); margin:0;">Tolak Pembayaran</h3>
                    <p style="font-size:12px; color:var(--text-secondary); margin:0;">
                        #{{ $transaction->transaction_code }}
                    </p>
                </div>
            </div>
            <button data-close="rejectModal"
                style="background:none; border:none; font-size:22px; cursor:pointer;
                       color:var(--text-secondary); line-height:1; padding:4px;">
                &times;
            </button>
        </div>

        <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST" id="rejectForm">
            @csrf
            @method('PATCH')

            <p style="font-size:13px; color:var(--text-secondary); margin:0 0 16px;">
                Pilih alasan penolakan agar pengguna tahu langkah selanjutnya.
            </p>

            {{-- Preset Reasons --}}
            <div class="reason-option" onclick="selectReason('r1')">
                <input type="radio" name="admin_note" id="r1"
                       value="Bukti transfer tidak terbaca / buram" required>
                <label for="r1" style="cursor:pointer;">Bukti transfer buram / tidak terbaca</label>
            </div>
            <div class="reason-option" onclick="selectReason('r2')">
                <input type="radio" name="admin_note" id="r2"
                       value="Nominal yang ditransfer tidak sesuai dengan harga paket">
                <label for="r2" style="cursor:pointer;">Nominal transfer tidak sesuai</label>
            </div>
            <div class="reason-option" onclick="selectReason('r3')">
                <input type="radio" name="admin_note" id="r3"
                       value="Pembayaran tidak terdeteksi pada mutasi rekening">
                <label for="r3" style="cursor:pointer;">Dana tidak masuk di mutasi rekening</label>
            </div>
            <div class="reason-option" onclick="selectReason('r4')">
                <input type="radio" name="admin_note" id="r4"
                       value="Bukti transfer terindikasi telah diedit / dipalsukan">
                <label for="r4" style="cursor:pointer;">Bukti transfer terindikasi dipalsukan</label>
            </div>

            {{-- Custom Reason --}}
            <div style="margin-top:6px;">
                <label style="font-size:13px; color:var(--text-secondary); display:block; margin-bottom:6px;">
                    Atau tulis alasan lain:
                </label>
                <textarea id="customReasonInput" rows="3"
                    placeholder="Contoh: Rekening tujuan tidak sesuai..."
                    style="width:100%; padding:12px 16px; border-radius:12px; border:1px solid var(--border-color);
                           background:var(--bg-body); color:var(--text-main); font-size:14px; resize:none;
                           outline:none; box-sizing:border-box; transition:border-color 0.2s;"></textarea>
            </div>

            <p id="rejectFormError" style="color:#e11d48; font-size:12px; margin-top:8px; display:none;">
                <i class="fas fa-exclamation-circle"></i> Pilih alasan atau tulis alasan penolakan.
            </p>

            <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="button" data-close="rejectModal"
                    style="flex:1; padding:13px; border-radius:10px; border:1px solid var(--border-color);
                           background:var(--bg-body); color:var(--text-main); font-size:14px; font-weight:600; cursor:pointer;">
                    Batal
                </button>
                <button type="button" id="rejectSubmitBtn"
                    style="flex:2; padding:13px; border-radius:10px; border:none;
                           background:#e11d48; color:white; font-size:14px; font-weight:700; cursor:pointer;">
                    <i class="fas fa-times-circle"></i> Kirim Penolakan
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ══════════════════════════════════════════
     LIGHTBOX
══════════════════════════════════════════ --}}
<div id="lightbox">
    <img id="lightboxImg" src="" alt="Bukti Pembayaran">
</div>

@endsection


@push('scripts')
<script>
// ══════════════════════════════════════════
// Utility: Modal open/close
// ══════════════════════════════════════════
function openModal(id)  { document.getElementById(id).classList.add('open');    }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('[data-close]').forEach(el => {
    el.addEventListener('click', () => closeModal(el.dataset.close));
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') ['approveModal', 'rejectModal'].forEach(closeModal);
});


// ══════════════════════════════════════════
// APPROVE MODAL
// ══════════════════════════════════════════
document.getElementById('openApproveModalBtn')?.addEventListener('click', () => openModal('approveModal'));

document.querySelector('#approveModal form')?.addEventListener('submit', function () {
    const btn = document.getElementById('approveSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
});


// ══════════════════════════════════════════
// REJECT MODAL
// ══════════════════════════════════════════
document.getElementById('openRejectModalBtn')?.addEventListener('click', () => {
    // Reset state
    document.querySelectorAll('.reason-option').forEach(o => o.classList.remove('selected'));
    document.querySelectorAll('input[name="admin_note"]').forEach(r => r.checked = false);
    document.getElementById('customReasonInput').value = '';
    document.getElementById('rejectFormError').style.display = 'none';
    openModal('rejectModal');
});

function selectReason(id) {
    document.querySelectorAll('.reason-option').forEach(o => o.classList.remove('selected'));
    const radio = document.getElementById(id);
    radio.checked = true;
    radio.closest('.reason-option').classList.add('selected');
    // Kosongkan custom textarea jika memilih preset
    document.getElementById('customReasonInput').value = '';
}

// Jika user mulai ketik di textarea, uncheck semua radio
document.getElementById('customReasonInput').addEventListener('input', function () {
    if (this.value.trim()) {
        document.querySelectorAll('input[name="admin_note"]').forEach(r => r.checked = false);
        document.querySelectorAll('.reason-option').forEach(o => o.classList.remove('selected'));
    }
    document.getElementById('rejectFormError').style.display = 'none';
});

document.getElementById('rejectSubmitBtn').addEventListener('click', () => {
    const selectedRadio = document.querySelector('input[name="admin_note"]:checked');
    const customReason  = document.getElementById('customReasonInput').value.trim();
    const errorEl       = document.getElementById('rejectFormError');

    // Validasi: harus ada salah satu
    if (!selectedRadio && !customReason) {
        errorEl.style.display = 'block';
        return;
    }

    // Jika custom diisi, inject ke form sebagai admin_note
    if (!selectedRadio && customReason) {
        const hidden = document.createElement('input');
        hidden.type  = 'hidden';
        hidden.name  = 'admin_note';
        hidden.value = customReason;
        document.getElementById('rejectForm').appendChild(hidden);
    }

    const btn = document.getElementById('rejectSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

    document.getElementById('rejectForm').submit();
});


// ══════════════════════════════════════════
// LIGHTBOX
// ══════════════════════════════════════════
function openLightbox(src) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightbox').style.display = 'flex';
}

document.getElementById('lightbox').addEventListener('click', function () {
    this.style.display = 'none';
});
</script>
@endpush