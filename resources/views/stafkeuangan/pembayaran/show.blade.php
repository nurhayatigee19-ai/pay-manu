@extends('layouts.template_default')

@section('content')
<div class="container">
    <h3>Detail Pembayaran</h3>

    {{-- Informasi Siswa --}}
    <div class="card mb-3">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="200">NIS</th>
                    <td>: {{ $siswa->nis }}</td>
                </tr>
                <tr>
                    <th>Nama Siswa</th>
                    <td>: {{ $siswa->nama }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>: {{ $siswa->kelas->nama_kelas }}</td>
                </tr>
                <tr>
                    <th>Total Tagihan</th>
                    <td>: Rp {{ number_format($totalTagihan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Total Dibayar</th>
                    <td>: Rp {{ number_format($totalDibayar, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Sisa Tagihan</th>
                    <td>: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Riwayat Pembayaran --}}
    <div class="card">
        <div class="card-header">
            <b>Riwayat Pembayaran</b>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle table-theme">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Keterangan</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                        <th>Tanggal Bayar</th>
                        <th width="100">Cetak</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $p->keterangan ?? 'Pembayaran SPP' }}
                             </td>

                            <td>
                                {{ ucfirst($p->tagihanSiswa->semester ?? '-') }}
                                {{ $p->tagihanSiswa->tahunAjar->tahun ?? '-' }}
                             </td>

                            <td>
                                Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                             </td>

                            <td>
                                {{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d-m-Y') }}
                             </td>

                            {{-- ⭐ TOMBOL CETAK MENJADI IKON (DIUBAH) --}}
                            <td class="text-center">
                                <a href="{{ route('stafkeuangan.pembayaran.cetak', $p->id) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-success btn-action"
                                   title="Cetak">
                                    <i class="bi bi-printer-fill"></i>
                                </a>
                             </td>
                         </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Belum ada pembayaran
                             </td>
                         </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-start">
        <a href="{{ route('stafkeuangan.pembayaran.index') }}"
            class="btn btn-back-pro d-inline-flex align-items-center justify-content-center gap-2">
                <span class="icon-wrap">
                    <i class="bi bi-arrow-left"></i>
                </span>
                <span>Kembali</span>
        </a>
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

/* ⭐ STYLE UNTUK TOMBOL IKON */
.btn-action {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    border-radius: 8px;
}

.btn-action i {
    font-size: 16px;
}

.btn-back-pro {
    background-color: #198754;
    color: #fff;
    border-radius: 10px;
    padding: 8px 16px;
    transition: all 0.2s ease;
    border: none;
    text-decoration: none;
}

.btn-back-pro:hover {
    background-color: #157347;
    color: #fff;
    transform: translateX(-3px);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el)
    });
});
</script>
@endpush

@endsection