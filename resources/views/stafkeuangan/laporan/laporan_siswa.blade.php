@extends('layouts.template_default')
@section('title', 'Laporan Siswa')

@section('content')
<div class="container">
    <h4 class="mb-4">Laporan Pembayaran per Siswa</h4>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <select name="kelas_id" class="form-select">
                <option value="">-- Semua Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Total Tagihan</th>
                        <th>Total Bayar</th>
                        <th>Sisa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $row->nis }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->kelas->nama_kelas }}</td>
                            <td class="text-end">Rp {{ number_format($row->total_tagihan,0,',','.') }}</td>
                            <td class="text-end">Rp {{ number_format($row->total_dibayar,0,',','.') }}</td>
                            <td class="text-end">Rp {{ number_format($row->sisa,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data siswa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection