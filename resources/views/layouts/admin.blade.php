<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
        }
        
        .sidebar {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            border-right: 1px solid #334155;
        }
        
        .nav-item {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            border-left: 3px solid #60a5fa;
        }
        
        .nav-item.active {
            background: rgba(255, 255, 255, 0.08);
            border-left: 3px solid #3b82f6;
        }
        
        .header-bg {
            background: #1e293b;
            border-bottom: 1px solid #334155;
        }
        
        .card {
            background: #1e293b;
            border: 1px solid #334155;
        }
    </style>
</head>
<body class="bg-slate-900">
    <div class="flex h-screen">
        <div class="sidebar w-64 flex-shrink-0 text-slate-200">
            <div class="p-6 border-b border-slate-700">
                <h1 class="text-2xl font-bold text-center text-white">Ulbi Fest</h1>
                <p class="text-slate-400 text-sm text-center mt-2">Admin Panel</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-item flex items-center px-6 py-3 text-slate-200 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 text-blue-400"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.tickets.index') }}" 
                   class="nav-item flex items-center px-6 py-3 text-slate-200 {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt mr-3 text-green-400"></i>
                    Kelola Tiket
                </a>
                
                <a href="{{ route('admin.checkin.form') }}" 
                   class="nav-item flex items-center px-6 py-3 text-slate-200 {{ request()->routeIs('admin.checkin.*') ? 'active' : '' }}">
                    <i class="fas fa-qrcode mr-3 text-yellow-400"></i>
                    Check-in
                </a>
                
                <a href="{{ route('admin.reports') }}" 
                   class="nav-item flex items-center px-6 py-3 text-slate-200 {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar mr-3 text-purple-400"></i>
                    Laporan
                </a>
            </nav>
            
            <div class="absolute bottom-0 w-64 p-4 border-t border-slate-700 bg-slate-800">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-slate-400 text-xs">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center justify-center px-4 py-2 bg-red-600 rounded-lg text-white text-sm font-semibold transition-all duration-300 hover:bg-red-700">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
        
        <div class="flex-1 overflow-auto bg-slate-900">
            <header class="header-bg text-white shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-white">
                            @yield('title')
                        </h2>
                        <div class="text-slate-300">
                            <i class="fas fa-clock mr-2"></i>
                            <span id="current-time">{{ now()->format('d F Y H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </header>
            
            <main class="p-6">
                @if(session('success'))
                    <div class="card rounded-lg p-4 mb-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-400 text-xl mr-3"></i>
                            <span class="text-green-200 font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="card rounded-lg p-4 mb-6 border-l-4 border-red-500">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-400 text-xl mr-3"></i>
                            <span class="text-red-200 font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        function updateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('current-time').textContent = now.toLocaleDateString('id-ID', options);
        }
        
        setInterval(updateTime, 1000);
        updateTime();
    </script>
    
    @yield('scripts')
</body>
</html>