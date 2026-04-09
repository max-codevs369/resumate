<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password; 

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'avatar'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,jfif', 'max:2048'],
            'is_active'  => ['boolean'],
            'is_premium' => ['boolean'],
            'password'   => [
                'required', 
                'confirmed', 
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama wajib diisi.',
            'name.max'           => 'Nama maksimal 255 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            
            'avatar.image'       => 'File harus berupa gambar.',
            'avatar.mimes'       => 'Format gambar harus JPG, JPEG, PNG, WEBP, atau JFIF.',
            'avatar.max'         => 'Ukuran gambar maksimal 2MB.',

            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal harus 8 karakter.',
            'password.letters'   => 'Password harus mengandung huruf.',
            'password.mixed'     => 'Password harus mengandung huruf besar dan kecil.',
            'password.numbers'   => 'Password harus mengandung angka.',
            'password.symbols'   => 'Password harus mengandung simbol.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'  => $this->boolean('is_active'),
            'is_premium' => $this->boolean('is_premium'),
        ]);
    }
}