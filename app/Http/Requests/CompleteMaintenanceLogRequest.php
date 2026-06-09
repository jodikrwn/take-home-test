<?php

namespace App\Http\Requests;

use App\Models\MaintenanceLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CompleteMaintenanceLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            /** @var MaintenanceLog $log */
            $log = $this->route('maintenanceLog');

            if ($log?->status === 'completed') {
                $validator->errors()->add(
                    'status',
                    'Servis ini sudah berstatus completed.'
                );
            }
        });
    }
}
