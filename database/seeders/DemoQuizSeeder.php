<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\BatchSesi;
use App\Models\Kelas;
use App\Models\KelasUser;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\Sesi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoQuizSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = Kelas::updateOrCreate(
            ['nama_kelas' => 'Foundation Class 2'],
            [
                'kategori' => 'Equip - Plant',
                'deskripsi' => 'Data demo untuk menguji alur sesi, quiz, batch, dan laporan peserta.',
                'gambar' => 'img/curved-images/curved14.jpg',
            ]
        );

        $sessionTitles = [
            'Pengenalan Pertumbuhan Rohani',
            'Membangun Disiplin Doa',
            'Memahami Firman Tuhan',
            'Hidup dalam Komunitas',
        ];
        $sesis = collect();

        foreach ($sessionTitles as $index => $title) {
            $sesi = Sesi::updateOrCreate(
                ['kelas_id' => $kelas->id, 'urutan' => $index + 1],
                [
                    'judul' => $title,
                    'deskripsi' => 'Materi demo untuk ' . $title . '.',
                    'link_quiz' => null,
                ]
            );
            $sesis->push($sesi);

            for ($videoIndex = 1; $videoIndex <= 2; $videoIndex++) {
                Materi::updateOrCreate(
                    ['sesi_id' => $sesi->id, 'urutan' => $videoIndex],
                    [
                        'kelas_id' => $kelas->id,
                        'judul' => $title . ' - Video ' . $videoIndex,
                        'deskripsi' => 'Video pembelajaran demo.',
                        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                        'pembicara' => 'Tim Equip',
                    ]
                );
            }
        }

        $batch = Batch::updateOrCreate(
            ['kelas_id' => $kelas->id, 'nama_batch' => 'Batch Demo September 2026'],
            ['start_date' => '2026-09-01', 'is_active' => true]
        );

        foreach ($sesis as $index => $sesi) {
            BatchSesi::updateOrCreate(
                ['batch_id' => $batch->id, 'sesi_id' => $sesi->id],
                ['tanggal_pelaksanaan' => now()->startOfMonth()->addWeeks($index)->toDateString()]
            );
        }

        $users = collect();
        for ($index = 1; $index <= 15; $index++) {
            $users->push(User::updateOrCreate(
                ['email' => 'demo.peserta' . $index . '@example.com'],
                [
                    'nama_lengkap' => 'Peserta Demo ' . str_pad($index, 2, '0', STR_PAD_LEFT),
                    'jenis_kelamin' => $index % 2 ? 'Laki laki' : 'Perempuan',
                    'no_hp' => '08120000' . str_pad($index, 4, '0', STR_PAD_LEFT),
                    'role' => 'Member',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            ));
        }

        $allMateri = Materi::where('kelas_id', $kelas->id)->get();
        foreach ($users as $user) {
            KelasUser::updateOrCreate(
                ['user_id' => $user->id, 'kelas_id' => $kelas->id],
                ['batch_id' => $batch->id, 'status' => 'in_progress']
            );

            foreach ($allMateri as $materi) {
                $user->materi()->syncWithoutDetaching([
                    $materi->id => ['is_completed' => true],
                ]);
            }
        }

        $quiz = Quiz::updateOrCreate(
            ['sesi_id' => $sesis->first()->id],
            [
                'judul' => 'Quiz Sesi 1 - Pertumbuhan Rohani',
                'deskripsi' => 'Quiz demo pilihan ganda dan esai untuk laporan peserta.',
                'passing_score' => 25,
                'is_active' => true,
            ]
        );

        $quiz->questions()->delete();
        $questions = [
            ['text' => 'Apa tujuan utama disiplin rohani?', 'type' => 'multiple_choice', 'points' => 10, 'options' => ['Bertumbuh dalam relasi dengan Tuhan', 'Mendapat pujian manusia', 'Menghindari semua tanggung jawab', 'Mengumpulkan nilai'], 'correct' => 0],
            ['text' => 'Kapan waktu terbaik untuk membangun kebiasaan doa?', 'type' => 'multiple_choice', 'points' => 10, 'options' => ['Secara konsisten setiap hari', 'Hanya saat ada masalah', 'Setahun sekali', 'Saat diminta orang lain'], 'correct' => 0],
            ['text' => 'Apa manfaat belajar Firman Tuhan bersama komunitas?', 'type' => 'multiple_choice', 'points' => 10, 'options' => ['Saling menguatkan dan menerapkan kebenaran', 'Menjadi lebih terkenal', 'Menghindari proses belajar', 'Mendapat hadiah'], 'correct' => 0],
            ['text' => 'Jelaskan satu kebiasaan rohani yang ingin Anda praktikkan minggu ini.', 'type' => 'essay', 'points' => 10, 'options' => [], 'correct' => null],
        ];

        foreach ($questions as $index => $questionData) {
            $question = QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question' => $questionData['text'],
                'type' => $questionData['type'],
                'points' => $questionData['points'],
                'sort_order' => $index + 1,
            ]);

            foreach ($questionData['options'] as $optionIndex => $optionText) {
                QuizOption::create([
                    'quiz_question_id' => $question->id,
                    'option_text' => $optionText,
                    'is_correct' => $optionIndex === $questionData['correct'],
                    'sort_order' => $optionIndex + 1,
                ]);
            }
        }

        QuizAttempt::where('quiz_id', $quiz->id)->delete();
        $quizQuestions = $quiz->fresh('questions.options')->questions;
        foreach ($users as $index => $user) {
            $attempt = QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'user_id' => $user->id,
                'status' => $index < 5 ? 'needs_review' : 'graded',
                'score' => null,
                'submitted_at' => now()->subDays(15 - $index),
            ]);

            $correctAnswers = min(3, 1 + intdiv($index, 5));
            $score = 0;
            foreach ($quizQuestions as $questionIndex => $question) {
                if ($question->type === 'multiple_choice') {
                    $option = $question->options->firstWhere('is_correct', true);
                    $isCorrect = $questionIndex < $correctAnswers;
                    $selectedOption = $isCorrect ? $option : $question->options->where('is_correct', false)->first();
                    $points = $isCorrect ? $question->points : 0;
                    $score += $points;
                    QuizAnswer::create([
                        'quiz_attempt_id' => $attempt->id,
                        'quiz_question_id' => $question->id,
                        'quiz_option_id' => $selectedOption->id,
                        'points_awarded' => $points,
                    ]);
                } else {
                    $essayPoints = $index >= 5 ? 10 : null;
                    if ($essayPoints) $score += $essayPoints;
                    QuizAnswer::create([
                        'quiz_attempt_id' => $attempt->id,
                        'quiz_question_id' => $question->id,
                        'answer_text' => 'Saya akan menyediakan waktu doa dan membaca Firman setiap hari.',
                        'points_awarded' => $essayPoints,
                    ]);
                }
            }

            $attempt->update(['score' => $score]);
        }

        $this->command?->info('Demo quiz selesai dibuat. Login peserta: demo.peserta1@example.com s/d demo.peserta15@example.com | password: password');
    }
}
