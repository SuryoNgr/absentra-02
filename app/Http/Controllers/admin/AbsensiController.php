<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Client;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with(['petugas', 'petugas.client']);

        if ($request->filled('role')) {
            $query->whereHas('petugas', fn($q) => $q->where('role', $request->role));
        }

        if ($request->filled('client_id')) {
            $query->whereHas('petugas', fn($q) => $q->where('client_id', $request->client_id));
        }

        $absensi = $query->latest()->paginate(10);
        $clients = Client::all(); // untuk filter client
        $roles = ['security', 'cleaning services', 'other'];

        return view('content.admin.absensi.index', compact('absensi', 'clients', 'roles'));
    }
}
