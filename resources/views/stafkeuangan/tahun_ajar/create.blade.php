@extends('layouts.template_default')

@section('title', 'Tambah Tahun Ajar')

@section('content')
<div class="container">

    <h4 class="fw-bold mb-4">Tambah Tahun Ajar</h4>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('stafkeuangan.tahun_ajar.store') }}" method="POST">
                @csrf

                {{-- INPUT --}}
                <div class="mb-3">
                    <label class="form-label">Tahun Ajar</label>

                    <input
                        type="text"
                        name="tahun"
                        class="form-control @error('tahun') is-invalid @enderror"
                        placeholder="Contoh: 2024/2025"
                        value="{{ old('tahun') }}"
                        required
                    >

                    @error('tahun')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- BUTTON (SAMAKAN SEMUA HALAMAN) --}}
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
                    <a href="{{ route('stafkeuangan.tahun_ajar.index') }}"
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