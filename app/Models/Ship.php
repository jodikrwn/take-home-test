<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ship extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'kode_kapal', 'tahun_pembuatan'];

    protected $casts = [
        'tahun_pembuatan' => 'integer',
    ];

    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class);
    }

    public function latestMaintenanceLog(): HasOne
    {
        return $this->hasOne(MaintenanceLog::class)->latestOfMany('tanggal_servis');
    }
}
