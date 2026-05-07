<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
     protected $table = 'absensis';

    public $timestamps = false;

    protected $fillable = [
        'pondok_id',
        'peserta_id',
        'kategori_id',
        'jadwal_id',
        'tanggal',
        'waktu_scan',
        'status',
    ];

    public function pondok()
    {
        return $this->belongsTo(Pondok::class, 'pondok_id');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }
}
