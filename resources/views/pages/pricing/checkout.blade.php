@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran')

@push('styles')
<style>
    .checkout-section {
        padding: 60px 0 100px;
        background: var(--bg-body);
        min-height: calc(100vh - 80px);
    }

    .checkout-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 40px;
        align-items: start;
    }

    .summary-card {
        background: var(--bg-card);
        padding: 30px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 30px var(--shadow-sm);
        position: sticky;
        top: 100px;
    }

    .summary-card h3 {
        font-size: 20px; font-weight: 700; color: var(--text-main);
        margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);
    }

    .summary-item {
        display: flex; justify-content: space-between;
        margin-bottom: 15px; font-size: 15px; color: var(--text-secondary);
    }

    .summary-item span:last-child { font-weight: 600; color: var(--text-main); }

    .total-pay {
        margin-top: 25px; padding: 20px; background: rgba(76, 175, 80, 0.05);
        border-radius: 12px; display: flex; justify-content: space-between;
        align-items: center; border: 1px dashed var(--primary-color);
    }

    .total-label { font-size: 14px; color: var(--text-secondary); }
    .total-amount { font-size: 24px; font-weight: 800; color: var(--primary-color); }

    .info-note {
        margin-top: 20px; font-size: 13px; color: var(--text-secondary);
        line-height: 1.5; display: flex; gap: 8px; padding: 10px;
        background: var(--bg-body); border-radius: 8px;
    }

    .payment-methods {
        background: var(--bg-card); padding: 40px; border-radius: 24px;
        border: 1px solid var(--border-color); box-shadow: 0 4px 20px var(--shadow-sm);
    }

    .step-header {
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 20px; font-weight: 700; color: var(--text-main); font-size: 18px;
    }

    .step-num {
        background: var(--primary-color); color: white; width: 28px; height: 28px;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 700; flex-shrink: 0;
    }

    .method-tabs { display: flex; gap: 15px; margin-bottom: 30px; }

    .tab-btn {
        flex: 1; padding: 15px; border: 1px solid var(--border-color); border-radius: 12px;
        background: var(--bg-body); cursor: pointer; font-weight: 600; font-size: 14px;
        color: var(--text-secondary); transition: all 0.3s; display: flex;
        align-items: center; justify-content: center; gap: 8px;
    }

    .tab-btn:hover { border-color: var(--primary-color); color: var(--primary-color); }
    .tab-btn.active {
        border-color: var(--primary-color); background: rgba(76, 175, 80, 0.05);
        color: var(--primary-color); box-shadow: 0 4px 12px rgba(76, 175, 80, 0.1);
    }

    .method-content { animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .qris-container {
        text-align: center; padding: 30px; border: 1px solid var(--border-color);
        border-radius: 16px; background: var(--bg-body); display: flex; flex-direction: column; align-items: center;
    }
    .qris-image {
        width: 200px; height: 200px; margin: 0 auto 15px; background: white;
        padding: 10px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .qris-image img { width: 100%; height: 100%; object-fit: contain; }
    .qris-logos {
        display: flex; justify-content: center; gap: 15px; margin-top: 15px;
        opacity: 0.7; font-size: 12px; font-weight: 600; color: var(--text-secondary);
    }

    .bank-info {
        background: rgba(76, 175, 80, 0.05); padding: 25px; border-radius: 16px;
        border: 1px solid var(--border-color); text-align: center;
    }
    .bank-name { font-size: 14px; color: var(--text-secondary); margin-bottom: 5px; }
    .account-number {
        font-family: 'Courier New', monospace; font-size: 28px; font-weight: 800;
        letter-spacing: 2px; display: block; margin: 10px 0; color: var(--text-main);
    }
    .account-name { font-size: 14px; font-weight: 600; color: var(--text-main); }

    .upload-section { margin-top: 40px; padding-top: 40px; border-top: 1px dashed var(--border-color); }
    .upload-zone {
        border: 2px dashed var(--border-color); padding: 30px; border-radius: 16px;
        text-align: center; cursor: pointer; margin: 20px 0; transition: all 0.3s;
        background: var(--bg-body);
    }
    .upload-zone:hover { border-color: var(--primary-color); background: rgba(76, 175, 80, 0.05); }
    .upload-icon { font-size: 32px; color: var(--primary-color); margin-bottom: 10px; }
    .upload-text { font-size: 14px; color: var(--text-secondary); }

    .btn-submit {
        display: flex; align-items: center; justify-content: center; gap: 12px;
        background: var(--primary-color); color: white; padding: 18px; border: none;
        border-radius: 12px; font-weight: 700; font-size: 16px; width: 100%;
        margin-top: 20px; transition: all 0.3s; cursor: pointer;
    }
    .btn-submit:hover {
        background: var(--primary-hover); transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
    }

    .text-error { color: #dc2626; font-size: 12px; margin-top: 6px; display: block; text-align: center; }

    @media (max-width: 992px) {
        .checkout-container { 
            grid-template-columns: 1fr; 
            max-width: 650px; 
            gap: 24px; 
        }
        .summary-card { 
            position: relative; 
            top: 0; 
            order: -1; 
        }
    }

    @media (max-width: 768px) {
        .checkout-section { 
            padding: 30px 0 80px; 
        }
        
        .checkout-container {
            padding: 0 16px;
        }

        .summary-card { 
            padding: 20px; 
        }
        .payment-methods { 
            padding: 24px 20px; 
            border-radius: 20px;
        }

        .method-tabs { 
            flex-direction: column; 
            gap: 10px; 
            margin-bottom: 24px;
        }
        .tab-btn { 
            padding: 12px; 
        }

        .account-number { 
            font-size: 22px; 
            letter-spacing: 1px;
        }
        .total-amount { 
            font-size: 20px; 
        }
        .step-header {
            font-size: 16px;
        }

        .qris-image { 
            width: 160px; 
            height: 160px; 
        }
        .qris-logos { 
            font-size: 11px; 
            flex-wrap: wrap; 
            gap: 10px;
        }

        .upload-section { 
            margin-top: 30px; 
            padding-top: 30px; 
        }
        .upload-zone { 
            padding: 20px 15px; 
        }
        .upload-icon {
            font-size: 28px;
        }
        
        .btn-submit {
            padding: 16px;
            font-size: 15px;
        }
    }

    .btn-download-qr {
        display: inline-flex; align-items: center; gap: 8px;
        margin: 10px 0; padding: 8px 16px;
        background: rgba(16, 185, 129, 0.1); color: var(--primary-color);
        border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 700;
        transition: all 0.3s;
    }
    .btn-download-qr:hover { background: var(--primary-color); color: white; }
</style>
@endpush

@section('content')
<div class="checkout-section">
    <form action="{{ route('user.checkout.process') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
        @csrf
        <div class="checkout-container">
            @if(session('success'))
                <div style="grid-column: 1 / -1; background: #dcfce7; color: #16a34a; padding: 20px; border-radius: 16px; margin-bottom: 10px; font-weight: 600; text-align: center; border: 1px solid #bbf7d0; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.08);">
                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
                </div>
            @endif

            <div class="summary-side">
                <div class="summary-card">
                    <h3>Ringkasan Pesanan</h3>
                    <div class="summary-item">
                        <span>Paket</span>
                        <span>Pro Member (1 Bulan)</span>
                    </div>
                    
                    <div class="total-pay">
                        <span class="total-label">Total Bayar</span>
                        <span class="total-amount">Rp {{ number_format($settings['pricing_amount'] ?? 299, 0, ',', '.') }}.000</span>
                    </div>
                    
                    <div class="info-note">
                        <i class="fas fa-info-circle" style="color: var(--primary-color); margin-top: 2px;"></i>
                        <span>Pastikan nominal yang ditransfer sesuai dengan total bayar untuk mempercepat proses verifikasi admin.</span>
                    </div>
                </div>
            </div>

            <div class="payment-side">
                <div class="payment-methods">
                    <div class="step-header">
                        <span class="step-num">1</span> Pilih Metode Pembayaran
                    </div>
                    
                    <div class="method-tabs">
                        <button type="button" class="tab-btn active" onclick="switchMethod('Transfer Bank', event, 'bank')">
                            <i class="fas fa-university"></i> Bank Transfer
                        </button>
                        <button type="button" class="tab-btn" onclick="switchMethod('QRIS', event, 'qris')">
                            <i class="fas fa-qrcode"></i> QRIS (E-Wallet)
                        </button>
                    </div>

                    <input type="hidden" name="payment_method" id="payment_method_input" value="Transfer Bank">

                    <div id="method-bank" class="method-content">
                        <div class="bank-info">
                            <div class="bank-name">{{ $settings['bank_name'] ?? 'Bank Central Asia (BCA)' }}</div>
                            <strong class="account-number">{{ $settings['bank_acc_number'] ?? '8291 002 391' }}</strong>
                            <div class="account-name">a/n {{ $settings['bank_acc_name'] ?? 'PT CV Kreatif Indonesia' }}</div>
                        </div>
                    </div>

                    <div id="method-qris" class="method-content" style="display: none;">
                        <div class="qris-container">
                            <div class="qris-image">
                                @if(isset($settings['qris_image']))
                                    <img src="{{ asset('storage/' . $settings['qris_image']) }}" alt="Scan QRIS">
                                @else
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="Sample QRIS">
                                @endif
                            </div>
                            <p style="font-size: 14px; font-weight: 600; color: var(--text-main);">Scan QRIS untuk Membayar</p>
                            <a href="{{ isset($settings['qris_image']) ? asset('storage/' . $settings['qris_image']) : 'https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg' }}" download="QRIS_Pembayaran" class="btn-download-qr">
                                <i class="fas fa-download"></i> Unduh Kode QR
                            </a>
                            <div class="qris-logos">
                                <span>GOPAY</span> • <span>OVO</span> • <span>DANA</span> • <span>SHOPEEPAY</span>
                            </div>
                        </div>
                    </div>

                    <div class="upload-section">
                        <div class="step-header">
                            <span class="step-num">2</span> Upload Bukti Pembayaran
                        </div>
                        
                        <div class="upload-zone" onclick="document.getElementById('fileInput').click()">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <p class="upload-text" id="uploadText">Klik di sini untuk upload screenshot bukti transfer</p>
                            <input type="file" id="fileInput" name="proof_of_payment" hidden accept="image/*" required>
                        </div>

                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="fas fa-paper-plane"></i> Kirim Bukti Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function switchMethod(methodName, event, sectionId) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');

        document.getElementById('method-bank').style.display = 'none';
        document.getElementById('method-qris').style.display = 'none';

        document.getElementById('method-' + sectionId).style.display = 'block';
        
        document.getElementById('payment_method_input').value = methodName;
    }

    const fileInput = document.getElementById('fileInput');
    const uploadText = document.getElementById('uploadText');

    fileInput.addEventListener('change', function() {
        if(this.files && this.files[0]) {
            uploadText.innerHTML = `<span style="color: var(--primary-color); font-weight: 700;">File terpilih: ${this.files[0].name}</span>`;
        }
    });

    document.getElementById('checkoutForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    });
</script>
@endpush