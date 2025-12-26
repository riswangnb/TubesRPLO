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
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .nav-active {
            background: linear-gradient(90deg, #00C2FF 0%, #0055FF 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 194, 255, 0.3);
        }
        
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* --- LOGIKA ANTI-KEDIP (CRITICAL CSS) --- */
        @media (min-width: 1024px) {
            body.is-minimized aside {
                width: 5rem !important; /* 80px */
            }
            body.is-minimized .content-wrapper {
                margin-left: 5rem !important; /* 80px */
            }
            body.is-minimized .hide-on-minimized {
                display: none !important;
                opacity: 0;
            }
            body.is-minimized .show-on-minimized {
                display: block !important;
                opacity: 1;
            }
            body.is-minimized .toggle-icon {
                transform: rotate(180deg);
            }
            body.is-minimized .sidebar-header {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }

            /* --- [BARU] PERBAIKAN AGAR MENU JADI KOTAK SIMETRIS --- */
            /* Kode ini memaksa link menu dan tombol logout jadi kotak 46x46px di tengah */
            body.is-minimized nav a, 
            body.is-minimized form button {
                display: flex !important;           /* Gunakan flexbox */
                justify-content: center !important; /* Ikon di tengah horizontal */
                align-items: center !important;     /* Ikon di tengah vertikal */
                padding: 0 !important;              /* Hapus padding bawaan */
                
                width: 46px !important;             /* Lebar Fix */
                height: 46px !important;            /* Tinggi Fix (Sama dengan lebar = Kotak) */
                
                margin-left: auto !important;       /* Auto margin kiri */
                margin-right: auto !important;      /* Auto margin kanan (biar di tengah sidebar) */
                margin-bottom: 8px !important;      /* Jarak antar menu */
                
                border-radius: 12px !important;     /* Sudut melengkung rapi */
            }
        }
    </style>
</head>
<body class="bg-surface text-slate-800 font-sans antialiased" 
      x-data="{ 
          sidebarOpen: false, 
          sidebarMinimized: localStorage.getItem('sidebarMinimized') === 'true',
          toggleMinimize() {
              this.sidebarMinimized = !this.sidebarMinimized;
              localStorage.setItem('sidebarMinimized', this.sidebarMinimized);
              
              if(this.sidebarMinimized) {
                  document.body.classList.add('is-minimized');
              } else {
                  document.body.classList.remove('is-minimized');
              }
          }
      }">

    <script>
        if (localStorage.getItem('sidebarMinimized') === 'true') {
            document.body.classList.add('is-minimized');
        }
    </script>

    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-transition.opacity
         class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden">
    </div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed top-0 left-0 z-50 h-screen bg-slate-900 text-white transition-all duration-300 ease-in-out lg:translate-x-0 shadow-2xl flex flex-col w-64">
        
        <div class="sidebar-header flex items-center h-20 bg-slate-900 border-b border-white/10 shrink-0 transition-all duration-300 justify-between px-6">
            <div class="flex items-center gap-3 overflow-hidden whitespace-nowrap">
                <div class="w-8 h-8 bg-brand text-white rounded-lg flex items-center justify-center font-bold shadow-lg shadow-brand/20 shrink-0">F</div>
                <div class="hide-on-minimized transition-opacity duration-200">
                    <span class="text-xl font-bold tracking-tight">FreshClean.</span>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 space-y-1 no-scrollbar transition-all duration-300 px-4">
            <p class="hide-on-minimized px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 mt-2 transition-opacity duration-200">Menu</p>
            <div class="show-on-minimized h-4 hidden"></div>

            @php
                $menus = [
                    ['route' => 'admin.dashboard', 'icon' => 'fa-home', 'label' => 'Dashboard'],
                    ['route' => 'admin.orders.index', 'icon' => 'fa-shopping-cart', 'label' => 'Orders'],
                    ['route' => 'admin.pelanggans.index', 'icon' => 'fa-users', 'label' => 'Pelanggan'],
                    ['route' => 'admin.packages.index', 'icon' => 'fa-box', 'label' => 'Layanan'],
                    ['route' => 'admin.laporan.index', 'icon' => 'fa-chart-pie', 'label' => 'Laporan'],
                ];
            @endphp

            @foreach($menus as $menu)
            <a href="{{ route($menu['route']) }}" 
               class="flex items-center gap-3 py-3 rounded-xl text-sm font-medium transition-all group relative overflow-hidden whitespace-nowrap px-4
                      {{ request()->routeIs(Str::before($menu['route'], '.index').'*') ? 'nav-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                
                <i class="fas {{ $menu['icon'] }} w-5 text-center text-lg shrink-0"></i>
                
                <span class="hide-on-minimized transition-opacity duration-200">
                    {{ $menu['label'] }}
                </span>

                <div class="show-on-minimized hidden absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 whitespace-nowrap border border-white/10 shadow-xl">
                    {{ $menu['label'] }}
                </div>
            </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-white/10 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 py-3 rounded-xl text-sm font-medium text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors whitespace-nowrap px-4">
                    <i class="fas fa-sign-out-alt w-5 text-center text-lg shrink-0"></i>
                    <span class="hide-on-minimized">Logout</span>
                </button>
            </form>
        </div>

        <button @click="toggleMinimize()" 
                class="absolute -right-4 top-1/2 -translate-y-1/2 w-4 h-16 bg-slate-900 border-y border-r border-white/10 rounded-r-2xl hidden lg:flex items-center justify-center text-slate-500 hover:text-brand hover:w-6 transition-all duration-200 cursor-pointer z-50 shadow-lg group">
            <i class="fas fa-chevron-left text-[10px] transition-transform duration-300 toggle-icon"></i>
        </button>

    </aside>

    <div class="content-wrapper flex flex-col min-h-screen transition-all duration-300 min-w-0 lg:ml-64">
        
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-30 flex items-center justify-between px-4 md:px-8 transition-all duration-300">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="text-slate-500 hover:text-brand focus:outline-none lg:hidden p-2">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                <h2 class="text-xl font-bold text-slate-800 truncate">@yield('header', 'Dashboard')</h2>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:block text-right">
                    <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-slate-500">Administrator</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 md:p-8 relative">
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand/5 rounded-full blur-3xl pointer-events-none -z-10"></div>

            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 flex items-center gap-3 animate-pulse">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
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

    @stack('scripts')
</body>
</html>