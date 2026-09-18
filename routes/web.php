<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

Route::view('/privacy-policy', 'privacy')->name('privacy');
Route::get('/auto-login', function () {
    auth()->loginUsingId(1);
    return redirect('/dashboard');
});

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    // 1. Hitung User Stats
    $users = \App\Models\User::with('kelas')->get();

    $stats = [
        'users_member' => 0,
        'users_ctt' => 0,
        'users_dm' => 0,
        'users_new' => 0,
        'users_plant' => 0,
        'users_grow' => 0,
        'users_fasilitator' => 0,

        'kelas_community' => \App\Models\Kelas::where('kategori', 'like', '%Community%')->count(),
        'kelas_equip_new' => \App\Models\Kelas::where('kategori', 'like', '%Equip - New%')->count(),
        'kelas_equip_plant' => \App\Models\Kelas::where('kategori', 'like', '%Equip - Plant%')->count(),
        'kelas_equip_grow' => \App\Models\Kelas::where('kategori', 'like', '%Equip - Grow%')->count(),
        'kelas_equip_leadership' => \App\Models\Kelas::where('kategori', 'like', '%Leadership%')->count(),
        'total_kelas' => \App\Models\Kelas::count(),
    ];

    foreach($users as $user) {
        if ($user->role === 'Fasilitator') {
            $stats['users_fasilitator']++;
        }

        $userStatus = $user->status_user; // calls getStatusUserAttribute()
        if ($userStatus === 'Disciple Maker (DM)') {
            $stats['users_dm']++;
        } elseif ($userStatus === 'Core Team') {
            $stats['users_ctt']++;
        } else {
            $stats['users_member']++;
        }

        $equipStatus = $user->equip_status; // calls getEquipStatusAttribute()
        if ($equipStatus === 'New') {
            $stats['users_new']++;
        } elseif ($equipStatus === 'Plant') {
            $stats['users_plant']++;
        } elseif ($equipStatus === 'Grow') {
            $stats['users_grow']++;
        }
    }

    return view('welcome', compact('stats'));
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
    Route::get('/kelas/{kelas}/sesi/{sesi}/quiz', [\App\Http\Controllers\QuizController::class, 'show'])->name('quiz.show');
    Route::post('/kelas/{kelas}/sesi/{sesi}/quiz', [\App\Http\Controllers\QuizController::class, 'submit'])->name('quiz.submit');

    // Rute Users (Admin Only)
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::post('/users/{user_id}/approve/{kelas_id}', [\App\Http\Controllers\UserController::class, 'approve'])->name('users.approve');
    Route::post('/users/{user_id}/reject/{kelas_id}', [\App\Http\Controllers\UserController::class, 'reject'])->name('users.reject');
    Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

    // Admin CMS (Manajemen Kelas & Video)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/participant-detail', [ReportController::class, 'participantDetail'])->name('reports.participant-detail');
        Route::get('reports/participant-detail/pdf', [ReportController::class, 'exportParticipantDetailPdf'])->name('reports.participant-detail.pdf');
        Route::get('reports/class-status', [ReportController::class, 'classStatus'])->name('reports.class-status');
        Route::get('reports/class-status/pdf', [ReportController::class, 'exportClassStatusPdf'])->name('reports.class-status.pdf');
        Route::get('reports/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportPdf'])->name('reports.pdf');
        Route::get('quiz-reports', [\App\Http\Controllers\Admin\QuizReportController::class, 'index'])->name('quiz-reports.index');
        Route::get('quiz-reports/pdf', [\App\Http\Controllers\Admin\QuizReportController::class, 'exportPdf'])->name('quiz-reports.pdf');
        Route::resource('kelas', \App\Http\Controllers\AdminKelasController::class)->except(['show']);
        Route::resource('kelas.batches', \App\Http\Controllers\AdminBatchController::class)->except(['show']);

        Route::get('kelas/{kelas}/sesi', [\App\Http\Controllers\AdminSesiController::class, 'index'])->name('sesi.index');
        Route::get('kelas/{kelas}/sesi/create', [\App\Http\Controllers\AdminSesiController::class, 'create'])->name('sesi.create');
        Route::post('kelas/{kelas}/sesi', [\App\Http\Controllers\AdminSesiController::class, 'store'])->name('sesi.store');
        Route::get('kelas/{kelas}/sesi/{sesi}/edit', [\App\Http\Controllers\AdminSesiController::class, 'edit'])->name('sesi.edit');
        Route::put('kelas/{kelas}/sesi/{sesi}', [\App\Http\Controllers\AdminSesiController::class, 'update'])->name('sesi.update');
        Route::delete('kelas/{kelas}/sesi/{sesi}', [\App\Http\Controllers\AdminSesiController::class, 'destroy'])->name('sesi.destroy');

        Route::get('kelas/{kelas}/sesi/{sesi}/quiz', [\App\Http\Controllers\AdminQuizController::class, 'edit'])->name('quiz.edit');
        Route::post('kelas/{kelas}/sesi/{sesi}/quiz', [\App\Http\Controllers\AdminQuizController::class, 'save'])->name('quiz.save');
        Route::delete('kelas/{kelas}/sesi/{sesi}/quiz', [\App\Http\Controllers\AdminQuizController::class, 'destroy'])->name('quiz.destroy');

        // Sub-rute untuk Materi Video di dalam Kelas
        Route::get('kelas/{kelas}/materi', [\App\Http\Controllers\AdminMateriController::class, 'index'])->name('materi.index');
        Route::get('kelas/{kelas}/materi/create', [\App\Http\Controllers\AdminMateriController::class, 'create'])->name('materi.create');
        Route::post('kelas/{kelas}/materi', [\App\Http\Controllers\AdminMateriController::class, 'store'])->name('materi.store');
        Route::get('kelas/{kelas}/materi/{materi}/edit', [\App\Http\Controllers\AdminMateriController::class, 'edit'])->name('materi.edit');
        Route::put('kelas/{kelas}/materi/{materi}', [\App\Http\Controllers\AdminMateriController::class, 'update'])->name('materi.update');
        Route::delete('kelas/{kelas}/materi/{materi}', [\App\Http\Controllers\AdminMateriController::class, 'destroy'])->name('materi.destroy');
    });
});

// Public capability links for sharing an individual quiz result.
Route::get('/quiz-results/{token}', [\App\Http\Controllers\Admin\QuizReportController::class, 'preview'])->name('quiz-results.preview');
Route::get('/quiz-results/{token}/download', [\App\Http\Controllers\Admin\QuizReportController::class, 'exportAttemptPdf'])->name('quiz-results.download');

require __DIR__.'/auth.php';
