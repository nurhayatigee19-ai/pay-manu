@extends('layouts.template_default')

@section('title', 'Data Siswa')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            @isset($kelas)
                Data Siswa Kelas {{ $kelas->kelas }}
            @else
                Data Siswa (Global)
            @endisset
        </h3>
    </div>

    <div class="mb-3">
        <a href="{{ route('stafkeuangan.siswa.create') }}"
            class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Tambah Siswa
        </a>
    </div>

    {{-- CARD --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <table class="table table-hover table-theme align-middle mb-0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th class="text-end">Jumlah Tagihan</th>
                        <th class="text-end">Total Bayar</th>
                        <th class="text-end">Sisa Tagihan</th>
                        <th>Status</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($siswa as $s)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $s->nis }}</td>
                        <td>{{ $s->nama }}</td>
                        <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>

                        <td class="text-end">
                            Rp {{ number_format($s->total_tagihan, 0, ',', '.') }}
                        </td>

                        <td class="text-end">
                            Rp {{ number_format($s->total_bayar, 0, ',', '.') }}
                        </td>

                        <td class="text-end">
                            Rp {{ number_format($s->sisa_tagihan, 0, ',', '.') }}
                        </td>

                        <td class="text-center">
                            @if ($s->status === 'Lunas')
                                <span class="badge badge-lunas">Lunas</span>
                            @else
                                <span class="badge badge-belum">Belum Lunas</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @empty($kelas)
                                <a href="{{ route('stafkeuangan.kelas.siswa.index', $s->kelas_id) }}"
                                   class="btn btn-sm btn-outline-success">
                                    Detail
                                </a>
                            @endempty

                            @isset($kelas)
                                @if($s->tagihan)
                                    <a href="{{ route('stafkeuangan.pembayaran.create', $s->tagihan->id) }}"
                                        class="btn btn-sm btn-success">
                                        Bayar
                                    </a>
                                @endif
                            @endisset
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            Data siswa belum tersedia
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

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

@endsection