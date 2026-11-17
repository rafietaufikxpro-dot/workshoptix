<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Workshop;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Ringkasan dashboard panitia (FR-27).
     */
    public function index(): View
    {
        $workshops = Workshop::all();
        $pendaftar = Registration::all();

        return view('panitia.dashboard', compact('workshops', 'pendaftar'));
    }
}
