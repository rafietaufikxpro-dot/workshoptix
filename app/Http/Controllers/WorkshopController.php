<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Registration;
use App\Models\Workshop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WorkshopController extends Controller
{
    /**
     * Daftar workshop untuk peserta.
     */
    public function index(): View
    {
        $workshops = Workshop::upcoming()->orderBy('starts_at')->get();

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

        // Lock baris workshop agar dua pendaftaran bersamaan tidak melebihi kuota.
        try {
            $registration = DB::transaction(function () use ($request, $workshop) {
                $workshop = Workshop::lockForUpdate()->findOrFail($workshop->id);

                if ($workshop->hasStarted()) {
                    throw new \InvalidArgumentException('Workshop ini sudah dimulai, pendaftaran ditutup.');
                }

                if ($workshop->seatsLeft() <= 0) {
                    throw new \InvalidArgumentException('Kuota workshop ini sudah penuh.');
                }

                return Registration::create([
                    'user_id' => $request->user()->id,
                    'workshop_id' => $workshop->id,
                    'amount' => $workshop->price,
                    'payment_status' => 'pending',
                ]);
            });
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('registrations.show', $registration)
            ->with('status', 'Pendaftaran dibuat. Selesaikan pembayaran untuk mendapatkan tiket.');
    }
}
