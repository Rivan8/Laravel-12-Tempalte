<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Batch;
use App\Models\BatchSesi;
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
        $sesis = $kelas->sesis()->get();
        return view('admin.batches.create', compact('kelas', 'sesis'));
    }

    public function store(Request $request, $kelas_id)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelas = Kelas::findOrFail($kelas_id);

        $validated = $request->validate([
            'nama_batch' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);

        $sesis = $kelas->sesis()->get();
        if ($sesis->count() > 1) {
            $dateRules = ['tanggal_sesi' => 'required|array'];
            foreach ($sesis as $sesi) {
                $dateRules['tanggal_sesi.' . $sesi->id] = 'required|date';
            }
            $validatedDates = $request->validate($dateRules)['tanggal_sesi'];
        }

        if ($request->has('is_active')) {
            $kelas->batches()->update(['is_active' => false]);
            $validated['is_active'] = true;
        } else {
            $validated['is_active'] = false;
        }

        $batch = $kelas->batches()->create($validated);

        if ($sesis->count() > 1) {
            foreach ($sesis as $sesi) {
                BatchSesi::create([
                    'batch_id' => $batch->id,
                    'sesi_id' => $sesi->id,
                    'tanggal_pelaksanaan' => $validatedDates[$sesi->id],
                ]);
            }
        }

        return redirect()->route('admin.kelas.batches.index', $kelas->id)->with('success', 'Batch berhasil ditambahkan.');
    }

    public function edit($kelas_id, $id)
    {
        if(auth()->user()->role !== 'Admin') abort(403);
        $kelas = Kelas::findOrFail($kelas_id);
        $batch = Batch::findOrFail($id);
        $sesis = $kelas->sesis()->get();
        $batch->load('sessionSchedules');
        return view('admin.batches.edit', compact('kelas', 'batch', 'sesis'));
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

        $sesis = $kelas->sesis()->get();
        if ($sesis->count() > 1) {
            $dateRules = ['tanggal_sesi' => 'required|array'];
            foreach ($sesis as $sesi) {
                $dateRules['tanggal_sesi.' . $sesi->id] = 'required|date';
            }
            $validatedDates = $request->validate($dateRules)['tanggal_sesi'];
        }

        if ($request->has('is_active')) {
            $kelas->batches()->where('id', '!=', $id)->update(['is_active' => false]);
            $validated['is_active'] = true;
        } else {
            $validated['is_active'] = false;
        }

        $batch->update($validated);

        $batch->sessionSchedules()->delete();
        if ($sesis->count() > 1) {
            foreach ($sesis as $sesi) {
                BatchSesi::create([
                    'batch_id' => $batch->id,
                    'sesi_id' => $sesi->id,
                    'tanggal_pelaksanaan' => $validatedDates[$sesi->id],
                ]);
            }
        }

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
