<?php

namespace App\Services;

use App\Models\Ticket;

class TicketService
{
    public function detectPotentialFraud(Ticket $ticket)
    {
        $riskScore = 0;
        $flags = [];

        $duplicateId = Ticket::where('id_card', $ticket->id_card)
            ->where('id', '!=', $ticket->id)
            ->exists();
            
        if ($duplicateId) {
            $riskScore += 30;
            $flags[] = 'Duplicate ID card detected';
        }

        if ($this->isSuspiciousEmail($ticket->email)) {
            $riskScore += 20;
            $flags[] = 'Suspicious email pattern';
        }

        $multipleTickets = Ticket::where('phone', $ticket->phone)
            ->where('id', '!=', $ticket->id)
            ->count();
            
        if ($multipleTickets > 2) {
            $riskScore += 25;
            $flags[] = 'Multiple tickets with same phone number';
        }

        return [
            'risk_score' => $riskScore,
            'risk_level' => $this->getRiskLevel($riskScore),
            'flags' => $flags
        ];
    }

    private function isSuspiciousEmail($email)
    {
        $suspiciousPatterns = [
            '/temp\./',
            '/fake\./',
            '/test\./',
            '/throwaway/'
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $email)) {
                return true;
            }
        }

        return false;
    }

    private function getRiskLevel($score)
    {
        if ($score >= 70) return 'high';
        if ($score >= 40) return 'medium';
        return 'low';
    }
}