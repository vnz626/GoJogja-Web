<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
        public function authorize(): bool
    {
        // Ubah jadi true agar request ini bisa dijalankan
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'gender' => ['nullable', 'in:Laki-laki,Perempuan'],
            'date_of_birth' => ['nullable', 'date'],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // max 2MB
        ];
    }
}
