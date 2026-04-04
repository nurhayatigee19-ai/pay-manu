@extends('layouts.template_default')

@section('content')
<div class="container">
    <h3>Edit Kelas</h3>
    <form action="{{ route('stafkeuangan.kelas.update', $kelas->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama Kelas</label>
            <input type="text" name="kelas" class="form-control" value="{{ $kelas->kelas }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('stafkeuangan.kelas.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
