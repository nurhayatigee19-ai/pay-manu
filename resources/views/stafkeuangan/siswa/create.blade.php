@extends('layouts.template_default')

@section('content')
<div class="container">

    <h4 class="fw-bold mb-4">
        Tambah Siswa
    </h4>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('stafkeuangan.siswa.store') }}" method="POST">
                @csrf

                {{-- NIS --}}
                <div class="mb-3">
                    <label class="form-label">NIS</label>
                    <input type="text" name="nis" class="form-control" required>
                </div>

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label">Nama Siswa</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                {{-- KELAS --}}
                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <select name="kelas_id" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($listKelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
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
                    <a href="{{ route('stafkeuangan.siswa.index') }}"
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