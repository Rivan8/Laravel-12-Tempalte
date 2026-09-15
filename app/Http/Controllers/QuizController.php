<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use App\Models\Sesi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    private function authorizedSesi($kelasId, $sesiId): Sesi
    {
        $sesi = Sesi::where('kelas_id', $kelasId)->with(['kelas', 'materi', 'quiz.questions.options'])->findOrFail($sesiId);
        $enrollment = auth()->user()->kelas()->wherePivot('kelas_id', $kelasId)->first();

        if (!$enrollment || !in_array($enrollment->pivot->status, ['in_progress', 'completed'], true)) {
            abort(403, 'Anda belum memiliki akses ke kelas ini.');
        }

        if (!$sesi->quiz || !$sesi->quiz->is_active) {
            abort(404, 'Quiz sesi belum tersedia.');
        }

        $completedIds = auth()->user()->materi()
            ->wherePivot('is_completed', true)
            ->whereIn('materis.id', $sesi->materi->pluck('id'))
            ->pluck('materis.id');

        if ($sesi->materi->isEmpty() || $completedIds->count() !== $sesi->materi->count()) {
            abort(403, 'Selesaikan semua video pada sesi ini terlebih dahulu.');
        }

        return $sesi;
    }

    public function show($kelasId, $sesiId)
    {
        $sesi = $this->authorizedSesi($kelasId, $sesiId);
        $quiz = $sesi->quiz;
        $latestAttempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', auth()->id())
            ->with('answers')
            ->latest()
            ->first();

        return view('quiz.show', compact('sesi', 'quiz', 'latestAttempt'));
    }

    public function submit(Request $request, $kelasId, $sesiId)
    {
        $sesi = $this->authorizedSesi($kelasId, $sesiId);
        $quiz = $sesi->quiz;
        $answers = $request->input('answers', []);

        $attempt = DB::transaction(function () use ($quiz, $answers) {
            $hasEssay = false;
            $score = 0;
            $attempt = QuizAttempt::create([
                'share_token' => Str::random(48),
                'quiz_id' => $quiz->id,
                'user_id' => auth()->id(),
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            foreach ($quiz->questions as $question) {
                $answer = $answers[$question->id] ?? [];
                $selectedOptionId = $question->type === 'multiple_choice' ? ($answer['option_id'] ?? null) : null;
                $answerText = $question->type === 'essay' ? ($answer['text'] ?? null) : null;
                $points = null;

                if ($question->type === 'multiple_choice') {
                    $option = $question->options->firstWhere('id', (int) $selectedOptionId);
                    $selectedOptionId = $option?->id;
                    if ($option && $option->is_correct) {
                        $points = $question->points;
                        $score += $question->points;
                    } else {
                        $points = 0;
                    }
                } else {
                    $hasEssay = true;
                }

                QuizAnswer::create([
                    'quiz_attempt_id' => $attempt->id,
                    'quiz_question_id' => $question->id,
                    'quiz_option_id' => $selectedOptionId,
                    'answer_text' => $answerText,
                    'points_awarded' => $points,
                ]);
            }

            $attempt->update([
                'score' => $score,
                'status' => $hasEssay ? 'needs_review' : 'graded',
            ]);

            return $attempt;
        });

        return redirect()->route('quiz.show', [$kelasId, $sesiId])->with('success', 'Jawaban quiz berhasil dikirim.');
    }
}
