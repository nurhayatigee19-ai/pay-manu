@extends('layouts.template_default')

@section('title', 'Laporan Tunggakan')

@section('content')

<div class="page-heading mb-4">
    <h2 class="fw-bold">Laporan Tunggakan Siswa</h2>
</div>

<div class="page-content">
<section class="row">
<div class="col-12">

<div class="card shadow-sm border-0">

    <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
        <span>
            <i class="bi bi-file-earmark-bar-graph me-2"></i>
            Data Tunggakan
        </span>

        <a href="{{ route('kepsek.laporan.cetakTunggakan', request()->all()) }}"
           target="_blank"
           class="btn btn-danger btn-sm">
            <i class="bi bi-file-earmark-pdf"></i>
            Cetak PDF
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle mb-0">

                <thead class="table-light text-center">
                    <tr>
                        <th width="60">No</th>
                        <th width="120">NIS</th>
                        <th>Nama</th>
                        <th width="120">Kelas</th>
                        <th width="180">Sisa Tagihan</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($tagihan as $d)
                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="text-center">
                                {{ $d->siswa->nis ?? '-' }}
                            </td>

                            <td>
                                {{ $d->siswa->nama ?? '-' }}
                            </td>

                            <td class="text-center">
                                {{ $d->siswa->kelas->nama_kelas ?? '-' }}
                            </td>

                            <td class="text-end">
                                Rp {{ number_format($d->sisa_tagihan ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                Tidak ada data tunggakan
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

</div>
</section>
</div>

@endsection
