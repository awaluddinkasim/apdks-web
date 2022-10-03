<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function userRegister(Request $request)
    {
        $user = new User();
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->tgl_lahir = $request->tgl_lahir;
        $user->save();

        return response()->json([
            'message' => "success"
        ], 200);
    }

    public function userLogin(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('auth-token')->plainTextToken;

                return response()->json([
                    'message' => 'Berhasil',
                    'user' => $user,
                    'token' => $token
                ], 200);
            }
        }

        return response()->json([
            'message' => 'Username atau Password salah'
        ], 401);
    }

    public function userLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil'
        ], 200);
    }
}
