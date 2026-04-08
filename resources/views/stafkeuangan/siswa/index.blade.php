@extends('layouts.template_default')

@section('title', 'Data Siswa')

@section('content')
<div class="container">

    {{-- HEADER + TOMBOL --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            @isset($kelas)
                Data Siswa Kelas {{ $kelas->nama_kelas }}
            @else
                Data Siswa (Global)
            @endisset
        </h3>

        {{-- ✅ TOMBOL SUDAH DISAMAKAN --}}
        <a href="{{ route('stafkeuangan.siswa.create') }}" class="btn-add-icon">
            <i class="bi bi-plus-circle"></i> Tambah Siswa
        </a>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="mb-3">
        <div class="row g-2">

            <div class="col-md-3">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama / NIS..."
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <select name="kelas" class="form-control">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($listKelas as $k)
                        <option value="{{ $k->id }}"
                            {{ request('kelas') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">-- Semua Status --</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Lunas</option>
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary" title="Filter">
                    <i class="bi bi-funnel-fill"></i>
                </button>

                <a href="{{ route('stafkeuangan.siswa.index') }}"
                   class="btn btn-secondary" title="Reset">
                   <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>

        </div>
    </form>

    {{-- TABEL --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover table-theme align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th class="text-end">Jumlah Tagihan</th>
                            <th class="text-end">Total Bayar</th>
                            <th class="text-end">Sisa Tagihan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($siswa as $s)
                            <tr>
                                <td class="text-center">
                                    {{ ($siswa->currentPage() - 1) * $siswa->perPage() + $loop->iteration }}
                                </td>

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
                                    <div class="action-group">

                                        <a href="{{ route('stafkeuangan.siswa.show', $s->id) }}"
                                           class="btn btn-sm btn-outline-primary btn-action"
                                           title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if($s->tagihan)
                                            <a href="{{ route('stafkeuangan.pembayaran.create', $s->tagihan->id) }}"
                                                class="btn btn-sm btn-success btn-action"
                                                title="Bayar">
                                                <i class="bi bi-cash-stack"></i>
                                            </a>
                                        @endif

                                    </div>
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

            {{-- FOOTER --}}
            <div class="d-flex justify-content-between align-items-center mt-2">

                <div class ="text-muted small">
                    @php
                        $from = $siswa->firstItem();
                        $to = $siswa->lastItem();
                        $total = $siswa->total();
                        $current = $siswa->currentPage();
                        $pages = $siswa->lastPage();
                    @endphp

                    Menampilkan {{ $from }}–{{ $to }} dari {{ $total }} data 
                    (Halaman {{ $current }} dari {{ $pages }})
                </div>

                <div>
                    {{ $siswa->links() }}
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
.table-theme thead th {
    background-color: #198754;
    color: #ffffff;
}

/* Badge Status */
.badge-lunas {
    background:#198754;
    color:#fff;
    padding:6px 12px;
}

.badge-belum {
    background:#dc3545;
    color:#fff;
    padding:6px 12px;
}

/* Tombol ikon */
.action-group {
    display: flex;
    justify-content: center;
    gap: 6px;
}

.btn-action {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    justify-content: center;
    align-items: center;
}

/* Tombol aksi */
.btn-add-icon {
    background: #198754;
    color: #fff;
    padding: 10px 16px;
    border-radius: 10px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    border: none;
    transition: all 0.2s ease;
}

.btn-add-icon:hover {
    background: #157347;
    color: #fff;
    transform: translateY(-1px);
}

/* Pagination */
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
});
</script>
@endpush

@endsection