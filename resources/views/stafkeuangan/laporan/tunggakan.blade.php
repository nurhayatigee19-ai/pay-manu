@extends('layouts.template_default')
@section('title', 'Laporan Tunggakan')

@section('content')
<div class="container">

    <h4 class="mb-4">Laporan Tunggakan Siswa</h4>

    {{-- FILTER (optional: bisa ditambahkan nanti) --}}
    <form method="GET" action="{{ route('stafkeuangan.laporan.tunggakan') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <select name="kelas_id" class="form-select">
                <option value="">-- Semua Kelas --</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
        <div class="col-md-2 text-end">
            <a href="{{ route('stafkeuangan.laporan.tunggakan', request()->all()) }}" target="_blank" class="btn btn-danger w-100">
                <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
            </a>
        </div>
    </form>

    {{-- TABEL DATA TUNGGAKAN --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Jumlah Siswa Menunggak</th>
                        <th>Total Tunggakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $d)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $d->kelas }}</td>
                            <td class="text-center">{{ $d->jumlah_siswa }}</td>
                            <td class="text-end">
                                Rp {{ number_format($d->total_tunggakan, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada data tunggakan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection