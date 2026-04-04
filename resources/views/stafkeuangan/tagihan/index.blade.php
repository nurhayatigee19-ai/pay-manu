@extends('layouts.template_default')

@section('title', 'Daftar Tagihan Siswa')

@section('content')
<div class="container">
    <h4 class="mb-4">Daftar Tagihan Siswa</h4>

    {{-- ERROR / SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Total Tagihan</th>
                            <th>Total Dibayar</th>
                            <th>Sisa Tagihan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tagihan as $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $t->siswa->nama }}</td>
                            <td>{{ $t->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>Rp {{ number_format($t->nominal_tagihan,0,',','.') }}</td>
                            <td>Rp {{ number_format($t->total_dibayar,0,',','.') }}</td>
                            <td>Rp {{ number_format($t->sisa_tagihan,0,',','.') }}</td>
                            <td>
                                <span class="badge {{ $t->sisa_tagihan == 0 ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $t->status }}
                                </span>
                            </td>
                            <td>
                                @if($t->sisa_tagihan > 0)
                                    <a href="{{ route('stafkeuangan.pembayaran.create', $t->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        Bayar
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>Lunas</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Belum ada tagihan siswa
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table-theme thead th {
    background-color: #198754; /* hijau dashboard */
    color: #ffffff;
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
    border: 1px solid #dee2e6;
}
</style>
@endpush