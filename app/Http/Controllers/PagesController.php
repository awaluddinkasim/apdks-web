<?php

namespace App\Http\Controllers;

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
                return view('pages.master-penyakit');

            case 'gejala':
                return view('pages.master-gejala');

            case 'relasi':
                return view('pages.master-relasi');

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

    public function profil()
    {
        return view('pages.profil');
    }
}
