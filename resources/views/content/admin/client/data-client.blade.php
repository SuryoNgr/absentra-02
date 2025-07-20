@extends('layouts.adminlayout')

@section('title', 'Absentra - Data Client')

@section('content')
<div class="client-container">
    <h2>Daftar Client</h2>
    <div style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
        <a href="{{ route('admin.client.create') }}" class="add-button">
            <span>+</span>
        </a>
    </div>


</a>

    <table class="client-table">
        <thead>
            <tr>
                <th>Nama Perusahaan</th>
                <th>Email</th>
                <th>Nomor Telephone</th>
                <th>Alamat</th>
                <th>Total Petugas</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
            <tr>
                <td>{{ $client->nama_perusahaan }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->nomor_telephone }}</td>
                <td>{{ $client->alamat }}</td>
                <td>{{ $client->petugas_count }} orang</td>
                <td class="action-buttons">
                    <a href="{{ route('admin.client.edit', $client) }}" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                        |
                    <a href="#" title="Hapus" style="color: #d00;"
                    onclick="event.preventDefault(); if(confirm('Yakin hapus?')) document.getElementById('delete-form-{{ $client->id }}').submit();">
                        <i class="fas fa-trash"></i>
                    </a>

                    <form id="delete-form-{{ $client->id }}" action="{{ route('admin.client.destroy', $client) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>

            </tr>
            @empty
            <tr><td colspan="5">Tidak ada data client</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection


