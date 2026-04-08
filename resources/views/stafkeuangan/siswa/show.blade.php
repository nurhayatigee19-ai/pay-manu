@extends('layouts.template_default')

@section('title', 'Detail Siswa')

@section('content')
<div class="container">
    <h4 class="mb-4">Detail Siswa</h4>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="200">NIS</th>
                    <td>{{ $siswa->nis }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $siswa->nama }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Tagihan</th>
                    <td>Rp {{ number_format($siswa->jumlah_tagihan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Total Dibayar</th>
                    <td>Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Sisa Tagihan</th>
                    <td>
                        Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($status === 'Lunas')
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-danger">Belum Lunas</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <h5 class="mb-3">Riwayat Pembayaran</h5>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle table-theme">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Periode</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d-m-Y') }}</td>
                            <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td>
                                @if($item->tagihanSiswa && $item->tagihanSiswa->tahunAjar)
                                    {{ ucfirst($item->tagihanSiswa->semester) }}
                                    {{ $item->tagihanSiswa->tahunAjar->tahun }}
                                @else
                                    <span class="text-muted">Tidak ada periode</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada pembayaran
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 d-flex justify-content-start">
                <a href="{{ route('stafkeuangan.siswa.index') }}"
                    class="btn btn-back-pro d-inline-flex align-items-center justify-content-center gap-2">
                        <span class="icon-wrap">
                            <i class="bi bi-arrow-left"></i>
                        </span>
                        <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.table-theme thead th {
    background-color: var(--bs-success) !important;
    color: #ffffff !important;
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
    border: 1px solid rgba(255,255,255,0.25) !important;
}
</style>
@endpush

@push('styles')
<style>
.btn-back {
    border-radius: 10px;
    transition: all 0.2s ease;
}

.btn-back:hover {
    background-color: #198754;
    color: #fff;
    transform: translateX(-3px);
}
</style>
@endpush

@endsection
