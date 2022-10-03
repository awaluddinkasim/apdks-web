<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Stadium;
use App\Models\Relasi;
use App\Models\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function dashboard()
    {
        $data = [
            'pengguna' => User::all()->count(),
            'gejala' => Gejala::all()->count(),
            'konsul' => 0,
        ];

        return view('pages.dashboard', $data);
    }

    public function masterData($jenis)
    {
        switch ($jenis) {
            case 'stadium':
                $data = [
                    'daftarKanker' => Stadium::orderBy('stadium')->get()
                ];

                return view('pages.master-kanker', $data);

            case 'gejala':
                $data = [
                    'daftarGejala' => Gejala::orderBy('keterangan')->get()
                ];

                return view('pages.master-gejala', $data);

            case 'relasi':
                $data = [
                    'daftarKanker' => Stadium::orderBy('stadium')->get(),
                    'daftarGejala' => Gejala::doesntHave('relasi')->orderBy('keterangan')->get()
                ];

                return view('pages.master-relasi', $data);

            default:
                return redirect()->route('dashboard');
        }
    }

    public function masterDataStore(Request $request, $jenis)
    {
        switch ($jenis) {
            case 'stadium':
                $check = Stadium::where('stadium', $request->stadium)->first();
                if ($check) {
                    return redirect()->back()->with('failed', "Kanker dengan stadium tersebut sudah terinput sebelumnya");
                }

                $stadium = new Stadium();
                $stadium->stadium = $request->stadium;
                $stadium->penyebab = $request->penyebab;
                $stadium->keterangan = $request->keterangan;
                $stadium->solusi = $request->solusi;
                $stadium->save();

                return redirect()->back()->with('success', 'Input data berhasil');

            case 'gejala':
                $gejala = new Gejala();
                $gejala->keterangan = $request->gejala;
                $gejala->save();

                return redirect()->back()->with('success', 'Input data berhasil');

            case 'relasi':
                $check = Relasi::where('id_kanker_serviks', $request->penyakit)->first();

                if ($check) {
                    return redirect()->back()->with('failed', 'Gejala sudah terdaftar sebelumnya');
                }

                $relasi = new Relasi();
                $relasi->id_kanker_serviks = $request->stadium;
                $relasi->id_gejala = $request->gejala;
                $relasi->save();

                return redirect()->back()->with('success', 'Relasi berhasil ditambah');

            default:
                return redirect()->route('dashboard');
        }
    }

    public function masterDataDelete(Request $request, $jenis)
    {
        switch ($jenis) {
            case 'stadium':
                Stadium::find($request->id)->delete();

                return redirect()->back()->with('success', 'Data telah dihapus');

            case 'gejala':
                Gejala::find($request->id)->delete();

                return redirect()->back()->with('success', 'Data telah dihapus');

            case 'relasi':
                Relasi::find($request->id)->delete();

                return redirect()->back()->with('success', 'Relasi berhasil dihapus');

            default:
                return redirect()->route('dashboard');
        }
    }

    public function daftarPengguna()
    {
        $data = [
            'users' => User::orderBy('nama')->get()
        ];

        return view('pages.users', $data);
    }

    public function penggunaUpdate(Request $request)
    {
        return redirect()->back()->with('success', 'Update pengguna berhasil');
    }

    public function penggunaDelete(Request $request)
    {
        User::find($request->id)->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus');
    }

    public function laporanStatistik()
    {
        return view('pages.laporan-statistik');
    }

    public function laporanKonsultasi()
    {
        return view('pages.laporan-konsultasi');
    }

    public function profil()
    {
        return view('pages.profil');
    }
}
