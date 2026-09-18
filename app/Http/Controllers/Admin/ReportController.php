<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Batch;
use App\Models\KelasUser;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function participantDetail(Request $request)
    {
        $participants = User::query()->orderBy('nama_lengkap')->get();
        $kelases = Kelas::query()->orderBy('nama_kelas')->get();
        $selectedParticipant = $request->filled('user_id')
            ? $participants->firstWhere('id', $request->integer('user_id'))
            : null;
        $selectedKelas = $request->filled('kelas_id')
            ? $kelases->firstWhere('id', $request->integer('kelas_id'))
            : null;
        $classReports = collect();

        if ($selectedParticipant) {
            $enrollments = KelasUser::with('batch', 'user')
                ->where('user_id', $selectedParticipant->id)
                ->when($selectedKelas, fn ($query) => $query->where('kelas_id', $selectedKelas->id))
                ->get();

            $classReports = $enrollments->map(function (KelasUser $enrollment) {
                $kelas = Kelas::find($enrollment->kelas_id);
                $progress = $kelas ? $enrollment->user->classProgress($kelas->id) : 0;

                return [
                    'kelas' => $kelas,
                    'batch' => $enrollment->batch,
                    'status' => $progress >= 100 || $enrollment->status === 'completed'
                        ? 'Selesai'
                        : ($progress > 0 || $enrollment->status === 'in_progress' ? 'Sedang Berjalan' : 'Belum Dimulai'),
                    'progress' => $progress,
                    'joined_at' => $enrollment->created_at,
                ];
            })->filter(fn (array $report) => $report['kelas']);
        }

        $completedCount = $classReports->where('status', 'Selesai')->count();
        $averageProgress = $classReports->count() ? round($classReports->avg('progress')) : 0;

        return view('admin.reports.participant-detail', compact(
            'participants', 'kelases', 'selectedParticipant', 'selectedKelas', 'classReports', 'completedCount', 'averageProgress'
        ));
    }

    public function classStatus(Request $request)
    {
        $kelases = Kelas::query()->orderBy('nama_kelas')->get();
        $selectedStatus = $request->string('status')->toString();
        $selectedCategory = $request->string('category')->toString();
        $displayKelases = $kelases->filter(fn (Kelas $kelas) => $this->matchesReportCategory($kelas, $selectedCategory));
        $search = strtolower($request->string('search')->toString());
        $participantsQuery = User::query()->orderBy('nama_lengkap');

        if ($request->filled('date_from')) {
            $participantsQuery->whereHas('kelas', fn ($query) => $query->whereDate('kelas_users.created_at', '>=', $request->date('date_from')));
        }
        if ($request->filled('date_to')) {
            $participantsQuery->whereHas('kelas', fn ($query) => $query->whereDate('kelas_users.created_at', '<=', $request->date('date_to')));
        }

        $participants = $participantsQuery->with('kelas')->get();
        $reports = $participants->map(function (User $participant) use ($displayKelases, $selectedStatus, $selectedCategory) {
            $classes = $displayKelases->mapWithKeys(function (Kelas $kelas) use ($participant) {
                $enrollment = $participant->kelas->firstWhere('id', $kelas->id);
                $progress = $enrollment ? $participant->classProgress($kelas->id) : null;
                $status = $this->reportClassStatus($enrollment, $progress);

                return [$kelas->id => ['status' => $status, 'progress' => $progress]];
            });
            $visibleClasses = $classes->filter(fn (array $class) => $class['progress'] !== null);
            $overallProgress = $visibleClasses->count() ? round($visibleClasses->avg('progress')) : 0;

            return [
                'participant' => $participant,
                'classes' => $classes,
                'overall_progress' => $overallProgress,
            ];
        })->filter(function (array $report) use ($selectedStatus, $selectedCategory, $search) {
            $participant = $report['participant'];
            if ($search && ! str_contains(strtolower($participant->nama_lengkap), $search) && ! str_contains(strtolower($participant->email), $search)) {
                return false;
            }
            if ($selectedStatus && ! $report['classes']->contains(fn (array $class) => $class['status'] === $selectedStatus)) {
                return false;
            }
            if ($selectedCategory && ! $report['participant']->kelas->contains(fn (Kelas $kelas) => $this->matchesReportCategory($kelas, $selectedCategory))) {
                return false;
            }
            return true;
        });

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $reports = new LengthAwarePaginator(
            $reports->forPage($currentPage, $perPage)->values(),
            $reports->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $categories = $kelases->pluck('kategori')->filter()
            ->map(fn (string $category) => $this->reportCategoryLabel($category))
            ->unique()
            ->sort()
            ->values();

        return view('admin.reports.class-status', compact(
            'kelases', 'displayKelases', 'categories', 'reports', 'selectedStatus', 'selectedCategory'
        ));
    }

    private function matchesReportCategory(Kelas $kelas, string $selectedCategory): bool
    {
        return $selectedCategory === '' || $this->reportCategoryLabel((string) $kelas->kategori) === $selectedCategory;
    }

    private function reportCategoryLabel(string $category): string
    {
        $normalized = strtolower(trim($category));

        if (str_contains($normalized, 'equip') && (str_contains($normalized, 'new') || str_contains($normalized, 'plant'))) {
            return 'Equip';
        }

        return $category;
    }

    public function exportParticipantDetailPdf(Request $request)
    {
        $participant = User::find($request->integer('user_id'));
        $kelasId = $request->integer('kelas_id');

        if (! $participant) {
            return redirect()->route('admin.reports.participant-detail')
                ->with('error', 'Pilih peserta terlebih dahulu.');
        }

        $kelas = $kelasId ? Kelas::find($kelasId) : null;
        $classReports = KelasUser::with('batch', 'user')
            ->where('user_id', $participant->id)
            ->when($kelas, fn ($query) => $query->where('kelas_id', $kelas->id))
            ->get()
            ->map(function (KelasUser $enrollment) {
                $kelas = Kelas::find($enrollment->kelas_id);
                $progress = $kelas ? $enrollment->user->classProgress($kelas->id) : 0;

                return [
                    'kelas' => $kelas,
                    'batch' => $enrollment->batch,
                    'status' => $progress >= 100 || $enrollment->status === 'completed'
                        ? 'Selesai'
                        : ($progress > 0 || $enrollment->status === 'in_progress' ? 'Sedang Berjalan' : 'Belum Dimulai'),
                    'progress' => $progress,
                    'joined_at' => $enrollment->created_at,
                ];
            })
            ->filter(fn (array $report) => $report['kelas']);

        $completedCount = $classReports->where('status', 'Selesai')->count();
        $averageProgress = $classReports->count() ? round($classReports->avg('progress')) : 0;
        $pdf = Pdf::loadView('admin.reports.participant-detail-pdf', compact(
            'participant', 'classReports', 'completedCount', 'averageProgress'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Peserta_' . str_replace(' ', '_', $participant->nama_lengkap) . '_' . date('Y-m-d') . '.pdf');
    }

    public function exportClassStatusPdf(Request $request)
    {
        ini_set('memory_limit', '512M');

        $kelases = Kelas::query()->orderBy('nama_kelas')->get();
        $selectedStatus = $request->string('status')->toString();
        $selectedCategory = $request->string('category')->toString();
        $displayKelases = $kelases->filter(fn (Kelas $kelas) => $this->matchesReportCategory($kelas, $selectedCategory));
        $search = strtolower($request->string('search')->toString());
        $participantsQuery = User::query()->orderBy('nama_lengkap');

        if ($request->filled('date_from')) {
            $participantsQuery->whereHas('kelas', fn ($query) => $query->whereDate('kelas_users.created_at', '>=', $request->date('date_from')));
        }
        if ($request->filled('date_to')) {
            $participantsQuery->whereHas('kelas', fn ($query) => $query->whereDate('kelas_users.created_at', '<=', $request->date('date_to')));
        }

        $reports = $participantsQuery->with('kelas')->get()->map(function (User $participant) use ($displayKelases) {
            $classes = $displayKelases->mapWithKeys(function (Kelas $kelas) use ($participant) {
                $enrollment = $participant->kelas->firstWhere('id', $kelas->id);
                $progress = $enrollment ? $participant->classProgress($kelas->id) : null;
                $status = $this->reportClassStatus($enrollment, $progress);

                return [$kelas->id => ['status' => $status, 'progress' => $progress]];
            });

            $visibleClasses = $classes->filter(fn (array $class) => $class['progress'] !== null);
            return [
                'participant' => $participant,
                'classes' => $classes,
                'overall_progress' => $visibleClasses->count() ? round($visibleClasses->avg('progress')) : 0,
            ];
        })->filter(function (array $report) use ($selectedStatus, $selectedCategory, $search) {
            $participant = $report['participant'];
            if ($search && ! str_contains(strtolower($participant->nama_lengkap), $search) && ! str_contains(strtolower($participant->email), $search)) {
                return false;
            }
            if ($selectedStatus && ! $report['classes']->contains(fn (array $class) => $class['status'] === $selectedStatus)) {
                return false;
            }
            return ! $selectedCategory || $participant->kelas->contains(fn (Kelas $kelas) => $this->matchesReportCategory($kelas, $selectedCategory));
        });

        $kelases = $displayKelases;
        $pdf = Pdf::loadView('admin.reports.class-status-pdf', compact(
            'kelases', 'reports', 'selectedStatus', 'selectedCategory'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Status_Kelas_Peserta_' . date('Y-m-d') . '.pdf');
    }

    private function reportClassStatus($enrollment, ?int $progress): string
    {
        if (! $enrollment) {
            return 'Belum';
        }

        if ($progress >= 100 || $enrollment->pivot->status === 'completed') {
            return 'Selesai';
        }

        if ($progress > 0) {
            return 'Aktif';
        }

        return in_array($enrollment->pivot->status, ['requested', 'in_progress'], true)
            ? 'Pending'
            : 'Belum';
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
