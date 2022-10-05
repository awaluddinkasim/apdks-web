<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKonsultasi extends Model
{
    use HasFactory;
    protected $table = 'hasil_konsultasi';

    protected $with = ['kanker'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kanker()
    {
        return $this->belongsTo(Stadium::class, 'id_kanker_serviks');
    }
}
