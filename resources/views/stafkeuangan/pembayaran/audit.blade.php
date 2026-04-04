@extends('layouts.template_default')

@section('title', 'Riwayat Audit Pembayaran')

@section('content')
<div class="container">
    <h4 class="mb-3">Audit Pembayaran</h4>

    <div class="card">
        <div class="card-body">
            <p><strong>Kode Transaksi:</strong> {{ $pembayaran->kode_transaksi }}</p>
            <p><strong>Jumlah:</strong> Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> {{ $pembayaran->status }}</p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">Riwayat Aksi</div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Aksi</th>
                        <th>Oleh</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayaran->audit as $audit)
                        <tr>
                            <td>{{ $audit->created_at }}</td>
                            <td>{{ strtoupper($audit->aksi) }}</td>
                            <td>{{ $audit->user?->name ?? '-' }}</td>
                            <td>{{ $audit->keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada audit</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection