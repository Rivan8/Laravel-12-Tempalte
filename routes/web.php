<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $myClasses = $user->kelas()->get();
    return view('dashboard', compact('user', 'myClasses'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rute Kelas
    Route::get('/kelas', [\App\Http\Controllers\KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/{id}', [\App\Http\Controllers\KelasController::class, 'show'])->name('kelas.show');
    Route::post('/kelas/{id}/request', [\App\Http\Controllers\KelasController::class, 'requestKelas'])->name('kelas.request');
    Route::get('/kelas/{id}/belajar/{materi_id?}', [\App\Http\Controllers\KelasController::class, 'belajar'])->name('kelas.belajar');
    
    // API Pelacakan Progres Video (80%)
    Route::post('/materi/{materi_id}/complete', [\App\Http\Controllers\Api\ProgressController::class, 'markComplete'])->name('materi.complete');
    
    // Rute Users (Admin Only)
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user_id}/approve/{kelas_id}', [\App\Http\Controllers\UserController::class, 'approve'])->name('users.approve');

    // Admin CMS (Manajemen Kelas & Video)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('kelas', \App\Http\Controllers\AdminKelasController::class)->except(['show']);
        
        // Sub-rute untuk Materi Video di dalam Kelas
        Route::get('kelas/{kelas}/materi', [\App\Http\Controllers\AdminMateriController::class, 'index'])->name('materi.index');
        Route::get('kelas/{kelas}/materi/create', [\App\Http\Controllers\AdminMateriController::class, 'create'])->name('materi.create');
        Route::post('kelas/{kelas}/materi', [\App\Http\Controllers\AdminMateriController::class, 'store'])->name('materi.store');
        Route::delete('kelas/{kelas}/materi/{materi}', [\App\Http\Controllers\AdminMateriController::class, 'destroy'])->name('materi.destroy');
    });
});

require __DIR__.'/auth.php';
