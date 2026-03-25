<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;

class ProgressController extends Controller
{
    public function markComplete(Request $request, $materi_id)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $materi = Materi::findOrFail($materi_id);

        $user->materi()->syncWithoutDetaching([
            $materi->id => ['is_completed' => true]
        ]);

        // Cek secara otomatis apakah user sudah menyelesaikan semua materi di kelas ini
        $kelas = $materi->kelas;
        
        if ($kelas) {
            $totalMateri = $kelas->materi()->count();
            // Cek materi apa saja yang ada di kelas ini dan diambil ID-nya
            $materiIds = $kelas->materi->pluck('id');
            
            // Hitung berapa materi di kelas ini yang sudah 'is_completed' oleh user
            $completedMateriCount = $user->materi()
                ->whereIn('materi_id', $materiIds)
                ->wherePivot('is_completed', true)
                ->count();

            // Jika semua materi kelas tersebut sudah selesai, update tabel pivot `kelas_users`
            if ($completedMateriCount >= $totalMateri && $totalMateri > 0) {
                // Pastikan user sebelumnya mendaftar kelas ini. Jika update gagal karena data di pivot tidak ada, 
                // akan aman karena ini updateExistingPivot.
                $user->kelas()->updateExistingPivot($kelas->id, ['status' => 'completed']);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Progress saved successfully.'
        ]);
    }
}
