<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class WorkshopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->role === 'panitia';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'speaker' => ['required', 'string', 'max:255'],
            'venue' => ['required', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'price' => ['required', 'integer', 'min:1'],
            'quota' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Pesan error dalam Bahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul workshop wajib diisi.',
            'description.required' => 'Deskripsi workshop wajib diisi.',
            'image.image' => 'Foto harus berupa gambar.',
            'image.mimes' => 'Format foto harus JPG, PNG, atau WebP.',
            'image.max' => 'Ukuran foto maksimal 2 MB.',
            'speaker.required' => 'Nama pemateri wajib diisi.',
            'venue.required' => 'Lokasi workshop wajib diisi.',
            'starts_at.required' => 'Jadwal mulai wajib diisi.',
            'ends_at.required' => 'Jadwal selesai wajib diisi.',
            'ends_at.after' => 'Jadwal selesai harus setelah jadwal mulai.',
            'price.required' => 'Harga wajib diisi.',
            'price.integer' => 'Harga harus bilangan bulat.',
            'price.min' => 'Harga minimal Rp 1.',
            'quota.required' => 'Kuota wajib diisi.',
            'quota.integer' => 'Kuota harus bilangan bulat.',
            'quota.min' => 'Kuota minimal 1.',
        ];
    }
}
