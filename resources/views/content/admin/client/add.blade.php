@extends('layouts.adminlayout')

@section('title', 'Absentra - Tambah Data Client')

@section('content')
@stack('styles')
<div class="client-container">
    <h2>Tambah Client</h2>
    <form action="{{ route('admin.client.store') }}" method="POST">
        @csrf
        @include('content.admin.client.form')
        <button type="submit">Simpan</button>
    </form>
</div>

@stack('scripts')
@endsection

