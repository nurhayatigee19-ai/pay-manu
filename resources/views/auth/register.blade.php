@extends('layouts.auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-3">Register Akun</h3>

        {{-- Error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Pesan sukses (jika ada) --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.staf.store') }}">

            @csrf

            <div class="form-group mb-3">
                <label for="name">Nama</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required
                >
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required
                >
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Daftar
            </button>

            <p class="text-center mt-3 mb-0">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login</a>
            </p>
        </form>
    </div>
</div>
@endsection