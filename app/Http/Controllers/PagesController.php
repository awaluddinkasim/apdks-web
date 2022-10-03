<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\Relasi;
use App\Models\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function dashboard()
    {
        $data = [
            'pengguna' => User::all()->count(),
            'penyakit' => 0,
            'konsul' => 0,
        ];

        return view('pages.dashboard', $data);
    }

    public function masterData($jenis)
    {
        switch ($jenis) {
            case 'penyakit':
                $data = [
                    'daftarPenyakit' => Penyakit::orderBy('nama')->get()
                ];

                return view('pages.master-penyakit', $data);

            case 'gejala':
                $data = [
                    'daftarGejala' => Gejala::orderBy('keterangan')->get()
                ];

                return view('pages.master-gejala', $data);

            case 'relasi':
                $data = [
                    'daftarPenyakit' => Penyakit::orderBy('nama')->get(),
                    'daftarGejala' => Gejala::orderBy('keterangan')->get()
                ];

                return view('pages.master-relasi', $data);

            default:
                return redirect()->route('dashboard');
        }
    }

    public function masterDataStore(Request $request, $jenis)
    {
        switch ($jenis) {
            case 'penyakit':
                $penyakit = new Penyakit();
                $penyakit->nama = $request->nama;
                $penyakit->penyebab = $request->penyebab;
                $penyakit->keterangan = $request->keterangan;
                $penyakit->solusi = $request->solusi;
                $penyakit->save();

                return redirect()->back()->with('success', 'Input data berhasil');

            case 'gejala':
                $gejala = new Gejala();
                $gejala->keterangan = $request->gejala;
                $gejala->save();

                return redirect()->back()->with('success', 'Input data berhasil');

            case 'relasi':
                $relasi = new Relasi();
                $relasi->id_penyakit = $request->penyakit;
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
            case 'penyakit':
                Penyakit::find($request->id)->delete();

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
