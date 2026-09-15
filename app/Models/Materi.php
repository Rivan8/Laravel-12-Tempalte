<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = [
        'kelas_id', 'sesi_id', 'judul', 'deskripsi', 'video_url', 'pembicara', 'urutan'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class);
    }
}
