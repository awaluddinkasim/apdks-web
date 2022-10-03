<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Stadium extends Model
{
    use HasFactory;
    protected $table = 'kanker_serviks';

    public function relasi()
    {
        return $this->hasMany(Relasi::class, 'id_kanker_serviks');
    }
}
