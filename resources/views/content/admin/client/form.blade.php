@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.11.0/dist/geosearch.css" />
    <link rel="stylesheet" href="{{ asset('css/dataclientform.css') }}">
@endpush

<div>
    <label>Nama Perusahaan</label>
    <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $client->nama_perusahaan ?? '') }}" required>
</div>
<div>
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $client->email ?? '') }}" required>
</div>
<div>
    <label>Nomor Telephone</label>
    <input type="text" name="nomor_telephone" value="{{ old('nomor_telephone', $client->nomor_telephone ?? '') }}" required>
</div>

{{-- Map-based location --}}
<div>
    <label>Lokasi (Klik peta atau cari)</label>
    <div id="map" style="height: 400px;"></div>
    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $client->latitude ?? '') }}">
    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $client->longitude ?? '') }}">
</div>
<div>
    <label>Alamat</label>
    <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $client->alamat ?? '') }}" required readonly>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-geosearch@3.11.0/dist/bundle.min.js"></script>
<script>
    const defaultLat = {{ old('latitude', $client->latitude ?? -6.2) }};
    const defaultLng = {{ old('longitude', $client->longitude ?? 106.8) }};

    const map = L.map('map').setView([defaultLat, defaultLng], 13);
    const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
    }).addTo(map);

    let marker = L.marker([defaultLat, defaultLng]).addTo(map);

    const search = new window.GeoSearch.GeoSearchControl({
        provider: new window.GeoSearch.OpenStreetMapProvider(),
        style: 'bar',
        autoComplete: true,
        autoCompleteDelay: 250,
        showMarker: false,
    });
    map.addControl(search);

    map.on('click', async function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        // Fetch alamat via reverse geocoding dari Nominatim
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
        const data = await response.json();

        if (data && data.display_name) {
            document.getElementById('alamat').value = data.display_name;
        }
    });
</script>

@endpush
