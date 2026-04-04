@extends('layouts.template_default')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Data Siswa</h3>
        <a href="{{ route('kepsek.siswa.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Siswa
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jumlah Tagihan (Rp)</th>
                        <th>Total Bayar (Rp)</th>   <!-- ✅ Tambahkan -->
                        <th>Sisa Tagihan (Rp)</th>  <!-- ✅ Tambahkan -->
                        <th>Status</th>             <!-- ✅ Tambahkan -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswa as $s)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $s->nis }}</td>
                        <td>{{ $s->nama }}</td>
                        <td>{{ $s->kelas->kelas }}</td>
                        <td class="text-end">Rp {{ number_format($s->jumlah_tagihan, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($s->total_bayar, 0, ',', '.') }}</td>   <!-- ✅ -->
                        <td class="text-end">Rp {{ number_format($s->sisa_tagihan, 0, ',', '.') }}</td>  <!-- ✅ -->
                        <td class="text-center">
                            @if ($s->status == 'Lunas')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-danger">Belum Lunas</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <!-- Tombol edit & hapus -->
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data siswa</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el)
    })
});
</script>
@endsection
