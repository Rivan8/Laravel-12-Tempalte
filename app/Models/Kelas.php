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
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'kelas_users')
            ->withPivot('status')
            ->withTimestamps();
    }
}
