<?php

namespace App\Http\Controllers;

use App\Models\Relasi;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function relasiGejala(Request $request)
    {
        $data = [
            'daftarRelasi' => Relasi::where('id_penyakit', $request->id)->get()->sortBy('gejala.keterangan')
        ];

        return view('ajax.relasi-gejala', $data);
    }
}
