<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perangkat extends Model
{
    protected $table = 'tb_perangkat';

    protected $fillable = [
        'id_ruang',
        'nama_perangkat',
        'jumlah',
        'uom',
        'daya',
        'total_daya',
    ];

    /**
     * Get the ruang that owns this perangkat.
     */
    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class, 'id_ruang');
    }

    /**
     * Automatically calculate total_daya before saving.
     */
    protected static function booted(): void
    {
        static::saving(function (Perangkat $perangkat): void {
            $perangkat->total_daya = $perangkat->jumlah * $perangkat->daya;
        });
    }
}
