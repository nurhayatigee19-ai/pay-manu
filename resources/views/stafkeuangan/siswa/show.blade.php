@extends('layouts.app')

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
                    <td>{{ $siswa->kelas->kelas ?? '-' }}</td>
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
            <table class="table table-bordered">
                <thead class="table-light">
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
                            <td>{{ $item->periode ?? '-' }}</td>
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

            <a href="{{ route('stafkeuangan.siswa.index') }}" class="btn btn-secondary mt-3">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
