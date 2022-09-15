<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $remember = $request->remember ? true : false;

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $remember)) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('failed', 'Username atau Password salah');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
