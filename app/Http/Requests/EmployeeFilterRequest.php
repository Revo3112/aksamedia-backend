<?php
// app/Http/Requests/EmployeeFilterRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'division_id' => 'sometimes|uuid|exists:divisions,id',
        ];
    }
}
