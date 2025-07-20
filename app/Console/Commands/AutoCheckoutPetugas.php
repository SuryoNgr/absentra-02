<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Absensi;
use Carbon\Carbon;

class AutoCheckoutPetugas extends Command
{
    protected $signature = 'absensi:auto-checkout';
    protected $description = 'Auto checkout petugas jika melewati batas waktu job dan belum checkout.';

    public function handle()
    {
        $now = Carbon::now();

        $absensis = Absensi::with('job')
            ->whereNotNull('checkin_at')
            ->whereNull('checkout_at')
            ->get();

        $count = 0;

        foreach ($absensis as $absensi) {
            if (!$absensi->job) {
                continue; // skip jika job tidak ditemukan
            }

            $jobSelesai = Carbon::parse($absensi->job->waktu_selesai);

            // Cek jika waktu sekarang sudah 2 jam lewat dari job selesai
            if ($now->diffInMinutes($jobSelesai, absolute: false) <= -120) {
                $absensi->checkout_at = $jobSelesai->copy()->addHours(2);
                $absensi->status = 'lupa checkout';
                $absensi->save();

                $count++;
            }
        }

        $this->info("Auto checkout selesai. $count absensi diupdate.");
    }
}
