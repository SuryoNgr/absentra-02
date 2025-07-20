<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
class SupervisorController extends Controller
{
    public function index(Request $request)
{
    $clients = Client::all(); // untuk dropdown
    $query = User::where('role', 'supervisor');

    if ($request->filled('client_id')) {
        $query->where('client_id', $request->client_id);
    }

    $supervisors = $query->get();

    return view('content.admin.supervisor.index', compact('supervisors', 'clients'));
}


   public function create()
{
    $clients = Client::all();
    return view('content.admin.supervisor.create', compact('clients'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'client_id' => 'required|exists:clients,id',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'client_id' => $request->client_id,
        'password' => Hash::make('super123'),
        'role' => 'supervisor',
        'must_change_password' => true,
    ]);

    return redirect()->route('admin.supervisor.index')->with('success', 'Supervisor berhasil ditambahkan');
}

public function resetPassword($id)
{
    $supervisor = User::where('role', 'supervisor')->findOrFail($id);

    $defaultPassword = 'super123';
    $supervisor->password = Hash::make($defaultPassword);
    $supervisor->must_change_password = true;
    $supervisor->save();

    return redirect()->back()->with('success', 'Password supervisor berhasil direset. Supervisor wajib mengganti password saat login.');
}

}
