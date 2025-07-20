@extends('layouts.adminlayout')

@section('title', 'Absentra - Edit Penempatan Petugas')

@section('content')
<div class="client-container">
    <h2>Edit Penempatan Petugas</h2>

    <form method="POST" action="{{ route('admin.manage-petugas.update', $petugas->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Petugas</label>
            <input type="text" class="form-control" value="{{ $petugas->nama }}" readonly>
        </div>

        <div class="form-group">
            <label for="client_id">Perusahaan Baru</label>
            <select name="client_id" class="form-control" required>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ $client->id == $petugas->client_id ? 'selected' : '' }}>
                        {{ $client->nama_perusahaan }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.manage-petugas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
