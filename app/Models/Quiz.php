<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;

class Quiz extends Model
{
    protected $fillable = ['sesi_id', 'judul', 'deskripsi', 'passing_score', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('sort_order');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
