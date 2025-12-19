<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - FreshClean Laundry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 text-white shadow-lg" style="background: linear-gradient(180deg, #56C5D0 0%, #3FA9B5 100%);">
            <div class="p-6 border-b" style="border-color: #3FA9B5;">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <span class="text-lg font-bold" style="color: #56C5D0;">FC</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">FreshClean</h1>
                        <p class="text-xs" style="color: #AEE4FF;">Admin Panel</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-opacity-100' : 'hover:bg-opacity-50 transition' }}" style="background-color: {{ request()->routeIs('admin.dashboard') ? '#3FA9B5' : 'transparent' }};">
                    <i class="fas fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-opacity-100' : 'hover:bg-opacity-50 transition' }}" style="background-color: {{ request()->routeIs('admin.orders.*') ? '#3FA9B5' : 'transparent' }};">
                    <i class="fas fa-shopping-cart w-5"></i>
                    <span>Orders</span>
                </a>

                <a href="{{ route('admin.pelanggans.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.pelanggans.*') ? 'bg-opacity-100' : 'hover:bg-opacity-50 transition' }}" style="background-color: {{ request()->routeIs('admin.pelanggans.*') ? '#3FA9B5' : 'transparent' }};">
                    <i class="fas fa-users w-5"></i>
                    <span>Pelanggan</span>
                </a>

                <a href="{{ route('admin.packages.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.packages.*') ? 'bg-opacity-100' : 'hover:bg-opacity-50 transition' }}" style="background-color: {{ request()->routeIs('admin.packages.*') ? '#3FA9B5' : 'transparent' }};">
                    <i class="fas fa-box w-5"></i>
                    <span>Packages</span>
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.laporan.*') ? 'bg-opacity-100' : 'hover:bg-opacity-50 transition' }}" style="background-color: {{ request()->routeIs('admin.laporan.*') ? '#3FA9B5' : 'transparent' }};">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span>Laporan</span>
                </a>
            </nav>

            {{-- <div class="absolute bottom-0 left-0 right-0 p-4 border-t" style="border-color: #3FA9B5; background-color: #3FA9B5;">
                <div class="text-center">
                    <p class="text-sm" style="color: #AEE4FF;">Logged in as</p>
                    <p class="font-semibold">Admin User</p>
                </div>
            </div> --}}
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-8 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('header', 'Dashboard')</h2>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-600 hover:text-gray-800">
                            <i class="fas fa-bell text-xl"></i>
                        </button>
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white cursor-pointer">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-auto p-8">
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
