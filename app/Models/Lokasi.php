<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lokasi extends Model
{
    protected $table = 'tb_lokasi';

    protected $fillable = [
        'nama_lokasi',
        'latitude',
        'longitude',
    ];

    /**
     * Get the ruang records for this lokasi.
     */
    public function ruang(): HasMany
    {
        return $this->hasMany(Ruang::class, 'id_lokasi');
    }

    /**
     * Get the meteran records for this lokasi.
     */
    public function meteran(): HasMany
    {
        return $this->hasMany(Meteran::class, 'id_lokasi');
    }
}
