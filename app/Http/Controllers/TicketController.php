<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TicketController extends Controller
{
    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'id_card' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'seat_type' => 'required|in:vip,festival,premium'
        ]);

        $ticketNumber = 'TX' . Str::upper(Str::random(8)) . Carbon::now()->format('Ymd');

        $prices = [
            'vip' => 500000,
            'premium' => 300000, 
            'festival' => 150000
        ];

        $ticketData = array_merge($validated, [
            'ticket_number' => $ticketNumber,
            'price' => $prices[$validated['seat_type']],
        ]);

        $ticket = Ticket::create($ticketData);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Tiket berhasil dipesan! Silakan simpan tiket ini untuk check-in.');
    }

    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    public function index(Request $request)
{
    $query = Ticket::query();

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('ticket_number', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    if ($request->has('status') && $request->status != '') {
        if ($request->status == 'checked_in') {
            $query->where('is_checked_in', true);
        } elseif ($request->status == 'not_checked_in') {
            $query->where('is_checked_in', false);
        }
    }

    if ($request->has('seat_type') && $request->seat_type != '') {
        $query->where('seat_type', $request->seat_type);
    }

    $tickets = $query->latest()->paginate(10);

    return view('admin.tickets.index', compact('tickets'));
    }

    public function edit(Ticket $ticket)
    {
        return view('admin.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'id_card' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'seat_type' => 'required|in:vip,festival,premium'
        ]);

        $ticket->update($validated);

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Data tiket berhasil diperbarui.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')
            ->with('success', 'Tiket berhasil dihapus.');
    }

    public function checkinForm()
    {
        return view('admin.checkin.form');
    }


    public function checkin(Request $request)
{
    $request->validate([
        'ticket_number' => 'required|string'
    ]);

    $ticket = Ticket::where('ticket_number', $request->ticket_number)->first();

    if (!$ticket) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'error' => 'Tiket tidak ditemukan.'
            ], 404);
        }
        return back()->with('error', 'Tiket tidak ditemukan.');
    }

    if ($ticket->is_checked_in) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'error' => 'Tiket sudah digunakan untuk check-in.'
            ], 400);
        }
        return back()->with('error', 'Tiket sudah digunakan untuk check-in.');
    }

    $ticket->update([
        'is_checked_in' => true,
        'checked_in_at' => now()
    ]);

 

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil! Penonton dipersilakan masuk.',
            'ticket' => [
                'name' => $ticket->name,
                'ticket_number' => $ticket->ticket_number,
                'seat_type' => $ticket->seat_type
            ]
        ]);
    }

    return view('admin.checkin.success', compact('ticket'))
        ->with('success', 'Check-in berhasil! Penonton dipersilakan masuk.');
    }

    public function reports()
    {
    $checkedIn = Ticket::where('is_checked_in', true)->get();
    $notCheckedIn = Ticket::where('is_checked_in', false)->get();
    
    $stats = [
        'total' => Ticket::count(),
        'checked_in' => $checkedIn->count(),
        'not_checked_in' => $notCheckedIn->count(),
        'attendance_rate' => Ticket::count() > 0 ? 
            round(($checkedIn->count() / Ticket::count()) * 100, 2) : 0
    ];

    return view('admin.reports.index', compact('checkedIn', 'notCheckedIn', 'stats'));
    }

    public function details(Ticket $ticket)
    {
        $html = view('admin.tickets.details', compact('ticket'))->render();
        
        return response()->json([
            'html' => $html
        ]);
    }

    
        private function generateQRCode($ticketNumber)
    {
        try {
            $qrCode = QrCode::format('png')
                ->size(200)
                ->margin(1)
                ->errorCorrection('H')
                ->generate($ticketNumber);
                
            $base64 = base64_encode($qrCode);
            return 'data:image/png;base64,' . $base64;
            
        } catch (\Exception $e) {
            return $this->generateSimpleQRBase64($ticketNumber);
        }
    }

    private function generateSimpleQRBase64($ticketNumber)
    {
        $image = imagecreate(200, 200);
        
        $white = imagecolorallocate($image, 255, 255, 255);
        $cyan = imagecolorallocate($image, 0, 243, 255);
        $purple = imagecolorallocate($image, 185, 103, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        
        imagefill($image, 0, 0, $white);
        
        for($i = 0; $i < 5; $i++) {
            imagerectangle($image, 5+$i, 5+$i, 195-$i, 195-$i, $cyan);
        }
        
        imagestring($image, 3, 60, 70, 'E-TICKET', $black);
        imagestring($image, 2, 40, 100, $ticketNumber, $black);
        imagestring($image, 1, 50, 130, 'Ulbi Fest', $purple);
        
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);
        
        return 'data:image/png;base64,' . base64_encode($imageData);
    }

    public function export($type = 'all')
{
    $query = Ticket::query();

    if ($type === 'checkedin') {
        $query->where('is_checked_in', true);
        $filename = 'tickets_checked_in_' . date('Y-m-d_H-i-s') . '.csv';
    } elseif ($type === 'notcheckedin') {
        $query->where('is_checked_in', false);
        $filename = 'tickets_pending_' . date('Y-m-d_H-i-s') . '.csv';
    } else {
        $filename = 'all_tickets_' . date('Y-m-d_H-i-s') . '.csv';
    }

    $tickets = $query->get();

    $headers = [
        'Content-Type' => 'text/csv; charset=utf-8',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        'Pragma' => 'no-cache',
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
        'Expires' => '0'
    ];

    $callback = function() use ($tickets) {
        $file = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fwrite($file, "\xEF\xBB\xBF");
        
        // Headers
        fputcsv($file, [
            'No. Tiket',
            'Nama Pemesan',
            'Email',
            'Telepon',
            'No. KTP',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Tipe Kursi',
            'Harga',
            'Status Check-in',
            'Waktu Check-in',
            'Tanggal Pemesanan'
        ], ';'); // Use semicolon as delimiter for better Excel compatibility

        // Data
        foreach ($tickets as $ticket) {
            fputcsv($file, [
                $ticket->ticket_number,
                $ticket->name,
                $ticket->email,
                $ticket->phone,
                $ticket->id_card,
                $ticket->birth_date->format('d/m/Y'),
                $ticket->gender == 'male' ? 'Laki-laki' : 'Perempuan',
                strtoupper($ticket->seat_type),
                number_format($ticket->price, 0, ',', '.'),
                $ticket->is_checked_in ? 'Sudah Check-in' : 'Belum Check-in',
                $ticket->checked_in_at ? $ticket->checked_in_at->format('d/m/Y H:i:s') : '-',
                $ticket->created_at->format('d/m/Y H:i:s')
            ], ';');
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
    
}