@extends('layouts.supervisorlayout')

@section('title', 'Aktivitas Petugas')

@section('content')
<style>
    
    .aktivitas-container {
        padding: 20px;
    }

    .filter-select, .filter-input {
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

    img.foto-bukti {
        width: 100px;
        border-radius: 4px;
    }
</style>

<div class="aktivitas-container">
    <h2>Aktivitas Petugas</h2>

    <form method="GET" style="display:flex; align-items:center; flex-wrap:wrap; gap:10px;">
        <select name="petugas_id" class="filter-select">
            <option value="">Semua Petugas</option>
            @foreach($daftarPetugas as $petugas)
                <option value="{{ $petugas->id }}" {{ request('petugas_id') == $petugas->id ? 'selected' : '' }}>
                    {{ $petugas->nama }}
                </option>
            @endforeach
        </select>

        <select name="role" class="filter-select">
            <option value="">Semua Role</option>
            <option value="security" {{ request('role') == 'security' ? 'selected' : '' }}>Security</option>
            <option value="cleaning services" {{ request('role') == 'cleaning services' ? 'selected' : '' }}>Cleaning</option>
            <option value="driver" {{ request('role') == 'driver' ? 'selected' : '' }}>Driver</option>
            <option value="pramugari" {{ request('role') == 'pramugari' ? 'selected' : '' }}>Pramugari</option>
        </select>

        <input type="date" name="tanggal" class="filter-input" value="{{ request('tanggal') }}">
        <button class="btn btn-primary">Filter</button>

        <a href="{{ route('supervisor.aktivitas.cetak', request()->query()) }}" class="btn btn-danger" target="_blank">
            Cetak PDF
        </a>
    </form>

    <div class="table-responsive">
        <table class="client-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Tanggal</th>
                    <th>Catatan</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $item)
                <tr>
                    <td>{{ $item->petugas->nama }}</td>
                    <td>{{ ucfirst($item->petugas->role) }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                    <td>{{ $item->catatan }}</td>
                    <td>
                        @if($item->foto)
                        <a href="{{ asset('storage/' . $item->foto) }}" target="_blank">
                            <img src="{{ asset('storage/' . $item->foto) }}" class="foto-bukti">
                        </a>
                        @else
                        Tidak Ada
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding: 20px;">Tidak ada data aktivitas ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-end">
        {{ $laporan->appends(request()->query())->links() }}
    </div>
</div>
@endsection
