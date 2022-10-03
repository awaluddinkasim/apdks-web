<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'userLogin']);
Route::get('/register', [AuthController::class, 'userRegister']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', function (Request $request) {
        return response()->json([
            'user' => $request->user()
        ], 200);
    });

    Route::get('/gejala', [ApiController::class, 'gejala']);
    Route::post('/konsultasi', [ApiController::class, 'konsultasi']);
    Route::get('/hasil', [ApiController::class, 'hasil']);

    Route::put('/update-profil', [ApiController::class, 'updateProfil']);

    Route::get('/logout', [AuthController::class, 'userLogout']);
});
