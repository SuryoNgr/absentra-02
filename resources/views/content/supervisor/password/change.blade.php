@extends('layouts.blank')

@section('title', 'Ganti Password')

@section('content')
<style>
.container {
    padding: 30px;
    max-width: 500px;
    background: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}


h2 {
    margin-bottom: 20px;
    color: #3b5998;
}

.form-group {
    margin-bottom: 15px;
}

.form-control {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.btn-primary {
    background-color: #3b5998;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #2e4a8a;
}

.text-danger {
    color: #d00;
    font-size: 14px;
}

.alert {
    padding: 10px;
    background-color: #f8d7da;
    color: #842029;
    margin-bottom: 15px;
    border: 1px solid #f5c2c7;
    border-radius: 6px;
}
</style>

<div class="container">
    <h2>Ganti Password</h2>

    {{-- Menampilkan error dari server --}}
    @if ($errors->any())
        <div class="alert">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('supervisor.password.update') }}" method="POST" onsubmit="return validateForm()">
        @csrf
        <div class="form-group">
            <label for="new_password">Password Baru</label>
            <input type="password" class="form-control" name="new_password" id="new_password" required>
            <div id="passwordError" class="text-danger"></div>
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" required>
            <div id="confirmError" class="text-danger"></div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Password</button>
    </form>
</div>

<script>
function validateForm() {
    const password = document.getElementById("new_password").value;
    const confirm = document.getElementById("new_password_confirmation").value;
    let valid = true;

    // Reset error messages
    document.getElementById("passwordError").innerText = "";
    document.getElementById("confirmError").innerText = "";

    // Validasi panjang & karakter
    if (password.length < 6 || !/[A-Za-z]/.test(password) || !/[0-9]/.test(password)) {
        document.getElementById("passwordError").innerText = "Password minimal 6 karakter dan harus mengandung huruf & angka.";
        valid = false;
    }

    if (password !== confirm) {
        document.getElementById("confirmError").innerText = "Konfirmasi password tidak cocok.";
        valid = false;
    }

    return valid;
}
</script>
@endsection
