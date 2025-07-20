@extends('layouts.adminlayout')

@section('title', 'Absentra - Penempatan Petugas')

@section('content')
<style>
    .client-container {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        max-width: 600px;
        margin: 0 auto;
    }

    .client-container h2 {
        margin-bottom: 25px;
        font-size: 24px;
        font-weight: 600;
        color: #333;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
        color: #555;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: 0.2s border-color;
    }

    .form-control:focus {
        border-color: #007bff;
        outline: none;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        transition: 0.2s background-color;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>


<div class="client-container">
    <h2>Manage Petugas</h2>

    <form action="{{ route('admin.manage-petugas.store') }}" method="POST">
        @csrf

        <!-- Dropdown Pilih Perusahaan -->
        <div class="form-group">
            <label for="client_id">Pilih Perusahaan</label>
            <select name="client_id" id="client_id" class="form-control" required>
                <option value="">-- Pilih Perusahaan --</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->nama_perusahaan }} - {{ $client->lokasi }}</option>
                @endforeach
            </select>
        </div>

        <!-- Role & Petugas -->
        <div class="form-group">
            <label for="role">Pilih Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="security">Security</option>
                <option value="cleaning services">Cleaning Services</option>
                <option value="pramugari">Pramugari</option>
                <option value="driver">Driver</option>
            </select>
        </div>

        <div class="form-group">
            <label for="petugas_id">Pilih Petugas</label>
            <select name="petugas_id" id="petugas_id" class="form-control" required>
                <option value="">-- Pilih Petugas --</option>
                {{-- Akan diisi via JS --}}
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('role').addEventListener('change', function () {
        const role = this.value;
        const petugasSelect = document.getElementById('petugas_id');
        petugasSelect.innerHTML = '<option value="">-- Memuat Petugas... --</option>';

        fetch(`/admin/manage-petugas/petugas-by-role/${role}`)
    .then(response => {
        if (!response.ok) throw new Error('Jaringan error');
        return response.json();
    })
    .then(data => {
        petugasSelect.innerHTML = '<option value="">-- Pilih Petugas --</option>';
        data.forEach(petugas => {
            petugasSelect.innerHTML += `<option value="${petugas.id}">${petugas.nama}</option>`;
        });
    })
    .catch((err) => {
        console.error('Gagal fetch:', err);
        petugasSelect.innerHTML = '<option value="">-- Gagal Memuat --</option>';
    });

    });
</script>
@endpush
