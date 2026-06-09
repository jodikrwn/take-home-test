<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'min_biaya' => ['nullable', 'numeric', 'min:0'],
            'max_biaya' => ['nullable', 'numeric', 'gte:min_biaya'],
            'status'    => ['nullable', 'in:planned,ongoing,completed'],
        ];
    }
}
