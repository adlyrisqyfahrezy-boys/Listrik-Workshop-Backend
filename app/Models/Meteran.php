<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meteran extends Model
{
    protected $table = 'tb_meteran';

    protected $fillable = [
        'id_lokasi',
        'nama_meteran',
        'maks_watt',
    ];

    /**
     * Get the lokasi that owns this meteran.
     */
    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }
}
