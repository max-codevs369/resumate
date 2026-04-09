<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', "unique:users,email,{$userId}"],
            'avatar'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,jfif', 'max:2048'],
            'is_active'  => ['boolean'],
            'is_premium' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Nama wajib diisi.',
            'name.max'       => 'Nama maksimal 255 karakter.',
            
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah digunakan oleh user lain.',
            
            'avatar.image'   => 'File harus berupa gambar.',
            'avatar.mimes'   => 'Format gambar harus JPG, JPEG, PNG, WEBP, atau JFIF.',
            'avatar.max'     => 'Ukuran gambar maksimal 2MB.',
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