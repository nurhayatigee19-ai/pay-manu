@extends('layouts.template_default')

@section('content')
<div class="container">

    <h4 class="fw-bold mb-4">
        Edit User
    </h4>

    <div class="card">
        <div class="card-body">

            <form method="POST"
                  action="{{ route('stafkeuangan.user.update', $user->id) }}">

                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label">
                        Nama
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required>

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           class="form-control @error('email') is-invalid @enderror"
                           required>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="mb-3">
                    <label class="form-label">
                        Role
                    </label>

                    <select name="role"
                            class="form-select @error('role') is-invalid @enderror">

                        <option value="stafkeuangan"
                            {{ $user->role == 'stafkeuangan' ? 'selected' : '' }}>
                            Staf Keuangan
                        </option>

                        <option value="kepsek"
                            {{ $user->role == 'kepsek' ? 'selected' : '' }}>
                            Kepala Sekolah
                        </option>

                    </select>

                    @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Button --}}
                <div class="mt-4">

                    <button type="submit"
                            class="btn btn-primary">
                        Update
                    </button>

                    <a href="{{ route('stafkeuangan.user.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection