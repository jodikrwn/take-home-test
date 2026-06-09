<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaintenanceLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ship_id'        => ['required', 'exists:ships,id'],
            'tanggal_servis' => ['required', 'date'],
            'jenis_servis'   => ['required', 'string', 'max:255'],
            'biaya'          => ['required', 'numeric', 'min:0'],
            'status'         => ['required', 'in:planned,ongoing,completed'],
        ];
    }
}
