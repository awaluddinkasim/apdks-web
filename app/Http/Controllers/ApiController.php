<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\HasilKonsultasi;
use App\Models\Konsultasi;
use App\Models\Relasi;
use App\Models\Stadium;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function gejala()
    {
        $data = [
            'daftarGejala' => Gejala::has('relasi')->orderBy("keterangan")->get()
        ];

        return response()->json($data, 200);
    }

    public function konsultasi(Request $request)
    {
        $id = $request->user()->id;

        Konsultasi::where('id_user', $id)->delete();

        foreach ($request->keluhan as $keluhan) {
            $konsultasi = new Konsultasi();
            $konsultasi->id_user = $id;
            $konsultasi->id_gejala = $keluhan['id'];
            $konsultasi->keluhan = $keluhan['answer'];
            $konsultasi->save();
        }

        // Ambil data konsultasi
        $konsul = Konsultasi::where('id_user', $id)->get(['id_gejala', 'keluhan']);

        $kanker = [];

        // Loop konsultasi untuk menambah nilai setiap Stadium
        foreach ($konsul as $user) {
            $relasi = Relasi::where('id_gejala', $user->id_gejala)->first();

            // Nilai bertambah apabila keluhan = Ya
            if (array_key_exists($relasi->kanker->stadium, $kanker)) {
                if ($user->keluhan == "Ya") {
                    $kanker[$relasi->kanker->stadium] += 1;
                } else {
                    $kanker[$relasi->kanker->stadium] += 0;
                }
            } else {
                if ($user->keluhan == "Ya") {
                    $kanker[$relasi->kanker->stadium] = 1;
                } else {
                    $kanker[$relasi->kanker->stadium] = 0;
                }
            }
        }

        $hasil = [];

        // Loop hasil perhitungan konsultasi untuk menghitung persentase
        foreach (array_keys($kanker) as $result) {
            $res = Stadium::where('stadium', $result)->first();
            $hasil[$res->id] = $kanker[$result] / $res->relasi->count() * 100;
        }

        // Mengambil nilai maksimum dari angka stadium untuk
        // mengambil stadium tertinggi apabila ada lebih dari
        // satu yang memiliki persentase yang sama
        $maxValue = max($hasil);
        $maxKey = max(array_keys($hasil));

        $filterHasil = Arr::where($hasil, function($value, $key) use($maxValue, $maxKey) {
            return $value == $maxValue && $key == $maxKey;
        });

        $idKanker = array_keys($filterHasil)[0];
        $persentase = $filterHasil[$idKanker];

        // Dinyatakan positif apabila persentase lebih atau sama dengan nilai yang tercantum
        if ($persentase >= 80) {
            HasilKonsultasi::where('id_user', $id)->delete();

            $h = new HasilKonsultasi();
            $h->id_user = $id;
            $h->id_kanker_serviks = $idKanker;
            $h->resiko = 'tinggi';
            $h->save();
        } elseif ($persentase >= 50) {
            HasilKonsultasi::where('id_user', $id)->delete();

            $h = new HasilKonsultasi();
            $h->id_user = $id;
            $h->resiko = 'sedang';
            $h->save();
        } else {
            HasilKonsultasi::where('id_user', $id)->delete();

            $h = new HasilKonsultasi();
            $h->id_user = $id;
            $h->save();
        }

        return response()->json([
            'message' => 'Berhasil',
            'hasil' => $hasil,
        ], 200);
    }

    public function hasil(Request $request)
    {
        $id = $request->user()->id;
        $hasil = HasilKonsultasi::where('id_user', $id)->first();

        return response()->json([
            'message' => 'Berhasil',
            'hasil' => $hasil,
        ], 200);
    }

    public function updateProfil(Request $request)
    {
        $user = User::find($request->user()->id);
        $user->username = $request->username;
        if ($request->has('password')) {
            $user->username = bcrypt($request->username);
        }
        $user->nama = $request->nama;
        $user->tgl_lahir = $request->tgl_lahir;
        $user->save();

        return response()->json([
            'message' => 'Berhasil',
            'user' => $user,
        ], 200);
    }
}
