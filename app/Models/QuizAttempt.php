<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = ['share_token', 'quiz_id', 'user_id', 'score', 'status', 'submitted_at'];

    protected $casts = ['score' => 'decimal:2', 'submitted_at' => 'datetime'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
