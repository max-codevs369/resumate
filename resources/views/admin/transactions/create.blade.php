@extends('layouts.admin')

@section('title', 'Buat Transaksi Baru')

@push('styles')
<style>
    .form-container {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 24px;
        align-items: start;
    }

    .card {
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .card-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-body);
    }

    .card-header h3 { font-size: 16px; font-weight: 700; color: var(--text-main); margin: 0; }

    .card-body { padding: 24px; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .full-width { grid-column: span 2; }
    .form-group { margin-bottom: 20px; }
    
    .form-label {
        display: block; font-size: 12px; font-weight: 700;
        text-transform: uppercase; color: var(--text-secondary);
        margin-bottom: 8px; letter-spacing: 0.5px;
    }

    .form-input {
        width: 100%; padding: 12px 16px; border-radius: 10px;
        border: 1px solid var(--border-color); background: var(--bg-card);
        color: var(--text-main); font-size: 14px; transition: 0.2s;
        box-sizing: border-box;
    }

    .form-input:focus { border-color: var(--primary-color); outline: none; box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1); }
    
    .text-error { color: #dc2626; font-size: 12px; margin-top: 6px; display: block; font-weight: 500; }

    #custom_payment_wrapper { display: none; margin-top: 12px; }

    .btn-save {
        width: 100%; background: var(--primary-color); color: white;
        padding: 14px; border-radius: 12px; border: none;
        font-weight: 700; cursor: pointer; transition: 0.3s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }

    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3); }

    @media (max-width: 992px) { .form-container { grid-template-columns: 1fr; } .form-grid { grid-template-columns: 1fr; } .full-width { grid-column: span 1; } }
</style>
@endpush

@section('content')
<div class="page-header" style="margin-bottom: 24px;">
    <div class="header-title">
        <h1 style="font-size: 24px; font-weight: 800;">Entri Transaksi Baru</h1>
        <p style="color: var(--text-secondary);">Pastikan seluruh data valid untuk kebutuhan audit keuangan.</p>
    </div>
</div>

<form action="{{ route('admin.transactions.store') }}" method="POST" id="mainForm" enctype="multipart/form-data">
    @csrf
    <div class="form-container">
        <div class="card">
            <div class="card-header"><h3><i class="fas fa-file-invoice"></i> Informasi Pembayaran</h3></div>
            <div class="card-body">
                <div class="form-grid">
                    
                    <div class="form-group full-width">
                        <label class="form-label">Email Pengguna Terdaftar</label>
                        <input type="email" name="user_search" class="form-input" 
                               placeholder="contoh@email.com" value="{{ old('user_search') }}" required>
                        @error('user_search')
                            <span class="text-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nominal (IDR)</label>
                        <input type="number" name="amount" class="form-input" placeholder="Contoh: 50000" value="{{ old('amount') }}" required min="1">
                        @error('amount')
                            <span class="text-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" id="payment_selector" class="form-input" required>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="QRIS">QRIS</option>
                            <option value="E-Wallet">E-Wallet</option>
                            <option value="Manual / Cash">Manual / Cash</option>
                            <option value="OTHER">-- Metode Lainnya --</option>
                        </select>
                        
                        <div id="custom_payment_wrapper">
                            <input type="text" id="custom_payment_input" class="form-input" placeholder="Masukkan Nama Metode Baru...">
                        </div>
                        @error('final_payment_method')
                            <span class="text-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="position: sticky; top: 20px;">
            <div class="card-header"><h3>Ringkasan</h3></div>
            <div class="card-body">
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="color: var(--text-secondary); font-size: 14px;">Status Awal:</span>
                        <span class="status-badge status-pending">Menunggu</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="color: var(--text-secondary); font-size: 14px;">Masa Aktif:</span>
                        <span style="font-weight: 700;">+30 Hari (PRO)</span>
                    </div>
                    <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 15px 0;">
                    <p style="font-size: 12px; color: var(--text-secondary); line-height: 1.5;">
                        <i class="fas fa-info-circle"></i> Transaksi akan dicatat sebagai <strong>Pending</strong>. Anda perlu melakukan verifikasi manual setelah data disimpan.
                    </p>
                </div>

                <button type="submit" class="btn-save" id="submitBtn">
                    <i class="fas fa-check-double"></i> Simpan Transaksi
                </button>
                
                <a href="{{ route('admin.transactions.index') }}" 
                   style="display: block; text-align: center; margin-top: 15px; font-size: 13px; color: var(--text-secondary); text-decoration: none;">
                    Batalkan & Kembali
                </a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    const paymentSelector = document.getElementById('payment_selector');
    const customWrapper = document.getElementById('custom_payment_wrapper');
    const customInput = document.getElementById('custom_payment_input');
    const mainForm = document.getElementById('mainForm');

    paymentSelector.addEventListener('change', function() {
        if (this.value === 'OTHER') {
            customWrapper.style.display = 'block';
            customInput.setAttribute('name', 'payment_method'); 
            paymentSelector.removeAttribute('name');
            customInput.required = true;
            customInput.focus();
        } else {
            customWrapper.style.display = 'none';
            paymentSelector.setAttribute('name', 'payment_method'); 
            customInput.removeAttribute('name');
            customInput.required = false;
        }
    });

    mainForm.addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Sedang Menyimpan...';
    });
</script>
@endpush