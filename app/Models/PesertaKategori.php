<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaKategori extends Model
{
    protected $table = 'peserta_kategoris';

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}