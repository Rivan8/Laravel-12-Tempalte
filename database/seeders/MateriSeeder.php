<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;

class MateriSeeder extends Seeder
{
    public function run(): void
    {
        $materis = [
            [
                'kelas_id'  => 1, // CTT
                'judul'     => 'Sesi 1: Pengenalan Dasar Core Team',
                'deskripsi' => 'Mari kita pelajari pondasi utama menjadi seorang tim inti yang berdedikasi tinggi dalam pelayanan.',
                'video_url' => 'https://www.youtube.com/embed/LXb3EKWsInQ',
                'urutan'    => 1,
            ],
            [
                'kelas_id'  => 1, // CTT
                'judul'     => 'Sesi 2: Langkah Praktikal Berkembang',
                'deskripsi' => 'Bagaimana mengimplementasikan visi pelayanan ke dalam tindakan nyata sehari-hari secara efektif.',
                'video_url' => 'https://www.youtube.com/embed/tgbNymZ7vqY',
                'urutan'    => 2,
            ],
            [
                'kelas_id'  => 1, // CTT
                'judul'     => 'Sesi 3: Integritas & Kesetiaan',
                'deskripsi' => 'Menjaga kemurnian hati, karakter kristus, dan komitmen kuat dalam pelayanan jangka panjang.',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'urutan'    => 3,
            ]
        ];

        foreach ($materis as $materi) {
            Materi::updateOrCreate(
                ['kelas_id' => $materi['kelas_id'], 'urutan' => $materi['urutan']],
                $materi
            );
        }
    }
}
