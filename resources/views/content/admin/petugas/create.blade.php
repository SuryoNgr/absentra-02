@extends('layouts.adminlayout')

@section('title', 'Absentra - Tambah Petugas')

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
    <h2>Tambah Petugas</h2>

    <form action="{{ route('admin.petugas.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" value="{{ old('nama') }}" required>
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="security" {{ old('role') == 'security' ? 'selected' : '' }}>Security</option>
                <option value="cleaning services" {{ old('role') == 'cleaning services' ? 'selected' : '' }}>Cleaning Services</option>
                <option value="pramugari" {{ old('role') == 'pramugari' ? 'selected' : '' }}>Pramugari</option>
                <option value="driver" {{ old('role') == 'driver' ? 'selected' : '' }}>Driver</option>
            </select>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}">
        </div>

        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
        </div>

        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin">
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" rows="3">{{ old('alamat') }}</textarea>
        </div>

        <button type="submit">Simpan</button>
    </form>
</div>
@endsection
