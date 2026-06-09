<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaintenanceLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'ship_id'        => $this->ship_id,
            'tanggal_servis' => $this->tanggal_servis?->format('Y-m-d'),
            'jenis_servis'   => $this->jenis_servis,
            'biaya'          => $this->biaya,
            'status'         => $this->status,
        ];
    }
}
