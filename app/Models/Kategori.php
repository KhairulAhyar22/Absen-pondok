<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'pondok_id',
        'nama',
        'deskripsi',
        'is_active',
    ];
    public function pondok()
    {
        return $this->belongsTo(Pondok::class, 'pondok_id');
    }

    public function pesertas()
    {
        return $this->belongsToMany(
            Peserta::class,
            'peserta_kategoris',
            'kategori_id',
            'peserta_id'
        )->withPivot('prioritas', 'is_active')
         ->withTimestamps();
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'kategori_id');
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'kategori_id');
    }
}
