<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use App\Models\LaporanPatroli;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AktivitasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = LaporanPatroli::with(['petugas'])
            ->whereHas('petugas', function ($q) use ($user, $request) {
                $q->where('client_id', $user->client_id);

                if ($request->filled('role')) {
                    $q->where('role', $request->role);
                }

                if ($request->filled('petugas_id')) {
                    $q->where('id', $request->petugas_id);
                }
            });

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $laporan = $query->latest()->paginate(10);
        $daftarPetugas = Petugas::where('client_id', $user->client_id)->orderBy('nama')->get();

        return view('content.supervisor.aktivitas.index', compact('laporan', 'daftarPetugas'));
    }

    public function cetak(Request $request)
    {
        $user = Auth::user();

        $query = LaporanPatroli::with(['petugas'])
            ->whereHas('petugas', function ($q) use ($user, $request) {
                $q->where('client_id', $user->client_id);

                if ($request->filled('role')) {
                    $q->where('role', $request->role);
                }

                if ($request->filled('petugas_id')) {
                    $q->where('id', $request->petugas_id);
                }
            });

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $laporan = $query->latest()->get();

        $petugasNama = null;
        if ($request->filled('petugas_id')) {
            $petugas = Petugas::find($request->petugas_id);
            $petugasNama = $petugas?->nama;
        }

        $pdf = Pdf::loadView('content.supervisor.aktivitas.pdf', compact('laporan', 'petugasNama'));
        return $pdf->download('laporan-aktivitas-' . now()->format('Ymd_His') . '.pdf');
    }
}
