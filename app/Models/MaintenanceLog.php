<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceLog extends Model
{
    use HasFactory;

    public const JENIS_SERVIS = [
        'Overhaul Mesin',
        'Penggantian Baling-baling',
        'Perbaikan Lambung',
        'Kalibrasi Navigasi',
        'Servis Sistem Kemudi',
        'Pemeriksaan Kelistrikan',
        'Pengecatan Ulang',
        'Penggantian Filter BBM',
        'Servis Pompa Air',
        'Inspeksi Rutin',
    ];

    protected $fillable = [
        'ship_id',
        'tanggal_servis',
        'jenis_servis',
        'biaya',
        'status',
    ];

    protected $casts = [
        'tanggal_servis' => 'date',
        'biaya'          => 'decimal:2',
    ];

    public function ship(): BelongsTo
    {
        return $this->belongsTo(Ship::class);
    }
}
