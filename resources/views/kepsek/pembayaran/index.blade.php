@extends('layouts.template_default')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Data Pembayaran</h3>
        <a href="{{ route('kepsek.pembayaran.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Pembayaran
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jumlah (Rp)</th>
                        <th>Tanggal Bayar</th>
                        <th>Keterangan</th>
                        <th>Periode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaran as $p)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $p->siswa->nis }}</td>
                            <td>{{ $p->siswa->nama }}</td>
                            <td>{{ $p->siswa->kelas->kelas }}</td>
                            <td class="text-end">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $p->tanggal_bayar ?? $p->created_at->format('d-m-Y') }}</td>
                            <td>{{ $p->keterangan ?? '-' }}</td>
                            <td>{{ $p->periode ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('kepsek.siswa.show', $p->siswa_id) }}" 
                                   class="btn btn-sm btn-info me-1" 
                                   data-bs-toggle="tooltip" title="Detail">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a href="{{ route('kepsek.pembayaran.cetak', $p->id) }}" 
                                   target="_blank"
                                   class="btn btn-sm btn-success me-1" 
                                   data-bs-toggle="tooltip" title="Cetak">
                                    <i class="fa fa-print"></i>
                                </a>

                                <a href="{{ route('kepsek.pembayaran.edit', $p->id) }}" 
                                   class="btn btn-sm btn-warning me-1 text-white" 
                                   data-bs-toggle="tooltip" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form action="{{ route('kepsek.pembayaran.destroy', $p->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            data-bs-toggle="tooltip" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data pembayaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Aktifkan tooltip Bootstrap --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (el) {
            return new bootstrap.Tooltip(el)
        })
    });
</script>
@endsection
