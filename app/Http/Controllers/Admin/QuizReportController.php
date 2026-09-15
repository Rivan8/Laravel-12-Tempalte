<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\QuizAttempt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizReportController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()->role === 'Admin', 403);
    }

    private function buildReport(Request $request): array
    {
        $kelases = Kelas::with('sesis')->orderBy('nama_kelas')->get();
        $selectedKelas = $request->filled('kelas_id') ? Kelas::with('sesis')->find($request->integer('kelas_id')) : null;
        $sesis = $selectedKelas ? $selectedKelas->sesis->sortBy('urutan')->values() : collect();
        $selectedSesi = $selectedKelas && $request->filled('sesi_id')
            ? $sesis->firstWhere('id', $request->integer('sesi_id'))
            : null;
        $batches = $selectedKelas ? $selectedKelas->batches()->orderByDesc('created_at')->get() : collect();
        $selectedBatch = $selectedKelas && $request->filled('batch_id')
            ? $batches->firstWhere('id', $request->integer('batch_id'))
            : null;
        $quiz = $selectedSesi?->quiz()->with('questions')->first();

        $reports = collect();
        $summary = [
            'participants' => 0,
            'submitted' => 0,
            'passed' => 0,
            'needs_review' => 0,
            'average' => 0,
            'max_score' => $quiz ? $quiz->questions->sum('points') : 0,
        ];

        if ($quiz && $selectedBatch) {
            $enrollments = $selectedBatch->kelasUsers()->with('user')->get()->filter(fn ($enrollment) => $enrollment->user);
            $summary['participants'] = $enrollments->count();
            $attempts = QuizAttempt::with(['answers.question', 'answers.option'])
                ->where('quiz_id', $quiz->id)
                ->whereIn('user_id', $enrollments->pluck('user_id'))
                ->latest('submitted_at')
                ->get()
                ->groupBy('user_id');

            foreach ($enrollments as $enrollment) {
                $attempt = $attempts->get($enrollment->user_id)?->first();
                if ($attempt && !$attempt->share_token) {
                    $attempt->update(['share_token' => Str::random(48)]);
                }
                $score = $attempt?->score;
                $percentage = $summary['max_score'] > 0 && $score !== null
                    ? round(($score / $summary['max_score']) * 100)
                    : 0;
                $isPassed = $attempt && $score >= $quiz->passing_score && $attempt->status !== 'needs_review';

                if ($attempt) {
                    $summary['submitted']++;
                    if ($attempt->status === 'needs_review') $summary['needs_review']++;
                    if ($isPassed) $summary['passed']++;
                }

                $reports->push([
                    'user' => $enrollment->user,
                    'attempt' => $attempt,
                    'score' => $score,
                    'percentage' => $percentage,
                    'passed' => $isPassed,
                ]);
            }

            $scores = $reports->pluck('score')->filter(fn ($score) => $score !== null);
            $summary['average'] = $scores->count() ? round($scores->avg(), 2) : 0;
        }

        return compact('kelases', 'selectedKelas', 'sesis', 'selectedSesi', 'batches', 'selectedBatch', 'quiz', 'reports', 'summary');
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();
        return view('admin.quiz-reports.index', $this->buildReport($request));
    }

    public function preview(string $token)
    {
        $attempt = $this->findAttempt($token);
        $data = $this->attemptData($attempt);

        return view('admin.quiz-reports.preview', $data);
    }

    public function exportAttemptPdf(string $token)
    {
        $attempt = $this->findAttempt($token);
        $data = $this->attemptData($attempt);
        $pdf = Pdf::loadView('admin.quiz-reports.attempt-pdf', $data)->setPaper('a4', 'portrait');
        $filename = 'Hasil_Quiz_' . str_replace(' ', '_', $data['participant']->nama_lengkap ?? 'Peserta') . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    private function findAttempt(string $token): QuizAttempt
    {
        return QuizAttempt::with([
            'user',
            'quiz.sesi.kelas',
            'quiz.questions',
            'answers.question',
            'answers.option',
        ])->where('share_token', $token)->firstOrFail();
    }

    private function attemptData(QuizAttempt $attempt): array
    {
        $maxScore = $attempt->quiz->questions->sum('points');
        $percentage = $maxScore > 0 && $attempt->score !== null
            ? round(($attempt->score / $maxScore) * 100)
            : 0;
        $passed = $attempt->status !== 'needs_review'
            && $attempt->score !== null
            && $attempt->score >= $attempt->quiz->passing_score;

        return [
            'attempt' => $attempt,
            'participant' => $attempt->user,
            'quiz' => $attempt->quiz,
            'percentage' => $percentage,
            'maxScore' => $maxScore,
            'passed' => $passed,
        ];
    }

    public function exportPdf(Request $request)
    {
        $this->ensureAdmin();
        $data = $this->buildReport($request);

        if (!$data['quiz'] || !$data['selectedBatch']) {
            return redirect()->route('admin.quiz-reports.index')->with('error', 'Pilih kelas, sesi, dan batch terlebih dahulu.');
        }

        $pdf = Pdf::loadView('admin.quiz-reports.pdf', $data)->setPaper('a4', 'landscape');
        $filename = 'Laporan_Quiz_' . str_replace(' ', '_', $data['selectedKelas']->nama_kelas) . '_Sesi_' . $data['selectedSesi']->urutan . '_' . date('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
}
