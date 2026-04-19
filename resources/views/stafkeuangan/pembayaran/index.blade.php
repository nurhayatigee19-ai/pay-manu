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

    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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
                                    {{-- ⭐ TOMBOL BATALKAN DENGAN SWEETALERT (DIUBAH) --}}
                                    <button type="button"
                                            class="btn btn-sm btn-danger"
                                            title="Batalkan"
                                            onclick="confirmBatal({{ $p->id }}, '{{ $p->nama_siswa }}', '{{ number_format($p->jumlah, 0, ',', '.') }}')">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </button>

                                    {{-- FORM TERSEMBUNYI UNTUK BATALKAN --}}
                                    <form id="batal-form-{{ $p->id }}" 
                                          action="{{ route('stafkeuangan.pembayaran.batalkan', $p->id) }}" 
                                          method="POST" 
                                          style="display: none;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="alasan" value="Pembatalan oleh staf">
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
@endsection

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

.alert {
    border-radius: 10px;
}
</style>
@endpush

{{-- TOOLTIP & SWEETALERT --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el)
    });
});

// ⭐ FUNGSI KONFIRMASI BATALKAN DENGAN SWEETALERT
function confirmBatal(id, namaSiswa, jumlah) {
    Swal.fire({
        title: 'Batalkan Pembayaran?',
        html: `Anda akan membatalkan pembayaran dari <strong>${namaSiswa}</strong><br>
               Jumlah: <strong>Rp ${jumlah}</strong><br><br>
               <small class="text-warning">⚠️ Pembayaran yang dibatalkan akan dikembalikan ke status tagihan!</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, batalkan!',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            // Tampilkan loading
            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang membatalkan pembayaran',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit form
            document.getElementById(`batal-form-${id}`).submit();
        }
    });
}
</script>
@endpush