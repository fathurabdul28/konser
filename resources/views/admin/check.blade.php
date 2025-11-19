@extends('layouts.admin')

@section('title', 'Test Real-time')

@section('content')
<div class="space-y-6">
    <div class="glow-card rounded-2xl p-6">
        <h2 class="text-2xl font-bold text-cyan-300 mb-4">Check Ticket</h2>
        
        <button onclick="testNotifikasi()" 
                class="px-6 py-3 bg-cyan-600 rounded-lg text-white font-semibold hover:bg-cyan-500 transition-colors">
            Test Notification
        </button>
        
        <button onclick="simulasicheckin()" 
                class="px-6 py-3 bg-green-600 rounded-lg text-white font-semibold hover:bg-green-500 transition-colors ml-4">
            Simulasi Check-in
        </button>
    </div>
</div>

<script>
function testNotifikasi() {
    const testTicket = {
        name: 'Test User',
        ticket_number: 'TXTEST123',
        seat_type: 'vip',
        checked_in_at: new Date().toLocaleTimeString()
    };
    showCheckInNotification(testTicket);
}

function simulasicheckin() {
    const event = new CustomEvent('pusher:event', {
        detail: {
            channel: 'checkins',
            event: 'CheckInProcessed',
            data: {
                ticket: {
                    name: 'Simulated User',
                    ticket_number: 'TXSIM456',
                    seat_type: 'festival',
                    checked_in_at: new Date().toLocaleTimeString()
                }
            }
        }
    });
    window.dispatchEvent(event);
}
</script>
@endsection