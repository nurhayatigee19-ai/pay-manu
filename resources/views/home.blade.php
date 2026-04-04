@extends('layouts.template_default')

@section('title', 'Dashboard')

@section('content')
<div class="page-heading">
    <h3>Dashboard</h3>
</div>

<div class="page-content">
    <div class="row">
        {{-- Statistik --}}
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stats-icon purple mb-2">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h6 class="text-muted font-semibold">Total Siswa</h6>
                    <h6 class="font-extrabold mb-0">{{ $total_siswa ?? 0 }}</h6>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stats-icon blue mb-2">
                        <i class="fa-solid fa-chalkboard"></i>
                    </div>
                    <h6 class="text-muted font-semibold">Total Kelas</h6>
                    <h6 class="font-extrabold mb-0">{{ $total_kelas ?? 0 }}</h6>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stats-icon green mb-2">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <h6 class="text-muted font-semibold">Pembayaran Bulan Ini</h6>
                    <h6 class="font-extrabold mb-0">Rp {{ number_format($pembayaran_bulan_ini ?? 0, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stats-icon red mb-2">
                        <i class="fa-solid fa-sack-xmark"></i>
                    </div>
                    <h6 class="text-muted font-semibold">Tunggakan</h6>
                    <h6 class="font-extrabold mb-0">Rp {{ number_format($tunggakan ?? 0, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Pembayaran --}}
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Grafik Pembayaran</h4>
                </div>
                <div class="card-body">
                    <div id="chart-pembayaran"></div>
                </div>
            </div>
        </div>

        {{-- Profil Admin --}}
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body py-4 px-5">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="avatar">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                            <h6 class="text-muted mb-0">{{ Auth::user()->email }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Pembayaran --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Riwayat Pembayaran Terbaru</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayat_pembayaran ?? [] as $pembayaran)
                                <tr>
                                    <td>{{ $pembayaran->siswa->nama }}</td>
                                    <td>{{ $pembayaran->siswa->kelas->nama }}</td>
                                    <td>{{ $pembayaran->tanggal }}</td>
                                    <td>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                    <td>
                                        @if($pembayaran->status == 'lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada pembayaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        chart: { type: 'line', height: 300 },
        series: [{
            name: 'Total Pembayaran',
            data: @json($grafik_pembayaran ?? [0,0,0,0,0,0])
        }],
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']
        },
        colors: ['#435ebe']
    };
    var chart = new ApexCharts(document.querySelector("#chart-pembayaran"), options);
    chart.render();
</script>
@endsection
