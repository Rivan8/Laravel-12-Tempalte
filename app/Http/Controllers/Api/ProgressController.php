<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;

class ProgressController extends Controller
{
    public function markComplete(Request $request, $materi_id)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $materi = Materi::findOrFail($materi_id);

        $user->materi()->syncWithoutDetaching([
            $materi->id => ['is_completed' => true]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Progress saved successfully.'
        ]);
    }
}
