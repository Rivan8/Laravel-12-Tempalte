<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
             'gambar'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
             'link_quiz'          => 'nullable|url',
             'handbook'           => 'nullable|file|mimes:pdf,docx,doc,pptx,ppt,zip,rar|max:10240',
             'tools'              => 'nullable|file|mimes:pdf,docx,doc,pptx,ppt,zip,rar|max:10240',
             'slide'              => 'nullable|file|mimes:pdf,docx,doc,pptx,ppt,zip,rar|max:10240',
         ]);
 
         // Handle upload gambar
         if ($request->hasFile('gambar')) {
             $path = $request->file('gambar')->store('kelas', 'public');
             $validated['gambar'] = 'storage/' . $path;
         } else {
             // Default cover jika tidak ada upload
             $validated['gambar'] = 'img/curved-images/curved1.jpg';
         }

         // Handle upload file pendukung
         foreach (['handbook', 'tools', 'slide'] as $fileField) {
             if ($request->hasFile($fileField)) {
                 $path = $request->file($fileField)->store('materi_pendukung', 'public');
                 $validated[$fileField] = 'storage/' . $path;
             }
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
             'gambar'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
             'link_quiz'          => 'nullable|url',
             'handbook'           => 'nullable|file|mimes:pdf,docx,doc,pptx,ppt,zip,rar|max:10240',
             'tools'              => 'nullable|file|mimes:pdf,docx,doc,pptx,ppt,zip,rar|max:10240',
             'slide'              => 'nullable|file|mimes:pdf,docx,doc,pptx,ppt,zip,rar|max:10240',
         ]);
 
         // Handle upload gambar baru
         if ($request->hasFile('gambar')) {
             // Hapus gambar lama jika bukan default
             if ($kelas->gambar && str_starts_with($kelas->gambar, 'storage/')) {
                 $oldPath = str_replace('storage/', '', $kelas->gambar);
                 Storage::disk('public')->delete($oldPath);
             }
             $path = $request->file('gambar')->store('kelas', 'public');
             $validated['gambar'] = 'storage/' . $path;
         } else {
             // Pertahankan gambar lama
             unset($validated['gambar']);
         }

         // Handle upload atau hapus file pendukung baru
         foreach (['handbook', 'tools', 'slide'] as $fileField) {
             if ($request->hasFile($fileField)) {
                 // Hapus file lama jika ada
                 if ($kelas->$fileField) {
                     $oldPath = str_replace('storage/', '', $kelas->$fileField);
                     Storage::disk('public')->delete($oldPath);
                 }
                 $path = $request->file($fileField)->store('materi_pendukung', 'public');
                 $validated[$fileField] = 'storage/' . $path;
             } elseif ($request->has("delete_{$fileField}")) {
                 // Hapus file jika dicentang hapus
                 if ($kelas->$fileField) {
                     $oldPath = str_replace('storage/', '', $kelas->$fileField);
                     Storage::disk('public')->delete($oldPath);
                 }
                 $validated[$fileField] = null;
             } else {
                 unset($validated[$fileField]);
             }
         }

        $kelas->update($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Informasi kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelas = Kelas::findOrFail($id);

         // Hapus gambar dari storage jika bukan default
         if ($kelas->gambar && str_starts_with($kelas->gambar, 'storage/')) {
             $oldPath = str_replace('storage/', '', $kelas->gambar);
             Storage::disk('public')->delete($oldPath);
         }
 
         // Hapus file pendukung
         foreach (['handbook', 'tools', 'slide'] as $fileField) {
             if ($kelas->$fileField) {
                 $oldPath = str_replace('storage/', '', $kelas->$fileField);
                 Storage::disk('public')->delete($oldPath);
             }
         }

        $kelas->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
