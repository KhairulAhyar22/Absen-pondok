<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwals';

    public function pondok()
    {
        return $this->belongsTo(Pondok::class, 'pondok_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'jadwal_id');
    }
}
