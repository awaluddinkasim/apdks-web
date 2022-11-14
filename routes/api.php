<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'userLogin']);
Route::post('/register', [AuthController::class, 'userRegister']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', function (Request $request) {
        return response()->json([
            'user' => $request->user()
        ], 200);
    });

    Route::get('/gejala-utama', [ApiController::class, 'gejalaUtama']);
    Route::get('/gejala', [ApiController::class, 'gejala']);
    Route::post('/diagnosa', [ApiController::class, 'diagnosa']);
    Route::post('/diagnosa-lanjut', [ApiController::class, 'diagnosaLanjut']);
    Route::get('/hasil', [ApiController::class, 'hasil']);

    Route::get('/dokter', [ApiController::class, 'dokter']);

    Route::put('/update-profil', [ApiController::class, 'updateProfil']);

    Route::get('/logout', [AuthController::class, 'userLogout']);
});
