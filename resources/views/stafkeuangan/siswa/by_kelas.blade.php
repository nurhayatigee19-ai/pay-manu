@extends('layouts.template_default')

@section('content')
<div class="container">
    <h4 class="mb-3">
        Daftar Siswa Kelas {{ $kelas->kelas }}
    </h4>

    <a href="{{ route('stafkeuangan.kelas.index') }}"
       class="btn btn-secondary btn-sm mb-3">
        ← Kembali
    </a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa as $s)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nama }}</td>
                <td>{{ $s->status_hitung }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">
                    Tidak ada siswa di kelas ini
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection