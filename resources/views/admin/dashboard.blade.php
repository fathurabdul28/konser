@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="glow-card rounded-2xl p-6 border-l-4 border-cyan-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-cyan-300 text-sm font-semibold">Total Tiket</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['total'] }}</p>
                </div>
                <i class="fas fa-ticket-alt text-cyan-400 text-3xl"></i>
            </div>
        </div>

        <div class="glow-card rounded-2xl p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-300 text-sm font-semibold">Sudah Check-in</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['checked_in'] }}</p>
                </div>
                <i class="fas fa-check-circle text-green-400 text-3xl"></i>
            </div>
        </div>

        <div class="glow-card rounded-2xl p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-300 text-sm font-semibold">Belum Check-in</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['not_checked_in'] }}</p>
                </div>
                <i class="fas fa-clock text-yellow-400 text-3xl"></i>
            </div>
        </div>

        <div class="glow-card rounded-2xl p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-300 text-sm font-semibold">Attendance Rate</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['attendance_rate'] }}%</p>
                </div>
                <i class="fas fa-chart-line text-purple-400 text-3xl"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.tickets.index') }}" 
            class="glow-card rounded-2xl p-6 text-center transition-all duration-300 hover:scale-105 hover:border-cyan-400 border-2 border-transparent">
            <i class="fas fa-list text-4xl text-cyan-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-white">Kelola Tiket</h3>
            <p class="text-gray-400 mt-2">Lihat dan edit data pemesan</p>
        </a>

        <a href="{{ route('admin.checkin.form') }}" 
            class="glow-card rounded-2xl p-6 text-center transition-all duration-300 hover:scale-105 hover:border-green-400 border-2 border-transparent">
            <i class="fas fa-qrcode text-4xl text-green-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-white">Check-in</h3>
            <p class="text-gray-400 mt-2">Proses check-in penonton</p>
        </a>

        <a href="{{ route('admin.reports') }}" 
            class="glow-card rounded-2xl p-6 text-center transition-all duration-300 hover:scale-105 hover:border-purple-400 border-2 border-transparent">
            <i class="fas fa-chart-bar text-4xl text-purple-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-white">Laporan</h3>
            <p class="text-gray-400 mt-2">Lihat laporan kehadiran</p>
        </a>
    </div>

    <div class="glow-card rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-cyan-300 mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-4">
            @foreach($recentTickets as $ticket)
            <div class="flex items-center justify-between p-4 rounded-lg bg-gray-800/50">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-cyan-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-white">{{ $ticket->name }}</p>
                        <p class="text-sm text-gray-400">{{ $ticket->ticket_number }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-400">{{ $ticket->created_at->diffForHumans() }}</p>
                    <span class="px-2 py-1 rounded-full text-xs {{ $ticket->is_checked_in ? 'bg-green-500' : 'bg-yellow-500' }}">
                        {{ $ticket->is_checked_in ? 'Checked-in' : 'Pending' }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection