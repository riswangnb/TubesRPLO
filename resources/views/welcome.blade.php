<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshClean - The Laundry Revolution</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#00C2FF', dark: '#0055FF', accent: '#C1FF00' },
                        surface: '#F8FAFC'
                    },
                    animation: {
                        'wave': 'wave 10s linear infinite',
                        'wave-slow': 'wave 15s linear infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        wave: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-50%)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* --- Wave Animation Setup --- */
        .ocean {
            height: 120px;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            overflow-x: hidden;
            z-index: 2;
            pointer-events: none;
        }
        .wave {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1600 198'%3E%3Cpath fill='%23F8FAFC' d='M1600 98l-70 12c-70 12-210 36-350 30-140-6-280-42-420-42-140 0-280 36-420 48-140 12-210-12-245-24L0 98l0 100 95 0c95 0 285 0 475 0 190 0 380 0 570 0 190 0 285 0 380 0 95 0 0 0 0 0z'/%3E%3C/svg%3E");
            position: absolute;
            width: 200%;
            height: 100%;
            animation: wave 10s cubic-bezier( 0.36, 0.45, 0.63, 0.53) infinite;
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
        .wave:nth-of-type(2) {
            top: -20px;
            animation: wave 12s cubic-bezier( 0.36, 0.45, 0.63, 0.53) -.125s infinite, swell 7s ease -1.25s infinite;
            opacity: 0.5;
        }
        @keyframes wave {
            0% { margin-left: 0; }
            100% { margin-left: -1600px; }
        }
        @keyframes swell {
            0%, 100% { transform: translate3d(0,-25px,0); }
            50% { transform: translate3d(0,5px,0); }
        }

        /* --- New Premium Hover Effects --- */
        
        /* 1. Base Card Transition (Bouncy) */
        .bento-card {
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .bento-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px -10px rgba(0, 194, 255, 0.15), 0 0 20px rgba(0, 194, 255, 0.1) inset;
            border-color: rgba(0, 194, 255, 0.3);
        }

        /* 2. Shine Effect (Kilau Kaca) */
        .hover-shine {
            position: relative;
            overflow: hidden;
        }
        .hover-shine::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            transition: none;
            pointer-events: none;
            z-index: 20;
        }
        .hover-shine:hover::after {
            animation: shine 0.75s cubic-bezier(0.4, 0.0, 0.2, 1);
        }

        @keyframes shine {
            100% { left: 150%; }
        }
        
        /* --- Custom Cursor --- */
        .cursor-bubble {
            width: 30px; height: 30px;
            border: 2px solid rgba(0, 194, 255, 0.8);
            border-radius: 50%;
            position: fixed; pointer-events: none; z-index: 9999;
            transform: translate(-50%, -50%);
            transition: transform 0.1s, width 0.3s, height 0.3s;
            background: rgba(255,255,255,0.1); backdrop-filter: blur(2px);
        }
        body.hovering .cursor-bubble {
            width: 60px; height: 60px;
            background: rgba(0, 194, 255, 0.2);
            border-color: #00C2FF;
        }
    </style>
</head>
<body class="bg-surface text-slate-800 selection:bg-brand selection:text-white cursor-none overflow-x-hidden">

    <div class="cursor-bubble hidden md:block"></div>

    <header class="fixed w-full top-0 z-50 py-4 transition-all duration-300">
        <nav class="container mx-auto px-6 max-w-6xl">
            <div class="bg-white/80 backdrop-blur-xl border border-white/60 rounded-full px-6 py-3 flex justify-between items-center shadow-lg shadow-brand/10">
                <div class="flex items-center gap-2 hover-trigger">
                    <div class="w-9 h-9 bg-brand-dark text-white rounded-full flex items-center justify-center font-bold text-lg">F</div>
                    <span class="font-bold text-lg tracking-tight">FreshClean.</span>
                </div>
                
                <div class="hidden md:flex gap-8 text-sm font-semibold text-slate-600">
                    <a href="#home" class="hover:text-brand-dark transition hover-trigger">Home</a>
                    <a href="#services" class="hover:text-brand-dark transition hover-trigger">Layanan</a>
                    <a href="#features" class="hover:text-brand-dark transition hover-trigger">Kenapa Kami</a>
                </div>

                <a href="#contact" class="hidden md:block bg-brand text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg shadow-brand/30 hover:scale-105 transition hover-trigger">
                    Pesan WA
                </a>
                <button class="md:hidden text-xl hover-trigger"><i class="fa-solid fa-bars"></i></button>
            </div>
        </nav>
    </header>

    <section id="home" class="relative min-h-screen flex items-center bg-gradient-to-br from-brand to-brand-dark overflow-hidden pt-32 pb-32">
        
        <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-float pointer-events-none"></div>
        <div class="absolute bottom-40 right-20 w-96 h-96 bg-brand-accent/20 rounded-full blur-3xl animate-float delay-1000 pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10 grid lg:grid-cols-2 gap-16 items-center">
            <div data-aos="fade-right" data-aos-duration="1000">
                <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-md rounded-full border border-white/30 text-white text-xs font-bold tracking-widest mb-6 animate-pulse">
                    🚀 LAUNDRY MASA DEPAN
                </div>
                <h1 class="text-5xl lg:text-7xl font-black text-white leading-[1.1] mb-6 tracking-tight">
                    BERSIH <br>
                    <span class="text-brand-accent">TANPA</span> <br>
                    BATAS.
                </h1>
                <p class="text-white/90 text-lg max-w-md mb-10 leading-relaxed font-light">
                    Revolusi laundry dengan teknologi 1 mesin 1 pelanggan. Lebih bersih, lebih cepat, dan wangi tahan lama.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button onclick="scrollToServices()" class="bg-white text-brand-dark px-8 py-4 rounded-full font-bold text-lg hover:shadow-2xl hover:scale-105 transition hover-trigger">
                        Mulai Sekarang
                    </button>
                    <button class="group flex items-center gap-4 px-6 py-4 rounded-full border border-white/30 text-white hover:bg-white/10 transition hover-trigger">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center group-hover:scale-110 transition"><i class="fa-solid fa-play"></i></div>
                        <span class="font-bold">Lihat Proses</span>
                    </button>
                </div>
            </div>

            <div class="relative h-[500px] hidden lg:block" data-aos="fade-left" data-aos-duration="1200">
                <div class="absolute top-10 left-10 w-72 h-96 rounded-[2rem] overflow-hidden border-4 border-white/20 shadow-xl -rotate-6 z-10 transition duration-500 hover:z-30 hover:rotate-0 hover-trigger bg-white">
                    <img src="{{ asset('build/assets/img/10342764.jpg') }}" class="w-full h-full object-cover opacity-90">
                </div>
                <div class="absolute top-0 left-32 w-72 h-96 rounded-[2rem] overflow-hidden border-4 border-white/30 shadow-2xl rotate-6 z-20 transition duration-500 hover:z-30 hover:rotate-0 hover:scale-105 hover-trigger bg-white">
                    <img src="{{ asset('build/assets/img/10392492.jpg') }}" class="w-full h-full object-cover">
                </div>
                <div class="absolute bottom-20 right-10 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-xl z-30 animate-float border border-white">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xl"><i class="fa-solid fa-circle-check"></i></div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Status Order</p>
                            <p class="text-base font-black text-slate-900">Selesai 100%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ocean">
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
    </section>

    <div class="bg-brand-accent overflow-hidden py-5 border-b-4 border-brand-dark relative z-10 shadow-sm">
        <div class="whitespace-nowrap animate-[wave_25s_linear_infinite] font-black text-xl text-slate-900 uppercase tracking-widest flex items-center">
            <span class="mx-4">⚡ Laundry Kilat</span> • <span class="mx-4">🛡️ Bersih Higienis</span> • <span class="mx-4">✨ Wangi Premium</span> • <span class="mx-4">💨 Setrika Uap</span> • <span class="mx-4">🚚 Antar Jemput</span> • <span class="mx-4">⚡ Laundry Kilat</span> • <span class="mx-4">🛡️ Bersih Higienis</span> • 
        </div>
    </div>

    <section id="services" class="py-24 px-6 bg-surface relative z-10">
        <div class="container mx-auto max-w-6xl">
            <div class="mb-16 text-center md:text-left" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-4">PAKET <span class="text-brand">ANDALAN.</span></h2>
                <p class="text-slate-500 text-xl max-w-xl">Solusi cerdas untuk pakaian bersih Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 md:grid-rows-2 gap-8">
                
                <div class="md:row-span-2 bento-card hover-shine bg-gradient-to-b from-slate-900 to-brand-dark rounded-[2.5rem] p-8 text-white flex flex-col justify-between overflow-hidden relative group cursor-pointer" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-brand/30 rounded-full blur-[80px] group-hover:blur-[60px] group-hover:scale-125 transition duration-700 ease-in-out"></div>
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-brand-accent border border-white/10 transition-all duration-500 group-hover:bg-brand-accent group-hover:text-slate-900 group-hover:rotate-12 group-hover:scale-110">
                                <i class="fa-solid fa-bolt text-2xl"></i>
                            </div>
                            <span class="bg-brand-accent text-slate-900 px-3 py-1 rounded-full text-xs font-extrabold tracking-wider animate-pulse">POPULER</span>
                        </div>
                        <h3 class="text-3xl font-bold mb-3 group-hover:text-brand-accent transition-colors duration-300">Express Kilat</h3>
                        <p class="text-white/70 leading-relaxed group-hover:text-white transition-colors duration-300">Butuh cepat? Selesai dalam 5 jam. Prioritas mesin & deterjen premium.</p>
                    </div>
                    <div class="space-y-6 relative z-10">
                        <div class="flex items-end gap-2">
                            <span class="text-6xl font-black text-brand-accent group-hover:scale-110 origin-left transition-transform duration-500">10k</span><span class="text-white/70 mb-2 text-lg">/kg</span>
                        </div>
                        <button class="w-full bg-brand-accent text-slate-900 py-4 rounded-xl font-bold transition-all duration-300 shadow-lg group-hover:bg-white group-hover:translate-y-[-2px] group-hover:shadow-brand-accent/50 flex items-center justify-center gap-2">
                            <span>Pesan Sekarang</span>
                            <i class="fa-solid fa-arrow-right opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
                        </button>
                    </div>
                </div>

                <div class="md:col-span-2 bento-card hover-shine bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-md flex flex-col md:flex-row items-center gap-10 relative overflow-hidden group cursor-pointer" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-brand-accent/20 rounded-full blur-3xl opacity-50 pointer-events-none group-hover:scale-150 transition duration-700"></div>
                    
                    <div class="flex-1 relative z-10">
                        <div class="flex items-center gap-4 mb-4">
                             <div class="w-12 h-12 rounded-xl bg-brand-dark/10 flex items-center justify-center text-brand-dark transition-all duration-500 group-hover:scale-110 group-hover:bg-brand-dark group-hover:text-white">
                                <i class="fa-solid fa-shirt text-xl group-hover:animate-bounce"></i>
                             </div>
                             <h3 class="text-2xl font-bold text-slate-900 group-hover:text-brand-dark transition-colors">Cuci Komplit</h3>
                        </div>
                        <p class="text-slate-500 mb-6 leading-relaxed">Cuci bersih + Setrika Uap + Parfum Premium. Pilihan cerdas untuk pakaian sehari-hari.</p>
                        <div class="flex flex-wrap gap-4 text-sm font-bold text-slate-700">
                            <span class="flex items-center gap-2 bg-slate-100 px-3 py-1.5 rounded-lg border border-transparent group-hover:border-brand-accent/50 transition-colors"><i class="fa-solid fa-circle-check text-brand"></i> 3 Hari</span>
                            <span class="flex items-center gap-2 bg-slate-100 px-3 py-1.5 rounded-lg border border-transparent group-hover:border-brand-accent/50 transition-colors"><i class="fa-solid fa-circle-check text-brand"></i> Free Plastik</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 p-6 rounded-[2rem] min-w-[180px] text-center border border-slate-100 relative z-10 transition-all duration-500 group-hover:scale-110 group-hover:rotate-3 group-hover:bg-brand-dark group-hover:text-white group-hover:shadow-xl">
                        <span class="block text-slate-400 text-xs font-bold uppercase mb-2 tracking-wider group-hover:text-white/60">Harga Terbaik</span>
                        <span class="block text-5xl font-black text-brand-dark group-hover:text-brand-accent">6k</span>
                        <span class="block text-slate-500 font-medium group-hover:text-white/80">per kg</span>
                    </div>
                </div>

                <div class="bento-card hover-shine bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-md group cursor-pointer relative overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <i class="fa-solid fa-shoe-prints absolute -bottom-4 -left-4 text-9xl text-slate-50 opacity-0 group-hover:opacity-100 group-hover:rotate-[-20deg] transition-all duration-700 z-0"></i>
                    
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 mb-6 transition-all duration-500 group-hover:bg-orange-500 group-hover:text-white group-hover:translate-x-2">
                            <i class="fa-solid fa-shoe-prints text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Cuci Sepatu</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">Deep cleaning untuk semua bahan sepatu kesayangan Anda.</p>
                        <div class="flex justify-between items-center mt-auto">
                            <span class="font-bold text-slate-900 text-2xl group-hover:text-orange-500 transition-colors">25k <span class="text-sm font-normal text-slate-400">/psg</span></span>
                            <button class="w-10 h-10 rounded-full bg-slate-900 flex items-center justify-center text-white transition-all duration-300 group-hover:bg-orange-500 group-hover:scale-125 group-hover:rotate-[-45deg]">
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bento-card bg-brand-dark text-white rounded-[2.5rem] p-8 shadow-lg shadow-brand-dark/20 relative overflow-hidden group cursor-pointer" data-aos="fade-up" data-aos-delay="400">
                    <i class="fa-solid fa-layer-group text-9xl absolute -right-10 -bottom-10 opacity-10 rotate-12 transition-transform duration-700 group-hover:rotate-0 group-hover:scale-125 group-hover:opacity-20"></i>
                    
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2 group-hover:translate-x-2 transition-transform duration-300">Satuan & Lainnya</h3>
                            <p class="text-white/80 text-sm leading-relaxed">Bedcover, Jas, Boneka, Karpet, Gorden, dll.</p>
                        </div>
                        <button class="mt-6 text-sm font-bold bg-white/20 py-3 px-6 rounded-xl transition-all duration-300 w-fit group-hover:bg-white group-hover:text-brand-dark group-hover:px-8">
                            Cek Daftar Harga
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="features" class="py-24 relative overflow-hidden bg-surface z-10">
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-300 to-transparent"></div>
        
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="text-center mb-20" data-aos="fade-up">
                <span class="text-brand-dark font-bold tracking-widest text-sm uppercase mb-2 block">Quality First</span>
                <h2 class="text-4xl font-black text-slate-900">Standar Kualitas Kami</h2>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                
                <div class="group relative bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-brand/50 shadow-sm hover:shadow-2xl hover:shadow-brand/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden hover-trigger" data-aos="fade-up" data-aos-delay="0">
                    <i class="fa-solid fa-fingerprint absolute -right-8 -bottom-8 text-9xl text-slate-50 opacity-0 group-hover:opacity-100 group-hover:rotate-12 transition-all duration-700 z-0"></i>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500 mb-6 group-hover:scale-110 group-hover:bg-blue-500 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-blue-500/30">
                            <i class="fa-solid fa-fingerprint text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-slate-900 group-hover:text-blue-600 transition-colors">Privasi Terjaga</h4>
                        <p class="text-sm text-slate-500 leading-relaxed group-hover:text-slate-600">
                            Sistem <span class="font-semibold text-slate-700">1 Mesin 1 Pelanggan</span>. Pakaian Anda diproses eksklusif, tidak dicampur dengan milik orang lain.
                        </p>
                    </div>
                </div>

                <div class="group relative bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-brand/50 shadow-sm hover:shadow-2xl hover:shadow-brand/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden hover-trigger" data-aos="fade-up" data-aos-delay="100">
                    <i class="fa-solid fa-wind absolute -right-8 -bottom-8 text-9xl text-slate-50 opacity-0 group-hover:opacity-100 group-hover:rotate-12 transition-all duration-700 z-0"></i>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-cyan-50 flex items-center justify-center text-cyan-500 mb-6 group-hover:scale-110 group-hover:bg-cyan-500 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-cyan-500/30">
                            <i class="fa-solid fa-wind text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-slate-900 group-hover:text-cyan-600 transition-colors">Setrika Uap</h4>
                        <p class="text-sm text-slate-500 leading-relaxed group-hover:text-slate-600">
                            Menggunakan teknologi <span class="font-semibold text-slate-700">Boiler High Pressure</span>. Pakaian licin sempurna, serat kain terjaga, bebas tanda gosong.
                        </p>
                    </div>
                </div>

                <div class="group relative bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-brand/50 shadow-sm hover:shadow-2xl hover:shadow-brand/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden hover-trigger" data-aos="fade-up" data-aos-delay="200">
                    <i class="fa-solid fa-flask absolute -right-8 -bottom-8 text-9xl text-slate-50 opacity-0 group-hover:opacity-100 group-hover:rotate-12 transition-all duration-700 z-0"></i>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-500 mb-6 group-hover:scale-110 group-hover:bg-purple-500 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-purple-500/30">
                            <i class="fa-solid fa-flask text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-slate-900 group-hover:text-purple-600 transition-colors">Deterjen Premium</h4>
                        <p class="text-sm text-slate-500 leading-relaxed group-hover:text-slate-600">
                            Formula ramah lingkungan dengan <span class="font-semibold text-slate-700">Oxy-Booster</span>. Efektif angkat noda membandel sekaligus mencerahkan warna.
                        </p>
                    </div>
                </div>

                <div class="group relative bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-brand/50 shadow-sm hover:shadow-2xl hover:shadow-brand/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden hover-trigger" data-aos="fade-up" data-aos-delay="300">
                    <i class="fa-solid fa-shield-halved absolute -right-8 -bottom-8 text-9xl text-slate-50 opacity-0 group-hover:opacity-100 group-hover:rotate-12 transition-all duration-700 z-0"></i>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-brand-accent/20 flex items-center justify-center text-brand-dark mb-6 group-hover:scale-110 group-hover:bg-brand-accent group-hover:text-slate-900 transition-all duration-500 shadow-sm group-hover:shadow-brand-accent/50">
                            <i class="fa-solid fa-shield-halved text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-slate-900 group-hover:text-brand-dark transition-colors">Garansi 100%</h4>
                        <p class="text-sm text-slate-500 leading-relaxed group-hover:text-slate-600">
                            Komitmen kepuasan pelanggan. Jika kurang bersih atau kurang rapi, kami <span class="font-semibold text-slate-700">Cuci Ulang Gratis</span> tanpa syarat.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer id="contact" class="bg-slate-900 text-white pt-24 pb-12 rounded-t-[3rem] relative overflow-hidden z-20 -mt-10">
        
        <div class="container mx-auto px-6 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-black mb-8 tracking-tight">WAKTUNYA SANTAI.</h2>
            <p class="text-slate-400 mb-12 max-w-xl mx-auto text-lg">Biarkan kami yang menangani tumpukan pakaian kotor Anda.</p>
            
            <div class="flex justify-center gap-4 mb-16">
                <a href="#" class="group flex items-center gap-3 bg-brand-accent text-slate-900 px-8 py-4 rounded-full font-bold text-lg hover:scale-105 transition hover-trigger shadow-lg shadow-brand-accent/20">
                    <i class="fa-brands fa-whatsapp text-2xl"></i>
                    Chat WhatsApp
                </a>
                 <a href="#" class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center text-2xl hover:bg-white hover:text-slate-900 transition hover-trigger border border-white/20"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center text-2xl hover:bg-white hover:text-slate-900 transition hover-trigger border border-white/20"><i class="fa-solid fa-map-location-dot"></i></a>
            </div>

            <div class="border-t border-white/10 pt-8">
                <p class="text-slate-500 text-sm font-medium">© 2024 FreshClean Laundry. Dibuat dengan ❤️ untuk kebersihan.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 800, offset: 100 });

        // Custom Cursor Logic
        const cursor = document.querySelector('.cursor-bubble');
        const triggers = document.querySelectorAll('.hover-trigger');

        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        });

        triggers.forEach(el => {
            el.addEventListener('mouseenter', () => document.body.classList.add('hovering'));
            el.addEventListener('mouseleave', () => document.body.classList.remove('hovering'));
        });

        // Navbar Scroll Logic
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav div');
            if(window.scrollY > 50) {
                nav.classList.add('bg-white/90', 'shadow-md');
                nav.classList.remove('bg-white/70', 'shadow-brand/5');
            } else {
                nav.classList.add('bg-white/70', 'shadow-brand/5');
                nav.classList.remove('bg-white/90', 'shadow-md');
            }
        });

        function scrollToServices() {
            document.getElementById('services').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>