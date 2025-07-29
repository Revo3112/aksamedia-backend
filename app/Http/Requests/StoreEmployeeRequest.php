<?php
// app/Http/Requests/StoreEmployeeRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'division' => 'required|uuid|exists:divisions,id',
            'position' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'name.required' => 'Nama harus diisi',
            'phone.required' => 'Nomor telepon harus diisi',
            'division.required' => 'Divisi harus dipilih',
            'division.exists' => 'Divisi tidak ditemukan',
            'position.required' => 'Posisi harus diisi',
        ];
    }
}
