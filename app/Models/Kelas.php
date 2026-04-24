<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas',
        'kategori',
        'deskripsi',
        'gambar',
        'prasyarat_kelas_id',
        'link_quiz',
        'handbook',
        'handbook_name',
        'tools',
        'tools_name',
        'slide',
        'slide_name',
        'file_4', 'file_4_name',
        'file_5', 'file_5_name',
        'file_6', 'file_6_name',
        'file_7', 'file_7_name',
        'file_8', 'file_8_name',
        'file_9', 'file_9_name',
        'file_10', 'file_10_name',
        'file_11', 'file_11_name',
        'file_12', 'file_12_name',
    ];

    public function prasyarat()
    {
        return $this->belongsTo(Kelas::class, 'prasyarat_kelas_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'kelas_users', 'kelas_id', 'user_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
