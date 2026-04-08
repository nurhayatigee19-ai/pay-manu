@extends('layouts.template_default')

@section('title', 'Data Kelas')

@section('content')
<div class="container">

    <div class="page-header">
        <div>
            <h4 class="mb-1">Data Kelas</h4>
            <small class="text-muted">
                Tahun Ajar Aktif:
                <strong>{{ $tahunAjarAktif->tahun ?? '-' }}</strong>
            </small>
        </div>

        <a href="{{ route('stafkeuangan.kelas.create') }}" class="btn-add-icon">
            <i class="bi bi-plus-circle"></i> Tambah Kelas
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-theme">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Jumlah Siswa</th>
                            <th>Belum Lunas</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($kelas as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_kelas }}</td>
                            <td class="text-center">{{ $item->siswa_count }}</td>
                            <td class="text-center">{{ $item->belum_lunas }}</td>

                            <td class="text-center">
                                <div class="action-group">

                                    {{-- HAPUS (Modal) --}}
                                    <button type="button"
                                            class="btn btn-danger btn-sm btn-action"
                                            title="Hapus"
                                            onclick="setHapus('{{ route('stafkeuangan.kelas.destroy', $item->id) }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Data kelas belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Yakin ingin menghapus kelas ini?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <form id="formHapus" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>

        </div>
    </div>
</div>

@push('styles')
<style>
.table-theme thead th {
    background-color: #198754;
    color: #ffffff;
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
    border: 1px solid #dee2e6;
}

/* Biar ikon tersusun rapi */
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
</style>
@endpush

@push('scripts')
<script>
function setHapus(url) {
    document.getElementById('formHapus').action = url;
    let modal = new bootstrap.Modal(document.getElementById('modalHapus'));
    modal.show();
}
</script>
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