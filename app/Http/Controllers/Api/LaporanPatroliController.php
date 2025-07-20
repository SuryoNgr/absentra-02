<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPatroli;
use Illuminate\Support\Facades\Storage;

class LaporanPatroliController extends Controller
{
    // Simpan laporan patroli dari petugas yang login
    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'catatan' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto' => 'required|image|max:2048',
        ]);


        $path = null;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto-patroli', 'public');
        }

        $laporan = LaporanPatroli::create([
            'job_id' => $request->job_id,
            'petugas_id' => auth('petugas')->id(),
            'catatan' => $request->catatan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'foto' => $request->file('foto')->store('foto-patroli', 'public'),
        ]);


        return response()->json([
            'message' => 'Laporan berhasil dikirim',
            'data'    => $laporan,
        ]);
    }

    // (Opsional) Ambil semua laporan milik petugas yang login
    public function index()
    {
        $laporan = LaporanPatroli::where('petugas_id', auth('petugas')->id())
            ->with('job')
            ->latest()
            ->get();

        return response()->json($laporan);
    }
}
