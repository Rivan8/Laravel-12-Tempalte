<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
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

        $search = $request->input('search');

        $usersQuery = \App\Models\User::with('kelas')->orderBy('created_at', 'desc');

        if ($search) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $users = $usersQuery->paginate(10);

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

    public function reject(Request $request, $user_id, $kelas_id)
    {
        if (auth()->user()->role !== 'Admin') abort(403);

        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        \Illuminate\Support\Facades\DB::table('kelas_users')
            ->where('user_id', $user_id)
            ->where('kelas_id', $kelas_id)
            ->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Request kelas berhasil ditolak.');
    }

    public function edit(\App\Models\User $user)
    {
        if (auth()->user()->role !== 'Admin') abort(403);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, \App\Models\User $user)
    {
        if (auth()->user()->role !== 'Admin') abort(403);

        $validated = $request->validate([
            'role' => 'required|in:Admin,Fasilitator,Member',
        ]);

        $user->update([
            'role' => $validated['role']
        ]);

        return redirect()->route('users.index')->with('success', 'Role pengguna ' . $user->nama_lengkap . ' berhasil diperbarui.');
    }

    public function destroy(\App\Models\User $user)
    {
        if (auth()->user()->role !== 'Admin') abort(403);

        // Hapus data relasi jika perlu, tapi biasanya sudah ada cascade di DB
        // Namun untuk amannya kita hapus manual relasinya
        \Illuminate\Support\Facades\DB::table('kelas_users')->where('user_id', $user->id)->delete();
        \Illuminate\Support\Facades\DB::table('materi_users')->where('user_id', $user->id)->delete();

        $nama = $user->nama_lengkap ?? $user->name;
        $user->delete();

        return back()->with('success', 'Pengguna ' . $nama . ' berhasil dihapus.');
    }
}
