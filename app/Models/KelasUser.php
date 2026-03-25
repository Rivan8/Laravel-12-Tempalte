<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasUser extends Model
{
    protected $table = 'kelas_users';
    
    protected $fillable = [
        'user_id',
        'kelas_id',
        'status',
    ];
}
