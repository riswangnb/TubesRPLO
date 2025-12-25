<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - FreshClean</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#00C2FF', dark: '#0055FF', accent: '#C1FF00' },
                        surface: '#F8FAFC'
                    }
                }
            }
        }
    </script>

    <style>
        /* --- Base Styles --- */
        body { cursor: default; }

        /* --- Bubble Cursor Effect --- */
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

        /* --- Sidebar & Glass Styles --- */
        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Scrollbar Customization */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Nav Link Active State Indicator */
        .nav-active {
            background: linear-gradient(90deg, #00C2FF 0%, #0055FF 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 194, 255, 0.3);
        }
    </style>
</head>
<body class="bg-surface text-slate-800 font-sans antialiased overflow-hidden">

    <div class="flex h-screen">
        
        <aside class="w-72 bg-slate-900 text-white flex flex-col shadow-2xl z-20 transition-all duration-300 relative overflow-hidden">
            
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-brand/20 rounded-full blur-[80px]"></div>
                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black/50 to-transparent"></div>
            </div>

            <div class="p-8 z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg shadow-brand/20">
                        F
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">FreshClean.</h1>
                        <p class="text-[10px] text-brand-accent font-bold uppercase tracking-widest">Admin Panel</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 space-y-2 overflow-y-auto z-10 py-4">
                
                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 mt-2">Main Menu</p>

                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-medium transition-all duration-300 group {{ request()->routeIs('admin.dashboard') ? 'nav-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-home w-6 text-center {{ request()->routeIs('admin.dashboard') ? 'animate-pulse' : '' }}"></i>
                    <span>Dashboard</span>
                    @if(request()->routeIs('admin.dashboard'))
                        <i class="fas fa-chevron-right ml-auto text-xs opacity-70"></i>
                    @endif
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-medium transition-all duration-300 group {{ request()->routeIs('admin.orders.*') ? 'nav-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-shopping-cart w-6 text-center"></i>
                    <span>Orders</span>
                </a>

                <a href="{{ route('admin.pelanggans.index') }}" 
                   class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-medium transition-all duration-300 group {{ request()->routeIs('admin.pelanggans.*') ? 'nav-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-users w-6 text-center"></i>
                    <span>Pelanggan</span>
                </a>

                <a href="{{ route('admin.packages.index') }}" 
                   class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-medium transition-all duration-300 group {{ request()->routeIs('admin.packages.*') ? 'nav-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-box w-6 text-center"></i>
                    <span>Packages</span>
                </a>

                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6">Analytics</p>

                <a href="{{ route('admin.laporan.index') }}" 
                   class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-medium transition-all duration-300 group {{ request()->routeIs('admin.laporan.*') ? 'nav-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-chart-pie w-6 text-center"></i>
                    <span>Laporan</span>
                </a>
            </nav>

            <div class="p-4 z-10 border-t border-white/5">
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all duration-300 font-semibold group">
                        <i class="fas fa-sign-out-alt group-hover:-translate-x-1 transition-transform"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand/5 rounded-full blur-3xl pointer-events-none"></div>

            <header class="glass-header h-20 flex items-center justify-between px-8 z-10 shrink-0">
                <div class="flex items-center gap-4">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">@yield('header', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-4">
                    <button class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-brand hover:border-brand transition-colors flex items-center justify-center relative">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                    </button>
                    
                    <div class="h-8 w-px bg-slate-200 mx-1"></div>

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-slate-500">Administrator</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand to-brand-dark p-0.5 shadow-lg shadow-brand/20">
                            <div class="w-full h-full bg-white rounded-full flex items-center justify-center overflow-hidden">
                                 <i class="fas fa-user text-slate-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scroll-smooth">
                
                @if($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 flex items-start gap-3 shadow-sm animate-pulse">
                        <i class="fas fa-exclamation-circle mt-1"></i>
                        <div>
                            <ul class="list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100 text-green-700 flex items-center gap-3 shadow-sm">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                             <i class="fas fa-check"></i>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="animate-[float_0.5s_ease-out]">
                    @yield('content')
                </div>

                <div class="mt-10 pt-6 border-t border-slate-200 text-center text-slate-400 text-xs">
                    &copy; {{ date('Y') }} FreshClean Laundry System. 
                </div>

            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
        let lastBubbleTime = 0;
        document.addEventListener('mousemove', (e) => {
            const now = Date.now();
            if (now - lastBubbleTime > 50) {
                createBubble(e.clientX, e.clientY);
                lastBubbleTime = now;
            }
        });

        function createBubble(x, y) {
            const bubble = document.createElement('div');
            bubble.classList.add('soap-bubble');
            const size = Math.random() * 12 + 8; 
            bubble.style.width = `${size}px`;
            bubble.style.height = `${size}px`;
            bubble.style.left = `${x}px`;
            bubble.style.top = `${y}px`;
            document.body.appendChild(bubble);
            setTimeout(() => { bubble.remove(); }, 1000);
        }
    </script>
</body>
</html>