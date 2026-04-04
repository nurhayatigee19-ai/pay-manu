@extends('layouts.template_default')

@section('content')
<div class="container">
    <h3>Edit Data Siswa</h3>

    <form action="{{ route('stafkeuangan.siswa.update', $siswa->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nis">NIS</label>
            <input type="text" name="nis" class="form-control" value="{{ $siswa->nis }}" required>
        </div>

        <div class="mb-3">
            <label for="nama">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $siswa->nama }}" required>
        </div>

        <div class="mb-3">
            <label for="kelas_id">Kelas</label>
            <select name="kelas_id" class="form-control" required>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>
                        {{ $k->kelas }}
                    </option>
                @endforeach
            </select>
        </div>

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

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('stafkeuangan.siswa.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
