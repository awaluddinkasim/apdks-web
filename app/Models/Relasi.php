<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relasi extends Model
{
    use HasFactory;
    protected $table = 'relasi';

    public function kanker()
    {
        return $this->belongsTo(Stadium::class, 'id_kanker_serviks');
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class, 'id_gejala');
    }
}
