<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function gejala()
    {
        $data = [
            'daftarGejala' => Gejala::orderBy("keterangan")->get()
        ];

        return response()->json($data, 200);
    }
}
