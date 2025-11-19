<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', function () {
    return redirect()->route('tickets.create');
});

Route::get('/booking', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/booking', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/ticket/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

// Admin auth routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// Admin protected routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Ticket management
    Route::get('/tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('admin.tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('admin.tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('admin.tickets.destroy');
    
    // Check-in
    Route::get('/checkin', [TicketController::class, 'checkinForm'])->name('admin.checkin.form');
    Route::post('/checkin', [TicketController::class, 'checkin'])->name('admin.checkin.process');
    
    // Reports
    Route::get('/reports', [TicketController::class, 'reports'])->name('admin.reports');
    // Check-in routes
    Route::get('/admin/checkin', [TicketController::class, 'checkinForm'])->name('admin.checkin.form');
    Route::post('/admin/checkin', [TicketController::class, 'checkin'])->name('admin.checkin.process');
    // routes/web.php - Tambahkan route ini
    Route::get('/admin/tickets/{ticket}/details', [TicketController::class, 'details'])->name('admin.tickets.details');
    Route::get('/admin/reports/export/{type}', [TicketController::class, 'export'])->name('admin.reports.export');
});