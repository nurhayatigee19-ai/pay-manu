@extends('layouts.template_default')

@section('title', 'Tahun Ajar')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Daftar Tahun Ajar</h4>

        <a href="{{ route('stafkeuangan.tahun_ajar.create') }}" class="btn-add-icon">
            <i class="bi bi-plus-circle"></i> Tambah Tahun Ajar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle table-theme">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="80">ID</th>
                            <th>Tahun Ajar</th>
                            <th width="150">Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($tahunAjar as $t)
                        <tr>
                            <td class="text-center">{{ $t->id }}</td>

                            <td>
                                <strong>{{ $t->tahun }}</strong>
                            </td>

                            <td class="text-center">
                                @if($t->aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="action-group">

                                    {{-- AKTIFKAN --}}
                                    @if(!$t->aktif)
                                    <form action="{{ route('stafkeuangan.tahun_ajar.aktifkan', $t->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-success btn-sm btn-action"
                                                title="Aktifkan">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                    @endif

                                    {{-- HAPUS (PAKAI MODAL) --}}
                                    <button type="button"
                                            class="btn btn-danger btn-sm btn-action"
                                            title="Hapus"
                                            onclick="setHapus('{{ route('stafkeuangan.tahun_ajar.destroy', $t->id) }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Belum ada data tahun ajar
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
                Yakin ingin menghapus tahun ajar ini?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <form id="formHapus" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Ya, Hapus
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

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
</style>
@endpush

@push('styles')
<style>
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