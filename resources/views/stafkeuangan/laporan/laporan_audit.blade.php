@extends('layouts.template_default')
@section('title', 'Laporan Audit Pembayaran')

@section('content')
<div class="container">
    <h4 class="mb-4">Laporan Audit Pembayaran</h4>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Nominal</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($audit as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->aksi }}</td>
                            <td class="text-end">Rp {{ number_format($row->nominal,0,',','.') }}</td>
                            <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data audit</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection