<?php

// File: app/Console/Kernel.php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Absensi;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $now = now();

        $absensis = Absensi::whereNull('checkout_at')
            ->whereHas('job', function ($query) use ($now) {
                $query->where('waktu_selesai', '<=', $now->subHours(2));
            })->get();

        foreach ($absensis as $absen) {
            $absen->checkout_at = $now;
            $absen->status = 'terlambat checkout';
            $absen->save();
        }
    })->everyTenMinutes(); // atau everyFiveMinutes() sesuai kebutuhan
}

    protected function commands(): void
    {
        // Kamu bisa load command secara otomatis atau secara eksplisit
        $this->load(__DIR__.'/Commands');
    }
}