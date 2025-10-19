<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeerRandomLock extends Model
{
    use HasFactory;

    protected $table = 'peer_random_lock';

    protected $fillable = [
        'periode_id',
        'kelas_id',
        'siswa_user_id',
        'teman_user_id',
        'bulan',
        'minggu_ke',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'siswa_user_id', 'id');
    }

    public function teman()
    {
        return $this->belongsTo(User::class, 'teman_user_id', 'id');
    }

    // public function assessmentProcess()
    // {
    //     return $this->hasOne(AssessmentProcess::class, 'siswa_user_id', 'teman_user_id');
    // }

    public function getAssessmentProcessAttribute()
    {
        return AssessmentProcess::where('siswa_user_id', $this->teman_user_id)
            ->where('periode_id', $this->periode_id)
            ->where('kelas_id', $this->kelas_id)
            ->where('bulan', $this->bulan)
            ->where('minggu_ke', $this->minggu_ke)
            ->first();
    }
}
