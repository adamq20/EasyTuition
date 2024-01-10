<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TagihanSppController;
use App\Http\Controllers\PembayaranSppMuridController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Pages
Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [PagesController::class, 'getIndex']);
    Route::get('/profile', [PagesController::class, 'getProfile']);
    Route::patch('/profile', [PagesController::class, 'updateProfile']);
    Route::patch('/u/password', [PagesController::class, 'updatePassword']);
});

// Tagihan Spp
Route::group(['middleware' => ['auth']], function() {
    Route::prefix('tagihan')->group(function() {
        Route::get('/', [TagihanSppController::class, 'index']);
        Route::any('/json', [TagihanSppController::class, 'tagihanSppJson']);
        Route::group(['middleware' => ['role:admin']], function() {
            Route::get('/c', [TagihanSppController::class, 'create']);
            Route::post('/s', [TagihanSppController::class, 'store']);
            Route::get('/{tagihan}', [TagihanSppController::class, 'show']);
            Route::get('/e/{tagihan}', [TagihanSppController::class, 'edit']);
            Route::put('/u/{tagihan}', [TagihanSppController::class, 'update']);
            Route::delete('/d/{tagihan}', [TagihanSppController::class, 'destroy']);
        });
    });
});

// Siswa
Route::group(['middleware' => ['auth', 'role:admin']], function() {
    Route::prefix('siswa')->group(function() {
        Route::get('/', [SiswaController::class, 'index']);
        Route::any('/json', [SiswaController::class, 'siswaJson']);
        Route::get('/c', [SiswaController::class, 'create']);
        Route::post('/s', [SiswaController::class, 'store']);
        Route::get('/{nis}', [SiswaController::class, 'show']);
        Route::get('/e/{nis}', [SiswaController::class, 'edit']);
        Route::put('/u/{nis}', [SiswaController::class, 'update']);
        Route::delete('/d/{nis}', [SiswaController::class, 'destroy']);
    });
});

// Users
Route::group(['middleware' => ['auth', 'role:admin']], function() {
    Route::prefix('users')->group(function() {
        Route::patch('/reset-password/{user}', [UsersController::class, 'doResetPassword']);
    });
});

// Pembayaran Spp Murid
Route::group(['middleware' => ['auth']], function() {
    Route::prefix('pembayaran')->group(function() {
        Route::get('/', [PembayaranSppMuridController::class, 'index']);
        Route::any('/json', [PembayaranSppMuridController::class, 'pembayaranSppMuridJson']);
        Route::get('/c/{tagihan}', [PembayaranSppMuridController::class, 'create']);
        Route::post('/s', [PembayaranSppMuridController::class, 'store']);
        Route::get('/{pembayaran}', [PembayaranSppMuridController::class, 'show']);
        Route::group(['middleware' => ['role:admin']], function() {
            Route::patch('/confirm/{pembayaran}', [PembayaranSppMuridController::class, 'confirm']);
        });
        Route::group(['middleware' => ['role:siswa']], function() {
            Route::delete('/d/{pembayaran}', [PembayaranSppMuridController::class, 'destroy']);
        });
    });
});

// Auth
Route::group(['middleware' => ['guest']], function() {
    Route::get('/login', [AuthController::class, 'getLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'doLogin']);
});
Route::group(['middleware' => ['auth']], function() {
    Route::get('/logout', [AuthController::class, 'doLogout']);
});
