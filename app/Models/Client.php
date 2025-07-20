<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // App\Models\Client.php
protected $fillable = [
    'nama_perusahaan',
    'email',
    'nomor_telephone',
    'alamat',
    'latitude', // ← tambahkan ini
    'longitude' // ← dan ini
];


    public function petugas()
{
    return $this->hasMany(Petugas::class);
}

}
