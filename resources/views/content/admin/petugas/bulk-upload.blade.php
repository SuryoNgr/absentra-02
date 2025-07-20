@extends('layouts.adminlayout')

@section('title', 'Absentra - Upload Petugas dari Excel')

@section('content')
<div class="bulk-upload-wrapper">

    <a href="{{ route('admin.petugas.template') }}" class="template-button">
        <i class="fas fa-download"></i> Download Template Excel
    </a>    

    <div class="upload-container">
        <h2>Upload Data Petugas</h2>

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

        <form action="{{ route('admin.petugas.import') }}" method="POST" enctype="multipart/form-data" class="upload-form">
            @csrf
            <div class="upload-area">
                <label for="excel_file" class="custom-file-label">
                    <span id="file-name">Pilih File Excel</span>
                    <i class="fas fa-upload"></i>
                </label>
                <input type="file" id="excel_file" name="excel_file" accept=".xlsx,.xls" required>
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
