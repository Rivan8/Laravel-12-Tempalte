<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelases = \App\Models\Kelas::orderBy('created_at', 'desc')->get();
        // Extrak kategori unik untuk tombol Filter Dinamis
        $categories = $kelases->pluck('kategori')->filter()->unique()->values();

        return view('kelas.index', compact('kelases', 'categories'));
    }

    public function requestKelas(Request $request, $id)
    {
        $kelas = \App\Models\Kelas::findOrFail($id);
        $user = auth()->user();

        // Cek apakah sudah punya relasi dengan kelas ini
        $existingEnrollment = $user->kelas()->where('kelas_id', $id)->first();

        if ($existingEnrollment) {
            // Jika ditolak, izinkan untuk mengajukan ulang
            if ($existingEnrollment->pivot->status === 'rejected') {
                // Verifikasi Prasyarat Dinamis via Database
                if ($kelas->prasyarat_kelas_id) {
                    if ($user->role !== 'Fasilitator' && $user->role !== 'Admin') {
                        $prasyarat = \App\Models\Kelas::find($kelas->prasyarat_kelas_id);
                        $hasCompletedPrasyarat = $user->kelas()
                            ->where('kelas_id', $kelas->prasyarat_kelas_id)
                            ->where('kelas_users.status', 'completed')
                            ->exists();

                        if (!$hasCompletedPrasyarat) {
                            $namaPrasyarat = $prasyarat ? $prasyarat->nama_kelas : 'Prasyarat sebelumnya';
                            return back()->with('error', 'Anda harus menyelesaikan kelas ' . $namaPrasyarat . ' terlebih dahulu untuk dapat mendaftar kelas ini.');
                        }
                    }
                }

                $activeBatch = $kelas->batches()->where('is_active', true)->orderBy('created_at', 'desc')->first();
                $batchId = $activeBatch ? $activeBatch->id : null;

                $user->kelas()->updateExistingPivot($id, [
                    'status' => 'requested',
                    'rejection_reason' => null,
                    'batch_id' => $batchId,
                ]);

                return back()->with('success', 'Pengajuan ulang untuk kelas ' . $kelas->nama_kelas . ' berhasil dikirim.');
            }

            return back()->with('error', 'Anda sudah mengakses atau mendaftar kelas ini.');
        }

        // Verifikasi Prasyarat Dinamis via Database
        if ($kelas->prasyarat_kelas_id) {
            if ($user->role !== 'Fasilitator' && $user->role !== 'Admin') {
                $prasyarat = \App\Models\Kelas::find($kelas->prasyarat_kelas_id);
                $hasCompletedPrasyarat = $user->kelas()
                    ->where('kelas_id', $kelas->prasyarat_kelas_id)
                    ->where('kelas_users.status', 'completed')
                    ->exists();

                if (!$hasCompletedPrasyarat) {
                    $namaPrasyarat = $prasyarat ? $prasyarat->nama_kelas : 'Prasyarat sebelumnya';
                    return back()->with('error', 'Anda harus menyelesaikan kelas ' . $namaPrasyarat . ' terlebih dahulu untuk dapat mendaftar kelas ini.');
                }
            }
        }

        // Jika lolos semua validasi
        $activeBatch = $kelas->batches()->where('is_active', true)->orderBy('created_at', 'desc')->first();
        $batchId = $activeBatch ? $activeBatch->id : null;

        $user->kelas()->attach($id, ['status' => 'requested', 'batch_id' => $batchId]);

        return back()->with('success', 'Berhasil melakukan request untuk kelas ' . $kelas->nama_kelas);
    }

    public function show($id)
    {
        $kelas = \App\Models\Kelas::findOrFail($id);
        $user = auth()->user();

        $enrollment = $user ? $user->kelas()->wherePivot('kelas_id', $id)->first() : null;
        $status = $enrollment ? $enrollment->pivot->status : null;
        $rejectionReason = $enrollment ? $enrollment->pivot->rejection_reason : null;

        $belumBuka = false;
        $tanggalBuka = null;

        $batch = null;
        if ($enrollment && $enrollment->pivot->batch_id) {
            $batch = \App\Models\Batch::find($enrollment->pivot->batch_id);
        } else {
            $batch = $kelas->batches()->where('is_active', true)->orderBy('created_at', 'desc')->first();
        }

        if ($batch && $batch->start_date && $batch->start_date > today()) {
            $belumBuka = true;
            $tanggalBuka = \Carbon\Carbon::parse($batch->start_date)->translatedFormat('d F Y');
        }

        return view('kelas.show', compact('kelas', 'status', 'rejectionReason', 'belumBuka', 'tanggalBuka'));
    }

    public function belajar($id, $materi_id = null)
    {
        $kelas = \App\Models\Kelas::with(['sesis' => function ($q) {
            $q->with(['materi' => function ($materiQuery) {
                $materiQuery->orderBy('urutan', 'asc');
            }, 'quiz'])->orderBy('urutan', 'asc');
        }])->findOrFail($id);

        $user = auth()->user();

        $enrollment = $user->kelas()->wherePivot('kelas_id', $id)->first();

        if (!$enrollment || ($enrollment->pivot->status !== 'in_progress' && $enrollment->pivot->status !== 'completed')) {
            return redirect()->route('dashboard')->with('error', 'Anda belum memiliki akses untuk mempelajari kelas ini.');
        }

        // Pengecekan Tanggal Buka Batch
        if ($enrollment->pivot->batch_id) {
            $batch = \App\Models\Batch::with('sessionSchedules')->find($enrollment->pivot->batch_id);
            if ($batch && $batch->start_date && $batch->start_date > now()) {
                $formattedDate = \Carbon\Carbon::parse($batch->start_date)->translatedFormat('d F Y');
                return redirect()->route('kelas.show', $id)->with('error', 'Kelas belum di buka, akan tersedia di tanggal ' . $formattedDate);
            }
        }

        $sessionList = $kelas->sesis;
        $batchSchedules = isset($batch) ? $batch->sessionSchedules->keyBy('sesi_id') : collect();
        $completedMateriIds = $user->materi()->wherePivot('is_completed', true)->pluck('materi_id')->toArray();
        $materiList = collect();
        $isAllCompleted = true;

        foreach ($sessionList as $sessionIndex => $session) {
            $session->tanggal_pelaksanaan = optional($batchSchedules->get($session->id))->tanggal_pelaksanaan;
            $previousSession = $sessionList->get($sessionIndex - 1);
            $session->is_locked = $previousSession ? !$previousSession->is_completed : false;
            $session->is_completed = $session->materi->isNotEmpty()
                && $session->materi->every(fn ($materi) => in_array($materi->id, $completedMateriIds));

            foreach ($session->materi as $videoIndex => $materi) {
                $materi->is_completed = in_array($materi->id, $completedMateriIds);
                $previousVideo = $session->materi->get($videoIndex - 1);
                $materi->is_locked = $session->is_locked || ($previousVideo && !$previousVideo->is_completed);
                $materi->sesi = $session;
                $materiList->push($materi);

                if (!$materi->is_completed) {
                    $isAllCompleted = false;
                }
            }
        }

        if ($materi_id) {
            $activeMateri = $materiList->where('id', $materi_id)->first();
            if (!$activeMateri) abort(404, 'Materi tidak ditemukan');

            if ($activeMateri->is_locked) {
                return redirect()->route('kelas.belajar', $id)->with('error', 'Sesi ini masih tergembok! Harap tonton sesi sebelumnya setidaknya 80% durasi.');
            }
        } else {
            // Cari Sesi terjauh yang sudah terbuka namun BELUM selesai ditonton. Jika tidak ada, fallback ke Sesi 1.
            $activeMateri = $materiList->where('is_locked', false)->where('is_completed', false)->first() ?? $materiList->first();
        }

        // Jika materi kosong, biarkan lolos untuk Empty State (diatur di Blade)
        $activeSesi = $activeMateri ? $activeMateri->sesi : null;

        foreach ($sessionList as $session) {
            $session->quiz_unlocked = $session->is_completed && ($session->quiz?->is_active || filled($session->link_quiz));
        }

        return view('kelas.belajar', compact('kelas', 'enrollment', 'activeMateri', 'activeSesi', 'materiList', 'sessionList', 'isAllCompleted'));
    }
}
