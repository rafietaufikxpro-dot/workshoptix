<?php

use App\Http\Controllers\ProfileController;
use App\Support\DummyData;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------------------------------------------------------------------
// DUMMY — hapus di Langkah 03: rute pengganti sementara untuk tampilan saja.
// Nama rute mengikuti PRD 7.6 agar view tidak berubah saat disambungkan ke DB.
// ---------------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/workshops', fn () => view('workshops.index', [
        'workshops' => DummyData::workshops(),
    ]))->name('workshops.index');

    Route::get('/workshops/{workshop}', fn ($workshop) => view('workshops.show', [
        'workshop' => DummyData::workshop($workshop),
    ]))->name('workshops.show');

    Route::post('/workshops/{workshop}/register', function ($workshop) {
        return back()->with('error', 'Langkah 02: data dummy, pendaftaran belum disimpan.');
    })->name('workshops.register');

    Route::get('/registrations', fn () => view('registrations.index', [
        'registrations' => DummyData::registrations(),
    ]))->name('registrations.index');

    Route::get('/registrations/{registration}/ticket', fn ($registration) => view('registrations.ticket', [
        'registration' => DummyData::registration($registration),
    ]))->name('registrations.ticket');

    Route::post('/registrations/{registration}/pay', function ($registration) {
        return back()->with('status', 'Langkah 02: pembayaran dummy, Snap belum dipanggil.');
    })->name('registrations.pay');

    Route::post('/registrations/{registration}/check-status', function ($registration) {
        return back()->with('status', 'Langkah 02: pengecekan status dummy.');
    })->name('registrations.check');

    Route::get('/registrations/{registration}', fn ($registration) => view('registrations.show', [
        'registration' => DummyData::registration($registration),
    ]))->name('registrations.show');

    Route::prefix('panitia')->name('panitia.')->group(function () {
        Route::get('/dashboard', fn () => view('panitia.dashboard', [
            'workshops' => DummyData::workshops(),
            'pendaftar' => DummyData::pendaftar(),
        ]))->name('dashboard');

        Route::get('/workshops', fn () => view('panitia.workshops.index', [
            'workshops' => DummyData::workshops(),
        ]))->name('workshops.index');

        Route::get('/workshops/create', fn () => view('panitia.workshops.create'))->name('workshops.create');

        Route::post('/workshops', function () {
            return redirect()->route('panitia.workshops.index')
                ->with('success', 'Langkah 02: workshop dummy "tersimpan" (belum ke database).');
        })->name('workshops.store');

        Route::get('/workshops/{workshop}/edit', fn ($workshop) => view('panitia.workshops.edit', [
            'workshop' => DummyData::workshop($workshop),
        ]))->name('workshops.edit');

        Route::put('/workshops/{workshop}', function ($workshop) {
            return redirect()->route('panitia.workshops.index')
                ->with('success', 'Langkah 02: perubahan workshop dummy.');
        })->name('workshops.update');

        Route::delete('/workshops/{workshop}', function ($workshop) {
            return redirect()->route('panitia.workshops.index')
                ->with('success', 'Langkah 02: penghapusan workshop dummy.');
        })->name('workshops.destroy');

        Route::get('/registrations', fn () => view('panitia.registrations.index', [
            'pendaftar' => DummyData::pendaftar(),
        ]))->name('registrations.index');
    });
});

require __DIR__.'/auth.php';
