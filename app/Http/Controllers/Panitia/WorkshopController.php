<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkshopRequest;
use App\Models\Workshop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $workshops = Workshop::withCount('registrations')->latest()->get();

        return view('panitia.workshops.index', compact('workshops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('panitia.workshops.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkshopRequest $request): RedirectResponse
    {
        $workshop = Workshop::create([
            'title' => $request->title,
            'description' => $request->description,
            'speaker' => $request->speaker,
            'venue' => $request->venue,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'price' => $request->price,
            'quota' => $request->quota,
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('panitia.workshops.index')
            ->with('success', "Workshop {$workshop->title} berhasil ditambahkan.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workshop $workshop): View
    {
        return view('panitia.workshops.edit', compact('workshop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkshopRequest $request, Workshop $workshop): RedirectResponse
    {
        $workshop->update($request->validated());

        return redirect()->route('panitia.workshops.index')
            ->with('success', "Workshop {$workshop->title} berhasil diperbarui.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Workshop $workshop): RedirectResponse
    {
        // FR-10: workshop yang sudah punya pendaftaran tidak boleh dihapus.
        if ($workshop->registrations()->exists()) {
            return back()->with('error', 'Workshop ini sudah punya pendaftar dan tidak bisa dihapus.');
        }

        $workshop->delete();

        return redirect()->route('panitia.workshops.index')
            ->with('success', 'Workshop berhasil dihapus.');
    }
}
