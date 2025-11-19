<div class="space-y-4">
    <div class="text-center mb-6">
        <h4 class="text-2xl font-bold text-cyan-300">{{ $ticket->ticket_number }}</h4>
        <p class="text-gray-400">Detail Informasi Tiket</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-cyan-200 mb-1">Nama Lengkap</label>
            <p class="text-white">{{ $ticket->name }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-cyan-200 mb-1">Email</label>
            <p class="text-white">{{ $ticket->email }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-cyan-200 mb-1">Telepon</label>
            <p class="text-white">{{ $ticket->phone }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-cyan-200 mb-1">KTP</label>
            <p class="text-white">{{ $ticket->id_card }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-cyan-200 mb-1">Tanggal Lahir</label>
            <p class="text-white">{{ $ticket->birth_date->format('d/m/Y') }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-cyan-200 mb-1">Jenis Kelamin</label>
            <p class="text-white">{{ $ticket->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
        </div>
    </div>

    <div class="border-t border-gray-600 pt-4 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-3 rounded-lg bg-gray-800">
                <div class="text-lg font-bold text-cyan-300 capitalize">{{ $ticket->seat_type }}</div>
                <div class="text-sm text-gray-400">Tipe Kursi</div>
            </div>
            <div class="text-center p-3 rounded-lg bg-gray-800">
                <div class="text-lg font-bold text-green-400">Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
                <div class="text-sm text-gray-400">Harga</div>
            </div>
            <div class="text-center p-3 rounded-lg bg-gray-800">
                <div class="text-lg font-bold {{ $ticket->is_checked_in ? 'text-green-400' : 'text-yellow-400' }}">
                    {{ $ticket->is_checked_in ? 'Checked-in' : 'Pending' }}
                </div>
                <div class="text-sm text-gray-400">Status</div>
            </div>
        </div>
    </div>

    @if($ticket->is_checked_in)
    <div class="border-t border-gray-600 pt-4 mt-4">
        <h5 class="text-lg font-semibold text-green-300 mb-2">Informasi Check-in</h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-cyan-200 mb-1">Waktu Check-in</label>
                <p class="text-white">{{ $ticket->checked_in_at->format('d/m/Y H:i:s') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-cyan-200 mb-1">Durasi</label>
                <p class="text-white">{{ $ticket->checked_in_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="border-t border-gray-600 pt-4 mt-4">
        <h5 class="text-lg font-semibold text-cyan-300 mb-2">Timestamps</h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-cyan-200 mb-1">Dibuat</label>
                <p class="text-white">{{ $ticket->created_at->format('d/m/Y H:i:s') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-cyan-200 mb-1">Diupdate</label>
                <p class="text-white">{{ $ticket->updated_at->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>
    </div>
</div>