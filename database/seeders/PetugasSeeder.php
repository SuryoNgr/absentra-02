<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['security', 'cleaning services', 'pramugari', 'driver'];

        foreach ($roles as $role) {
            for ($i = 1; $i <= 3; $i++) {
                Petugas::create([
                    'nama' => ucfirst($role) . " $i",
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => now()->subYears(rand(20, 40))->subDays(rand(1, 365)),
                    'jenis_kelamin' => rand(0, 1) ? 'Laki-laki' : 'Perempuan',
                    'nomor_hp' => '0812' . rand(10000000, 99999999),
                    'email' => strtolower(str_replace(' ', '', $role)) . "$i@example.com",
                    'alamat' => 'Jl. Contoh Alamat No.' . $i,
                    'role' => $role,
                    'password' => Hash::make('password123'),
                ]);
            }
        }
    }
}
