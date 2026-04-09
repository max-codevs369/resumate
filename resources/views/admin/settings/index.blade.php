@extends('layouts.admin')

@section('title', 'Pengaturan Aplikasi')

@push('styles')
<style>
    .form-wrapper { max-width: 800px; margin: 0 auto; width: 100%; padding: 0 16px; }

    .page-header { margin-bottom: 28px; }
    .page-header h1 { font-size: 24px; font-weight: 800; color: var(--text-main); letter-spacing: -0.5px; }
    .page-header p { color: var(--text-secondary); font-size: 14px; margin-top: 4px; }

    .form-card {
        background: var(--bg-card); border-radius: 16px;
        border: 1px solid var(--border-color); padding: 32px;
        width: 100%; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .form-section { margin-bottom: 32px; }
    .form-section-title {
        font-size: 12px; font-weight: 800; text-transform: uppercase;
        letter-spacing: 1px; color: var(--text-secondary);
        margin-bottom: 16px; padding-bottom: 10px;
        border-bottom: 2px solid var(--bg-body);
    }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { display: flex; flex-direction: column; gap: 8px; }
    .form-group.full { grid-column: 1 / -1; }

    label { font-size: 13px; font-weight: 600; color: var(--text-main); }
    
    .form-control {
        padding: 12px 16px; border-radius: 10px;
        border: 1px solid var(--border-color);
        background: var(--bg-body); color: var(--text-main);
        font-size: 14px; outline: none; transition: 0.3s; width: 100%;
    }
    .form-control:focus { border-color: var(--primary-color); background: var(--bg-card); box-shadow: 0 0 0 3px rgba(76,175,80,0.1); }

    .qris-upload-wrapper { display: flex; align-items: center; gap: 20px; }
    .qris-preview {
        width: 120px; height: 120px; border-radius: 12px; flex-shrink: 0;
        background: white; border: 2px dashed var(--border-color);
        display: flex; align-items: center; justify-content: center; overflow: hidden;
    }
    .qris-preview img { width: 100%; height: 100%; object-fit: contain; }

    .btn-upload {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: 8px; cursor: pointer;
        border: 1px solid var(--primary-color); background: rgba(76, 175, 80, 0.1);
        color: var(--primary-color); font-size: 13px; font-weight: 600; transition: 0.2s;
    }
    .btn-upload:hover { background: var(--primary-color); color: white; }

    .form-actions {
        display: flex; gap: 12px; margin-top: 10px;
        padding-top: 24px; border-top: 1px solid var(--border-color);
    }
    .btn-submit {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 28px; background: var(--primary-color); color: white;
        border: none; border-radius: 10px; font-size: 14px; font-weight: 600;
        cursor: pointer; transition: 0.2s; box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
    }
    .btn-submit:hover { background: var(--primary-hover); transform: translateY(-2px); }

    @media (max-width: 640px) {
        .page-header h1 { font-size: 20px; } 
        .form-card { padding: 20px 16px; } 
        .form-grid { grid-template-columns: 1fr; gap: 16px; }
        
        .qris-upload-wrapper { 
            flex-direction: column; 
            align-items: center; 
            text-align: center; 
        }
        .avatar-actions { align-items: center; }
        
        .form-actions { justify-content: stretch; }
        .btn-submit { width: 100%; justify-content: center; } 
    }
</style>
@endpush

@section('content')
<div class="form-wrapper">
    <div class="page-header">
        <h1>Pengaturan Aplikasi</h1>
        <p>Kelola konten dinamis untuk halaman Pricing dan Checkout user.</p>
    </div>

    @if(session('success'))
        <div style="background: rgba(76, 175, 80, 0.1); border: 1px solid rgba(76, 175, 80, 0.2); color: #2E7D32; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="form-card">
        @csrf
        @method('PUT')

        <div class="form-section">
            <div class="form-section-title">Halaman Pricing</div>
            <div class="form-grid">
                <div class="form-group full">
                    <label>Judul Utama Pricing</label>
                    <input type="text" name="pricing_title" class="form-control" 
                           value="{{ $settings['pricing_title'] ?? '' }}" placeholder="Contoh: Investasi Karir Terbaik Anda">
                </div>
                <div class="form-group">
                    <label>Harga Paket Pro(Ribuan)</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 16px; top: 12px; font-size: 14px; color: var(--text-secondary);">Rp</span>
                        <input type="number" name="pricing_amount" class="form-control" style="padding-left: 45px;" value="{{ $settings['pricing_amount'] ?? '' }}" placeholder="299">
                    </div> 
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Informasi Rekening & QRIS</div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Bank</label>
                    <input type="text" name="bank_name" class="form-control" value="{{ $settings['bank_name'] ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Nomor Rekening</label>
                    <input type="text" name="bank_acc_number" class="form-control" value="{{ $settings['bank_acc_number'] ?? '' }}">
                </div>
                <div class="form-group full">
                    <label>Nama Pemilik Rekening</label>
                    <input type="text" name="bank_acc_name" class="form-control" value="{{ $settings['bank_acc_name'] ?? '' }}">
                </div>
                
                <div class="form-group full">
                    <label>Metode QRIS</label>
                    <div class="qris-upload-wrapper">
                        <div class="qris-preview" id="qrisPreview">
                            @if(isset($settings['qris_image']))
                                <img src="{{ asset('storage/' . $settings['qris_image']) }}" alt="QRIS">
                            @else
                                <i class="fas fa-qrcode fa-3x" style="color: var(--border-color)"></i>
                            @endif
                        </div>
                        <div class="avatar-actions">
                            <input type="file" name="qris_image" id="qrisInput" hidden accept="image/*" onchange="previewQRIS(event)">
                            <button type="button" class="btn-upload" onclick="document.getElementById('qrisInput').click()">
                                <i class="fas fa-upload"></i> Unggah QRIS Baru
                            </button>
                            <p style="font-size: 12px; color: var(--text-secondary); margin-top: 8px;">Format: JPG, PNG. Rekomendasi rasio 1:1.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function previewQRIS(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('qrisPreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview QRIS">`;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush