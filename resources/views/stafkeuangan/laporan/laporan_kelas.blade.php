@extends('layouts.template_default')
@section('title', 'Laporan Kelas')

@section('content')
<div class="container">
    <h4 class="mb-4">Laporan Pembayaran per Kelas</h4>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Total Siswa</th>
                        <th>Total Tagihan</th>
                        <th>Total Bayar</th>
                        <th>Total Sisa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelasData as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $row->nama_kelas }}</td>
                            <td class="text-center">{{ $row->jumlah_siswa }}</td>
                            <td class="text-end">Rp {{ number_format($row->total_tagihan,0,',','.') }}</td>
                            <td class="text-end">Rp {{ number_format($row->total_dibayar,0,',','.') }}</td>
                            <td class="text-end">Rp {{ number_format($row->sisa,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data kelas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection