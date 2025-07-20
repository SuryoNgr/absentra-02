<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; // ← WAJIB ADA
use App\Models\Client;
use App\Models\Job;

class DashboardController extends Controller
{
    public function index()
{
    $supervisor = Auth::guard('supervisor')->user();

    $client = Client::find($supervisor->client_id); // ⬅️ Ambil data client-nya supervisor

    $jobsToday = Job::with('petugas')
        ->where('client_id', $supervisor->client_id)
        ->whereDate('waktu_mulai', now()->toDateString())
        ->get()
        ->groupBy('nama_tim');

    return view('content.supervisor.dashboard', compact('jobsToday', 'client'));
}


}

