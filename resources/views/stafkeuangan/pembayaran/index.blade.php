@extends('layouts.template_default')

@section('title', 'Daftar Pembayaran Siswa')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4>Daftar Pembayaran Siswa</h4>
        <div class="text-muted">
            Kelas : {{ $kelas->nama_kelas ?? '-' }} |
            Tahun Ajar : {{ $tahunAjaran ?? '-' }}
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover align-middle table-theme">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jumlah</th>
                        <th>Tanggal Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($pembayaran as $i => $p)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>

                        {{-- ✅ SUDAH BERSIH --}}
                        <td>{{ $p->nis }}</td>
                        <td>{{ $p->nama_siswa }}</td>
                        <td>{{ $p->nama_kelas }}</td>

                        <td class="text-end">
                            Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                        </td>

                        <td class="text-center">
                            {{ $p->tanggal_bayar?->format('d-m-Y') }}
                        </td>

                        <td class="text-center">

                            <a href="{{ route('stafkeuangan.pembayaran.show', $p->id) }}"
                               class="btn btn-sm btn-info">
                                Detail
                            </a>

                            <a href="{{ route('stafkeuangan.pembayaran.cetak', $p->id) }}"
                               target="_blank"
                               class="btn btn-sm btn-success">
                                Cetak
                            </a>

                            @if($p->status === 'valid')
                                <form action="{{ route('stafkeuangan.pembayaran.batalkan', $p->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin membatalkan pembayaran ini?')">
                                    @csrf
                                    <input type="hidden" name="alasan" value="Kesalahan input oleh staf">

                                    <button class="btn btn-sm btn-danger">
                                        Batalkan
                                    </button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Data pembayaran belum tersedia.
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
    color: #fff !important;
    text-align: center;
    font-weight: 600;
}
</style>
@endpush

@endsection