<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;

class PetugasAuthControllerr extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $petugas = Petugas::where('email', $request->email)->first();

        if (! $petugas || ! Hash::check($request->password, $petugas->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $petugas->createToken('petugas-token')->plainTextToken;

        return response()->json([
            'token'   => $token,
            'petugas' => $petugas,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}

