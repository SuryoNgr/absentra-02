<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Http\Request;
use App\Models\Petugas;
use App\Models\Client;

class ManagePetugasController extends Controller
{
 public function index(Request $request)
{
    $query = Petugas::with('client');

    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    if ($request->filled('client_id')) {
        $query->where('client_id', $request->client_id);
    }

    $petugas = $query->get();
    $clients = Client::all();

    return view('content.admin.manage-petugas.index', compact('petugas', 'clients'));
}

public function create()
{
    $clients = Client::all();
    return view('content.admin.manage-petugas.create', compact('clients'));
}






    public function store(Request $request)
{
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'role' => 'required|string',
        'petugas_id' => 'required|exists:petugas,id',
    ]);

    $petugas = Petugas::findOrFail($request->petugas_id);
    $petugas->client_id = $request->client_id;
    $petugas->save();

    return redirect()->route('admin.manage-petugas.index')->with('success', 'Petugas berhasil ditempatkan.');
}


    public function edit($id)
{
    $petugas = Petugas::with('client')->findOrFail($id);
    $clients = Client::all();

    return view('content.admin.manage-petugas.edit', compact('petugas', 'clients'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'client_id' => 'required|exists:clients,id',
    ]);

    $petugas = Petugas::findOrFail($id);
    $petugas->client_id = $request->client_id;
    $petugas->save();

    return redirect()->route('admin.manage-petugas.index')->with('success', 'Penempatan petugas berhasil diperbarui.');
}

public function getPetugasByRole($role)
{
    $petugas = Petugas::where('role', $role)->whereNull('client_id')->get(['id', 'nama']);
    return response()->json($petugas);
}

public function import(Request $request)
{
    $request->validate([
        'excel_file' => 'required|file|mimes:xlsx,xls',
        'client_id' => 'required|exists:clients,id',
    ]);

    try {
        $path = $request->file('excel_file')->getRealPath();

        $rows = SimpleExcelReader::create($path, 'xlsx')->getRows();

        foreach ($rows as $row) {
            $petugas = Petugas::where('email', $row['email'])
                ->where('role', $row['role'])
                ->first();

            if ($petugas) {
                $petugas->client_id = $request->client_id;
                $petugas->save();
            }
        }

        return back()->with('success', 'Penempatan petugas berhasil diupload.');
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan saat membaca file: ' . $e->getMessage());
    }
}   

public function bulkUpload()
{
    $clients = \App\Models\Client::all(); // untuk dropdown perusahaan
    return view('content.admin.manage-petugas.bulk-upload', compact('clients'));
}



}
