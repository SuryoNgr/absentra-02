<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AbsensiController extends Controller
{
     public function index(Request $request)
    {
        $user = Auth::user(); // supervisor
        $query = Absensi::with(['petugas'])
            ->whereHas('petugas', function ($q) use ($user) {
                $q->where('client_id', $user->client_id);
            });

        // Optional filter
        if ($request->filled('role')) {
            $query->whereHas('petugas', function ($q) use ($user, $request) {
                $q->where('client_id', $user->client_id)
                  ->where('role', $request->role);
            });
        }


        $absensi = $query->latest()->paginate(10);

        return view('content.supervisor.absensi.index', compact('absensi'));
    }



        public function rekapPdf(Request $request)
        {
            $user = Auth::user(); // supervisor
            $startDate = Carbon::now()->subDays(30)->startOfDay();
            $endDate = Carbon::now()->endOfDay();

            $absensi = Absensi::with('petugas')
                ->whereHas('petugas', function ($q) use ($user, $request) {
                    $q->where('client_id', $user->client_id);

                    if ($request->filled('role')) {
                        $q->where('role', $request->role);
                    }
                })
                ->whereBetween('checkin_at', [$startDate, $endDate])
                ->orderBy('checkin_at', 'desc')
                ->get();

            $pdf = Pdf::loadView('content.supervisor.absensi.rekap-pdf', compact('absensi', 'startDate', 'endDate'));

            return $pdf->download('rekap-absensi-' . now()->format('Ymd') . '.pdf');
        }

}
