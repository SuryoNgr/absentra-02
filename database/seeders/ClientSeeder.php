<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::create([
            'nama_perusahaan' => 'PT Absentra Indonesia',
            'email' => 'admin@absentra.id',
            'nomor_telephone' => '081234567890',
            'alamat' => 'Jl. Raya Contoh No. 123, Jakarta Selatan',
            'latitude' => -6.20000000,
            'longitude' => 106.81666600,
        ]);
    }
}
