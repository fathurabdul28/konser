<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'name',
        'email', 
        'phone',
        'id_card',
        'birth_date',
        'gender',
        'seat_type',
        'price',
        'is_checked_in',
        'checked_in_at'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_checked_in' => 'boolean',
        'checked_in_at' => 'datetime',
        'price' => 'decimal:2'
    ];

    public function getQRCode()
    {
        try {
            $qrCode = QrCode::format('png')
                ->size(200)
                ->margin(1)
                ->errorCorrection('H')
                ->color(0, 0, 0)
                ->backgroundColor(255, 255, 255)
                ->generate($this->ticket_number);
                
            return 'data:image/png;base64,' . base64_encode($qrCode);
            
        } catch (\Exception $e) {
           $ticketData = urlencode($this->ticket_number);
            return "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={$ticketData}&format=png&margin=10";
        }
    }
}