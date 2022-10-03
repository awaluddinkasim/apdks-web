<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Konsultasi;
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

    public function konsultasi(Request $request)
    {
        $id = $request->user()->id;

        foreach ($request->keluhan as $keluhan) {
            $konsultasi = new Konsultasi();
            $konsultasi->id_user = $id;
            $konsultasi->id_gejala = $keluhan['id'];
            $konsultasi->keluhan = $keluhan['answer'];
            $konsultasi->save();
        }

        return response()->json([
            'message' => 'Berhasil'
        ], 200);
    }
}
