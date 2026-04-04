@extends('layouts.template_default')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Siswa</h3>

    <form action="{{ route('stafkeuangan.siswa.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">NIS</label>
            <input type="text" name="nis" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Siswa</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">
            <i class="bi bi-save"></i> Simpan
        </button>

        <a href="{{ route('stafkeuangan.siswa.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>
@endsection