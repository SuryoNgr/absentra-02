<?php

// app/Models/Absensi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'job_id',
        'petugas_id',
        'status',
        'checkin_at',
        'checkout_at',
        'foto_checkin',
        'latitude',
        'longitude',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}
