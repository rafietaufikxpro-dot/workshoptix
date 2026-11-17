<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * Pendaftaran saya.
     */
    public function index(): View
    {
        $registrations = auth()->user()->registrations()->with('workshop')->latest()->get();

        return view('registrations.index', compact('registrations'));
    }

    /**
     * Status pendaftaran (hanya pemilik, lewat policy).
     */
    public function show(Registration $registration): View
    {
        $this->authorize('view', $registration);

        return view('registrations.show', compact('registration'));
    }
}
