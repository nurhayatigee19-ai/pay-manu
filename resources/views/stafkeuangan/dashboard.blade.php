@extends('layouts.template_default')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Dashboard Staf Keuangan</h2>

    {{-- Statistik --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center card-stat">
                <div class="card-body">
                    <i class="bi bi-people-fill fs-2 text-primary"></i>
                    <h6 class="text-muted">Jumlah Siswa</h6>
                    <h4 class="fw-bold">{{ $jumlahSiswa }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center card-stat">
                <div class="card-body">
                    <i class="bi bi-calendar-day fs-2 text-success"></i>
                    <h6 class="text-muted">Hari Ini</h6>
                    <h5 class="fw-bold">Rp {{ number_format($pembayaranHariIni, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center card-stat">
                <div class="card-body">
                    <i class="bi bi-calendar-month fs-2 text-warning"></i>
                    <h6 class="text-muted">Bulan Ini</h6>
                    <h5 class="fw-bold">Rp {{ number_format($pembayaranBulanIni, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center card-stat">
                <div class="card-body">
                    <i class="bi bi-graph-up-arrow fs-2 text-danger"></i>
                    <h6 class="text-muted">Tahun Ini</h6>
                    <h5 class="fw-bold">Rp {{ number_format($pembayaranTahunIni, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Pembayaran --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white fw-bold">
            <i class="bi bi-cash-coin me-2"></i> Riwayat Pembayaran Terbaru
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"  text-center>
                    <tr>
                        <th class="text-center">Siswa</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatPembayaran as $p)
                    <tr>
                        <td class="text-center">{{ $p->tagihanSiswa->siswa->nama ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-success">
                                Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d-m-Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Belum ada riwayat pembayaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Hover animasi --}}
<style>
    .card-stat:hover {
        transform: translateY(-6px);
        transition: 0.3s;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection
