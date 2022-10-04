<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;
    protected $table = 'gejala';

    public function relasi()
    {
        return $this->hasOne(Relasi::class, 'id_gejala');
    }

    public function keluhan()
    {
        return $this->hasMany(Konsultasi::class, 'id_gejala')->where('keluhan', 'Ya');
    }
}
