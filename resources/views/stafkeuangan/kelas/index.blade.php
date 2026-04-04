@extends('layouts.template_default')

@section('title', 'Data Kelas')

@section('content')
<div class="container">
    <h4 class="mb-1">Data Kelas</h4>

    <small class="text-muted">
        Tahun Ajar Aktif:
        <strong>{{ $tahunAjarAktif->nama_tahun ?? '-' }}</strong>
    </small>

    <div class="mt-3">
        <a href="{{ route('stafkeuangan.kelas.create') }}"
           class="btn btn-primary mb-3">
            + Tambah Kelas
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-theme">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Jumlah Siswa</th>
                        <th>Belum Lunas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($kelas as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_kelas }}</td>
                        <td>{{ $item->siswa_count }}</td>
                        <td>{{ $item->belum_lunas }}</td>
                        <td>
                            <form action="{{ route('stafkeuangan.kelas.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Data kelas belum tersedia
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
.table-theme thead th {
    background-color: #198754; /* hijau dashboard */
    color: #ffffff;
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
    border: 1px solid #dee2e6;
}
</style>
@endpush
@endsection

