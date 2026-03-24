<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('layouts.app');
});


Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
