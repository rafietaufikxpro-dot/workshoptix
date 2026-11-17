<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * Daftar pendaftar untuk panitia (FR-11, FR-28).
     *
     * Versi EAGER: relasi user & workshop di-load sekali (FR-29).
     * Jumlah query dicatat di docs/query-comparison.md.
     */
    public function index(): View
    {
        $pendaftar = Registration::with(['user', 'workshop'])->get();

        return view('panitia.registrations.index', compact('pendaftar'));
    }
}
