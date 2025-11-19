<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/admin/login');
        }

        if (Auth::check() && Auth::user()->is_active) {
            return $next($request);
        }

        return redirect('/admin/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}