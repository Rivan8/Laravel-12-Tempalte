<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Pastikan hanya Admin yang bisa akses
        if (auth()->user()->role !== 'Admin') abort(403);

        $requests = \Illuminate\Support\Facades\DB::table('kelas_users')
            ->join('users', 'kelas_users.user_id', '=', 'users.id')
            ->join('kelas', 'kelas_users.kelas_id', '=', 'kelas.id')
            ->where('kelas_users.status', 'requested')
            ->select('users.id as user_id', 'users.nama_lengkap', 'users.email', 'kelas.id as kelas_id', 'kelas.nama_kelas', 'kelas_users.created_at as request_date')
            ->orderBy('kelas_users.created_at', 'desc')
            ->get();

        $users = \App\Models\User::orderBy('created_at', 'desc')->get();

        return view('users.index', compact('requests', 'users'));
    }

    public function approve($user_id, $kelas_id)
    {
        if (auth()->user()->role !== 'Admin') abort(403);

        \Illuminate\Support\Facades\DB::table('kelas_users')
            ->where('user_id', $user_id)
            ->where('kelas_id', $kelas_id)
            ->update([
                'status' => 'in_progress', 
                'updated_at' => now()
            ]);

        return back()->with('success', 'Request kelas berhasil disetujui.');
    }
}
