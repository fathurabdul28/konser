<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalTickets = Ticket::count();
        $checkedIn = Ticket::where('is_checked_in', true)->count();
        $notCheckedIn = Ticket::where('is_checked_in', false)->count();
        $attendanceRate = $totalTickets > 0 ? round(($checkedIn / $totalTickets) * 100, 2) : 0;

        $recentTickets = Ticket::latest()->take(5)->get();
        
        $todayCheckins = Ticket::whereDate('checked_in_at', Carbon::today())->count();
        $revenue = Ticket::sum('price');
        $todayRevenue = Ticket::whereDate('created_at', Carbon::today())->sum('price');

        $stats = [
            'total' => $totalTickets,
            'checked_in' => $checkedIn,
            'not_checked_in' => $notCheckedIn,
            'attendance_rate' => $attendanceRate,
            'today_checkins' => $todayCheckins,
            'revenue' => $revenue,
            'today_revenue' => $todayRevenue
        ];

        return view('admin.dashboard', compact('stats', 'recentTickets'));
    }
}