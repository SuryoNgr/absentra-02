@extends('layouts.supervisorlayout')

@section('title', 'Job Cleaning Services')

@section('content')
<style>
    .add-button {
    background-color: #3366cc;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    font-size: 24px;
    font-weight: bold;
    line-height: 1;
    text-align: center;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s;
    padding-bottom: 4px;
}

.add-button:hover {
    background-color: #254a99;
}

.filter-actions-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}


.filter-select {
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.manage-job-container {
    padding: 20px;
    background: #f4f6f8;
    border-radius: 8px;
    margin-top: 20px;
}

.manage-job-container h2 {
    color: #3b5998;
    margin-bottom: 20px;
}

/* Table styling */
.job-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    border-radius: 6px;
    overflow: hidden;
}

.job-table th, .job-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #ddd;
    text-align: center;
    vertical-align: middle;
}

.job-table th {
    background-color: #3b5998;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
}

.job-table tbody tr:hover {
    background-color: #f0f3f7;
}

.job-table td a {
    color: #3366cc;
    text-decoration: none;
}

.job-table td a:hover {
    text-decoration: underline;
}

/* Badge-style status or info */
.badge {
    padding: 5px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
    display: inline-block;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

.badge-warning {
    background-color: #ffc107;
    color: #212529;
}

.badge-danger {
    background-color: #dc3545;
    color: white;
}

/* Responsive Table Wrapper */
.table-responsive {
    overflow-x: auto;
}

/* Action buttons (icon-only links) */
.job-actions {
    display: flex;
    justify-content: center;
    gap: 12px;
}

.job-actions a {
    font-size: 16px;
    color: #3b5998;
}

.job-actions a:hover {
    color: #254a99;
}
.disband-link {
    color: #dc3545;
    font-size: 16px;
    margin-left: 8px;
}

.disband-link:hover {
    color: #b02a37;
}

</style>

<div class="manage-job-container">
    <h2>Daftar Pekerjaan Cleaning Services</h2>
  <div class="filter-actions-row">
    <!-- Tombol tambah -->
    <a href="{{ route('supervisor.job.cleaning.create') }}" class="add-button" title="Tambah Job">+</a>

    <!-- Filter dropdown -->
    <form method="GET" action="{{ route('supervisor.job.cleaning.index') }}" class="filter-form">
        <select name="team" class="filter-select" onchange="filterByTeam(this)">
            <option value="">-- Semua Tim --</option>
            @foreach($availableTeams as $team)
                <option value="{{ $team }}" {{ request('team') == $team ? 'selected' : '' }}>
                    {{ $team }}
                </option>
            @endforeach
        </select>
    </form>
</div>



    <div class="table-responsive">
        <table class="job-table">
            <thead>
                <tr>
                    <th>Nama Petugas</th>
                    <th>Nama Tim</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Lokasi</th>
                    <th>Tugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td>{{ $job->petugas->nama }}</td>
                        <td>{{ $job->nama_tim }}</td>
                        <td>{{ \Carbon\Carbon::parse($job->waktu_mulai)->format('d/m/Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($job->waktu_selesai)->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="https://maps.google.com/?q={{ $job->latitude }},{{ $job->longitude }}" target="_blank">Lihat Lokasi</a>
                        </td>
                        <td>{{ $job->deskripsi }}</td>
                        <td class="job-actions">
                            <a href="{{ route('supervisor.job.cleaning.show', $job->id) }}"><i class="fas fa-eye" title="Detail"></i></a>
                            <a href="{{ route('supervisor.job.cleaning.edit', $job->id) }}"><i class="fas fa-edit" title="Edit"></i></a>
                            <a href="{{ route('supervisor.job.cleaning.disbandTeam', ['team' => $job->nama_tim]) }}"onclick="return confirm('Yakin ingin membubarkan tim ini?')" class="disband-link" title="Bubarkan Tim">
                                <i class="fas fa-users-slash"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum ada pekerjaan tercatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function filterByTeam(select) {
    const value = select.value;
    const url = new URL(window.location.href);

    if (value) {
        url.searchParams.set('team', value);
    } else {
        url.searchParams.delete('team');
    }

    window.location.href = url.toString();
}
</script>


@endsection
