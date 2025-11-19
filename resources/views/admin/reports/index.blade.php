@extends('layouts.admin')

@section('title', 'Laporan Kehadiran')

@section('content')
<div class="space-y-6">
    <div class="glow-card rounded-2xl p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-cyan-300 font-orbitron mb-2">
                    <i class="fas fa-chart-bar mr-3"></i>LAPORAN KEHADIRAN
                </h1>
                <p class="text-gray-400">Analisis data kehadiran dan statistik konser</p>
            </div>
            <div class="text-right">
                <p class="text-cyan-300 text-lg font-semibold">{{ $stats['total'] }} Total</p>
                <p class="text-gray-400 text-sm">Update: {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glow-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-cyan-300 mb-4">Distribusi Tipe Kursi</h3>
            <div class="space-y-4">
                @php
                    $seatTypes = [
                        'vip' => ['count' => 0, 'color' => 'bg-purple-500', 'price' => 500000],
                        'premium' => ['count' => 0, 'color' => 'bg-cyan-500', 'price' => 300000],
                        'festival' => ['count' => 0, 'color' => 'bg-green-500', 'price' => 150000]
                    ];
                    
                    foreach($checkedIn as $ticket) {
                        if(isset($seatTypes[$ticket->seat_type])) {
                            $seatTypes[$ticket->seat_type]['count']++;
                        }
                    }
                    foreach($notCheckedIn as $ticket) {
                        if(isset($seatTypes[$ticket->seat_type])) {
                            $seatTypes[$ticket->seat_type]['count']++;
                        }
                    }
                @endphp

                @foreach($seatTypes as $type => $data)
                @php
                    $percentage = $stats['total'] > 0 ? round(($data['count'] / $stats['total']) * 100, 1) : 0;
                    $revenue = $data['count'] * $data['price'];
                @endphp
                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-800/50">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 {{ $data['color'] }} rounded-full"></div>
                        <div>
                            <span class="font-semibold text-white capitalize">{{ $type }}</span>
                            <span class="text-xs text-gray-400 ml-2">{{ $data['count'] }} tiket</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-cyan-300 font-semibold">{{ $percentage }}%</div>
                        <div class="text-xs text-gray-400">Rp {{ number_format($revenue, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="glow-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-cyan-300 mb-4">Check-in Hari Ini</h3>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @php
                    $todayCheckins = $checkedIn->filter(function($ticket) {
                        return $ticket->checked_in_at && $ticket->checked_in_at->isToday();
                    })->sortByDesc('checked_in_at');
                @endphp

                @if($todayCheckins->count() > 0)
                    @foreach($todayCheckins->take(10) as $checkin)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-800/30">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white text-sm">{{ $checkin->name }}</p>
                                <p class="text-xs text-gray-400">{{ $checkin->ticket_number }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-cyan-300">{{ $checkin->checked_in_at->format('H:i') }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ $checkin->seat_type }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-clock text-2xl mb-2"></i>
                        <p>Belum ada check-in hari ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glow-card rounded-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-green-300">
                    <i class="fas fa-check-circle mr-2"></i>Sudah Check-in
                    <span class="text-sm text-gray-400">({{ $checkedIn->count() }})</span>
                </h3>
                <button onclick="exportToCSV('checkedin')" 
                    class="px-3 py-1 bg-green-600 rounded-lg text-white text-xs font-semibold transition-all duration-300 hover:bg-green-500">
                    <i class="fas fa-download mr-1"></i>Export
                </button>
            </div>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @forelse($checkedIn as $ticket)
                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-800/30 border-l-4 border-green-500">
                    <div>
                        <p class="font-semibold text-white">{{ $ticket->name }}</p>
                        <p class="text-xs text-gray-400">{{ $ticket->ticket_number }} • {{ $ticket->email }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-cyan-300">{{ $ticket->checked_in_at->format('H:i') }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ $ticket->seat_type }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-users text-2xl mb-2"></i>
                    <p>Belum ada yang check-in</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="glow-card rounded-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-yellow-300">
                    <i class="fas fa-clock mr-2"></i>Belum Check-in
                    <span class="text-sm text-gray-400">({{ $notCheckedIn->count() }})</span>
                </h3>
                <button onclick="exportToCSV('notcheckedin')" 
                    class="px-3 py-1 bg-yellow-600 rounded-lg text-white text-xs font-semibold transition-all duration-300 hover:bg-yellow-500">
                    <i class="fas fa-download mr-1"></i>Export
                </button>
            </div>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @forelse($notCheckedIn as $ticket)
                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-800/30 border-l-4 border-yellow-500">
                    <div>
                        <p class="font-semibold text-white">{{ $ticket->name }}</p>
                        <p class="text-xs text-gray-400">{{ $ticket->ticket_number }} • {{ $ticket->email }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-500">Pending</span>
                        <p class="text-xs text-gray-400 mt-1 capitalize">{{ $ticket->seat_type }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-check-circle text-2xl mb-2"></i>
                    <p>Semua sudah check-in!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="glow-card rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-cyan-300 mb-4">Ringkasan Pendapatan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $totalRevenue = $checkedIn->sum('price') + $notCheckedIn->sum('price');
                $realizedRevenue = $checkedIn->sum('price');
                $potentialRevenue = $notCheckedIn->sum('price');
            @endphp
            
            <div class="text-center p-4 rounded-lg bg-gray-800/50">
                <div class="text-2xl font-bold text-green-400">Rp {{ number_format($realizedRevenue, 0, ',', '.') }}</div>
                <div class="text-sm text-gray-400">Realized Revenue</div>
                <div class="text-xs text-green-300 mt-1">Dari {{ $checkedIn->count() }} check-in</div>
            </div>
            
            <div class="text-center p-4 rounded-lg bg-gray-800/50">
                <div class="text-2xl font-bold text-yellow-400">Rp {{ number_format($potentialRevenue, 0, ',', '.') }}</div>
                <div class="text-sm text-gray-400">Potential Revenue</div>
                <div class="text-xs text-yellow-300 mt-1">Dari {{ $notCheckedIn->count() }} pending</div>
            </div>
            
            <div class="text-center p-4 rounded-lg bg-gray-800/50">
                <div class="text-2xl font-bold text-cyan-400">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="text-sm text-gray-400">Total Revenue</div>
                <div class="text-xs text-cyan-300 mt-1">Dari {{ $stats['total'] }} tiket</div>
            </div>
        </div>
    </div>
</div>

<script>
function exportToCSV(type) {
    let url = `/admin/reports/export/${type}`;
    window.open(url, '_blank');
}

setInterval(() => {
    fetch('/admin/dashboard/stats')
        .then(response => response.json())
        .then(data => {
            document.querySelector('[data-stat="total"]').textContent = data.total;
            document.querySelector('[data-stat="checked_in"]').textContent = data.checked_in;
            document.querySelector('[data-stat="not_checked_in"]').textContent = data.not_checked_in;
            document.querySelector('[data-stat="attendance_rate"]').textContent = data.attendance_rate + '%';
        });
}, 30000);
</script>

<style>
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #00f3ff;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #b967ff;
}
</style>
@endsection