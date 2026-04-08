@extends('layouts.template_default')

@section('title', 'Daftar Pembayaran Siswa')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="fw-semibold">Daftar Pembayaran Siswa</h4>
        <div class="text-muted">
            Kelas : {{ $kelas->nama_kelas ?? '-' }} |
            Tahun Ajar : {{ $tahunAjaran ?? '-' }}
        </div>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="mb-3">
        <div class="row align-items-end">

            <div class="col-md-4">
                <label class="form-label small text-muted">Cari</label>
                <input type="text" name="search" class="form-control"
                    placeholder="Nama / NIS..."
                    value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label small text-muted">Tanggal</label>
                <input type="date" name="tanggal" class="form-control"
                    value="{{ request('tanggal') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label d-block small text-muted">Aksi</label>
                <div class="d-flex gap-2">

                    <button class="btn btn-primary" title="Filter">
                        <i class="bi bi-funnel-fill"></i>
                    </button>

                    <a href="{{ route('stafkeuangan.pembayaran.index') }}"
                       class="btn btn-secondary" title="Reset">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>

                </div>
            </div>

        </div>
    </form>

    {{-- TABEL --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle table-theme mb-0">
                <thead class="text-center">
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
                @forelse ($pembayaran as $p)
                    <tr>
                        <td class="text-center">
                            {{ ($pembayaran->currentPage() - 1) * $pembayaran->perPage() + $loop->iteration }}
                        </td>

                        <td>{{ $p->nis }}</td>
                        <td>{{ $p->nama_siswa }}</td>
                        <td>{{ $p->nama_kelas }}</td>

                        <td class="text-end fw-semibold">
                            Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                        </td>

                        <td class="text-center">
                            {{ $p->tanggal_bayar?->format('d-m-Y') }}
                        </td>

                        {{-- AKSI (IKON) --}}
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                <a href="{{ route('stafkeuangan.pembayaran.show', $p->id) }}"
                                   class="btn btn-sm btn-info"
                                   title="Detail">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <a href="{{ route('stafkeuangan.pembayaran.cetak', $p->id) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-success"
                                   title="Cetak">
                                    <i class="bi bi-printer-fill"></i>
                                </a>

                                @if($p->status === 'valid')
                                    <form action="{{ url('/stafkeuangan/pembayaran/' . $p->id . '/batalkan') }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin membatalkan pembayaran ini?')">
                                        @csrf
                                        @method('PATCH')

                                        <input type="hidden" name="alasan" value="Kesalahan input oleh staf">

                                        <button type="button"
                                            class="btn btn-sm btn-danger btn-batalkan"
                                            data-id="{{ $p->id }}"
                                            title="Batalkan">
                                            <i class="bi bi-x-circle-fill"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-secondary">Batal</span>
                                @endif

                            </div>
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

            {{-- FOOTER --}}
            <div class="p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted">
                    Menampilkan <strong>{{ $pembayaran->count() }}</strong>
                    dari <strong>{{ $pembayaran->total() }}</strong> data
                </small>

                <div>
                    {{ $pembayaran->links() }}
                </div>
            </div>
        </div>
    </div>

</div>

{{-- MODAL KONFIRMASI Batalkan --}}
<div class="modal fade" id="modalBatal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formBatal" method="POST">
                @csrf
                @method('PATCH')

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>Yakin ingin membatalkan pembayaran ini?</p>

                    <div class="mb-3">
                        <label class="form-label">Alasan (opsional)</label>
                        <textarea name="alasan" class="form-control"
                            placeholder="Contoh: salah input nominal"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Ya, Batalkan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- STYLE --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
.table-theme thead th {
    background-color: var(--bs-success) !important;
    color: #fff !important;
}

/* tombol ikon lebih halus */
.btn-sm {
    border-radius: 8px;
    padding: 5px 8px;
}

.btn-sm i {
    font-size: 14px;
}

/* pagination hijau */
.pagination .page-link {
    color: #198754;
}

.pagination .page-item.active .page-link {
    background-color: #198754;
    border-color: #198754;
    color: #fff;
}

.pagination .page-link:hover {
    background-color: #157347;
    color: #fff;
}
</style>
@endpush

{{-- TOOLTIP --}}
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el)
    })

    // Modal batal
    const modal = new bootstrap.Modal(document.getElementById('modalBatal'))
    const form = document.getElementById('formBatal')

    document.querySelectorAll('.btn-batalkan').forEach(btn => {
        btn.addEventListener('click', function () {
            let id = this.getAttribute('data-id')

            // set action dinamis
            form.action = `/stafkeuangan/pembayaran/${id}/batalkan`

            modal.show()
        })
    })

})
</script>
@endpush

@endsection