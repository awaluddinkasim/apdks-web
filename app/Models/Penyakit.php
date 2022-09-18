<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;
    protected $table = 'penyakit';

    public function gejala()
    {
        return $this->hasManyThrough(Gejala::class, Relasi::class, 'id_penyakit', 'id_gejala');
    }
}
