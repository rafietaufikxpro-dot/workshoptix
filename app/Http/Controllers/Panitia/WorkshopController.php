<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkshopRequest;
use App\Models\Workshop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request);
        }

        $workshop = Workshop::create($data);

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
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $oldImage = $workshop->image;
            $data['image'] = $this->storeImage($request);
        }

        $workshop->update($data);

        if (($oldImage ?? null) && $oldImage !== ($workshop->image ?? null)) {
            $this->deleteImage($oldImage);
        }

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

        $this->deleteImage($workshop->image);
        $workshop->delete();

        return redirect()->route('panitia.workshops.index')
            ->with('success', 'Workshop berhasil dihapus.');
    }

    /**
     * Simpan foto workshop ke public/workshops dan kembalikan nama file.
     */
    protected function storeImage(Request $request): string
    {
        $directory = public_path('uploads/workshops');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = Str::uuid()->toString().'.'.$request->file('image')->extension();

        $request->file('image')->move($directory, $filename);

        return $filename;
    }

    /**
     * Hapus foto lama bila ada.
     */
    protected function deleteImage(?string $filename): void
    {
        if (! $filename) {
            return;
        }

        $path = public_path('uploads/workshops/'.$filename);

        if (is_file($path)) {
            unlink($path);
        }
    }
}
