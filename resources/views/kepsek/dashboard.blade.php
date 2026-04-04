@extends('layouts.template_default')

@section('title', 'Dashboard Kepala Sekolah')

@section('content')
<div class="container">

    <h2 class="fw-bold mb-4">Dashboard Kepala Sekolah</h2>

    <div class="alert alert-info shadow-sm">
        <i class="bi bi-info-circle me-2"></i>
        Anda login sebagai <b>Kepala Sekolah</b>.
        Halaman ini hanya menampilkan ringkasan data keuangan.
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-people-fill fs-2 text-primary"></i>
                    <h6 class="text-muted mt-2">Jumlah Siswa</h6>
                    <h3 class="fw-bold">{{ $jumlahSiswa }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-cash-stack fs-2 text-success"></i>
                    <h6 class="text-muted mt-2">Total Pembayaran Bulan Ini</h6>
                    <h3 class="fw-bold">
                        Rp {{ number_format($pembayaranBulanIni,0,',','.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-exclamation-circle fs-2 text-danger"></i>
                    <h6 class="text-muted mt-2">Total Tunggakan</h6>
                    <h3 class="fw-bold">
                        Rp {{ number_format($totalTunggakan,0,',','.') }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection