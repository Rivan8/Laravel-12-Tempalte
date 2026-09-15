<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sesi;
use Illuminate\Http\Request;

class AdminSesiController extends Controller
{
    private function authorizeAdmin(): void
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403);
        }
    }

    public function index($kelasId)
    {
        $this->authorizeAdmin();
        $kelas = Kelas::with(['sesis.materi', 'sesis.quiz.questions'])->findOrFail($kelasId);
        return view('admin.sesi.index', compact('kelas'));
    }

    public function create($kelasId)
    {
        $this->authorizeAdmin();
        $kelas = Kelas::findOrFail($kelasId);
        $nextUrutan = ($kelas->sesis()->max('urutan') ?? 0) + 1;
        return view('admin.sesi.create', compact('kelas', 'nextUrutan'));
    }

    public function store(Request $request, $kelasId)
    {
        $this->authorizeAdmin();
        Kelas::findOrFail($kelasId);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'link_quiz' => 'nullable|url',
            'urutan' => 'required|integer|min:1',
            'tanggal_pelaksanaan' => 'nullable|date',
        ]);
        $validated['kelas_id'] = $kelasId;
        Sesi::create($validated);

        return redirect()->route('admin.sesi.index', $kelasId)->with('success', 'Sesi berhasil dibuat.');
    }

    public function edit($kelasId, $sesiId)
    {
        $this->authorizeAdmin();
        $kelas = Kelas::findOrFail($kelasId);
        $sesi = Sesi::where('kelas_id', $kelasId)->findOrFail($sesiId);
        return view('admin.sesi.edit', compact('kelas', 'sesi'));
    }

    public function update(Request $request, $kelasId, $sesiId)
    {
        $this->authorizeAdmin();
        $sesi = Sesi::where('kelas_id', $kelasId)->findOrFail($sesiId);
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'link_quiz' => 'nullable|url',
            'urutan' => 'required|integer|min:1',
            'tanggal_pelaksanaan' => 'nullable|date',
        ]);
        $sesi->update($validated);

        return redirect()->route('admin.sesi.index', $kelasId)->with('success', 'Sesi berhasil diperbarui.');
    }

    public function destroy($kelasId, $sesiId)
    {
        $this->authorizeAdmin();
        $sesi = Sesi::where('kelas_id', $kelasId)->findOrFail($sesiId);
        $sesi->delete();

        return back()->with('success', 'Sesi dan video di dalamnya berhasil dihapus.');
    }
}
