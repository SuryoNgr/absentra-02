<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;

class SecurityJobController extends Controller
{
    // Tampilkan semua job security
    public function index(Request $request)
    {
        $user = Auth::guard('supervisor')->user();

        $query = Job::where('client_id', $user->client_id)
                    ->whereHas('petugas', function ($q) {
                        $q->where('role', 'security');
                    });

        if ($request->filled('team')) {
            $query->where('nama_tim', $request->team);
        }

        $jobs = $query->latest()->get();

        $availableTeams = Job::where('client_id', $user->client_id)
                            ->whereHas('petugas', fn($q) => $q->where('role', 'security'))
                            ->distinct()
                            ->pluck('nama_tim');

        return view('content.supervisor.job.security.index', compact('jobs', 'availableTeams'));
    }

    // Tampilkan form create
    public function create()
    {
        $client = Auth::guard('supervisor')->user()->client; // ambil relasi perusahaan
        $petugas = Petugas::where('client_id', $client->id)
                    ->where('role', 'security')
                    ->get();

        return view('content.supervisor.job.security.create', compact('petugas', 'client'));
    }

    // Simpan job security baru
   public function store(Request $request)
   {
             $request->validate([
           'nama_tim' => 'required|string|max:100',
           'waktu_mulai' => 'required|date',
           'waktu_selesai' => 'required|date',
           'petugas_id' => 'required|array|min:1',
           'deskripsi' => 'required|array|min:1',
           'latitude' => 'required|array|min:1',
           'longitude' => 'required|array|min:1',
       ]);

       $mulai = \Carbon\Carbon::parse($request->waktu_mulai);
       $selesai = \Carbon\Carbon::parse($request->waktu_selesai);

       if ($selesai->lte($mulai)) {
           $selesai->addDay();
       }

       $clientId = Auth::guard('supervisor')->user()->client_id;
       $jumlahTugas = count($request->deskripsi);

       foreach ($request->petugas_id as $petugasId) {
           for ($i = 0; $i < $jumlahTugas; $i++) {
               Job::create([
                   'petugas_id'    => $petugasId,
                   'client_id'     => $clientId,
                   'nama_tim'      => $request->nama_tim,
                   'waktu_mulai'   => $mulai,
                   'waktu_selesai' => $selesai,
                   'deskripsi'     => $request->deskripsi[$i],
                   'latitude'      => $request->latitude[$i],
                   'longitude'     => $request->longitude[$i],
               ]);
           }
       }

       return redirect()->route('supervisor.job.security.index')->with('success', 'Tugas security berhasil ditambahkan.');

   }


    // Detail job security
    public function show($id)
    {
        $job = Job::with('petugas')->findOrFail($id);

        if ($job->petugas->role !== 'security') {
            abort(404);
        }

        return view('content.supervisor.job.security.show', compact('job'));
    }

    // Form edit waktu
    public function edit($id)
    {
        $job = Job::findOrFail($id);

        if ($job->petugas->role !== 'security') {
            abort(404);
        }

        return view('content.supervisor.job.security.edit', compact('job'));
    }

    // Simpan update waktu
    public function update(Request $request, $id)
    {
      $request->validate([
    'waktu_mulai' => 'required|date',
    'waktu_selesai' => 'required|date',
    ]);
    
    $mulai = \Carbon\Carbon::parse($request->waktu_mulai);
    $selesai = \Carbon\Carbon::parse($request->waktu_selesai);
    
    if ($selesai->lte($mulai)) {
        $selesai->addDay();
    }
    
    $job->update([
        'waktu_mulai' => $mulai,
        'waktu_selesai' => $selesai,
    ]);


        return redirect()->route('supervisor.job.security.index')->with('success', 'Waktu tugas diperbarui.');
    }

    // Bubarkan tim berdasarkan nama_tim
    public function disbandTeam($team)
    {
        $user = Auth::guard('supervisor')->user();

        $deleted = Job::where('client_id', $user->client_id)
                    ->where('nama_tim', $team)
                    ->whereHas('petugas', fn($q) => $q->where('role', 'security'))
                    ->delete();

        return redirect()->back()->with('success', 'Tim berhasil dibubarkan (' . $deleted . ' tugas dihapus).');
    }
}
