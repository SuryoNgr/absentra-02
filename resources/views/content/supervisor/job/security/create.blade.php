@extends('layouts.supervisorlayout')

@section('title', 'Tambah Job Security Services')

@section('content')
<style>
    .container-security {
        padding: 20px;
        background: #f4f6f8;
        border-radius: 8px;
        margin-top: 20px;
    }

    .container-security h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 24px;
        font-weight: bold;
        color: #3b5998;
    }

    .form-section {
        margin-bottom: 25px;
    }

    label {
        font-weight: bold;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 8px;
        margin-top: 6px;
        margin-bottom: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    .map-container {
        height: 300px;
        margin-bottom: 10px;
        border-radius: 6px;
        overflow: hidden;
    }

    .btn-tambah {
        margin-top: 10px;
        display: inline-block;
        font-size: 14px;
        color: #3b5998;
        background: none;
        border: none;
        cursor: pointer;
        text-decoration: underline;
    }

    .btn-submit {
        background-color: #3b5998;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #2d4373;
    }

    .job-group {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 6px;
        background-color: #f9f9f9;
    }

    .remove-button {
        color: #d00;
        font-size: 14px;
        margin-top: 5px;
        cursor: pointer;
    }
</style>

<div class="container-security">
    <h2>Tambah Job Security Services</h2>

    <form action="{{ route('supervisor.job.security.store') }}" method="POST">
        @csrf

        <!-- Nama Tim dan Waktu -->
        <div class="form-section">
            <label>Nama Tim</label>
            <input type="text" name="nama_tim" class="form-control" required>

            <label>Waktu Mulai</label>
            <input type="datetime-local" name="waktu_mulai" class="form-control" required>

            <label>Waktu Selesai</label>
            <input type="datetime-local" name="waktu_selesai" class="form-control" required>
        </div>

        <!-- Pilih Petugas -->
        <div id="petugas-wrapper" class="form-section">
            <label>Pilih Petugas</label>
            <div class="job-group">
                <select name="petugas_id[]" class="form-select" required>
                    <option value="">-- Pilih Petugas --</option>
                    @foreach($petugas as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="button" class="btn-tambah" onclick="addPetugas()">+ Tambah Petugas</button>

        <!-- Tugas & Lokasi -->
        <div id="tugas-wrapper" class="form-section">
            <label>Tugas & Lokasi</label>
            <div class="job-group lokasi-group">
                <input type="text" name="deskripsi[]" class="form-control" placeholder="Tugas" required>

                <div class="map-container" id="map-0"></div>
                <input type="hidden" name="latitude[]" class="latitude">
                <input type="hidden" name="longitude[]" class="longitude">
                <button type="button" class="btn-tambah" onclick="setToCompanyLocation(this)">Gunakan Lokasi Perusahaan</button>
            </div>
        </div>
        <button type="button" class="btn-tambah" onclick="addTugas()">+ Tambah Lokasi & Tugas</button>

        <br><br>
        <button type="submit" class="btn-submit">Simpan</button>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</div>

{{-- Leaflet CSS & JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
     function addPetugas() {
        const html = `
            <div class="job-group">
                <select name="petugas_id[]" class="form-select" required>
                    <option value="">-- Pilih Petugas --</option>
                    @foreach($petugas as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                    @endforeach
                </select>
                <span class="remove-button" onclick="this.parentNode.remove()">Hapus</span>
            </div>`;
        document.getElementById('petugas-wrapper').insertAdjacentHTML('beforeend', html);
    }
    let mapIndex = 1;
    const defaultLat = {{ $client->latitude ?? -6.2 }};
    const defaultLng = {{ $client->longitude ?? 106.8 }};
    const maps = {};
    const markers = {};

    function initMap(index) {
        const map = L.map(`map-${index}`).setView([defaultLat, defaultLng], 15);
        maps[index] = map;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data © OpenStreetMap contributors'
        }).addTo(map);

        map.on('click', function (e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            const parent = document.getElementById(`map-${index}`).closest('.lokasi-group');
            parent.querySelector('.latitude').value = lat;
            parent.querySelector('.longitude').value = lng;

            if (markers[index]) {
                markers[index].setLatLng(e.latlng);
            } else {
                markers[index] = L.marker(e.latlng).addTo(map);
            }
        });
    }

    function setToCompanyLocation(btn) {
        const parent = btn.closest('.lokasi-group');
        const mapId = parent.querySelector('.map-container').id.split('-')[1];

        // Set input value
        parent.querySelector('.latitude').value = defaultLat;
        parent.querySelector('.longitude').value = defaultLng;

        // Pusatkan dan beri marker
        const map = maps[mapId];
        if (map) {
            map.setView([defaultLat, defaultLng], 16);

            if (markers[mapId]) {
                markers[mapId].setLatLng([defaultLat, defaultLng]);
            } else {
                markers[mapId] = L.marker([defaultLat, defaultLng]).addTo(map);
            }

            markers[mapId].bindPopup("Lokasi Perusahaan").openPopup();
        }
    }

    function addTugas() {
        const wrapper = document.getElementById('tugas-wrapper');
        const id = mapIndex++;

        const html = `
            <div class="job-group lokasi-group">
                <input type="text" name="deskripsi[]" class="form-control" placeholder="Tugas tugas" required>

                <div class="map-container" id="map-${id}"></div>
                <input type="hidden" name="latitude[]" class="latitude">
                <input type="hidden" name="longitude[]" class="longitude">
                <button type="button" class="btn-tambah" onclick="setToCompanyLocation(this)">Tampilkan Lokasi Perusahaan</button>
                <span class="remove-button" onclick="this.parentNode.remove()">Hapus</span>
            </div>`;
        wrapper.insertAdjacentHTML('beforeend', html);
        setTimeout(() => initMap(id), 100);
    }

    window.onload = () => initMap(0);
</script>

@endsection