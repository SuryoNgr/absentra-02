@extends('layouts.adminlayout')

@section('title', 'Absentra - Data Admin')

@section('content')
<div class="client-container">
    <h2>Daftar Admin</h2>

    <table class="client-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>Nomor Telephone</th>
                <th>Job</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $admin)
            <tr>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->jabatan }}</td>
                <td>{{ $admin->no_telp }}</td>
                <td>{{ $admin->job }}</td>
                <td>{{ $admin->lokasi }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;">Tidak ada data admin</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
