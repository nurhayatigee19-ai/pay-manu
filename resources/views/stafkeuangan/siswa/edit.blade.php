@extends('layouts.template_default')

@section('content')
<div class="container">
    <h3>Edit Data Siswa</h3>

    {{-- TAMPILKAN PESAN ERROR --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('stafkeuangan.siswa.update', $siswa->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- NIS --}}
        <div class="mb-3">
            <label for="nis" class="form-label">NIS <span class="text-danger">*</span></label>
            <input type="text" 
                   name="nis" 
                   id="nis" 
                   class="form-control @error('nis') is-invalid @enderror" 
                   value="{{ old('nis', $siswa->nis) }}" 
                   required>
            @error('nis')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nama Siswa --}}
        <div class="mb-3">
            <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
            <input type="text" 
                   name="nama" 
                   id="nama" 
                   class="form-control @error('nama') is-invalid @enderror" 
                   value="{{ old('nama', $siswa->nama) }}" 
                   required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kelas --}}
        <div class="mb-3">
            <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
            <select name="kelas_id" 
                    id="kelas_id" 
                    class="form-control @error('kelas_id') is-invalid @enderror" 
                    required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($listKelas as $k)
                    <option value="{{ $k->id }}" 
                        {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
            @error('kelas_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- ⚠️ PERHATIAN: HAPUS BAGIAN INI JIKA TIDAK ADA DI TABEL SISWA --}}
        {{-- 
        <div class="mb-3">
            <label for="jumlah_tagihan">Jumlah Tagihan</label>
            <input type="number" name="jumlah_tagihan" class="form-control" value="{{ $siswa->jumlah_tagihan }}">
        </div>

        <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="Belum Lunas" {{ $siswa->status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="Lunas" {{ $siswa->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>
        --}}

        <div class="mt-4 d-flex gap-3">
            {{-- UPDATE --}}
            <button type="submit"
                class="btn btn-back-pro d-inline-flex align-items-center justify-content-center gap-2">

                <span class="icon-wrap">
                    <i class="bi bi-check-circle"></i>
                </span>

                <span>Update</span>
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