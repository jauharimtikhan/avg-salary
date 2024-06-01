<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuruhController;
use App\Http\Controllers\MainController;
use App\Models\BuruhModel;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('Auth.signin');
    })->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.store');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});


Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        $pegawais = BuruhModel::all();
        return view('form-salary', compact('pegawais'));
    })->name('home');

    Route::resource('pegawai', BuruhController::class)->names('pegawai');
    Route::post('/pegawai/update', [BuruhController::class, 'update'])->name('pegawai.update');

    Route::controller(MainController::class)->group(function () {
        Route::post('/calculate', 'calculate')->name('calculate');
    });
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('web');
