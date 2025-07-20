<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Job;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function checkin(Request $request)
    {
        $request->validate([
            'job_id'    => 'required|exists:jobs,id',
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'foto'      => 'required|image|max:2048',
        ]);

        $petugas = auth('petugas')->user();
        if (!$petugas) {
            return response()->json(['message' => 'Tidak terautentikasi'], 401);
        }

        $petugasId = $petugas->id;

        // ❗ Cegah check-in dua kali
        $existing = Absensi::where('job_id', $request->job_id)
            ->where('petugas_id', $petugasId)
            ->whereNotNull('checkin_at')
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Anda sudah melakukan absen masuk untuk tugas ini',
            ], 409); // Conflict
        }

        $job = Job::find($request->job_id);
        $now = Carbon::now();
        $mulai = Carbon::parse($job->waktu_mulai)->subMinutes(5);
        $selesai = Carbon::parse($job->waktu_selesai)->addMinutes(30);

        if ($now->lt($mulai) || $now->gt($selesai)) {
            return response()->json(['message' => 'Waktu absen tidak sesuai shift'], 403);
        }

        $distance = $this->calculateDistance(
            $job->latitude, $job->longitude,
            $request->latitude, $request->longitude
        );

        if ($distance > 0.1) {
            return response()->json(['message' => 'Anda tidak berada di lokasi tugas'], 403);
        }

        $path = $request->file('foto')->store('foto-absensi', 'public');

        $status = $now->gt(Carbon::parse($job->waktu_mulai)->addMinutes(5)) ? 'terlambat checkin' : 'checkin';

        $absen = Absensi::create([
            'job_id'       => $job->id,
            'petugas_id'   => $petugasId,
            'checkin_at'   => $now,
            'status'       => $status,
            'latitude'     => $request->latitude,
            'longitude'    => $request->longitude,
            'foto_checkin' => $path,
        ]);

        return response()->json(['message' => 'Berhasil check-in', 'data' => $absen]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
        ]);

        $petugasId = auth('petugas')->id();
        $absen = Absensi::where('job_id', $request->job_id)
                        ->where('petugas_id', $petugasId)
                        ->whereNull('checkout_at')
                        ->first();

        if (!$absen) {
            return response()->json(['message' => 'Data absensi tidak ditemukan atau sudah checkout'], 404);
        }

        $job = $absen->job;
        $now = now();

        if ($now->lt(Carbon::parse($job->waktu_selesai))) {
            return response()->json([
                'message' => 'Belum saatnya checkout. Silakan tunggu hingga waktu tugas selesai.',
            ], 403);
        }

        $absen->checkout_at = $now;
        $absen->save();

        return response()->json(['message' => 'Berhasil checkout', 'data' => $absen]);
    }

    public function riwayatHariIni()
    {
        $petugasId = auth('petugas')->id();
        $today = Carbon::today();

        $absensi = Absensi::where('petugas_id', $petugasId)
            ->whereDate('checkin_at', $today)
            ->with('job')
            ->first();

        if (!$absensi) {
            return response()->json([
                'status' => 'tidak masuk',
                'message' => 'Petugas belum melakukan absensi hari ini'
            ]);
        }

        $status = $absensi->status;

        if ($absensi->checkin_at && !$absensi->checkout_at) {
            $checkinTime = Carbon::parse($absensi->checkin_at);
            if (now()->diffInHours($checkinTime) >= 3) {
                $status = 'lupa checkout';
            }
        }

        return response()->json([
            'status' => $status,
            'checkin' => $absensi->checkin_at,
            'checkout' => $absensi->checkout_at,
            'data' => $absensi,
        ]);
    }

    // ✅ Tambahkan fungsi ini agar error tidak muncul
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}
