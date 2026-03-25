<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;

class UpdatePrasyaratSeeder extends Seeder
{
    public function run(): void
    {
        // Peta Prasyarat berdasarkan ID Seeder Sebelumnya
        // 1: CTT, 2: DMT, 3: Foundation 1, 4: Membership, 5: Foundation 2, 6: Foundation 3
        // 7: Grade 1, 8: Grade 2, 9: Grade 3, 10: Volunteer, 11: Leadership, 12: Married

        $prasyarats = [
            2 => 1, // DMT wajib lulus CTT (1)
            5 => 3, // Foundation Class 2 wajib lulus Foundation Class 1 (3)
            6 => 3, // Foundation Class 3 wajib lulus Foundation Class 1 (3)
            7 => 5, // Grade 1 wajib lulus Foundation Class 2 (5)
            8 => 7, // Grade 2 wajib lulus Grade 1 (7)
            9 => 8, // Grade 3 wajib lulus Grade 2 (8)
            12 => 5 // Married Class wajib lulus Foundation Class 2 (5)
        ];

        foreach ($prasyarats as $kelasId => $prasyaratId) {
            Kelas::where('id', $kelasId)->update(['prasyarat_kelas_id' => $prasyaratId]);
        }
    }
}
