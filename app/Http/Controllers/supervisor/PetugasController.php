<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $supervisor = Auth::guard('supervisor')->user();

        // Ambil role unik
        $roles = Petugas::where('client_id', $supervisor->client_id)
                        ->select('role')
                        ->distinct()
                        ->pluck('role');

        // Filter berdasarkan role jika ada
        $query = Petugas::where('client_id', $supervisor->client_id);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $petugas = $query->get();

        return view('content.supervisor.petugas.index', compact('petugas', 'roles'));
    }

    public function unassign($id)
    {
        $petugas = Petugas::where('id', $id)
            ->where('client_id', Auth::user()->client_id) // memastikan hanya unassign milik client yg sesuai
            ->firstOrFail();

        $petugas->client_id = null; // kosongkan relasi ke client
        $petugas->save();

        return redirect()->route('supervisor.petugas.index')
            ->with('success', 'Petugas berhasil di-unassign.');
    }

}
