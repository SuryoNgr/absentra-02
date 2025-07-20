<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JobController extends Controller
{
    public function getActiveJob(Request $request)
    {
    $petugasId = auth('petugas')->id();
    $now = now();

    $job = Job::where('waktu_mulai', '<=', $now)
        ->where('waktu_selesai', '>=', $now)
        ->where('petugas_id', $petugasId)
        ->first();

    if (!$job) {
        return response()->json(['message' => 'Tidak ada tugas aktif'], 404);
    }

    return response()->json([
        'job_id' => $job->id,
        'nama_tim' => $job->nama_tim,
        'latitude' => $job->latitude,
        'longitude' => $job->longitude,
        'waktu_mulai' => $job->waktu_mulai,
        'waktu_selesai' => $job->waktu_selesai,
    ]);
    }

}
