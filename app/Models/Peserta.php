<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'pesertas';

    public function pondok()
    {
        return $this->belongsTo(Pondok::class, 'pondok_id');
    }

    public function kategoris()
    {
        return $this->belongsToMany(
            Kategori::class,
            'peserta_kategoris',
            'peserta_id',
            'kategori_id'
        )->withPivot('prioritas', 'is_active')
         ->withTimestamps();
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'peserta_id');
    }
}
