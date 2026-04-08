@extends('layouts.template_default')
@section('title', 'Laporan Pembayaran')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4 fw-semibold">Laporan Pembayaran</h4>

    {{-- ===============================
        FILTER + AKSI (RAPI & BALANCE)
    ================================ --}}
    <form method="GET" class="row g-3 mb-4 align-items-end">

        <div class="col-md-3">
            <label class="form-label small text-muted">Kelas</label>
            <select name="kelas_id" class="form-select">
                <option value="">-- Semua Kelas --</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label small text-muted">Tahun Ajar</label>
            <select name="tahun_ajar_id" class="form-select">
                <option value="">-- Semua Tahun Ajar --</option>
                @foreach ($tahunAjar as $ta)
                    <option value="{{ $ta->id }}"
                        {{ $tahunAjarId == $ta->id ? 'selected' : '' }}>
                        {{ $ta->tahun }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- FILTER --}}
        <div class="col-md-2">
            <label class="form-label small text-muted">Filter</label>
            <div class="d-flex gap-2">
                <button class="btn-icon btn-icon-primary" title="Filter">
                    <i class="bi bi-funnel-fill"></i>
                </button>

                <a href="{{ route('stafkeuangan.laporan.index') }}"
                   class="btn-icon btn-icon-secondary"
                   title="Reset">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </div>

        {{-- CETAK --}}
        <div class="col-md-4">
            <label class="form-label small text-muted">Cetak</label>
            <div class="d-flex gap-2">
                <a href="{{ route('stafkeuangan.laporan.cetak', request()->all()) }}"
                   target="_blank"
                   class="btn-icon btn-icon-danger"
                   title="Cetak Pembayaran">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                </a>

                <a href="{{ route('stafkeuangan.laporan.cetakTunggakan') }}"
                   target="_blank"
                   class="btn-icon btn-icon-warning"
                   title="Cetak Tunggakan">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                </a>
            </div>
        </div>

    </form>

    {{-- ===============================
        CARD SUMMARY (BERSIH & CENTER)
    ================================ --}}
    <div class="row mb-4 g-3">

        {{-- TOTAL --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">

                    <div class="icon-box bg-success text-white mb-2">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <div class="text-muted small">Total Pembayaran</div>

                    <h5 class="text-success fw-bold mb-0">
                        Rp {{ number_format($totalBayar, 0, ',', '.') }}
                    </h5>

                </div>
            </div>
        </div>

        {{-- TRANSAKSI --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">

                    <div class="icon-box bg-primary text-white mb-2">
                        <i class="bi bi-receipt"></i>
                    </div>

                    <div class="text-muted small">Jumlah Transaksi</div>

                    <h5 class="text-primary fw-bold mb-0">
                        {{ $pembayaran->count() }}
                    </h5>

                </div>
            </div>
        </div>

    </div>

    {{-- ===============================
        TABEL
    ================================ --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle table-theme mb-0">
                <thead class="text-center">
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

                            <td class="text-end fw-semibold">
                                Rp {{ number_format($row->jumlah, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Tidak ada data pembayaran
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ===============================
    STYLE (SIMPLE & CONSISTENT)
=============================== --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* TABLE */
.table-theme thead th {
    background-color: #198754 !important;
    color: #fff !important;
    text-align: center;
    font-weight: 600;
}

/* ICON CENTER */
.icon-box {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.icon-box i {
    font-size: 20px;
}

/* BUTTON ICON */
.btn-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-icon-primary { background: #0d6efd; color: #fff; }
.btn-icon-secondary { background: #6c757d; color: #fff; }
.btn-icon-danger { background: #dc3545; color: #fff; }
.btn-icon-warning { background: #ffc107; color: #000; }

</style>
@endpush

{{-- ===============================
    TOOLTIP
=============================== --}}
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el)
    })
});
</script>
@endpush

@endsection