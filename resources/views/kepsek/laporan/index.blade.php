@extends('layouts.template_default')
@section('title', 'Laporan Pembayaran')

@section('content')
<div class="page-heading mb-4">
    <h2 class="fw-bold">Laporan Pembayaran</h2>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12">

            {{-- FILTER CARD --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light fw-bold">
                    <i class="bi bi-funnel me-2"></i> Filter Data
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('kepsek.laporan.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="nis" value="{{ request('nis') }}" class="form-control" placeholder="Cari NIS">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="nama" value="{{ request('nama') }}" class="form-control" placeholder="Cari Nama">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">-- Status --</option>
                                <option value="lunas" {{ request('status')=='lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="belum" {{ request('status')=='belum' ? 'selected' : '' }}>Belum Lunas</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Cari
                            </button>
                            <a href="{{ route('kepsek.laporan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- DATA LAPORAN --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-file-earmark-bar-graph me-2"></i> Data Laporan</span>
                    <a href="{{ route('kepsek.laporan.cetak', request()->all()) }}" target="_blank" class="btn btn-danger btn-sm fw-bold">
                        <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
                    </a>
                    <a href="{{ route('kepsek.laporan.cetakTunggakan') }}" target="_blank" class="btn btn-warning">
                        <i class="bi bi-file-earmark-pdf"></i> Cetak PDF Tunggakan
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Tanggal Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembayaran as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->tagihanSiswa->siswa?->nis ?? '-' }}</td>
                                        <td>{{ $item->tagihanSiswa->siswa?->nama ?? '-' }}</td>
                                        <td class="text-center">{{ $item->tagihanSiswa->siswa?->kelas?->nama_kelas ?? '-' }}</td>
                                        <td class="text-end fw-semibold">
                                            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            @if($item->status == 'valid')
                                                <span class="badge bg-success px-3 py-2">Valid</span>
                                            @else
                                                <span class="badge bg-danger px-3 py-2">Batal</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d-m-Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada data pembayaran</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($pembayaran->count() > 0)
                            <tfoot>
                                <tr class="fw-bold table-light">
                                    <td colspan="3" class="text-center">Total</td>
                                    <td class="text-end">
                                        Rp {{ number_format($totalBayar,0,',','.') }}
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<style>
.card:hover {
    transform: translateY(-4px);
    transition: 0.3s;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12) !important;
}
.table-hover tbody tr:hover {
    background-color: #f8fbff;
}
</style>
@endsection