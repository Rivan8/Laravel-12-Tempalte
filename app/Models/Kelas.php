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
}
