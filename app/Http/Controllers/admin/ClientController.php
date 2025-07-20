<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('petugas')->get();

        return view('content.admin.client.data-client', compact('clients'));
    }

    public function create()
    {
        return view('content.admin.client.add');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_perusahaan' => 'required|string|max:255',
        'email' => 'required|email',
        'nomor_telephone' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'alamat' => 'required|string',
    ]);

    Client::create($request->only([
        'nama_perusahaan',
        'email',
        'nomor_telephone',
        'alamat',
        'latitude',
        'longitude',
    ]));

    return redirect()->route('admin.client.index')->with('success', 'Client berhasil ditambahkan.');
}

    public function edit(Client $client)
{
    return view('content.admin.client.edit', compact('client'));
}

public function update(Request $request, Client $client)
{
    $request->validate([
        'nama_perusahaan' => 'required|string|max:255',
        'email' => 'required|email',
        'nomor_telephone' => 'required|string',
        'alamat' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    $client->update($request->only([
        'nama_perusahaan',
        'email',
        'nomor_telephone',
        'alamat',
        'latitude',
        'longitude',
    ]));

    return redirect()->route('admin.client.index')->with('success', 'Client berhasil diperbarui.');
}

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('admin.client.index')->with('success', 'Client berhasil dihapus.');
    }
}
