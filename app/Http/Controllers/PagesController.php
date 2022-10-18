<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Dokter;
use App\Models\Gejala;
use App\Models\HasilKonsultasi;
use App\Models\Stadium;
use App\Models\Relasi;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class PagesController extends Controller
{
    public function dashboard()
    {
        $data = [
            'pengguna' => User::all()->count(),
            'gejala' => Gejala::all()->count(),
            'konsul' => HasilKonsultasi::all()->count(),
        ];

        return view('pages.dashboard', $data);
    }

    public function masterData(Request $request, $jenis)
    {
        switch ($jenis) {
            case 'stadium':
                if ($request->has('id')) {
                    $data = [
                        'kanker' => Stadium::find($request->id)
                    ];

                    return view('pages.master-kanker-edit', $data);
                }

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
                $romanStadium = is_numeric($request->stadium) ? numberToRoman($request->stadium) : strtoupper($request->stadium);

                $check = Stadium::where('stadium', $romanStadium)->first();
                if ($check) {
                    return redirect()->back()->with('failed', "Kanker dengan stadium tersebut sudah terinput sebelumnya");
                }

                $stadium = new Stadium();
                $stadium->stadium = $romanStadium;
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

    public function masterKankerUpdate(Request $request)
    {
        $kanker = Stadium::find($request->id);
        $kanker->keterangan = $request->keterangan;
        $kanker->solusi = $request->solusi;
        $kanker->update();

        return redirect()->route('master-data', 'stadium')->with('success', 'Update data berhasil');
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

    public function daftarPengguna(Request $request)
    {
        if ($request->has('id')) {
            $data = [
                'user' => User::find($request->id)
            ];

            return view('pages.user-edit', $data);
        }

        $data = [
            'users' => User::orderBy('nama')->get()
        ];

        return view('pages.users', $data);
    }

    public function penggunaUpdate(Request $request)
    {
        try {
            $user = User::find($request->id);
            $user->nama = $request->nama;
            $user->tgl_lahir = $request->tgl_lahir;
            $user->username = $request->username;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            return redirect()->route('users')->with('success', 'Update pengguna berhasil');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == "1062") {
                return redirect()->route('users')->with('failed', 'Username terdaftar pada akun lain');
            }
        }
    }

    public function penggunaDelete(Request $request)
    {
        User::find($request->id)->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus');
    }

    public function laporanStatistik()
    {
        $data = [
            'konsultasi' => HasilKonsultasi::all()->count(),
            'daftarGejala' => Gejala::orderBy('keterangan')->get(),
            'users' => User::all(),
        ];

        return view('pages.laporan-statistik', $data);
    }

    public function laporanDiagnosa()
    {
        $data = [
            'daftarKonsultasi' => HasilKonsultasi::all(),
        ];

        return view('pages.laporan-konsultasi', $data);
    }

    public function dokter()
    {
        $data = [
            'dokter' => Dokter::first()
        ];

        return view('pages.dokter', $data);
    }

    public function dokterUpdate(Request $request)
    {
        $file = $request->file('foto');
        if ($file) {
            $filename = 'profil.'.$file->extension();
        }

        $dokter = Dokter::first();

        if ($dokter) {
            $dokter->nama = $request->nama;
            $dokter->email = $request->email;
            $dokter->no_hp = $request->no_hp;
            if ($file) {
                File::delete(public_path('doctor/'.$dokter->foto));
                $file->move(public_path('doctor'), $filename);
                $dokter->foto = $filename;
            }
            $dokter->update();
        } else {
            $dokter = new Dokter();
            $dokter->nama = $request->nama;
            $dokter->email = $request->email;
            $dokter->no_hp = $request->no_hp;
            if ($file) {
                $file->move(public_path('doctor'), $filename);
                $dokter->foto = $filename;
            }
            $dokter->save();
        }

        return redirect()->back()->with('success', 'Update data berhasil');
    }

    public function laporanDiagnosaExport()
    {
        $data = [
            'daftarKonsultasi' => HasilKonsultasi::all(),
        ];

        $filename = 'laporan-'.time().'.pdf';
        $pdf = Pdf::loadView('export.pdf', $data)->setPaper('a4');

        return $pdf->download($filename);
    }

    public function profil()
    {
        return view('pages.profil');
    }

    public function profilUpdate(Request $request)
    {
        try {
            $admin = Admin::find(auth()->user()->id);
            $admin->nama = $request->nama;
            $admin->username = $request->username;
            if ($request->password) {
                $admin->password = bcrypt($request->password);
            }
            $admin->save();

            return redirect()->back()->with('success', 'Update profil berhasil');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == "1062") {
                return redirect()->route('users')->with('failed', 'Username terdaftar pada akun lain');
            }
        }
    }
}
