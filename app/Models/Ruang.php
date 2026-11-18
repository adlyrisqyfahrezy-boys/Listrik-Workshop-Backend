<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruang extends Model
{
    protected $table = 'tb_ruang';

    protected $fillable = [
        'nama_ruang',
        'id_lokasi',
    ];

    /**
     * Get the lokasi that owns this ruang.
     */
    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }

    /**
     * Get the perangkat records for this ruang.
     */
    public function perangkat(): HasMany
    {
        return $this->hasMany(Perangkat::class, 'id_ruang');
    }
}
