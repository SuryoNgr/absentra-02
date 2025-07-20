<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyAutoCheckoutSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();

        try {
            // Buat Job yang sudah selesai lebih dari 2 jam lalu
            $job = Job::create([
                'client_id' => 1,
                'petugas_id' => 1, // ✅ tambahkan ini sesuai ID petugas yang ada
                'nama_tim' => 'Tim Test Auto Checkout',
                'waktu_mulai' => Carbon::now()->subHours(5),
                'waktu_selesai' => Carbon::now()->subHours(3),
                'latitude' => -6.200000,
                'longitude' => 106.816666,
            ]);


            // Buat Absensi dengan checkin, tapi belum checkout
            Absensi::create([
                'job_id'        => $job->id,
                'petugas_id'    => 1, // Sesuaikan dengan ID petugas yang sudah ada
                'checkin_at'    => Carbon::now()->subHours(4),
                'checkout_at'   => null,
                'status'        => 'checkin',
                'latitude'      => -6.200000,
                'longitude'     => 106.816666,
                'foto_checkin'  => 'foto-absensi/dummy.jpg',
            ]);

            DB::commit();

            $this->command->info('Dummy job dan absensi untuk auto-checkout berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Gagal membuat data dummy: ' . $e->getMessage());
        }
    }
}
