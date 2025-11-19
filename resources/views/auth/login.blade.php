@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h1 class="text-5xl font-bold neon-text mb-4 font-orbitron">Ulbi Fest</h1>
            <p class="text-xl text-cyan-300 mb-2">Admin Portal</p>
            <p class="text-gray-400">Masuk ke sistem manajemen tiket</p>
        </div>

        <div class="glow-card rounded-3xl p-8 backdrop-blur-lg">
            <h2 class="text-2xl font-bold text-center mb-8 text-cyan-300 font-orbitron">
                <i class="fas fa-lock mr-3"></i>ADMIN LOGIN
            </h2>

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-cyan-200 mb-2">
                        <i class="fas fa-envelope mr-2"></i>Email Address
                    </label>
                    <input type="email" name="email" required 
                        class="w-full px-4 py-3 bg-gray-800 border border-cyan-500 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300"
                        placeholder="admin@gmail.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-cyan-200 mb-2">
                        <i class="fas fa-key mr-2"></i>Password
                    </label>
                    <input type="password" name="password" required 
                        class="w-full px-4 py-3 bg-gray-800 border border-cyan-500 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded bg-gray-800 border-cyan-500 text-cyan-600 focus:ring-cyan-500">
                        <span class="ml-2 text-sm text-gray-300">Ingat saya</span>
                    </label>
                    
                    <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors">
                        Lupa password?
                    </a>
                </div>

                <button type="submit" 
                    class="w-full py-4 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-full text-white font-bold text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-cyan-500/25">
                    <i class="fas fa-sign-in-alt mr-2"></i>MASUK KE SISTEM
                </button>
            </form>

            <div class="mt-8 p-4 bg-gray-800/50 rounded-lg">
                <h4 class="text-sm font-semibold text-cyan-300 mb-2">Akun Demo:</h4>
                <div class="text-xs text-gray-400 space-y-1">
                    <p><strong>Admin:</strong> admin@gmail.com / admin123</p>
                    <p><strong>Staff:</strong> staff@gmail.com / staff123</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection