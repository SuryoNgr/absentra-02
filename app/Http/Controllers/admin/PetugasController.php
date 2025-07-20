<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $roles = Petugas::select('role')->distinct()->pluck('role');
        $query = Petugas::query();

        if ($request->has('role') && $request->role !== '') {
            $query->where('role', $request->role);
        }

        $petugas = $query->get();

        return view('content.admin.petugas.data-petugas', compact('petugas', 'roles'));
    }

    public function create()
    {
        return view('content.admin.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'required|string|max:100',
            'email' => 'required|email|unique:petugas,email',
        ]);

        Petugas::create([
            'nama'          => $request->nama,
            'role'          => $request->role,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nomor_hp'      => $request->nomor_hp,
            'email'         => $request->email,
            'alamat'        => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'password'      => Hash::make('password123'), // default password
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil ditambahkan');
    }

    public function edit(Petugas $petugas)
    {
        return view('content.admin.petugas.edit', compact('petugas'));
    }

    public function update(Request $request, Petugas $petugas)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'required|string|max:100',
            'email' => 'required|email|unique:petugas,email,' . $petugas->id,
        ]);

        $petugas->update([
            'nama'          => $request->nama,
            'role'          => $request->role,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nomor_hp'      => $request->nomor_hp,
            'email'         => $request->email,
            'alamat'        => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil diperbarui');
    }

    public function destroy(Petugas $petugas)
    {
        $petugas->delete();
        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil dihapus');
    }

    public function bulkUpload()
    {
        return view('content.admin.petugas.bulk-upload');
    }

    public function downloadTemplate()
    {
        $filename = 'template-petugas.xlsx';
        $path = storage_path('app/temp/' . $filename);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        if (file_exists($path)) {
            unlink($path);
        }

        SimpleExcelWriter::create($path)
            ->addRow(['Nama', 'Role', 'Tempat Lahir', 'Tanggal Lahir', 'Nomor HP', 'Email', 'Alamat', 'Jenis Kelamin'])
            ->toBrowser($filename);
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        try {
            $file = $request->file('excel_file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $storedPath = $file->storeAs('temp', $filename);
            $fullPath = Storage::path($storedPath);

            if (!file_exists($fullPath)) {
                return back()->with('error', 'File gagal dibaca: ' . $fullPath);
            }

            $reader = SimpleExcelReader::create($fullPath);
            $reader->getRows()->each(function (array $row) {
                $tanggalLahir = null;

                if (!empty($row['Tanggal Lahir'])) {
                    try {
                        $tanggalLahir = Carbon::parse($row['Tanggal Lahir'])->format('Y-m-d');
                    } catch (\Exception $e) {
                        // abaikan
                    }
                }

                if (!empty($row['Email']) && !Petugas::where('email', $row['Email'])->exists()) {
                    Petugas::create([
                        'nama'           => $row['Nama'] ?? '',
                        'role'           => $row['Role'] ?? '',
                        'tempat_lahir'   => $row['Tempat Lahir'] ?? '',
                        'tanggal_lahir'  => $tanggalLahir,
                        'nomor_hp'       => $row['Nomor HP'] ?? '',
                        'email'          => $row['Email'] ?? '',
                        'alamat'         => $row['Alamat'] ?? '',
                        'jenis_kelamin'  => $row['Jenis Kelamin'] ?? '',
                        'password'       => Hash::make('password123'),
                    ]);
                }
            });

            Storage::delete($storedPath);

            return back()->with('success', 'Berhasil import data petugas (password default: password123)');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }

    public function indexByRole($role)
    {
        $petugas = Petugas::where('role', $role)->get();
        return view('content.admin.petugas.data-petugas', compact('petugas', 'role'));
    }
}
