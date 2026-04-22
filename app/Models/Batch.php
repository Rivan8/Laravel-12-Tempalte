<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'kelas_id',
        'nama_batch',
        'start_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kelasUsers()
    {
        return $this->hasMany(KelasUser::class);
    }
}
