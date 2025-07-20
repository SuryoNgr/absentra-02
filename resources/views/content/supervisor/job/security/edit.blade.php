@extends('layouts.supervisorlayout')

@section('title', 'Edit Waktu Job')

@section('content')
<style>
    .container-wrapper {
        background: #f9f9f9;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        margin-top: 30px;
    }

    h2 {
        color: #3b5998;
        margin-bottom: 20px;
        font-size: 22px;
        font-weight: bold;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
        transition: border-color 0.3s ease-in-out;
    }

    .form-control:focus {
        border-color: #3b5998;
        outline: none;
        box-shadow: 0 0 5px rgba(59, 89, 152, 0.2);
    }

    .btn-primary {
        background-color: #3b5998;
        border: none;
        color: white;
        padding: 10px 20px;
        font-weight: bold;
        font-size: 14px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #2e4372;
    }
</style>


<div class="container-wrapper" style="max-width: 600px; margin: auto; padding: 20px;">
    <h2>Edit Waktu Job</h2>

    <form method="POST" action="{{ route('supervisor.job.security.update', $job->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="waktu_mulai">Waktu Mulai</label>
            <input type="datetime-local" class="form-control" name="waktu_mulai"
                value="{{ \Carbon\Carbon::parse($job->waktu_mulai)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="form-group">
            <label for="waktu_selesai">Waktu Selesai</label>
            <input type="datetime-local" class="form-control" name="waktu_selesai"
                value="{{ \Carbon\Carbon::parse($job->waktu_selesai)->format('Y-m-d\TH:i') }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
    </form>
</div>
@endsection
