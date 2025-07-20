@extends('layouts.adminlayout')

@section('title', 'Absentra - Upload Petugas dari Excel')

@section('content')
<div class="bulk-upload-wrapper">



    <div class="upload-container">
        <h2>Upload Manage Petugas dari Excel</h2>

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Notifikasi error --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.manage-petugas.import') }}" method="POST" enctype="multipart/form-data" class="upload-form">
            @csrf

            {{-- Dropdown Perusahaan --}}
            <div class="form-group">
                <label for="client_id">Pilih Perusahaan</label>
                <select name="client_id" id="client_id" required>
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->nama_perusahaan }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Upload File --}}
            <div class="upload-area">
                <label for="excel_file" class="custom-file-label">
                    <span id="file-name">Pilih File Excel</span>
                    <i class="fas fa-upload"></i>
                </label>
                <input type="file" id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv" required>
            </div>

            <div id="uploading-msg" style="display: none; color: #3b5998; margin-top: 10px;">
                Uploading...
            </div>

            <button type="submit" class="upload-submit">Upload</button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/bulk-upload.css') }}">
<style>
     .form-group {
        margin-bottom: 20px;
    }

    select, input[type="file"] {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: 2px solid #000;
    }
.alert {
    padding: 10px 15px;
    border-radius: 4px;
    margin-bottom: 15px;
    font-size: 14px;
}
.alert-success {
    background-color: #d4edda;
    color: #155724;
}
.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}
.form-group {
    margin-bottom: 15px;
}
select {
    width: 100%;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
}
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('excel_file').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Pilih File Excel';
        document.getElementById('file-name').textContent = fileName;
    });

    document.querySelector('.upload-form').addEventListener('submit', function() {
        document.getElementById('uploading-msg').style.display = 'block';
    });
</script>
@endpush
