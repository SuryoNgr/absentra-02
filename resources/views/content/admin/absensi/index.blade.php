@extends('layouts.adminlayout')

@section('title', 'Riwayat Absensi Petugas')

@section('content')
<style>
    .filter-select {
        padding: 8px 12px;
        border: 2px solid #ccc;
        border-radius: 6px;
        margin-right: 10px;
    }

    .client-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: #fff;
    }

    .client-table th {
        background-color: #3b5998;
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    .client-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
        vertical-align: middle;
    }

    .badge {
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    .badge.bg-success { background-color: #28a745; color: white; }
    .badge.bg-warning { background-color: #ffc107; color: black; }
    .badge.bg-danger  { background-color: #dc3545; color: white; }
    .badge.bg-secondary { background-color: #6c757d; color: white; }
</style>

<h2>Riwayat Absensi Semua Petugas</h2>

<form method="GET" class="d-flex flex-wrap align-items-center mb-3" style="gap:10px;">
    <select name="client_id" class="filter-select">
        <option value="">Semua Client</option>
        @foreach($clients as $client)
            <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                {{ $client->nama_perusahaan }}
            </option>
        @endforeach
    </select>

    <select name="role" class="filter-select">
        <option value="">Semua Role</option>
        @foreach($roles as $role)
            <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                {{ ucfirst($role) }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-primary">Filter</button>
</form>

<div class="table-responsive">
    <table class="client-table">
        <thead>
            <tr>
                <th>Nama Petugas</th>
                <th>Role</th>
                <th>Client</th>
                <th>Tanggal</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensi as $item)
                <tr>
                    <td>{{ $item->petugas->nama }}</td>
                    <td>{{ ucfirst($item->petugas->role) }}</td>
                    <td>{{ $item->petugas->client->nama_perusahaan ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->checkin_at)->format('d-m-Y') }}</td>
                    <td>{{ $item->checkin_at ? \Carbon\Carbon::parse($item->checkin_at)->format('H:i') : '-' }}</td>
                    <td>{{ $item->checkout_at ? \Carbon\Carbon::parse($item->checkout_at)->format('H:i') : '-' }}</td>
                    <td>
                        <span class="badge
                            @if($item->status == 'checkin') bg-success
                            @elseif($item->status == 'terlambat checkin') bg-warning
                            @elseif($item->status == 'lupa checkout') bg-danger
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="padding: 20px;">Tidak ada data ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-end mt-3">
    {{ $absensi->appends(request()->query())->links() }}
</div>
@endsection
