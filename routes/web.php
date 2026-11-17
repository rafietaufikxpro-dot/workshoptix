<?php

use App\Http\Controllers\Panitia\DashboardController;
use App\Http\Controllers\Panitia\RegistrationController as PanitiaRegistrationController;
use App\Http\Controllers\Panitia\WorkshopController as PanitiaWorkshopController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WorkshopController;
use App\Models\Registration;
use App\Models\Workshop;
use Illuminate\Support\Facades\Route;

// PRD 7.6: `/` mengarahkan tamu ke login, yang sudah login sesuai peran.
Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    $role = auth()->user()->getAttributes()['role'] ?? null;

    return redirect()->route($role === 'panitia' ? 'panitia.dashboard' : 'workshops.index');
})->name('home');

// Landing page publik (dipisah dari `/` agar PRD 7.6 terpenuhi).
Route::get('/landing', function () {
    $workshops = Workshop::upcoming()->orderBy('starts_at')->get();

    return view('landing', [
        'workshops' => $workshops,
        'workshopCount' => $workshops->count(),
        'pesertaCount' => Registration::distinct('user_id')->count(),
        'tiketCount' => Registration::where('payment_status', 'paid')->count(),
    ]);
})->name('landing');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ---------------------------------------------------------------------------
// DUMMY — hapus di Langkah 03: rute pengganti sementara untuk tampilan saja.
// Nama rute mengikuti PRD 7.6 agar view tidak berubah saat disambungkan ke DB.
// ---------------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');

    Route::get('/workshops/{workshop}', [WorkshopController::class, 'show'])->name('workshops.show');

    Route::post('/workshops/{workshop}/register', [WorkshopController::class, 'register'])
        ->name('workshops.register');

    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');

    Route::get('/registrations/{registration}/ticket', [TicketController::class, 'show'])
        ->name('registrations.ticket');

    Route::post('/registrations/{registration}/pay', [PaymentController::class, 'pay'])
        ->name('registrations.pay');

    Route::post('/registrations/{registration}/check-status', [PaymentController::class, 'check'])
        ->name('registrations.check');

    Route::get('/registrations/{registration}', [RegistrationController::class, 'show'])
        ->name('registrations.show');

});

// Semua rute panitia wajib auth + role:panitia.
Route::middleware(['auth', 'role:panitia'])->prefix('panitia')->name('panitia.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/registrations', [PanitiaRegistrationController::class, 'index'])
        ->name('registrations.index');

    Route::resource('workshops', PanitiaWorkshopController::class)->except(['show']);
});

require __DIR__.'/auth.php';
