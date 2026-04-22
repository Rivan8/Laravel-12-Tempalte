<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Batch;
use Illuminate\Http\Request;

class AdminBatchController extends Controller
{
    public function index($kelas_id)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelas = Kelas::findOrFail($kelas_id);
        $batches = $kelas->batches()->orderBy('created_at', 'desc')->get();
        return view('admin.batches.index', compact('kelas', 'batches'));
    }

    public function create($kelas_id)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelas = Kelas::findOrFail($kelas_id);
        return view('admin.batches.create', compact('kelas'));
    }

    public function store(Request $request, $kelas_id)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelas = Kelas::findOrFail($kelas_id);

        $validated = $request->validate([
            'nama_batch' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);

        if ($request->has('is_active')) {
            $kelas->batches()->update(['is_active' => false]);
            $validated['is_active'] = true;
        } else {
            $validated['is_active'] = false;
        }

        $kelas->batches()->create($validated);

        return redirect()->route('admin.kelas.batches.index', $kelas->id)->with('success', 'Batch berhasil ditambahkan.');
    }

    public function edit($kelas_id, $id)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelas = Kelas::findOrFail($kelas_id);
        $batch = Batch::findOrFail($id);
        return view('admin.batches.edit', compact('kelas', 'batch'));
    }

    public function update(Request $request, $kelas_id, $id)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelas = Kelas::findOrFail($kelas_id);
        $batch = Batch::findOrFail($id);

        $validated = $request->validate([
            'nama_batch' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);

        if ($request->has('is_active')) {
            $kelas->batches()->where('id', '!=', $id)->update(['is_active' => false]);
            $validated['is_active'] = true;
        } else {
            $validated['is_active'] = false;
        }

        $batch->update($validated);

        return redirect()->route('admin.kelas.batches.index', $kelas->id)->with('success', 'Batch berhasil diperbarui.');
    }

    public function destroy($kelas_id, $id)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $batch = Batch::findOrFail($id);
        $batch->delete();
        return redirect()->route('admin.kelas.batches.index', $kelas_id)->with('success', 'Batch berhasil dihapus.');
    }
}
