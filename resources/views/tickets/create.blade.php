@extends('layouts.app')

@section('title', 'Pesan Tiket Konser')

@section('content')
<div class="min-h-screen bg-blue-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-4xl w-full space-y-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-blue-800 mb-4">Ulbi Fest</h1>
            <p class="text-gray-600 text-lg">Form Pemesanan Tiket Konser</p>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-8 text-blue-700">
                <i class="fas fa-ticket-alt mr-3 text-blue-600"></i>FORM PEMESANAN TIKET
            </h2>

            <form action="{{ route('tickets.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-blue-700 border-b border-blue-200 pb-2">
                            <i class="fas fa-user mr-2"></i>Informasi Pribadi
                        </h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" required 
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 placeholder-gray-400 transition-all duration-300">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" required 
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 placeholder-gray-400 transition-all duration-300">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" name="phone" required 
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 placeholder-gray-400 transition-all duration-300">
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-blue-700 border-b border-blue-200 pb-2">
                            <i class="fas fa-id-card mr-2"></i>Detail Tambahan
                        </h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor KTP</label>
                            <input type="text" name="id_card" required 
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 placeholder-gray-400 transition-all duration-300">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                            <input type="date" name="birth_date" required 
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 placeholder-gray-400 transition-all duration-300">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                            <select name="gender" required 
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800">
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-blue-700 border-b border-blue-200 pb-2">
                        <i class="fas fa-couch mr-2"></i>Pilihan Tempat Duduk
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="seat-option cursor-pointer">
                            <input type="radio" name="seat_type" value="vip" class="hidden" required>
                            <div class="bg-white border-2 border-yellow-400 rounded-xl p-6 text-center transition-all duration-300 hover:bg-yellow-50">
                                <div class="text-yellow-500 text-2xl mb-2">
                                    <i class="fas fa-crown"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800">VIP</h4>
                                <p class="text-yellow-600 font-semibold text-xl">Rp 500.000</p>
                            </div>
                        </label>

                        <label class="seat-option cursor-pointer">
                            <input type="radio" name="seat_type" value="premium" class="hidden" required>
                            <div class="bg-white border-2 border-blue-400 rounded-xl p-6 text-center transition-all duration-300 hover:bg-blue-50">
                                <div class="text-blue-500 text-2xl mb-2">
                                    <i class="fas fa-star"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800">PREMIUM</h4>
                                <p class="text-blue-600 font-semibold text-xl">Rp 300.000</p>
                            </div>
                        </label>

                        <label class="seat-option cursor-pointer">
                            <input type="radio" name="seat_type" value="festival" class="hidden" required>
                            <div class="bg-white border-2 border-green-400 rounded-xl p-6 text-center transition-all duration-300 hover:bg-green-50">
                                <div class="text-green-500 text-2xl mb-2">
                                    <i class="fas fa-music"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800">FESTIVAL</h4>
                                <p class="text-green-600 font-semibold text-xl">Rp 150.000</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="text-center pt-6">
                    <button type="submit" 
                        class="px-12 py-4 bg-blue-600 rounded-lg text-white font-bold text-lg transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
                        <i class="fas fa-ticket-alt mr-2"></i>PESAN TIKET SEKARANG
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.seat-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.seat-option').forEach(opt => {
                opt.querySelector('div').classList.remove('border-blue-500', 'bg-blue-50');
                opt.querySelector('div').classList.add('bg-white');
            });
            this.querySelector('div').classList.add('border-blue-500', 'bg-blue-50');
            this.querySelector('div').classList.remove('bg-white');
        });
    });
</script>
@endsection