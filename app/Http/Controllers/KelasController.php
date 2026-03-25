<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        return view('kelas.index');
    }

    public function requestKelas(Request $request, $id)
    {
        $kelas = \App\Models\Kelas::findOrFail($id);
        $user = auth()->user();

        // Pastikan belum request/completed
        if ($user->kelas()->where('kelas_id', $id)->exists()) {
            return back()->with('error', 'Anda sudah mengakses atau mendaftar kelas ini.');
        }

        $namaKelas = $kelas->nama_kelas;

        // Helper untuk cek apakah user sudah menyelesaikan kelas tertentu berdasarkan nama kelas
        $hasCompleted = function($kelasName) use ($user) {
            return $user->kelas()
                        ->where('nama_kelas', 'like', '%' . $kelasName . '%')
                        ->where('kelas_users.status', 'completed')
                        ->exists();
        };

        $canRequest = false;
        $errorMessage = 'Anda tidak memenuhi syarat untuk mendaftar kelas ini.';

        if (str_contains($namaKelas, 'DMT')) {
            if ($hasCompleted('CTT')) {
                $canRequest = true;
            } else {
                $errorMessage = 'User harus menyelesaikan kelas CTT baru bisa request kelas DMT.';
            }
        } elseif (str_contains($namaKelas, 'Foundation Class 2')) {
            if ($hasCompleted('Foundation Class 1')) {
                $canRequest = true;
            } else {
                $errorMessage = 'User harus menyelesaikan kelas Foundation Class 1 baru bisa request Foundation Class 2.';
            }
        } elseif (str_contains($namaKelas, 'Foundation Class 3')) {
            if ($hasCompleted('Foundation Class 1')) {
                $canRequest = true;
            } else {
                $errorMessage = 'User harus menyelesaikan Foundation Class 1 baru bisa request Foundation Class 3.';
            }
        } elseif (str_contains($namaKelas, 'Grade 1')) {
            if ($hasCompleted('Foundation Class 2')) {
                $canRequest = true;
            } else {
                $errorMessage = 'User harus menyelesaikan Foundation Class 2 baru bisa request Grade 1.';
            }
        } elseif (str_contains($namaKelas, 'Married Class')) {
            if ($hasCompleted('Foundation Class 2')) {
                $canRequest = true;
            } else {
                $errorMessage = 'User harus menyelesaikan Foundation Class 2 baru bisa request Married Class.';
            }
        } elseif (str_contains($namaKelas, 'Grade 2')) {
            if ($hasCompleted('Grade 1')) {
                $canRequest = true;
            } else {
                $errorMessage = 'User harus menyelesaikan Grade 1 baru bisa request Grade 2.';
            }
        } elseif (str_contains($namaKelas, 'Grade 3')) {
            if ($hasCompleted('Grade 2')) {
                $canRequest = true;
            } else {
                $errorMessage = 'User harus menyelesaikan Grade 2 baru bisa request Grade 3.';
            }
        } else {
            // Volunteer Class, Foundation Class 1, Membership Class, CTT selalu terbuka
            // Aturan default: jika tidak termasuk dalam daftar limit, akses diizinkan
            $canRequest = true;
        }

        if ($canRequest) {
            $user->kelas()->attach($id, ['status' => 'requested']);
            return back()->with('success', 'Berhasil request kelas ' . $namaKelas);
        }

        return back()->with('error', $errorMessage);
    }
}
