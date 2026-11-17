<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Tiket digital hanya untuk pemilik dan hanya setelah lunas (FR-24).
     */
    public function show(Registration $registration): View|RedirectResponse
    {
        $this->authorize('view', $registration);

        if ($registration->payment_status !== 'paid') {
            return redirect()->route('registrations.show', $registration)
                ->with('error', 'Tiket hanya tersedia setelah pembayaran lunas.');
        }

        return view('registrations.ticket', compact('registration'));
    }
}
