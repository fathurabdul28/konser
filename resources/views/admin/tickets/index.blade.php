@extends('layouts.admin')

@section('title', 'Kelola Tiket')

@section('content')
<div class="space-y-6">
    <div class="glow-card rounded-2xl p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-cyan-300 font-orbitron mb-2">
                    <i class="fas fa-ticket-alt mr-3"></i>KELOLA TIKET
                </h1>
                <p class="text-gray-400">Manajemen data pemesan tiket konser</p>
            </div>
            <div class="text-right">
                <p class="text-cyan-300 text-lg font-semibold">{{ $tickets->total() }} Tiket</p>
                <p class="text-gray-400 text-sm">Total terdaftar</p>
            </div>
        </div>
    </div>

    <div class="glow-card rounded-2xl p-6">
        <form action="{{ route('admin.tickets.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-cyan-200 mb-2">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full px-4 py-2 bg-gray-800 border border-cyan-500 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-white placeholder-gray-400"
                    placeholder="Nama, Email, No. Tiket...">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-cyan-200 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 bg-gray-800 border border-cyan-500 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-white">
                    <option value="">Semua Status</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Sudah Check-in</option>
                    <option value="not_checked_in" {{ request('status') == 'not_checked_in' ? 'selected' : '' }}>Belum Check-in</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-cyan-200 mb-2">Tipe Kursi</label>
                <select name="seat_type" class="w-full px-4 py-2 bg-gray-800 border border-cyan-500 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-white">
                    <option value="">Semua Tipe</option>
                    <option value="vip" {{ request('seat_type') == 'vip' ? 'selected' : '' }}>VIP</option>
                    <option value="premium" {{ request('seat_type') == 'premium' ? 'selected' : '' }}>Premium</option>
                    <option value="festival" {{ request('seat_type') == 'festival' ? 'selected' : '' }}>Festival</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" 
                    class="w-full px-4 py-2 bg-cyan-600 rounded-lg text-white font-semibold transition-all duration-300 hover:bg-cyan-500">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.tickets.index') }}" 
                    class="ml-2 px-4 py-2 bg-gray-600 rounded-lg text-white font-semibold transition-all duration-300 hover:bg-gray-500">
                    <i class="fas fa-refresh mr-2"></i>
                </a>
            </div>
        </form>
    </div>

    <div class="glow-card rounded-2xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-cyan-500/30">
                        <th class="px-4 py-3 text-left text-cyan-300 font-semibold">No. Tiket</th>
                        <th class="px-4 py-3 text-left text-cyan-300 font-semibold">Pemesan</th>
                        <th class="px-4 py-3 text-left text-cyan-300 font-semibold">Kontak</th>
                        <th class="px-4 py-3 text-left text-cyan-300 font-semibold">Tipe</th>
                        <th class="px-4 py-3 text-left text-cyan-300 font-semibold">Status</th>
                        <th class="px-4 py-3 text-left text-cyan-300 font-semibold">Tanggal</th>
                        <th class="px-4 py-3 text-left text-cyan-300 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr class="border-b border-gray-700/50 hover:bg-gray-800/30 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-mono text-cyan-300 text-sm">{{ $ticket->ticket_number }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-semibold text-white">{{ $ticket->name }}</div>
                            <div class="text-xs text-gray-400">{{ $ticket->id_card }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-white">{{ $ticket->email }}</div>
                            <div class="text-xs text-gray-400">{{ $ticket->phone }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                {{ $ticket->seat_type == 'vip' ? 'bg-purple-500' : 
                                   ($ticket->seat_type == 'premium' ? 'bg-cyan-500' : 'bg-green-500') }}">
                                {{ strtoupper($ticket->seat_type) }}
                            </span>
                            <div class="text-xs text-gray-400 mt-1">Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                {{ $ticket->is_checked_in ? 'bg-green-500' : 'bg-yellow-500' }}">
                                {{ $ticket->is_checked_in ? 'Checked-in' : 'Pending' }}
                            </span>
                            @if($ticket->is_checked_in)
                            <div class="text-xs text-gray-400 mt-1">{{ $ticket->checked_in_at->format('H:i') }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-white">{{ $ticket->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-400">{{ $ticket->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.tickets.edit', $ticket) }}" 
                                    class="px-3 py-1 bg-blue-600 rounded-lg text-white text-xs font-semibold transition-all duration-300 hover:bg-blue-500"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="showTicketDetails('{{ $ticket->id }}')"
                                    class="px-3 py-1 bg-cyan-600 rounded-lg text-white text-xs font-semibold transition-all duration-300 hover:bg-cyan-500"
                                    title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="px-3 py-1 bg-red-600 rounded-lg text-white text-xs font-semibold transition-all duration-300 hover:bg-red-500"
                                        onclick="return confirm('Hapus tiket {{ $ticket->ticket_number }}?')"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                            <i class="fas fa-ticket-alt text-4xl mb-3"></i>
                            <p>Tidak ada tiket ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tickets->hasPages())
        <div class="mt-6">
            {{ $tickets->links() }}
        </div>
        @endif
    </div>
</div>

<div id="ticketModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="glow-card rounded-2xl p-6 max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-bold text-cyan-300">Detail Tiket</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div id="ticketDetailsContent">
        </div>
    </div>
</div>

<script>
function showTicketDetails(ticketId) {
    fetch(`/admin/tickets/${ticketId}/details`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('ticketDetailsContent').innerHTML = data.html;
            document.getElementById('ticketModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading ticket details');
        });
}

function closeModal() {
    document.getElementById('ticketModal').classList.add('hidden');
}

document.getElementById('ticketModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>

<style>
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
}

.pagination li {
    margin: 0 2px;
}

.pagination li a,
.pagination li span {
    display: block;
    padding: 8px 12px;
    border: 1px solid #00f3ff;
    border-radius: 8px;
    color: #00f3ff;
    text-decoration: none;
    transition: all 0.3s;
}

.pagination li a:hover {
    background: #00f3ff;
    color: #0a0a1f;
}

.pagination li.active span {
    background: #00f3ff;
    color: #0a0a1f;
    border-color: #00f3ff;
}

.pagination li.disabled span {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
@endsection