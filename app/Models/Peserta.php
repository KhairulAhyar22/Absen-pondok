<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'pesertas';
    protected $fillable = [
        'pondok_id',
        'nama',
        'rfid',
        'deskripsi',
        'is_active',
    ];

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
    protected static function booted()
    {
        static::saving(function ($peserta) {

            if (! $peserta->exists) {
                return;
            }

            $kategoris = $peserta->kategoris()->get();

            $prioritas = $kategoris->pluck('pivot.prioritas')->toArray();

            if (count($prioritas) !== count(array_unique($prioritas))) {
                throw new \Exception('Prioritas kategori tidak boleh sama dalam satu peserta.');
            }
        });
    }
}
