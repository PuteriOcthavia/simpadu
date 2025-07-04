<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;


Route::get('/', function (){
    return view('dashboard');
})->name('home');


//Route::resource('prodi', ProdiController::class)->except('index');
Route::get('/', [DashboardController::class, 'index']);
//Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
//Route::post('/mahasiswa', [MahasiswaController::class, 'store']);
//Route::get('/mahasiswa/create', [MahasiswaController::class, 'create']);
Route::resource('mahasiswa', MahasiswaController::class);
