@extends('layouts.supervisorlayout')

@section('title', 'Detail Job Cleaning')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<style>
.detail-container {
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    max-width: 800px;
    margin: auto;
}
.detail-container h2 {
    color: #3b5998;
    margin-bottom: 20px;
}
.detail-row {
    margin-bottom: 15px;
}
.detail-label {
    font-weight: bold;
    color: #333;
}
.map-detail {
    height: 300px;
    margin-top: 15px;
    border-radius: 8px;
    overflow: hidden;
}
</style>

<div class="detail-container">
    <h2>Detail Job</h2>

    <div class="detail-row"><span class="detail-label">Nama Petugas:</span> {{ $job->petugas->nama }}</div>
    <div class="detail-row"><span class="detail-label">Nama Tim:</span> {{ $job->nama_tim }}</div>
    <div class="detail-row"><span class="detail-label">Waktu Mulai:</span> {{ \Carbon\Carbon::parse($job->waktu_mulai)->format('d M Y H:i') }}</div>
    <div class="detail-row"><span class="detail-label">Waktu Selesai:</span> {{ \Carbon\Carbon::parse($job->waktu_selesai)->format('d M Y H:i') }}</div>
    <div class="detail-row"><span class="detail-label">Deskripsi:</span> {{ $job->deskripsi }}</div>
    <div class="detail-row"><span class="detail-label">Koordinat:</span> {{ $job->latitude }}, {{ $job->longitude }}</div>

    @if($job->client)
        <div class="detail-row"><span class="detail-label">Perusahaan:</span> {{ $job->client->nama }}</div>
    @endif

    <div id="map" class="map-detail"></div>
</div>

<script>
    const lat = {{ $job->latitude }};
    const lng = {{ $job->longitude }};

    const map = L.map('map').setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup('Lokasi Tugas')
        .openPopup();
</script>
@endsection
