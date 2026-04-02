<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\KelasUser;

class KelasController extends Controller
{
    /**
     * Get all classes with enrollment status for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $kelases = Kelas::all()->map(function ($kelas) use ($user) {
            $enrollment = $kelas->users()->where('user_id', $user->id)->first();

            return [
                'id'                => $kelas->id,
                'nama_kelas'        => $kelas->nama_kelas,
                'kategori'          => $kelas->kategori,
                'deskripsi'         => $kelas->deskripsi,
                'gambar'            => $kelas->gambar,
                'prasyarat_kelas_id'=> $kelas->prasyarat_kelas_id,
                'is_enrolled'       => $enrollment ? true : false,
                'enrollment_status' => $enrollment ? $enrollment->pivot->status : null,
            ];
        });

        return response()->json(['status' => 'success', 'data' => $kelases]);
    }

    /**
     * Get class detail with materi list and user progress.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $kelas = Kelas::with(['materi' => function ($q) {
            $q->orderBy('urutan', 'asc');
        }])->findOrFail($id);

        $enrollment = $user->kelas()->where('kelas_id', $id)->first();
        $completedMateriIds = $user->materi()
            ->wherePivot('is_completed', true)
            ->pluck('materi_id')
            ->toArray();

        $materiList = $kelas->materi->map(function ($m, $index) use ($completedMateriIds, $kelas, $user) {
            $m->is_completed = in_array($m->id, $completedMateriIds);
            return $m;
        });

        // Set locked status based on sequential completion
        $materiList = $materiList->values();
        foreach ($materiList as $index => $m) {
            if ($index === 0) {
                $m->is_locked = false;
            } else {
                $m->is_locked = !$materiList[$index - 1]->is_completed;
            }
        }

        // Calculate progress percentage
        $total = $materiList->count();
        $done = $materiList->filter(fn($m) => $m->is_completed)->count();
        $progressPct = $total > 0 ? round(($done / $total) * 100) : 0;

        return response()->json([
            'status' => 'success',
            'data' => [
                'id'                => $kelas->id,
                'nama_kelas'        => $kelas->nama_kelas,
                'kategori'          => $kelas->kategori,
                'deskripsi'         => $kelas->deskripsi,
                'gambar'            => $kelas->gambar,
                'link_quiz'         => $kelas->link_quiz,   // ← was missing!
                'is_enrolled'       => $enrollment ? true : false,
                'enrollment_status' => $enrollment ? $enrollment->pivot->status : null,
                'progress_pct'      => $progressPct,
                'materi'            => $materiList,
            ],
        ]);
    }

    /**
     * Request to enroll in a class (sets status to 'requested', pending admin approval).
     */
    public function enroll(Request $request, $id)
    {
        $user = $request->user();
        $kelas = Kelas::findOrFail($id);

        // Check if already requested or enrolled
        if ($user->kelas()->where('kelas_id', $id)->exists()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Anda sudah terdaftar atau sudah pernah request kelas ini.'
            ], 400);
        }

        // Validate prerequisite if exists (same logic as web)
        if ($kelas->prasyarat_kelas_id && !in_array($user->role, ['Admin', 'Fasilitator'])) {
            $hasCompletedPrerequisite = $user->kelas()
                ->where('kelas_id', $kelas->prasyarat_kelas_id)
                ->where('kelas_users.status', 'completed')
                ->exists();

            if (!$hasCompletedPrerequisite) {
                $prasyarat = Kelas::find($kelas->prasyarat_kelas_id);
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Anda harus menyelesaikan kelas ' . ($prasyarat?->nama_kelas ?? 'sebelumnya') . ' terlebih dahulu.'
                ], 403);
            }
        }

        // Attach with 'requested' status — same as web flow
        $user->kelas()->attach($id, ['status' => 'requested']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Request kelas "' . $kelas->nama_kelas . '" berhasil dikirim! Tunggu persetujuan Admin.'
        ]);
    }

    /**
     * Get enrolled classes for the dashboard.
     */
    public function myClasses(Request $request)
    {
        $user = $request->user();
        $myClasses = $user->kelas()->withPivot('status')->get();

        // Map to a plain array so progress_pct is always serialized correctly
        $data = $myClasses->map(function ($kelas) use ($user) {
            return [
                'id'                => $kelas->id,
                'nama_kelas'        => $kelas->nama_kelas,
                'kategori'          => $kelas->kategori,
                'deskripsi'         => $kelas->deskripsi,
                'gambar'            => $kelas->gambar,
                'link_quiz'         => $kelas->link_quiz,
                'progress_pct'      => $user->classProgress($kelas->id), // Real calculation from materi completed
                'pivot'             => [
                    'status'        => $kelas->pivot->status,
                ],
            ];
        });

        return response()->json(['status' => 'success', 'data' => $data]);
    }
}
