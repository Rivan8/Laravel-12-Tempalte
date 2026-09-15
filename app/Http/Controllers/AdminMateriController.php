<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Materi;
use Illuminate\Http\Request;

class AdminMateriController extends Controller
{
    public function index($kelasId)
    {
        if(auth()->user()->role !== 'Admin') abort(403);

        $kelas = Kelas::with(['materi' => function($q) {
            $q->orderBy('sesi_id')->orderBy('urutan', 'asc');
        }, 'sesis.materi', 'sesis.quiz'])->findOrFail($kelasId);

        return view('admin.materi.index', compact('kelas'));
    }

    public function create($kelasId)
    {
        if(auth()->user()->role !== 'Admin') abort(403);

        $kelas = Kelas::findOrFail($kelasId);

        // Auto-increment urutan logic
        $sesiId = request()->integer('sesi_id') ?: null;
        $sesis = $kelas->sesis()->get();
        $nextUrutan = $sesiId ? (($kelas->materi()->where('sesi_id', $sesiId)->max('urutan') ?? 0) + 1) : (($kelas->materi()->max('urutan') ?? 0) + 1);

        return view('admin.materi.create', compact('kelas', 'sesis', 'sesiId', 'nextUrutan'));
    }

    public function store(Request $request, $kelasId)
    {
        if(auth()->user()->role !== 'Admin') abort(403);

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'video_url' => 'required|url',
            'pembicara' => 'nullable|string|max:255',
            'sesi_id'   => 'required|exists:sesis,id',
            'urutan'    => 'required|integer|min:1'
        ]);

        // Convert watch format to embed format
        if (strpos($validated['video_url'], 'watch?v=') !== false) {
            $validated['video_url'] = str_replace('watch?v=', 'embed/', $validated['video_url']);
        }

        $validated['kelas_id'] = $kelasId;

        if (!\App\Models\Sesi::where('id', $validated['sesi_id'])->where('kelas_id', $kelasId)->exists()) {
            abort(422, 'Sesi tidak sesuai dengan kelas.');
        }

        Materi::create($validated);

        return redirect()->route('admin.materi.index', $kelasId)->with('success', 'Video materi sesi terbaru berhasil diunggah.');
    }

    public function edit($kelasId, $materiId)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelas = Kelas::findOrFail($kelasId);
        $sesis = $kelas->sesis()->get();
        $materi = Materi::where('kelas_id', $kelasId)->findOrFail($materiId);

        return view('admin.materi.edit', compact('kelas', 'materi', 'sesis'));
    }

    public function update(Request $request, $kelasId, $materiId)
    {
        if(auth()->user()->role !== 'Admin') abort(403);

        $materi = Materi::where('kelas_id', $kelasId)->findOrFail($materiId);

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'video_url' => 'required|url',
            'pembicara' => 'nullable|string|max:255',
            'sesi_id'   => 'required|exists:sesis,id',
            'urutan'    => 'required|integer|min:1'
        ]);

        // Convert watch format to embed format
        if (strpos($validated['video_url'], 'watch?v=') !== false) {
            $validated['video_url'] = str_replace('watch?v=', 'embed/', $validated['video_url']);
        }

        if (!\App\Models\Sesi::where('id', $validated['sesi_id'])->where('kelas_id', $kelasId)->exists()) {
            abort(422, 'Sesi tidak sesuai dengan kelas.');
        }

        $materi->update($validated);

        return redirect()->route('admin.materi.index', $kelasId)->with('success', 'Video materi berhasil diperbarui.');
    }

    public function destroy($kelasId, $materiId)
    {
        if(auth()->user()->role !== 'Admin') abort(403);

        $materi = Materi::where('kelas_id', $kelasId)->findOrFail($materiId);
        $materi->delete();

        return back()->with('success', 'Sesi materi tersebut sukses dihapus.');
    }
}
