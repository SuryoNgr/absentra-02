<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';

protected $fillable = [
    'petugas_id',
    'client_id',
    'nama_tim',
    'waktu_mulai',
    'waktu_selesai',
    'deskripsi',
    'latitude',
    'longitude',
];
    // Relasi ke Petugas (jika ada)
    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }

    // Optional: relasi ke Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function absensis()
    {
        return $this->hasMany(\App\Models\Absensi::class);
    }
}
