@extends('layouts.admin')

@section('title', 'Check-in Tiket')

@section('content')
<div class="space-y-6">
    <div class="glow-card rounded-2xl p-6">
        <h1 class="text-3xl font-bold text-cyan-300 font-orbitron mb-2">
            <i class="fas fa-qrcode mr-3"></i>CHECK-IN TIKET
        </h1>
        <p class="text-gray-400">Input nomor tiket atau scan QR code untuk proses check-in</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glow-card rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-cyan-300 mb-4">
                <i class="fas fa-keyboard mr-2"></i>Input Manual
            </h2>

            <form action="{{ route('admin.checkin.process') }}" method="POST" class="space-y-4" id="manualForm">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-cyan-200 mb-2">
                        <i class="fas fa-ticket-alt mr-2"></i>Nomor Tiket
                    </label>
                    <input type="text" name="ticket_number" required 
                        class="w-full px-4 py-3 bg-gray-800 border border-cyan-500 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300"
                        placeholder="Contoh: TXABC12320241119"
                        autofocus
                        id="ticketInput">
                </div>

                <button type="submit" 
                    class="w-full py-3 bg-gradient-to-r from-green-500 to-cyan-600 rounded-lg text-white font-bold text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-green-500/25">
                    <i class="fas fa-check-circle mr-2"></i>PROSES CHECK-IN
                </button>
            </form>
        </div>

        <div class="glow-card rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-cyan-300 mb-4">
                <i class="fas fa-camera mr-2"></i>QR Code Scanner
            </h2>
            
            <div class="text-center">
                <div id="scanner-container" class="relative">
                    <div id="qr-scanner" class="w-full h-64 bg-black rounded-lg mb-4 overflow-hidden">
                        <video id="qr-video" class="w-full h-full object-cover" playsinline></video>
                        <div id="qr-overlay" class="absolute inset-0 flex items-center justify-center">
                            <div class="scanner-frame border-2 border-cyan-400 rounded-lg w-48 h-48 relative">
                                <div class="scanner-line"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="scanner-controls" class="flex justify-center space-x-4 mb-4">
                        <button id="start-scanner" 
                            class="px-4 py-2 bg-cyan-600 rounded-lg text-white font-semibold transition-all duration-300 hover:bg-cyan-500">
                            <i class="fas fa-play mr-2"></i>Start Scanner
                        </button>
                        <button id="stop-scanner" 
                            class="px-4 py-2 bg-red-600 rounded-lg text-white font-semibold transition-all duration-300 hover:bg-red-500">
                            <i class="fas fa-stop mr-2"></i>Stop Scanner
                        </button>
                        <button id="switch-camera" 
                            class="px-4 py-2 bg-purple-600 rounded-lg text-white font-semibold transition-all duration-300 hover:bg-purple-500">
                            <i class="fas fa-sync mr-2"></i>Switch Camera
                        </button>
                    </div>
                    
                    <div id="scanner-status" class="text-sm text-cyan-300 mb-2">
                        Scanner siap
                    </div>
                </div>
                
                <p class="text-gray-400 text-sm">
                    Arahkan kamera ke QR code pada tiket untuk scan otomatis
                </p>
            </div>
        </div>
    </div>

    <div class="glow-card rounded-2xl p-6">
        <h2 class="text-xl font-semibold text-cyan-300 mb-4">
            <i class="fas fa-history mr-2"></i>Check-in Terbaru
        </h2>
        
        <div class="space-y-3">
            @php
                $recentCheckins = \App\Models\Ticket::where('is_checked_in', true)
                    ->orderBy('checked_in_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            
            @if($recentCheckins->count() > 0)
                @foreach($recentCheckins as $checkin)
                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-800/50">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-white">{{ $checkin->name }}</p>
                            <p class="text-xs text-gray-400">{{ $checkin->ticket_number }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-cyan-300">{{ $checkin->checked_in_at->format('H:i') }}</p>
                        <p class="text-xs text-gray-400">{{ $checkin->checked_in_at->format('d/m/Y') }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-8">
                    <i class="fas fa-ticket-alt text-gray-500 text-4xl mb-3"></i>
                    <p class="text-gray-400">Belum ada check-in hari ini</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

<script>
class QRScanner {
    constructor() {
        this.video = document.getElementById('qr-video');
        this.canvas = document.createElement('canvas');
        this.context = this.canvas.getContext('2d');
        this.isScanning = false;
        this.stream = null;
        this.currentFacingMode = 'environment'; 
        this.scanInterval = null;
        
        this.initializeElements();
        this.setupEventListeners();
    }

    initializeElements() {
        this.startButton = document.getElementById('start-scanner');
        this.stopButton = document.getElementById('stop-scanner');
        this.switchButton = document.getElementById('switch-camera');
        this.statusElement = document.getElementById('scanner-status');
        this.ticketInput = document.getElementById('ticketInput');
    }

    setupEventListeners() {
        this.startButton.addEventListener('click', () => this.startScanner());
        this.stopButton.addEventListener('click', () => this.stopScanner());
        this.switchButton.addEventListener('click', () => this.switchCamera());
    }

    async startScanner() {
        try {
            this.statusElement.textContent = 'Mengakses kamera...';
            this.statusElement.className = 'text-sm text-yellow-300 mb-2';

            const constraints = {
                video: {
                    facingMode: this.currentFacingMode,
                    width: { ideal: 640 },
                    height: { ideal: 480 }
                }
            };

            this.stream = await navigator.mediaDevices.getUserMedia(constraints);
            this.video.srcObject = this.stream;
            
            await this.video.play();
            
            this.isScanning = true;
            this.statusElement.textContent = 'Scanner aktif - Arahkan ke QR code';
            this.statusElement.className = 'text-sm text-green-300 mb-2';
            
            this.startButton.disabled = true;
            this.stopButton.disabled = false;
            
            this.startScanning();
            
        } catch (error) {
            console.error('Error accessing camera:', error);
            this.statusElement.textContent = 'Error: Tidak dapat mengakses kamera';
            this.statusElement.className = 'text-sm text-red-300 mb-2';
            this.showCameraError(error);
        }
    }

    stopScanner() {
        this.isScanning = false;
        
        if (this.scanInterval) {
            clearInterval(this.scanInterval);
        }
        
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
            this.stream = null;
        }
        
        this.video.srcObject = null;
        
        this.statusElement.textContent = 'Scanner dihentikan';
        this.statusElement.className = 'text-sm text-gray-300 mb-2';
        
        this.startButton.disabled = false;
        this.stopButton.disabled = true;
    }

    async switchCamera() {
        this.stopScanner();
        this.currentFacingMode = this.currentFacingMode === 'environment' ? 'user' : 'environment';
        
        // Small delay before restarting
        setTimeout(() => {
            this.startScanner();
        }, 500);
    }

    startScanning() {
        this.scanInterval = setInterval(() => {
            if (this.video.readyState === this.video.HAVE_ENOUGH_DATA) {
                this.canvas.width = this.video.videoWidth;
                this.canvas.height = this.video.videoHeight;
                
                this.context.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);
                
                const imageData = this.context.getImageData(0, 0, this.canvas.width, this.canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);
                
                if (code) {
                    this.handleQRCodeDetected(code.data);
                }
            }
        }, 100); 
    }

    handleQRCodeDetected(data) {
        console.log('QR Code detected:', data);
        
        if (this.isValidTicketNumber(data)) {
            this.statusElement.textContent = ' QR Code berhasil di-scan!';
            this.statusElement.className = 'text-sm text-green-300 mb-2';
            
            this.ticketInput.value = data;
            this.autoSubmitForm(data);
            
            this.stopScanner();
        } else {
            this.statusElement.textContent = ' QR Code tidak valid';
            this.statusElement.className = 'text-sm text-red-300 mb-2';
            
            setTimeout(() => {
                if (this.isScanning) {
                    this.statusElement.textContent = 'Scanner aktif - Arahkan ke QR code';
                    this.statusElement.className = 'text-sm text-green-300 mb-2';
                }
            }, 2000);
        }
    }

    isValidTicketNumber(data) {
        const ticketPattern = /^TX[A-Z0-9]{8}\d{8}$/;
        return ticketPattern.test(data);
    }

    autoSubmitForm(ticketNumber) {
        this.statusElement.textContent = '🔄 Memproses check-in...';
        
        const formData = new FormData();
        formData.append('ticket_number', ticketNumber);
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        fetch('{{ route("admin.checkin.process") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.showSuccessMessage(data.message);
                this.ticketInput.value = '';
            } else {
                this.showErrorMessage(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.showErrorMessage('Terjadi kesalahan saat check-in');
        });
    }

    showSuccessMessage(message) {
        this.showNotification('success', 'Check-in Berhasil', message);
        
        setTimeout(() => {
            location.reload();
        }, 2000);
    }

    showErrorMessage(message) {
        this.showNotification('error', 'Check-in Gagal', message);
        
        setTimeout(() => {
            if (this.isScanning) {
                this.statusElement.textContent = 'Scanner aktif - Arahkan ke QR code';
                this.statusElement.className = 'text-sm text-green-300 mb-2';
            }
        }, 3000);
    }

    showNotification(type, title, message) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 glow-card p-4 rounded-lg border-l-4 z-50 ${
            type === 'success' ? 'border-green-500' : 'border-red-500'
        }`;
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle text-${type === 'success' ? 'green' : 'red'}-400 text-xl"></i>
                <div>
                    <p class="font-semibold text-white">${title}</p>
                    <p class="text-sm text-gray-300">${message}</p>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }

    showCameraError(error) {
        let errorMessage = 'Tidak dapat mengakses kamera. ';
        
        if (error.name === 'NotAllowedError') {
            errorMessage += 'Izin kamera ditolak. Silakan izinkan akses kamera.';
        } else if (error.name === 'NotFoundError') {
            errorMessage += 'Kamera tidak ditemukan.';
        } else if (error.name === 'NotSupportedError') {
            errorMessage += 'Browser tidak mendukung akses kamera.';
        } else {
            errorMessage += error.message;
        }
        
        this.showNotification('error', 'Kamera Error', errorMessage);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    window.qrScanner = new QRScanner();
    
    const styles = `
        .scanner-frame {
            position: relative;
            box-shadow: 0 0 0 4000px rgba(0, 0, 0, 0.7);
        }
        
        .scanner-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #00f3ff, transparent);
            animation: scanLine 2s linear infinite;
        }
        
        @keyframes scanLine {
            0% { top: 0; }
            50% { top: 100%; }
            100% { top: 0; }
        }
        
        #qr-overlay {
            pointer-events: none;
        }
    `;
    
    const styleSheet = document.createElement('style');
    styleSheet.textContent = styles;
    document.head.appendChild(styleSheet);
});
</script>

<style>
#qr-scanner {
    position: relative;
    background: #000;
}

#scanner-controls button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.scanner-frame {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(0, 243, 255, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(0, 243, 255, 0); }
    100% { box-shadow: 0 0 0 0 rgba(0, 243, 255, 0); }
}
</style>

@if(session('success'))
@endif

@if(session('error'))
@endif
@endsection