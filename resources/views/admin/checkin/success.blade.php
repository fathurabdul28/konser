@extends('layouts.admin')

@section('title', 'Check-in Berhasil')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full text-center">
        <div class="bg-slate-800 rounded-full w-32 h-32 mx-auto mb-6 flex items-center justify-center border-4 border-green-500">
            <i class="fas fa-check-circle text-green-400 text-5xl"></i>
        </div>

        <div class="bg-slate-800 rounded-2xl p-8 mb-6 border-l-4 border-green-500">
            <h1 class="text-2xl font-bold text-green-400 mb-4">CHECK-IN BERHASIL!</h1>
            
            <div class="space-y-4 text-left">
                <div class="flex justify-between">
                    <span class="text-slate-400">Nama:</span>
                    <span class="text-white font-semibold">{{ $ticket->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">No. Tiket:</span>
                    <span class="text-white font-semibold">{{ $ticket->ticket_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Tipe:</span>
                    <span class="text-white font-semibold capitalize">{{ $ticket->seat_type }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Harga:</span>
                    <span class="text-white font-semibold">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Waktu Check-in:</span>
                    <span class="text-white font-semibold">{{ $ticket->checked_in_at->format('H:i:s') }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <a href="{{ route('admin.checkin.form') }}" 
                class="block w-full py-4 bg-blue-600 rounded-lg text-white font-bold text-lg transition-all duration-300 hover:bg-blue-700">
                <i class="fas fa-qrcode mr-2"></i>CHECK-IN BERIKUTNYA
            </a>
            
            <a href="{{ route('admin.dashboard') }}" 
                class="block w-full py-3 bg-slate-700 rounded-lg text-white font-semibold transition-all duration-300 hover:bg-slate-600">
                <i class="fas fa-tachometer-alt mr-2"></i>KE DASHBOARD
            </a>
        </div>
    </div>
</div>
@endsection