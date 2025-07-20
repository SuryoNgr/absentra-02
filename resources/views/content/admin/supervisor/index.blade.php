@extends('layouts.adminlayout')

@section('title', 'Absentra - Daftar Supervisor')

@section('content')
<style>
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
.supervisor-container {
    padding: 20px;
    background: url('/images/bg-pattern.png');
}

.add-button {
    background-color: #3366cc;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    text-decoration: none;
    margin-bottom: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: flex;
    justify-content: center;
    align-items: center;
}

.add-button span {
    font-size: 24px;
    font-weight: bold;
    padding-bottom: 6px;
}

.add-button:hover {
    background-color: #254a99;
}

.supervisor-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    margin-top: 15px;
}

.supervisor-table th {
    background-color: #3b5998;
    color: #fff;
    padding: 10px;
}

.supervisor-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

.supervisor-table a {
    color: #3366cc;
    text-decoration: none;
    font-size: 1rem;
    margin: 0 5px;
}

.supervisor-table a:hover {
    text-decoration: underline;
}
</style>

<div class="supervisor-container">
    <h2>Daftar Supervisor</h2>

    {{-- Tombol dan filter --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        {{-- Tombol kiri --}}
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.supervisor.create') }}" class="add-button" title="Tambah Supervisor">
                <span>+</span>
            </a>
        </div>

        {{-- Filter kanan --}}
        <form method="GET" action="{{ route('admin.supervisor.index') }}">
            <select name="client_id" onchange="this.form.submit()" class="filter-select">
                <option value="">Semua Perusahaan</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->nama_perusahaan }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>



    <table class="supervisor-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Perusahaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supervisors as $index => $sup)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $sup->name }}</td>
                <td>{{ $sup->email }}</td>
                <td>{{ $sup->client->nama_perusahaan ?? '-' }}</td>
                <td>
                    <a href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                    <a href="#" title="Reset Password" onclick="event.preventDefault(); if(confirm('Reset password ke super123?')) document.getElementById('reset-form-{{ $sup->id }}').submit();">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                        <form id="reset-form-{{ $sup->id }}" action="{{ route('admin.supervisor.reset-password', $sup->id) }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                  
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; padding: 20px;">Belum ada supervisor</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
