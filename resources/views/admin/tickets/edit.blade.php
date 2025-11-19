@extends('layouts.admin')

@section('title', 'Edit Tiket')

@section('content')
<div class="space-y-6">
    <div class="glow-card rounded-2xl p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-cyan-300 font-orbitron mb-2">
                    <i class="fas fa-edit mr-3"></i>EDIT TIKET
                </h1>
                <p class="text-gray-400">Update data pemesan tiket</p>
            </div>
            <div class="text-right">
                <p class="text-cyan-300 font-mono">{{ $ticket->ticket_number }}</p>
                <p class="text-gray-400 text-sm">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="glow-card rounded-2xl p-6">
        <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-cyan-300 border-b border-cyan-500 pb-2">
                        <i class="fas fa-user mr-2"></i>Informasi Pribadi
                    </h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-cyan-200 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $ticket->name) }}" required 
                            class="w-full px-4 py-3 bg-gray-800 border border-cyan-500 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-cyan-200 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $ticket->email) }}" required 
                            class="w-full px-4 py-3 bg-gray-800 border border-cyan-500 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-cyan-200 mb-2">Nomor Telepon</label>
                        <input type="tel" name="phone" value="{{ old('phone', $ticket->phone) }}" required 
                            class="w-full px-4 py-3 bg-gray-800 border border-cyan-500 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300">
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-cyan-300 border-b border-cyan-500 pb-2">
                        <i class="fas fa-id-card mr-2"></i>Detail Tambahan
                    </h3>

                    <div>
                        <label class="block text-sm font-medium text-cyan-200 mb-2">Nomor KTP</label>
                        <input type="text" name="id_card" value="{{ old('id_card', $ticket->id_card) }}" required 
                            class="w-full px-4 py-3 bg-gray-800 border border-cyan-500 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-cyan-200 mb-2">Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $ticket->birth_date->format('Y-m-d')) }}" required 
                            class="w-full px-4 py-3 bg-gray-800 border border-cyan-500 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-cyan-200 mb-2">Jenis Kelamin</label>
                        <select name="gender" required 
                            class="w-full px-4 py-3 bg-gray-800 border border-cyan-500 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-white">
                            <option value="male" {{ $ticket->gender == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ $ticket->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-semibold text-cyan-300 border-b border-cyan-500 pb-2">
                    <i class="fas fa-couch mr-2"></i>Pilihan Tempat Duduk
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="seat-option cursor-pointer">
                        <input type="radio" name="seat_type" value="vip" class="hidden" required 
                            {{ $ticket->seat_type == 'vip' ? 'checked' : '' }}>
                        <div class="glow-card rounded-xl p-6 text-center transition-all duration-300 hover:scale-105 border-2 {{ $ticket->seat_type == 'vip' ? 'neon-border border-cyan-400' : 'border-transparent' }}">
                            <div class="text-cyan-400 text-2xl mb-2">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h4 class="font-bold text-lg">VIP</h4>
                            <p class="text-cyan-300 font-semibold text-xl">Rp 500.000</p>
                        </div>
                    </label>

                    <label class="seat-option cursor-pointer">
                        <input type="radio" name="seat_type" value="premium" class="hidden" required
                            {{ $ticket->seat_type == 'premium' ? 'checked' : '' }}>
                        <div class="glow-card rounded-xl p-6 text-center transition-all duration-300 hover:scale-105 border-2 {{ $ticket->seat_type == 'premium' ? 'neon-border border-purple-400' : 'border-transparent' }}">
                            <div class="text-purple-400 text-2xl mb-2">
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="font-bold text-lg">PREMIUM</h4>
                            <p class="text-purple-300 font-semibold text-xl">Rp 300.000</p>
                        </div>
                    </label>

                    <label class="seat-option cursor-pointer">
                        <input type="radio" name="seat_type" value="festival" class="hidden" required
                            {{ $ticket->seat_type == 'festival' ? 'checked' : '' }}>
                        <div class="glow-card rounded-xl p-6 text-center transition-all duration-300 hover:scale-105 border-2 {{ $ticket->seat_type == 'festival' ? 'neon-border border-green-400' : 'border-transparent' }}">
                            <div class="text-green-400 text-2xl mb-2">
                                <i class="fas fa-music"></i>
                            </div>
                            <h4 class="font-bold text-lg">FESTIVAL</h4>
                            <p class="text-green-300 font-semibold text-xl">Rp 150.000</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="glow-card rounded-xl p-6 border-l-4 {{ $ticket->is_checked_in ? 'border-green-500' : 'border-yellow-500' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-lg font-semibold {{ $ticket->is_checked_in ? 'text-green-400' : 'text-yellow-400' }}">
                            <i class="fas {{ $ticket->is_checked_in ? 'fa-check-circle' : 'fa-clock' }} mr-2"></i>
                            {{ $ticket->is_checked_in ? 'Sudah Check-in' : 'Belum Check-in' }}
                        </h4>
                        @if($ticket->is_checked_in)
                        <p class="text-gray-300 text-sm">Check-in pada: {{ $ticket->checked_in_at->format('d/m/Y H:i:s') }}</p>
                        @else
                        <p class="text-gray-300 text-sm">Menunggu check-in</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-cyan-300">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                        <p class="text-gray-400 text-sm">Harga Tiket</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6">
                <a href="{{ route('admin.tickets.index') }}" 
                    class="px-6 py-3 bg-gray-600 rounded-lg text-white font-semibold transition-all duration-300 hover:bg-gray-500">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <button type="submit" 
                    class="px-6 py-3 bg-cyan-600 rounded-lg text-white font-semibold transition-all duration-300 hover:bg-cyan-500 hover:scale-105">
                    <i class="fas fa-save mr-2"></i>UPDATE TIKET
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.seat-option').forEach(option => {
    option.addEventListener('click', function() {
        document.querySelectorAll('.seat-option').forEach(opt => {
            opt.querySelector('div').classList.remove('neon-border', 'border-cyan-400', 'border-purple-400', 'border-green-400');
        });
        
        const seatType = this.querySelector('input').value;
        let borderColor = 'border-cyan-400';
        if (seatType === 'premium') borderColor = 'border-purple-400';
        if (seatType === 'festival') borderColor = 'border-green-400';
        
        this.querySelector('div').classList.add('neon-border', borderColor);
    });
});
</script>
@endsection