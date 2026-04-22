<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_lengkap',
        'jenis_kelamin',
        'email',
        'no_hp',
        'role',
        'password',
    ];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_users')
            ->withPivot('status', 'rejection_reason')
            ->withTimestamps();
    }

    public function materi()
    {
        return $this->belongsToMany(Materi::class, 'materi_users')
                    ->withPivot('is_completed')
                    ->withTimestamps();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Penilaian Spiritual Status User (DM / Core Team / Member)
     * Otomatis membaca kelas yang lulus (completed)
     */
    public function getStatusUserAttribute()
    {
        $lulusan = $this->kelas()->wherePivot('status', 'completed')->pluck('nama_kelas')->map(function($nama) {
            return strtolower($nama);
        })->toArray();
        
        // Prioritas Tertinggi: DM
        if ($this->hasCompletedClass($lulusan, ['dmt', 'disciple maker'])) {
            return 'Disciple Maker (DM)';
        }
        
        // Prioritas Kedua: Core Team
        if ($this->hasCompletedClass($lulusan, ['ctt', 'core team'])) {
            return 'Core Team';
        }
        
        return 'Member';
    }

    /**
     * Penilaian Fase Pertumbuhan EQUIP (Volunteer / Grow / Plant / New)
     */
    public function getEquipStatusAttribute()
    {
        $lulusan = $this->kelas()->wherePivot('status', 'completed')->pluck('nama_kelas')->map(function($nama) {
            return strtolower($nama);
        })->toArray();
        
        if ($this->hasCompletedClass($lulusan, ['volunteer'])) {
            return 'Volunteer';
        }
        
        $hasGrade1 = $this->hasCompletedClass($lulusan, ['grade 1', 'g1']);
        $hasMarried = $this->hasCompletedClass($lulusan, ['married', 'marriage', 'family & marriage']);
        if ($hasGrade1 && $hasMarried) {
            return 'Grow';
        }
        
        if ($this->hasCompletedClass($lulusan, ['foundation class 2', 'fc2', 'foundation 2'])) {
            return 'Plant';
        }
        
        return 'New';
    }

    /**
     * Helper string-matching function
     */
    private function hasCompletedClass($lulusanArray, $keywordsArray)
    {
        foreach ($lulusanArray as $lulusan) {
            foreach ($keywordsArray as $keyword) {
                if (str_contains($lulusan, strtolower($keyword))) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Fungsi Cerdas: Menghitung persentase tontonan sesi (Progress Kelas)
     */
    public function classProgress($kelas_id)
    {
        $kelas = \App\Models\Kelas::withCount('materi')->find($kelas_id);
        
        // Cek jika kelas belum punya materi video satupun
        if (!$kelas || $kelas->materi_count == 0) {
            return 0;
        }
        
        // Membaca riwayat Pivot materi yang sudah is_completed untuk Kelas ID bersangkutan
        $completedCount = $this->materi()
            ->where('materis.kelas_id', $kelas_id)
            ->wherePivot('is_completed', true)
            ->count();
            
        return round(($completedCount / $kelas->materi_count) * 100);
    }
}
