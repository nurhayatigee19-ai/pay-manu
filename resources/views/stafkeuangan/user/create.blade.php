@extends('layouts.template_default')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 fw-bold">Tambah User</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('stafkeuangan.user.store') }}" method="POST">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label">Nama</label>

                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>

                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   required>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label">Password</label>

                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required>

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="mb-3">
                            <label class="form-label">Role</label>

                            <select name="role"
                                    class="form-select @error('role') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Role --</option>
                                <option value="stafkeuangan">Staf Keuangan</option>
                                <option value="kepsek">Kepala Sekolah</option>
                            </select>

                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- BUTTON (FIX KONSISTEN) --}}
                        <div class="mt-4 d-flex gap-3">

                            {{-- SIMPAN --}}
                            <button type="submit"
                                class="btn btn-back-pro d-inline-flex align-items-center justify-content-center gap-2">

                                <span class="icon-wrap">
                                    <i class="bi bi-check-circle"></i>
                                </span>

                                <span>Simpan</span>
                            </button>

                            {{-- KEMBALI --}}
                            <a href="{{ route('stafkeuangan.user.index') }}"
                                class="btn btn-back-pro d-inline-flex align-items-center justify-content-center gap-2">

                                <span class="icon-wrap">
                                    <i class="bi bi-arrow-left"></i>
                                </span>

                                <span>Kembali</span>
                            </a>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@push('styles')
<style>
.btn-back-pro {
    background-color: #198754;
    color: #fff;
    border-radius: 10px;
    padding: 8px 16px;
    transition: all 0.2s ease;
    border: none;
}

.btn-back-pro:hover {
    background-color: #157347;
    color: #fff;
    transform: translateX(-3px);
}

</style>
@endpush

@endsection