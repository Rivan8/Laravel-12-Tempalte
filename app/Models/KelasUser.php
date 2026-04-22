<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasUser extends Model
{
    protected $table = 'kelas_users';
    
    protected $fillable = [
        'user_id',
        'kelas_id',
        'batch_id',
        'status',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
