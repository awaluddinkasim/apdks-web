<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('authenticate');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');

    Route::get('/master/{jenis}', [PagesController::class, 'masterData'])->name('master-data');
    Route::post('/master/{jenis}', [PagesController::class, 'masterDataStore'])->name('master-data.store');
    Route::delete('/master/{jenis}', [PagesController::class, 'masterDataDelete'])->name('master-data.delete');

    Route::get('/daftar-pengguna', [PagesController::class, 'daftarPengguna'])->name('users');
    Route::put('/daftar-pengguna', [PagesController::class, 'penggunaUpdate'])->name('user.update');
    Route::delete('/daftar-pengguna', [PagesController::class, 'penggunaDelete'])->name('user.delete');

    Route::get('/profil', [PagesController::class, 'profil'])->name('profil');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('ajax')->group(function () {
        Route::get('/relasi/gejala', [AjaxController::class, 'relasiGejala']);
    });
});
