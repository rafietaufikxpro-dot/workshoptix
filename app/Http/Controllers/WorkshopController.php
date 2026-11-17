<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Registration;
use App\Models\Workshop;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkshopController extends Controller
{
    /**
     * Daftar workshop untuk peserta.
     */
    public function index(): View
    {
        $workshops = Workshop::orderBy('starts_at')->get();

        return view('workshops.index', compact('workshops'));
    }

    /**
     * Detail workshop.
     */
    public function show(Workshop $workshop): View
    {
        return view('workshops.show', compact('workshop'));
    }

    /**
     * Peserta mendaftar workshop (FR-14, FR-15, FR-16).
     */
    public function register(RegistrationRequest $request, Workshop $workshop): RedirectResponse
    {
        // Hanya peserta yang boleh mendaftar (policy).
        $this->authorize('create', Registration::class);

        if ($workshop->hasStarted()) {
            return back()->with('error', 'Workshop ini sudah dimulai, pendaftaran ditutup.');
        }

        if ($workshop->seatsLeft() <= 0) {
            return back()->with('error', 'Kuota workshop ini sudah penuh.');
        }

        $registration = Registration::create([
            'user_id' => $request->user()->id,
            'workshop_id' => $workshop->id,
            'amount' => $workshop->price,
            'payment_status' => 'pending',
        ]);

        return redirect()->route('registrations.show', $registration)
            ->with('status', 'Pendaftaran dibuat. Selesaikan pembayaran untuk mendapatkan tiket.');
    }
}
