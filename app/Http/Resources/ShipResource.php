<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'nama'                  => $this->nama,
            'kode_kapal'            => $this->kode_kapal,
            'tahun_pembuatan'       => $this->tahun_pembuatan,
            'total_biaya_servis'    => number_format((float) ($this->total_biaya_servis ?? 0), 2, '.', ''),
            'servis_terakhir'       => $this->latestMaintenanceLog ? new MaintenanceLogResource($this->latestMaintenanceLog) : null,
        ];
    }
}
