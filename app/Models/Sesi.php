<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    protected $fillable = [
        'kelas_id',
        'judul',
        'deskripsi',
        'link_quiz',
        'urutan',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class)->orderBy('urutan');
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }
}
