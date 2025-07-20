@extends('layouts.adminlayout')

@section('title', 'Absentra - Edit Client')

@section('content')
<div class="client-container">
    <h2>Edit Client</h2>
    <form action="{{ route('admin.client.update', $client) }}" method="POST">
        @csrf
        @method('PUT')
        @include('content.admin.client.form', ['client' => $client])
        <button type="submit">Update</button>
    </form>
</div>
@endsection
