@extends('layouts.adminlayout')

@section('title', 'Tambah Supervisor')

@section('content')
<style>
.supervisor-container {
    padding: 20px;
    background: url('/images/bg-pattern.png');
    max-width: 600px;
    margin: auto;
}

.supervisor-container h2 {
    color: #3b5998;
    margin-bottom: 20px;
    text-align: center;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
}

button[type="submit"] {
    background-color: #3366cc;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #254a99;
}
</style>

<div class="supervisor-container">
    <h2>Tambah Supervisor Baru</h2>

    <form method="POST" action="{{ route('admin.supervisor.store') }}">
        @csrf
        <div style="margin-bottom: 10px;">
            <label>Nama:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Perusahaan:</label>
            <select name="client_id" class="form-control" required>
                <option value="">-- Pilih Perusahaan --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->nama_perusahaan }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
