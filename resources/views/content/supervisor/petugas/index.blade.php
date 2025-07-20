    @extends('layouts.supervisorlayout')

    @section('title', 'Absentra - Data Petugas')

    @section('content')
    <style>
    .petugas-container {
        padding: 20px;
        background: url('/images/bg-pattern.png'); /* opsional: tambahkan background grid jika ada */
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
        margin-top: 10px;;
        cursor: pointer;
        transition: background-color 0.3s ease;

        /* FLEXBOX untuk center isi */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .add-button span {
        font-size: 24px;
        font-weight: bold;
        line-height: 1;
        padding-bottom: 6px;
    }

    .add-button:hover {
        background-color: #254a99;
    }




    .petugas-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
    }

    .petugas-table th {
        background-color: #3b5998;
        color: #fff;
        padding: 10px;
    }

    .petugas-table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .petugas-table a {
        color: #3366cc;
        text-decoration: none;
    }

    .petugas-table a:hover {
        text-decoration: underline;
    }
    .petugas-table td a {
        font-size: 1rem;
        margin-right: 8px;
        text-decoration: none;
        justify-content: center;
    }
    .action-buttons{
        display: flex;
        gap: 10px;
    }
    .petugas-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .petugas-table th,
    .petugas-table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;  /* center horizontal */
        vertical-align: middle;  /* center vertical */
    }

    .petugas-table th {
        background-color: #3b5998;
        color: #fff;
    }

    .petugas-table td.action-buttons {
        display: flex;
        justify-content: center;  /* center horizontal */
        align-items: center;      /* center vertical */
        gap: 10px;                /* jarak antar icon */
    }
    .petugas-container form {
        margin-bottom: 15px;
    }

    .petugas-container h3 {
        margin-top: 20px;
        color: #3b5998;
    }

    .petugas-container form,
    .petugas-container a.add-button {
        vertical-align: middle;
    }

    .petugas-container input[type="file"] {
        margin-right: 5px;
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
    <div class="petugas-container">
        <h2>Daftar Petugas</h2>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
        <div style="display:flex; gap:10px;"></div>

        <select id="filterRole" onchange="filterPetugas()" class="filter-select">
        <option value="">Semua Role</option>
        @foreach($roles as $role)
            <option value="{{ $role }}" {{ request('role')==$role?'selected':'' }}>{{ ucfirst($role) }}</option>
        @endforeach
        </select>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif


    <div class="table-responsive">
        <table class="client-table">
        <thead>
            <tr>
            <th>Nama</th><th>Role</th><th>Email</th><th>Telepon</th><th>Status</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($petugas as $p)
            <tr>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->role }}</td>
                <td>{{ $p->email ?? '-' }}</td>
                <td>{{ $p->nomor_hp ?? '-' }}</td>
                <td>
                @if($p->password)<span class="badge bg-success">Aktif</span>
                @else<span class="badge bg-warning">Nonaktif</span>@endif
                </td>
                <td class="action-buttons">
                        <a href="{{ route('supervisor.petugas.unassign', $p->id) }}"
                        onclick="event.preventDefault(); if(confirm('Yakin ingin unassign petugas ini?')) document.getElementById('unassign-form-{{ $p->id }}').submit();"
                        title="Unassign" style="color: #d00;">
                            <i class="fas fa-user-slash"></i>
                        </a>

                        <form id="unassign-form-{{ $p->id }}" action="{{ route('supervisor.petugas.unassign', $p->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('PUT')
                        </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:20px;">Tidak ada data petugas</td></tr>
            @endforelse
        </tbody>
        </table>
    </div>
    </div>

    <script>
    function filterPetugas(){
    let r=document.getElementById('filterRole').value;
    let u=new URL(window.location);
    r?u.searchParams.set('role',r):u.searchParams.delete('role');
    window.location=u;
    }
    </script>
    @endsection
