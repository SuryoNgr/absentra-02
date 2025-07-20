@extends('layouts.adminlayout')

@section('title', 'Absentra - Edit Petugas')

@section('content')
<style>
    .form-container {
        background-color: #fff;
        padding: 25px;
        border-radius: 10px;
        max-width: 700px;
        margin: 0 auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-weight: 600;
    }

    input[type="text"],
    input[type="email"],
    input[type="date"],
    select,
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }

    button {
        background-color: #3366cc;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    button:hover {
        background-color: #254a99;
    }
</style>

<div class="form-container">
    <h2>Edit Petugas</h2>

    <form action="{{ route('admin.petugas.update', $petugas) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $petugas->nama) }}" required>
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="security" {{ old('role', $petugas->role) == 'security' ? 'selected' : '' }}>Security</option>
                <option value="cleaning services" {{ old('role', $petugas->role) == 'cleaning services' ? 'selected' : '' }}>Cleaning Services</option>
                <option value="pramugari" {{ old('role', $petugas->role) == 'pramugari' ? 'selected' : '' }}>Pramugari</option>
                <option value="driver" {{ old('role', $petugas->role) == 'driver' ? 'selected' : '' }}>Driver</option>
            </select>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $petugas->email) }}" required>
        </div>

        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $petugas->nomor_hp) }}">
        </div>

        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $petugas->tempat_lahir) }}">
        </div>

        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $petugas->tanggal_lahir ? $petugas->tanggal_lahir->format('Y-m-d') : '') }}">
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin">
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin', $petugas->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $petugas->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" rows="3">{{ old('alamat', $petugas->alamat) }}</textarea>
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
@endsection
