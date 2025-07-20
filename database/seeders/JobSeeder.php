<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'client_id'     => 1,
                'petugas_id'    => 1,
                'nama_tim'      => 'Tim Alpha',
                'waktu_mulai'   => Carbon::now()->subHours(2),
                'waktu_selesai' => Carbon::now()->addHours(2),
                'latitude'      => -6.2000000,
                'longitude'     => 106.8166667,
                'deskripsi'     => 'Patroli area utama gedung A',
            ],
            [
                'client_id'     => 1,
                'petugas_id'    => 1,
                'nama_tim'      => 'Tim Bravo',
                'waktu_mulai'   => Carbon::now()->addDay()->setTime(8, 0),
                'waktu_selesai' => Carbon::now()->addDay()->setTime(16, 0),
                'latitude'      => -6.2100000,
                'longitude'     => 106.8200000,
                'deskripsi'     => 'Patroli area parkir dan sekitarnya',
            ],
        ];

        foreach ($jobs as $job) {
            Job::create($job);
        }
    }
}
