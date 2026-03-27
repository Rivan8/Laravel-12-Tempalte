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
            $q->orderBy('urutan', 'asc');
        }])->findOrFail($kelasId);
        
        return view('admin.materi.index', compact('kelas'));
    }

    public function create($kelasId)
    {
        if(auth()->user()->role !== 'Admin') abort(403);

        $kelas = Kelas::findOrFail($kelasId);
        
        // Auto-increment urutan logic
        $nextUrutan = $kelas->materi()->max('urutan') + 1;
        
        return view('admin.materi.create', compact('kelas', 'nextUrutan'));
    }

    public function store(Request $request, $kelasId)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'video_url' => 'required|url',
            'urutan'    => 'required|integer|min:1'
        ]);
        
        // Convert watch format to embed format
        if (strpos($validated['video_url'], 'watch?v=') !== false) {
            $validated['video_url'] = str_replace('watch?v=', 'embed/', $validated['video_url']);
        }
        
        $validated['kelas_id'] = $kelasId;

        Materi::create($validated);

        return redirect()->route('admin.materi.index', $kelasId)->with('success', 'Video materi sesi terbaru berhasil diunggah.');
    }

    public function edit($kelasId, $materiId)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelas = Kelas::findOrFail($kelasId);
        $materi = Materi::where('kelas_id', $kelasId)->findOrFail($materiId);
        
        return view('admin.materi.edit', compact('kelas', 'materi'));
    }

    public function update(Request $request, $kelasId, $materiId)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        
        $materi = Materi::where('kelas_id', $kelasId)->findOrFail($materiId);
        
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'video_url' => 'required|url',
            'urutan'    => 'required|integer|min:1'
        ]);
        
        // Convert watch format to embed format
        if (strpos($validated['video_url'], 'watch?v=') !== false) {
            $validated['video_url'] = str_replace('watch?v=', 'embed/', $validated['video_url']);
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
