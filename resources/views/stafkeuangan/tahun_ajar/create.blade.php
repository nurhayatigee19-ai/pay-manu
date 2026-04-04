@extends('layouts.template_default')

@section('title', 'Tambah Tahun Ajar')

@section('content')
<div class="container">

    <h4 class="mb-4">Tambah Tahun Ajar</h4>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('stafkeuangan.tahunajar.store') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label class="form-label">Tahun Ajar</label>

                    <input
                        type="text"
                        name="tahun"
                        class="form-control"
                        placeholder="Contoh: 2024/2025"
                        value="{{ old('tahun') }}"
                        required
                    >

                    @error('tahun')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="{{ route('stafkeuangan.tahunajar.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection