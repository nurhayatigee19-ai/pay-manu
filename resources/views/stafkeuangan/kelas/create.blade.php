@extends('layouts.template_default')

@section('title', 'Tambah Kelas')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Kelas</h4>

    <form method="POST" action="{{ route('stafkeuangan.kelas.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Kelas</label>
            <input type="text" name="nama_kelas"
                   class="form-control"
                   placeholder="Contoh: X IPA 1"
                   required>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('stafkeuangan.kelas.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>
@endsection