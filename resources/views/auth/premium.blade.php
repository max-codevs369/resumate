<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Premium Aktif! - ResuMate</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; 
        }
        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
        .animate-shimmer {
            animation: shimmer 1.5s infinite;
        }
    </style>
</head>
<body class="antialiased">

    <div class="min-h-screen flex items-center justify-center p-4">
        
        <div class="max-w-md w-full bg-white rounded-[2rem] shadow-2xl p-8 text-center border border-slate-100 relative overflow-hidden">
            
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-48 bg-yellow-300 opacity-20 blur-[50px] rounded-full pointer-events-none"></div>

            <div class="relative mx-auto w-24 h-24 bg-gradient-to-tr from-yellow-100 to-yellow-50 rounded-full flex items-center justify-center mb-6 shadow-inner border border-yellow-200">
                <i class="fas fa-crown text-5xl text-yellow-500 drop-shadow-md"></i>
                <div class="absolute -bottom-2 -right-2 bg-emerald-500 text-white w-8 h-8 rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                    <i class="fas fa-check text-sm"></i>
                </div>
            </div>
            
            <h1 class="text-3xl font-extrabold text-slate-800 mb-3 tracking-tight">Selamat! 🎉</h1>
            <p class="text-slate-500 mb-8 leading-relaxed text-sm md:text-base">
                Akun Anda sekarang telah berstatus <span class="font-bold text-yellow-600">PREMIUM</span>. Pembayaran telah diverifikasi dan semua batasan telah dibuka.
            </p>
            
            <div class="bg-slate-50 rounded-2xl p-5 mb-8 text-left border border-slate-100">
                <ul class="space-y-4 text-sm text-slate-600 font-medium">
                    <li class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        Akses Semua Template Premium
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        Prediksi Skor ATS Friendly CV
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        Ekspor PDF Tanpa Watermark
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        Simpan Banyak Versi CV
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        Prioritas Support 24/7
                    </li>
                </ul>
            </div>
            
            <a href="{{ route('templates') }}" class="group relative inline-flex items-center justify-center w-full bg-slate-900 hover:bg-slate-800 text-slate-50 font-semibold py-4 px-8 rounded-xl transition-all duration-300 overflow-hidden shadow-lg hover:shadow-xl hover:-translate-y-1">
                <span class="relative z-10 flex items-center gap-2">
                    Mulai Buat CV Sekarang <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                </span>
                <div class="absolute inset-0 h-full w-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
            </a>

            <div class="mt-6">
                <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-slate-600 font-medium transition-colors">
                    Ke Home
                </a>
            </div>
        </div>

    </div>

</body>
</html>