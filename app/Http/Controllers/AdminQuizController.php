<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sesi;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminQuizController extends Controller
{
    private function authorizeAdmin(): void
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403);
        }
    }

    private function findSesi($kelasId, $sesiId): Sesi
    {
        return Sesi::where('kelas_id', $kelasId)
            ->with(['quiz.questions.options'])
            ->findOrFail($sesiId);
    }

    public function edit($kelasId, $sesiId)
    {
        $this->authorizeAdmin();
        $kelas = Kelas::findOrFail($kelasId);
        $sesi = $this->findSesi($kelasId, $sesiId);

        return view('admin.quiz.edit', compact('kelas', 'sesi'));
    }

    public function save(Request $request, $kelasId, $sesiId)
    {
        $this->authorizeAdmin();
        $sesi = Sesi::where('kelas_id', $kelasId)->findOrFail($sesiId);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'passing_score' => 'required|integer|min:0',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:multiple_choice,essay',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*.text' => 'nullable|string|max:255',
            'questions.*.correct_index' => 'nullable|integer|min:0',
        ]);

        foreach ($validated['questions'] as $index => $question) {
            if ($question['type'] === 'multiple_choice') {
                $options = collect($question['options'] ?? [])
                    ->filter(fn ($option) => filled($option['text'] ?? null))
                    ->values();
                $correctIndex = $question['correct_index'] ?? null;

                if ($options->count() < 2) {
                    return back()->withInput()->withErrors([
                        "questions.{$index}.options" => 'Pilihan ganda minimal memiliki 2 opsi.',
                    ]);
                }

                if ($correctIndex === null || !$options->has($correctIndex)) {
                    return back()->withInput()->withErrors([
                        "questions.{$index}.correct_index" => 'Tentukan satu jawaban yang benar.',
                    ]);
                }
            }
        }

        DB::transaction(function () use ($validated, $sesi) {
            $quiz = Quiz::updateOrCreate(
                ['sesi_id' => $sesi->id],
                [
                    'judul' => $validated['judul'],
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'passing_score' => $validated['passing_score'],
                    'is_active' => true,
                ]
            );

            $quiz->questions()->delete();

            foreach ($validated['questions'] as $questionIndex => $questionData) {
                $question = $quiz->questions()->create([
                    'question' => $questionData['text'],
                    'type' => $questionData['type'],
                    'points' => $questionData['points'],
                    'sort_order' => $questionIndex + 1,
                ]);

                if ($questionData['type'] === 'multiple_choice') {
                    $options = collect($questionData['options'] ?? [])
                        ->filter(fn ($option) => filled($option['text'] ?? null))
                        ->values();
                    $correctIndex = (int) ($questionData['correct_index'] ?? -1);

                    foreach ($options as $optionIndex => $optionData) {
                        $question->options()->create([
                            'option_text' => $optionData['text'],
                            'is_correct' => $optionIndex === $correctIndex,
                            'sort_order' => $optionIndex + 1,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.sesi.index', $kelasId)->with('success', 'Quiz sesi berhasil disimpan.');
    }

    public function destroy($kelasId, $sesiId)
    {
        $this->authorizeAdmin();
        $sesi = Sesi::where('kelas_id', $kelasId)->findOrFail($sesiId);
        $sesi->quiz()->delete();

        return back()->with('success', 'Quiz sesi berhasil dihapus.');
    }
}
