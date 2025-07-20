@extends('layouts.supervisorlayout')

@section('title', 'Absentra - Dashboard Supervisor')

@section('content')
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        .map-card {
            background: #fff;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .map-container {
            width: 100%;
            height: 350px;
            border-radius: 6px;
        }
        .dashboard-section {
    margin-top: 30px;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}

.job-card {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-left: 6px solid #3b5998;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .job-card:hover {
        box-shadow: 0 6px 12px rgba(0,0,0,0.08);
    }

    .job-card h4 {
        font-size: 20px;
        font-weight: 600;
        color: #3b5998;
        margin-bottom: 10px;
    }

    .job-card p {
        margin: 6px 0;
        font-size: 14px;
        color: #444;
    }

    .job-card ul {
        list-style-type: disc;
        padding-left: 20px;
        margin-bottom: 10px;
    }

    .job-card ul li {
        font-size: 14px;
        margin-bottom: 4px;
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 30px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .badge.upcoming {
        background-color: #ffe082;
        color: #5c4400;
    }

    .badge.ongoing {
        background-color: #81c784;
        color: #1b5e20;
    }

    .badge.finished {
        background-color: #b0bec5;
        color: #263238;
    }

    .dashboard-section h3 {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 25px;
        color: #2c3e50;
    }
    </style>
@endpush

@if($client && $client->latitude && $client->longitude)
<div class="dashboard-section">
   <center style="padding-top: 20px; padding-bottom: 10px;"><h3>Lokasi Perusahaan</h3></center>
    <div class="map-card">
        <div id="map" class="map-container"></div>
    </div>
</div>

@endif
<div class="dashboard-section">
    <center><h3>Tugas Hari Ini</h3></center>

    @forelse ($jobsToday as $teamName => $jobs)
        <div class="job-card">
            <h4>Tim: {{ $teamName }}</h4>

            <p><strong>Waktu:</strong> {{ $jobs->first()->waktu_mulai }} - {{ $jobs->first()->waktu_selesai }}</p>

            <p><strong>Petugas:</strong></p>
            <ul>
                @foreach ($jobs->pluck('petugas')->unique('id') as $petugas)
                    <li>{{ $petugas->nama }}</li>
                @endforeach
            </ul>

            <p><strong>Lokasi & Tugas:</strong></p>
            <ul>
                @foreach ($jobs->unique(fn($job) => $job->deskripsi . $job->latitude . $job->longitude) as $job)
                    <li>
                        {{ $job->deskripsi }} -
                        <a href="https://www.google.com/maps?q={{ $job->latitude }},{{ $job->longitude }}" target="_blank">Lihat di Maps</a>
                    </li>
                @endforeach
            </ul>

            <p><strong>Status:</strong>
                @php
                    $now = now();
                    $mulai = $jobs->first()->waktu_mulai;
                    $selesai = $jobs->first()->waktu_selesai;
                @endphp

                @if ($now < $mulai)
                    <span class="badge upcoming">Belum Mulai</span>
                @elseif ($now >= $mulai && $now <= $selesai)
                    <span class="badge ongoing">Sedang Berlangsung</span>
                @else
                    <span class="badge finished">Selesai</span>
                @endif
            </p>
        </div>
    @empty
        <center><p>Tidak ada tugas hari ini.</p></center>
    @endforelse
</div>



@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    const lat = {{ $client->latitude }};
    const lng = {{ $client->longitude }};

    const map = L.map('map').setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup("Lokasi {{ $client->nama_perusahaan }}")
        .openPopup();
</script>
@endpush


@endsection
