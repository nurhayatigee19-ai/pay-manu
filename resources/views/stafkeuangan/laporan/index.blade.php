@extends('layouts.template_default')
@section('title', 'Laporan Pembayaran')

@section('content')
<div class="container-fluid">

    <h4 class="mb-3">Laporan Pembayaran</h4>

    {{-- ===============================
        FORM FILTER
    ================================ --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <select name="kelas_id" class="form-select">
                <option value="">-- Semua Kelas --</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <input type="number" name="tahun_ajar_id" class="form-control" placeholder="Tahun Ajar ID" value="{{ $tahunAjarId }}">
        </div>

        <div class="col-md-4 d-flex gap-2">
            <button class="btn btn-primary w-100">Filter</button>
            <a href="{{ route('stafkeuangan.laporan.index') }}" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>

    {{-- ===============================
        TOMBOL CETAK PDF
    ================================ --}}
    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('stafkeuangan.laporan.cetak', request()->all()) }}" target="_blank" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Cetak PDF Pembayaran
        </a>
        <a href="{{ route('stafkeuangan.laporan.cetakTunggakan') }}" target="_blank" class="btn btn-warning">
            <i class="bi bi-file-earmark-pdf"></i> Cetak PDF Tunggakan
        </a>
    </div>

    {{-- ===============================
        RINGKASAN LAPORAN
    ================================ --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h6>Total Pembayaran</h6>
                    <h4 class="text-success">Rp {{ number_format($totalBayar, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h6>Jumlah Transaksi</h6>
                    <h4 class="text-info">{{ $pembayaran->count() }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- ===============================
        TABEL DATA PEMBAYARAN
    ================================ --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover align-middle table-theme">
                <thead class="table-success text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayaran as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->created_at->format('d-m-Y') }}</td>
                            @php
                                $siswa = optional($row->tagihanSiswa)->siswa;
                            @endphp
                            <td>{{ $siswa->nis ?? '-' }}</td>
                            <td>{{ $siswa->nama ?? '-' }}</td>
                            <td>{{ optional($siswa->kelas)->nama_kelas ?? '-' }}</td>
                            <td class="text-end">Rp {{ number_format($row->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data pembayaran</td>
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
    background-color: var(--bs-success) !important;
    color: #fff !important;
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
    border: 1px solid rgba(255,255,255,0.25) !important;
}
</style>
@endpush
@endsection