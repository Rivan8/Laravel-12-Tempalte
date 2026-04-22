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

        // Pastikan belum request/completed
        if ($user->kelas()->where('kelas_id', $id)->exists()) {
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
        
        return view('kelas.show', compact('kelas', 'status', 'belumBuka', 'tanggalBuka'));
    }

    public function belajar($id, $materi_id = null)
    {
        $kelas = \App\Models\Kelas::with(['materi' => function($q) {
            $q->orderBy('urutan', 'asc');
        }])->findOrFail($id);
        
        $user = auth()->user();
        
        $enrollment = $user->kelas()->wherePivot('kelas_id', $id)->first();
        
        if (!$enrollment || ($enrollment->pivot->status !== 'in_progress' && $enrollment->pivot->status !== 'completed')) {
            return redirect()->route('dashboard')->with('error', 'Anda belum memiliki akses untuk mempelajari kelas ini.');
        }

        // Pengecekan Tanggal Buka Batch
        if ($enrollment->pivot->batch_id) {
            $batch = \App\Models\Batch::find($enrollment->pivot->batch_id);
            if ($batch && $batch->start_date && $batch->start_date > now()) {
                $formattedDate = \Carbon\Carbon::parse($batch->start_date)->translatedFormat('d F Y');
                return redirect()->route('kelas.show', $id)->with('error', 'Kelas belum di buka, akan tersedia di tanggal ' . $formattedDate);
            }
        }

        $materiList = $kelas->materi;
        $completedMateriIds = $user->materi()->wherePivot('is_completed', true)->pluck('materi_id')->toArray();
        $isAllCompleted = true;
        
        // Kalkulasi Status Terkunci (Locked) & Status Selesai
        foreach ($materiList as $index => $m) {
            $m->is_completed = in_array($m->id, $completedMateriIds);
            
            // Sesi 1 selalu terbuka. Sesi selanjutnya ditinjau dari kelulusan sesi sebelumnya.
            if ($index == 0) {
                $m->is_locked = false;
            } else {
                $m->is_locked = !$materiList[$index - 1]->is_completed;
            }
            
            if (!$m->is_completed) {
                $isAllCompleted = false;
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
        return view('kelas.belajar', compact('kelas', 'enrollment', 'activeMateri', 'materiList', 'isAllCompleted'));
    }
}
