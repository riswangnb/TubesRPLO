<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - FreshClean</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#00C2FF', dark: '#0055FF', accent: '#C1FF00' },
                    },
                    animation: { 'float': 'float 6s ease-in-out infinite' },
                    keyframes: {
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
        .ocean {
            height: 120px; /* Tinggi ombak dikurangi agar tidak memakan tempat */
            width: 100%; position: absolute; bottom: 0; left: 0; right: 0; overflow-x: hidden; z-index: 1; pointer-events: none;
        }
        .wave {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1600 198'%3E%3Cpath fill='%23F8FAFC' d='M1600 98l-70 12c-70 12-210 36-350 30-140-6-280-42-420-42-140 0-280 36-420 48-140 12-210-12-245-24L0 98l0 100 95 0c95 0 285 0 475 0 190 0 380 0 570 0 190 0 285 0 380 0 95 0 0 0 0 0z'/%3E%3C/svg%3E");
            position: absolute; width: 200%; height: 100%; animation: wave 10s linear infinite; opacity: 1;
        }
        .wave:nth-of-type(2) { top: -20px; animation: wave 12s linear infinite; opacity: 0.5; }
        @keyframes wave { 0% { margin-left: 0; } 100% { margin-left: -1600px; } }

        /* Bubble Cursor */
        body { cursor: default; }
        .soap-bubble {
            position: fixed; border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.1));
            box-shadow: 0 0 2px rgba(255, 255, 255, 0.5), inset 0 0 4px rgba(0, 194, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.4); pointer-events: none; z-index: 9999;
            animation: pop-fade 1s ease-out forwards; backdrop-filter: blur(1px);
        }
        @keyframes pop-fade {
            0% { transform: translate(-50%, -50%) scale(0.5); opacity: 0.8; }
            100% { transform: translate(-50%, -150%) scale(0); opacity: 0; }
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.9); border: 2px solid transparent; transition: all 0.3s ease;
        }
        .glass-input:focus {
            background: #fff; border-color: #00C2FF; box-shadow: 0 0 15px rgba(0, 194, 255, 0.2); outline: none;
        }
        .hover-shine { overflow: hidden; position: relative; }
        .hover-shine::after {
            content: ''; position: absolute; top: 0; left: -100%; width: 50%; height: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.1), transparent);
            transform: skewX(-25deg); animation: shine 6s infinite; pointer-events: none;
        }
        @keyframes shine { 0%, 80% { left: -100%; } 100% { left: 200%; } }
    </style>
</head>
<body class="bg-gradient-to-br from-brand to-brand-dark min-h-screen flex items-center justify-center overflow-hidden relative">

    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-white/10 rounded-full blur-3xl animate-float pointer-events-none"></div>
    <div class="absolute bottom-[10%] right-[-5%] w-80 h-80 bg-brand-accent/20 rounded-full blur-3xl animate-float delay-1000 pointer-events-none"></div>

    <div class="ocean">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <div class="relative z-20 w-full max-w-sm px-4"> <div class="bg-white/10 backdrop-blur-xl border border-white/40 rounded-3xl p-6 md:p-8 shadow-2xl hover-shine" data-aos="zoom-in">
            
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white/20 text-white mb-3 border border-white/30 shadow-lg shadow-brand/20">
                    <i class="fa-solid fa-user-shield text-2xl"></i>
                </div>
                <h2 class="text-2xl font-black text-white tracking-tight">Admin Login</h2>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                
                <div class="space-y-1">
                    <label for="email" class="text-white/90 text-xs font-bold ml-1 uppercase tracking-wide">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-brand-dark/50">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                            class="glass-input w-full pl-9 pr-3 py-2.5 rounded-xl text-sm text-slate-900 placeholder-slate-400 font-medium shadow-sm"
                            placeholder="admin@freshclean.com">
                    </div>
                    @error('email')
                        <p class="text-brand-accent text-[10px] font-bold mt-1 ml-1 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="password" class="text-white/90 text-xs font-bold ml-1 uppercase tracking-wide">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-brand-dark/50">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input id="password" type="password" name="password" required 
                            class="glass-input w-full pl-9 pr-10 py-2.5 rounded-xl text-sm text-slate-900 placeholder-slate-400 font-medium shadow-sm"
                            placeholder="••••••••">
                        
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-brand-dark transition-colors focus:outline-none">
                            <i id="eyeIcon" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="remember" class="peer sr-only">
                            <div class="w-4 h-4 bg-white/20 border border-white/50 rounded transition-all peer-checked:bg-brand-accent peer-checked:border-brand-accent"></div>
                            <i class="fa-solid fa-check absolute top-0 left-0.5 text-slate-900 text-[10px] opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                        </div>
                        <span class="ml-2 text-white/80 text-xs font-medium group-hover:text-white transition-colors">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" 
                    class="w-full bg-brand-accent text-slate-900 py-3 rounded-xl font-black text-sm uppercase tracking-wider shadow-lg hover:bg-white hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2 group mt-2">
                    <span>Masuk Dashboard</span>
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <p class="mt-6 text-center text-[10px] text-white/40 font-medium">
                &copy; {{ date('Y') }} FreshClean. Secure Portal.
            </p>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        function togglePassword() {
            const p = document.getElementById('password');
            const i = document.getElementById('eyeIcon');
            if (p.type === 'password') { p.type = 'text'; i.classList.replace('fa-eye', 'fa-eye-slash'); } 
            else { p.type = 'password'; i.classList.replace('fa-eye-slash', 'fa-eye'); }
        }

        // Bubble Logic
        let lastBubbleTime = 0;
        document.addEventListener('mousemove', (e) => {
            const now = Date.now();
            if (now - lastBubbleTime > 50) {
                createBubble(e.clientX, e.clientY); lastBubbleTime = now;
            }
        });
        function createBubble(x, y) {
            const b = document.createElement('div'); b.classList.add('soap-bubble');
            const s = Math.random() * 10 + 5; 
            b.style.width = `${s}px`; b.style.height = `${s}px`; 
            b.style.left = `${x}px`; b.style.top = `${y}px`;
            document.body.appendChild(b); setTimeout(() => { b.remove(); }, 1000);
        }
    </script>
</body>
</html>