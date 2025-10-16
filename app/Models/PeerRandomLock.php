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
}
