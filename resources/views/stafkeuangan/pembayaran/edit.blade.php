@extends('layouts.template_default')

@section('content')
<div class="container">
    <h3>Edit Pembayaran</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('stafkeuangan.pembayaran.update', $pembayaran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="siswa_id" class="form-label">Siswa</label>
            <select name="siswa_id" id="siswa_id" class="form-control" required>
                @foreach($siswa as $s)
                    <option value="{{ $s->id }}" {{ $pembayaran->siswa_id == $s->id ? 'selected' : '' }}>
                        {{ $s->nis }} - {{ $s->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ $pembayaran->jumlah }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
            <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control" value="{{ $pembayaran->tanggal_bayar }}" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $pembayaran->keterangan }}">
        </div>

        <div class="mb-3">
            <label for="periode" class="form-label">Periode</label>
            <input type="text" name="periode" id="periode" class="form-control" value="{{ $pembayaran->periode }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('stafkeuangan.pembayaran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
