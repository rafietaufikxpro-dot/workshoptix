<?php

namespace App\Http\Requests;

use App\Models\Workshop;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    /**
     * Ambil id workshop dari parameter rute, bukan dari input klien.
     */
    protected function prepareForValidation(): void
    {
        $workshop = $this->route('workshop');

        $this->merge([
            'workshop_id' => $workshop instanceof Workshop ? $workshop->id : $workshop,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'workshop_id' => [
                'required',
                Rule::exists('workshops', 'id'),
                // FR-15: satu pendaftaran per (user, workshop); unique di migration sebagai cadangan.
                Rule::unique('registrations', 'workshop_id')
                    ->where(fn ($query) => $query->where('user_id', $this->user()?->id)),
            ],
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
            'workshop_id.exists' => 'Workshop tidak ditemukan.',
            'workshop_id.unique' => 'Kamu sudah terdaftar di workshop ini.',
        ];
    }
}
