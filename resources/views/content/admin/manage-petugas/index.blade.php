@extends('layouts.adminlayout')

@section('title', 'Absentra - Manage Petugas')

@section('content')

<style>
.filter-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    flex-wrap: wrap;
}

.filter-row .button-group {
    display: flex;
    gap: 10px;
}

.filter-row .filter-form {
    display: flex;
    gap: 10px;
}

.filter-select {
    padding: 8px 12px;
    border: 2px solid #ccc;
    border-radius: 6px;
    background: #fff;
    color: #333;
    font-size: 14px;
    transition: border-color 0.3s;
}

.filter-select:focus,
.filter-select:hover {
    border-color: #4a6cf7;
    outline: none;
}
</style>

<div class="client-container">
    <h2>Manage Petugas</h2>

    <div class="filter-row">
    <div class="button-group">
        <a href="{{ route('admin.manage-petugas.create') }}" class="add-button" title="Tambah Petugas">
            <span>+</span>
        </a>
        <a href="{{ route('admin.manage-petugas.bulk_upload') }}" class="add-button" title="Import Excel"
            style="background-color: #28a745;">
            <span><i class="fas fa-file-excel"></i></span>
        </a>
    </div>

    <form method="GET" action="{{ route('admin.manage-petugas.index') }}" class="filter-form">
        <select name="client_id" class="filter-select">
            <option value="">Semua Perusahaan</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                    {{ $client->nama_perusahaan }}
                </option>
            @endforeach
        </select>

        <select name="role" class="filter-select">
            <option value="">Semua Role</option>
            <option value="security" {{ request('role') == 'security' ? 'selected' : '' }}>Security</option>
            <option value="cleaning services" {{ request('role') == 'cleaning services' ? 'selected' : '' }}>Cleaning Services</option>
            <option value="pramugari" {{ request('role') == 'pramugari' ? 'selected' : '' }}>Pramugari</option>
            <option value="driver" {{ request('role') == 'driver' ? 'selected' : '' }}>Driver</option>
        </select>

        <button type="submit" class="filter-select">Filter</button>
    </form>
</div>

    

    <table class="client-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Petugas</th>
                <th>Perusahaan</th>
                <th>Role</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($petugas as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->client->nama_perusahaan ?? '-' }}</td>
                <td>{{ $p->role }}</td>
                <td>{{ $p->client->alamat ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.manage-petugas.edit', $p->id) }}" title="Pindahkan"><i class="fas fa-pencil-alt"></i></a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
@endsection

