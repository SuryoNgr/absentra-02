@extends('layouts.supervisorlayout')

@section('title', 'Absentra - Riwayat Absensi')

@section('content')
<style>
.petugas-container {
    padding: 20px;
    background: url('/images/bg-pattern.png');
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

.badge.bg-success {
    background-color: #28a745;
    color: white;
}

.badge.bg-warning {
    background-color: #ffc107;
    color: black;
}

.badge.bg-danger {
    background-color: #dc3545;
    color: white;
}

.badge.bg-secondary {
    background-color: #6c757d;
    color: white;
}
</style>

<div class="petugas-container">
    <h2>Riwayat Absensi Petugas</h2>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
        <div style="display:flex; gap:10px;"></div>

        <select id="filterRole" onchange="filterAbsensi()" class="filter-select">
            <option value="">Semua Role</option>
            <option value="security" {{ request('role') == 'security' ? 'selected' : '' }}>Security</option>
            <option value="cleaning services" {{ request('role') == 'cleaning services' ? 'selected' : '' }}>Cleaning Services</option>
            <option value="driver" {{ request('role') == 'driver' ? 'selected' : '' }}>Driver</option>
            <option value="pramugari" {{ request('role') == 'pramugari' ? 'selected' : '' }}>Pramugari</option>
        </select>

        <a href="{{ route('supervisor.absensi.rekap', ['role' => request('role')]) }}" class="btn btn-success">
            <i class="fa fa-file-pdf"></i> Rekap PDF (30 Hari)
        </a>
    </div>

    <div class="table-responsive">
        <table class="client-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Role</th>
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
                <tr><td colspan="6" style="padding: 20px;">Tidak ada data absensi ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $absensi->appends(request()->query())->links() }}
    </div>
</div>

<script>
function filterAbsensi(){
    let r = document.getElementById('filterRole').value;
    let u = new URL(window.location);
    r ? u.searchParams.set('role', r) : u.searchParams.delete('role');
    window.location = u;
}
</script>
@endsection
