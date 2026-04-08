@extends('layouts.template_default')

@section('title', 'Tambah Kelas')

@section('content')
<div class="container">

    <h4 class="fw-bold mb-4">Tambah Kelas</h4>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('stafkeuangan.kelas.store') }}" method="POST">
                @csrf

                {{-- INPUT --}}
                <div class="mb-3">
                    <label class="form-label">Nama Kelas</label>

                    <input
                        type="text"
                        name="nama_kelas"
                        class="form-control @error('nama_kelas') is-invalid @enderror"
                        placeholder="Contoh: X IPA 1"
                        value="{{ old('nama_kelas') }}"
                        required
                    >

                    @error('nama_kelas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- BUTTON --}}
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
                    <a href="{{ route('stafkeuangan.kelas.index') }}"
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

{{-- STYLE --}}
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