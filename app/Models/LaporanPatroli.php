<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanPatroli extends Model
{
    use HasFactory;

    protected $table = 'laporan_patroli';

    protected $fillable = [
        'job_id',
        'petugas_id',
        'catatan',
        'latitude',
        'longitude',
        'foto',
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
