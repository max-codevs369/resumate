@extends('layouts.app')

@section('title', 'Paket Harga')

@push('styles')
<style>
    body { overflow-x: hidden; }

    .pricing-header {
        background: var(--bg-body);
        padding: 100px 20px 60px;
        text-align: center;
    }
    .pricing-header h1 {
        font-size: 42px; font-weight: 800; color: var(--text-main); margin-bottom: 20px; letter-spacing: -1px;
    }
    .pricing-header h1 span {
        background: linear-gradient(135deg, var(--primary-color), #2E7D32);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .pricing-header p {
        font-size: 18px; color: var(--text-secondary); margin: 0 auto; max-width: 600px; line-height: 1.6;
    }

    .pricing-section {
        padding: 20px 20px 100px;
        background: var(--bg-body);
        display: flex;
        justify-content: center;
    }

    .pricing-container { width: 100%; max-width: 450px; }

    .pricing-card.popular {
        background: var(--bg-card);
        border-radius: 24px;
        padding: 40px 30px;
        border: 2px solid var(--primary-color);
        box-shadow: 0 10px 30px rgba(76, 175, 80, 0.1);
        text-align: center;
        position: relative;
    }

    .popular-badge {
        position: absolute; top: -15px; left: 50%; transform: translateX(-50%);
        background: var(--primary-color); color: white; padding: 6px 16px;
        border-radius: 20px; font-size: 12px; font-weight: 700; letter-spacing: 0.5px;
    }

    .card-header { margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid var(--border-color); }
    .plan-title { font-size: 18px; font-weight: 600; color: var(--text-secondary); margin-bottom: 15px; text-transform: uppercase; }
    
    .plan-price { display: flex; justify-content: center; align-items: baseline; color: var(--text-main); }
    .currency { font-size: 24px; font-weight: 600; top: -15px; position: relative; }
    .amount { font-size: 56px; font-weight: 800; line-height: 1; }
    .unit { font-size: 16px; color: var(--text-secondary); margin-left: 5px; font-weight: 500; }

    .card-features { list-style: none; padding: 0; margin: 0 0 30px 0; text-align: left; }
    .card-features li { margin-bottom: 16px; display: flex; align-items: center; gap: 12px; color: var(--text-main); font-size: 15px; }
    .card-features i { color: var(--primary-color); font-size: 18px; flex-shrink: 0; }

    .btn-filled {
        display: block; width: 100%; padding: 16px; border-radius: 12px;
        font-weight: 700; text-align: center; text-decoration: none; transition: all 0.3s; font-size: 16px;
        background: var(--primary-color); color: white; border: none;
    }
    .btn-filled:hover {
        background: var(--primary-hover);
        transform: translateY(-2px); box-shadow: 0 8px 20px rgba(76, 175, 80, 0.25);
    }

    .faq-section { padding: 80px 20px; background: var(--bg-card); border-top: 1px solid var(--border-color); }
    .faq-header { text-align: center; margin-bottom: 50px; }
    .faq-header h2 { font-size: 32px; font-weight: 700; color: var(--text-main); margin-bottom: 10px; }
    .faq-header p { color: var(--text-secondary); }
    .faq-wrapper { max-width: 800px; margin: 0 auto; }
    
    .accordion-item { border-bottom: 1px solid var(--border-color); margin-bottom: 15px; }
    .accordion-button {
        width: 100%; padding: 24px 0; background: none; border: none; outline: none;
        display: flex; justify-content: space-between; align-items: center; cursor: pointer; text-align: left;
        color: var(--text-main); font-size: 18px; font-weight: 600; transition: color 0.3s;
    }
    .accordion-button:hover { color: var(--primary-color); }
    .icon-plus { font-size: 20px; color: var(--primary-color); transition: transform 0.3s ease; }
    .accordion-body { max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; }
    .accordion-body p { padding-bottom: 24px; color: var(--text-secondary); line-height: 1.6; font-size: 16px; margin: 0; }
    .accordion-item.active .accordion-body { max-height: 200px; }
    .accordion-item.active .icon-plus { transform: rotate(45deg); }
</style>
@endpush

@section('content')
<div class="container" style="max-width: 800px; margin: 0 auto; padding-top: 20px;">
    @if(session('success'))
        <div style="background: #dcfce7; color: #16a34a; padding: 16px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; text-align: center; border: 1px solid #bbf7d0; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.08);">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif
</div>

<header class="pricing-header">
    <h1>{!! $settings['pricing_title'] ?? 'Investasi Karir <span>Terbaik Anda</span>' !!}</h1>
    <p>{{ $settings['pricing_subtitle'] ?? 'Akses fitur unggulan kami untuk mulai membuat CV profesional.' }}</p>
</header>

<section class="pricing-section">
    <div class="pricing-container">
        <div class="pricing-card popular">
            <div class="popular-badge">PAKET PRO</div>
            <div class="card-header">
                <div class="plan-title">Akses Penuh 1 Bulan</div>
                <div class="plan-price">
                    <span class="currency">Rp</span>
                    <span class="amount">{{ $settings['pricing_amount'] ?? '299' }}</span>
                    <span class="currency" style="font-size: 20px; top: -5px;">rb</span>
                </div>
            </div>
            <ul class="card-features">
                <li><i class="fas fa-check-circle"></i> Akses Semua Template Premium</li>
                <li><i class="fas fa-check-circle"></i> Ekspor PDF Tanpa Watermark</li>
                <li><i class="fas fa-check-circle"></i> Simpan Banyak Versi CV</li>
                <li><i class="fas fa-check-circle"></i> Prioritas Support 24/7</li>
            </ul>
            
            @if($transaction && $transaction->status === 'pending')
                <a href="#" class="btn-filled" style="cursor: default; opacity: 0.8;">
                    <i class="fas fa-clock"></i> Sedang menunggu verifikasi Admin
                </a>
            @else
                <a href="{{ auth()->check() ? route('user.checkout') : route('login') }}" class="btn-filled">
                    {{ auth()->check() ? 'Pilih Paket Pro' : 'Login untuk Berlangganan' }}
                </a>
            @endif

        </div>
    </div>
</section>

<section class="faq-section">
    <div class="faq-wrapper">
        <div class="faq-header">
            <h2>Pertanyaan Umum</h2>
            <p>Jawaban untuk hal-hal yang mungkin Anda bingungkan.</p>
        </div>
        
        <div class="accordion-item">
            <button class="accordion-button">
                Metode pembayaran apa saja yang tersedia?
                <i class="fas fa-plus icon-plus"></i>
            </button>
            <div class="accordion-body">
                <p>Kami menerima pembayaran melalui Transfer Bank dan E-Wallet. Anda dapat melihat instruksi lengkap pada halaman pembayaran setelah memilih paket.</p>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-button">
                Apakah saya bisa membatalkan langganan?
                <i class="fas fa-plus icon-plus"></i>
            </button>
            <div class="accordion-body">
                <p>Tentu saja. Anda tidak terikat kontrak panjang. Anda dapat berhenti berlangganan kapan saja dan akun Anda akan kembali ke versi gratis setelah masa aktif Pro Anda habis.</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    const accButtons = document.querySelectorAll('.accordion-button');
    accButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.parentElement;
            document.querySelectorAll('.accordion-item').forEach(i => {
                if(i !== item) i.classList.remove('active');
            });
            item.classList.toggle('active');
        });
    });
</script>
@endpush