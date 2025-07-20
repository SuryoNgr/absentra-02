<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;

class CleaningJobController extends Controller
{
    // Tampilkan semua pekerjaan Cleaning Services
    public function index(Request $request)
    {
        $user = Auth::guard('supervisor')->user();

        $query = Job::where('client_id', $user->client_id)
                    ->whereHas('petugas', function ($q) {
                        $q->where('role', 'cleaning services');
                    });

        if ($request->filled('team')) {
            $query->where('nama_tim', $request->team);
        }

        $jobs = $query->latest()->get();

        $availableTeams = Job::where('client_id', $user->client_id)
                            ->whereHas('petugas', function ($q) {
                                $q->where('role', 'cleaning services');
                            })
                            ->distinct()->pluck('nama_tim');

        return view('content.supervisor.job.cleaning.index', compact('jobs', 'availableTeams'));
    }

    // Form tambah job Cleaning
    public function create()
{
    $client = Auth::guard('supervisor')->user()->client;

    $petugas = Petugas::where('client_id', $client->id)
                      ->where('role', 'cleaning services')
                      ->get();

    return view('content.supervisor.job.cleaning.create', compact('petugas', 'client'));
}


    // Simpan job Cleaning baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_tim' => 'required|string|max:100',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'petugas_id' => 'required|array|min:1',
            'petugas_id.*' => 'required|exists:petugas,id',
            'deskripsi' => 'required|array|min:1',
            'deskripsi.*' => 'nullable|string',
            'latitude' => 'required|array|min:1',
            'latitude.*' => 'required|numeric|between:-90,90',
            'longitude' => 'required|array|min:1',
            'longitude.*' => 'required|numeric|between:-180,180',
        ]);

        $petugasIds = $request->petugas_id;
        $deskripsiList = $request->deskripsi;
        $latitudes = $request->latitude;
        $longitudes = $request->longitude;

        // Validasi jumlah tugas dan lokasi harus cocok
        $jumlahTugas = count($deskripsiList);
        if ($jumlahTugas !== count($latitudes) || $jumlahTugas !== count($longitudes)) {
            return back()->with('error', 'Jumlah tugas dan lokasi tidak cocok.');
        }

        foreach ($petugasIds as $petugasId) {
            $petugas = Petugas::findOrFail($petugasId);

            for ($i = 0; $i < $jumlahTugas; $i++) {
                Job::create([
                    'petugas_id'    => $petugas->id,
                    'client_id'     => $petugas->client_id,
                    'nama_tim'      => $request->nama_tim,
                    'waktu_mulai'   => $request->waktu_mulai,
                    'waktu_selesai' => $request->waktu_selesai,
                    'deskripsi'     => $deskripsiList[$i],
                    'latitude'      => $latitudes[$i],
                    'longitude'     => $longitudes[$i],
                ]);
            }
        }

        return redirect()->route('supervisor.job.cleaning.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

public function show($id)
{
    $job = \App\Models\Job::with(['petugas', 'client'])->findOrFail($id);

    return view('content.supervisor.job.cleaning.show', compact('job'));
}
public function edit($id)
{
    $job = \App\Models\Job::findOrFail($id);

    // Pastikan supervisor hanya bisa edit job dari client-nya
    if ($job->client_id != auth('supervisor')->user()->client_id) {
        abort(403);
    }

    return view('content.supervisor.job.cleaning.edit', compact('job'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'waktu_mulai' => 'required|date',
        'waktu_selesai' => 'required|date|after:waktu_mulai',
    ]);

    $job = \App\Models\Job::findOrFail($id);

    if ($job->client_id != auth('supervisor')->user()->client_id) {
        abort(403);
    }

    $job->update([
        'waktu_mulai' => $request->waktu_mulai,
        'waktu_selesai' => $request->waktu_selesai,
    ]);

    return redirect()->route('supervisor.job.cleaning.index')->with('success', 'Waktu job berhasil diperbarui.');
}
public function disbandTeam($team)
{
    $user = Auth::guard('supervisor')->user();

    Job::where('client_id', $user->client_id)
        ->where('nama_tim', $team)
        ->delete();

    return redirect()->back()->with('success', "Tim \"$team\" telah dibubarkan.");
}


}
