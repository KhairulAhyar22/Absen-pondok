<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pondok extends Model
{
    protected $table = 'pondoks';
    protected $fillable = [
        'nama',
        'kode',
        'alamat',
        'telepon',
        'is_active',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'pondok_id');
    }

    public function pesertas()
    {
        return $this->hasMany(Peserta::class, 'pondok_id');
    }

    public function kategoris()
    {
        return $this->hasMany(Kategori::class, 'pondok_id');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'pondok_id');
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'pondok_id');
    }
}
