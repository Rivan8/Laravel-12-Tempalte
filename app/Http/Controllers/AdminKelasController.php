<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class AdminKelasController extends Controller
{
    public function index()
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelases = Kelas::with(['prasyarat', 'materi'])->get();
        return view('admin.kelas.index', compact('kelases'));
    }

    public function create()
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelasLain = Kelas::all();
        return view('admin.kelas.create', compact('kelasLain'));
    }

    public function store(Request $request)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        
        $validated = $request->validate([
            'nama_kelas'         => 'required|string|max:255',
            'kategori'           => 'required|string|max:255',
            'deskripsi'          => 'required|string',
            'prasyarat_kelas_id' => 'nullable|exists:kelas,id',
            'gambar'             => 'nullable|string',
            'link_quiz'          => 'nullable|url'
        ]);

        if (empty($validated['gambar'])) {
            $validated['gambar'] = 'img/curved-images/curved1.jpg'; // default cover
        }

        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas baru berhasil dibuat.');
    }

    public function edit($id)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelas = Kelas::findOrFail($id);
        $kelasLain = Kelas::where('id', '!=', $id)->get();
        return view('admin.kelas.edit', compact('kelas', 'kelasLain'));
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        
        $kelas = Kelas::findOrFail($id);
        
        $validated = $request->validate([
            'nama_kelas'         => 'required|string|max:255',
            'kategori'           => 'required|string|max:255',
            'deskripsi'          => 'required|string',
            'prasyarat_kelas_id' => 'nullable|exists:kelas,id',
            'gambar'             => 'nullable|string',
            'link_quiz'          => 'nullable|url'
        ]);

        $kelas->update($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Informasi kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
