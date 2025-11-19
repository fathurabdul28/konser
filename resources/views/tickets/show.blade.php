@extends('layouts.app')

@section('title', 'E-Ticket')

@section('content')
<div class="min-h-screen bg-blue-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-2xl w-full">
        @if(session('success'))
        <div class="bg-white rounded-xl p-6 mb-8 border-l-4 border-green-500 shadow-md">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 text-2xl mr-4"></i>
                <div>
                    <h3 class="text-lg font-semibold text-green-600">Sukses!</h3>
                    <p class="text-gray-600">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl overflow-hidden shadow-lg transition-all duration-300">
            <div class="bg-blue-600 py-6 px-8 text-center">
                <h1 class="text-3xl font-bold text-white">E-TICKET</h1>
                <p class="text-blue-100 mt-2">Ulbi Fest 2025</p>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-1 flex justify-center">
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <img src="{{ $ticket->getQRCode() }}" alt="QR Code" class="w-48 h-48 mx-auto">
                            <p class="text-center text-sm text-gray-600 mt-4 font-mono">{{ $ticket->ticket_number }}</p>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-gray-500 text-sm font-semibold">Nama Pemesan</label>
                                <p class="text-gray-800 text-lg">{{ $ticket->name }}</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-sm font-semibold">Email</label>
                                <p class="text-gray-800 text-lg">{{ $ticket->email }}</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-sm font-semibold">Telepon</label>
                                <p class="text-gray-800 text-lg">{{ $ticket->phone }}</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-sm font-semibold">KTP</label>
                                <p class="text-gray-800 text-lg">{{ $ticket->id_card }}</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-sm font-semibold">Tanggal Lahir</label>
                                <p class="text-gray-800 text-lg">{{ $ticket->birth_date->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-sm font-semibold">Jenis Kelamin</label>
                                <p class="text-gray-800 text-lg">{{ $ticket->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                        </div>

                        <div class="bg-blue-50 rounded-xl p-6 mt-6 border border-blue-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-2xl font-bold text-blue-700">{{ strtoupper($ticket->seat_type) }}</h3>
                                    <p class="text-gray-600">Tempat Duduk</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-green-600">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                                    <p class="text-gray-600">Harga Tiket</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-blue-600 py-4 px-8">
                <div class="flex justify-between items-center text-sm">
                    <div class="text-blue-100">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        {{ now()->format('d F Y H:i') }}
                    </div>
                    <div class="text-blue-100">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Tiket Digital Terverifikasi
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 mt-8 shadow-md">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">
                <i class="fas fa-info-circle mr-2 text-blue-500"></i>Instruksi Penting
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex items-start">
                    <i class="fas fa-qrcode text-blue-500 mt-1 mr-3"></i>
                    <p class="text-gray-600">Tunjukkan QR code ini di gerbang masuk untuk check-in</p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-print text-blue-500 mt-1 mr-3"></i>
                    <p class="text-gray-600">Simpan tiket ini atau screenshot halaman ini</p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-clock text-blue-500 mt-1 mr-3"></i>
                    <p class="text-gray-600">Datang 2 jam sebelum konser dimulai</p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-id-card text-blue-500 mt-1 mr-3"></i>
                    <p class="text-gray-600">Bawa KTP asli untuk verifikasi</p>
                </div>
            </div>
        </div>

        <div class="flex justify-center space-x-4 mt-8">
            <button onclick="window.print()" 
                class="px-6 py-3 bg-blue-600 rounded-lg text-white font-semibold transition-all duration-300 hover:bg-blue-700">
                <i class="fas fa-print mr-2"></i>Print Tiket
            </button>
            <a href="{{ route('tickets.create') }}" 
                class="px-6 py-3 bg-gray-600 rounded-lg text-white font-semibold transition-all duration-300 hover:bg-gray-700">
                <i class="fas fa-plus mr-2"></i>Pesan Tiket Lain
            </a>
        </div>
    </div>
</div>
@endsection