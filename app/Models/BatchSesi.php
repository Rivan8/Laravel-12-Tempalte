<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchSesi extends Model
{
    protected $table = 'batch_sesi';

    protected $fillable = [
        'batch_id',
        'sesi_id',
        'tanggal_pelaksanaan',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class);
    }
}
