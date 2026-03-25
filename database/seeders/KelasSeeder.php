<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasData = [
            [
                'nama_kelas' => 'CTT (Core Team Training)',
                'kategori'   => 'Disciple Community',
                'deskripsi'  => 'Membangun tim inti yang kuat dan berdedikasi.',
                'gambar'     => 'img/curved-images/curved0.jpg',
            ],
            [
                'nama_kelas' => 'DMT (Disciple Maker Training)',
                'kategori'   => 'Disciple Community',
                'deskripsi'  => 'Pelatihan untuk menjadi pembuat murid yang efektif.',
                'gambar'     => 'img/curved-images/curved1.jpg',
            ],
            [
                'nama_kelas' => 'Foundation Class 1',
                'kategori'   => 'Equip - New',
                'deskripsi'  => 'Dasar Keselamatan dan Baptisan (Salvation & Baptism).',
                'gambar'     => 'img/curved-images/curved6.jpg',
            ],
            [
                'nama_kelas' => 'Membership Class',
                'kategori'   => 'Equip - New',
                'deskripsi'  => 'Memahami visi, misi, dan komitmen sebagai anggota.',
                'gambar'     => 'img/curved-images/curved8.jpg',
            ],
            [
                'nama_kelas' => 'Foundation Class 2',
                'kategori'   => 'Equip - Plant',
                'deskripsi'  => 'Membangun kebiasaan Doa, Alkitab, dan Komunitas.',
                'gambar'     => 'img/curved-images/curved14.jpg',
            ],
            [
                'nama_kelas' => 'Foundation Class 3',
                'kategori'   => 'Equip - Plant',
                'deskripsi'  => 'Renewal Life: Pemulihan dan pembaharuan hidup.',
                'gambar'     => 'img/curved-images/white-curved.jpeg',
            ],
            [
                'nama_kelas' => 'Grade 1 (The Cross)',
                'kategori'   => 'Equip - Grow',
                'deskripsi'  => 'Mendalami makna dan kuasa Salib Kristus.',
                'gambar'     => 'img/curved-images/curved0.jpg',
            ],
            [
                'nama_kelas' => 'Grade 2 (The Power)',
                'kategori'   => 'Equip - Grow',
                'deskripsi'  => 'Mengalami kuasa Roh Kudus dalam kehidupan sehari-hari.',
                'gambar'     => 'img/curved-images/curved1.jpg',
            ],
            [
                'nama_kelas' => 'Grade 3 (The Eternity)',
                'kategori'   => 'Equip - Grow',
                'deskripsi'  => 'Hidup dengan perspektif kekekalan.',
                'gambar'     => 'img/curved-images/curved6.jpg',
            ],
            [
                'nama_kelas' => 'Volunteer Class',
                'kategori'   => 'Equip - Serve',
                'deskripsi'  => 'Persiapan untuk melayani di berbagai departemen.',
                'gambar'     => 'img/curved-images/curved8.jpg',
            ],
            [
                'nama_kelas' => 'Leadership Class',
                'kategori'   => 'Equip - Lead',
                'deskripsi'  => 'Membangun jiwa kepemimpinan yang berintegritas.',
                'gambar'     => 'img/curved-images/curved14.jpg',
            ],
            [
                'nama_kelas' => 'Married Class',
                'kategori'   => 'Equip - Grow',
                'deskripsi'  => 'Membangun pernikahan yang berpusat pada Kristus.',
                'gambar'     => 'img/curved-images/curved14.jpg', // Placeholder image since not in view
            ],
        ];

        foreach ($kelasData as $data) {
            \App\Models\Kelas::updateOrCreate(
                ['nama_kelas' => $data['nama_kelas']],
                $data
            );
        }
    }
}
