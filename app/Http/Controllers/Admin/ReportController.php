<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Batch;
use App\Models\KelasUser;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $kelases = Kelas::all();
        $selectedKelas = $request->kelas_id ? Kelas::find($request->kelas_id) : null;
        
        $batches = collect();
        if ($selectedKelas) {
            $batches = $selectedKelas->batches;
        }

        $selectedBatch = $request->batch_id ? Batch::find($request->batch_id) : null;

        $reports = [];
        $summary = [
            'total_peserta' => 0,
            'avg_progress' => 0,
            'completed_count' => 0,
            'not_started_count' => 0,
        ];

        if ($selectedBatch) {
            $enrollments = KelasUser::with('user')->where('batch_id', $selectedBatch->id)->get();
            $totalMateri = $selectedKelas->materi()->count();
            $materiList = $selectedKelas->materi()->orderBy('urutan')->get();

            $totalPercentage = 0;
            $counter = 0;

            foreach ($enrollments as $enrollment) {
                $user = $enrollment->user;
                if ($user) {
                    $counter++;

                    // Get completed materi details
                    $completedMateriIds = $user->materi()
                        ->where('materis.kelas_id', $selectedKelas->id)
                        ->where('materi_users.is_completed', true)
                        ->pluck('materis.id')
                        ->toArray();
                    
                    $completedMateri = count($completedMateriIds);
                    $percentage = $totalMateri > 0 ? round(($completedMateri / $totalMateri) * 100) : 0;
                    $totalPercentage += $percentage;

                    // Get last activity (last completed materi timestamp)
                    $lastActivity = $user->materi()
                        ->where('materis.kelas_id', $selectedKelas->id)
                        ->where('materi_users.is_completed', true)
                        ->orderByDesc('materi_users.updated_at')
                        ->first();

                    $reports[] = [
                        'no' => $counter,
                        'user_name' => $user->nama_lengkap ?? $user->name ?? '-',
                        'user_email' => $user->email,
                        'user_phone' => $user->no_hp ?? '-',
                        'user_gender' => $user->jenis_kelamin ?? '-',
                        'user_role' => $user->role ?? 'Member',
                        'status' => $enrollment->status,
                        'completed' => $completedMateri,
                        'total' => $totalMateri,
                        'percentage' => $percentage,
                        'joined_at' => $enrollment->created_at,
                        'last_activity' => $lastActivity ? $lastActivity->pivot->updated_at : null,
                        'completed_materi_ids' => $completedMateriIds,
                    ];

                    // Summary counters
                    if ($percentage >= 100) {
                        $summary['completed_count']++;
                    }
                    if ($percentage == 0) {
                        $summary['not_started_count']++;
                    }
                }
            }

            $summary['total_peserta'] = $counter;
            $summary['avg_progress'] = $counter > 0 ? round($totalPercentage / $counter) : 0;
        }

        return view('admin.reports.index', compact(
            'kelases', 'selectedKelas', 'batches', 'selectedBatch', 'reports', 'summary'
        ));
    }

    public function exportPdf(Request $request)
    {
        $selectedKelas = $request->kelas_id ? Kelas::find($request->kelas_id) : null;
        $selectedBatch = $request->batch_id ? Batch::find($request->batch_id) : null;

        if (!$selectedKelas || !$selectedBatch) {
            return redirect()->route('admin.reports.index')
                ->with('error', 'Pilih kelas dan batch terlebih dahulu.');
        }

        $enrollments = KelasUser::with('user')->where('batch_id', $selectedBatch->id)->get();
        $totalMateri = $selectedKelas->materi()->count();

        $reports = [];
        $summary = [
            'total_peserta' => 0,
            'avg_progress' => 0,
            'completed_count' => 0,
            'not_started_count' => 0,
        ];

        $totalPercentage = 0;
        $counter = 0;

        foreach ($enrollments as $enrollment) {
            $user = $enrollment->user;
            if ($user) {
                $counter++;

                $completedMateri = $user->materi()
                    ->where('materis.kelas_id', $selectedKelas->id)
                    ->where('materi_users.is_completed', true)
                    ->count();
                
                $percentage = $totalMateri > 0 ? round(($completedMateri / $totalMateri) * 100) : 0;
                $totalPercentage += $percentage;

                $lastActivity = $user->materi()
                    ->where('materis.kelas_id', $selectedKelas->id)
                    ->where('materi_users.is_completed', true)
                    ->orderByDesc('materi_users.updated_at')
                    ->first();

                $reports[] = [
                    'no' => $counter,
                    'user_name' => $user->nama_lengkap ?? $user->name ?? '-',
                    'user_email' => $user->email,
                    'user_phone' => $user->no_hp ?? '-',
                    'user_gender' => $user->jenis_kelamin ?? '-',
                    'user_role' => $user->role ?? 'Member',
                    'status' => $enrollment->status,
                    'completed' => $completedMateri,
                    'total' => $totalMateri,
                    'percentage' => $percentage,
                    'joined_at' => $enrollment->created_at,
                    'last_activity' => $lastActivity ? $lastActivity->pivot->updated_at : null,
                ];

                if ($percentage >= 100) $summary['completed_count']++;
                if ($percentage == 0) $summary['not_started_count']++;
            }
        }

        $summary['total_peserta'] = $counter;
        $summary['avg_progress'] = $counter > 0 ? round($totalPercentage / $counter) : 0;

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'selectedKelas', 'selectedBatch', 'reports', 'summary'
        ));

        $pdf->setPaper('a4', 'landscape');

        $filename = 'Laporan_Progress_' . str_replace(' ', '_', $selectedKelas->nama_kelas) . '_' . str_replace(' ', '_', $selectedBatch->nama_batch) . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
