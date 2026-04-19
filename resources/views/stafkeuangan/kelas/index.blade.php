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

                                    {{-- ⭐ TOMBOL HAPUS DENGAN SWEETALERT (DIUBAH) --}}
                                    <button type="button"
                                            class="btn btn-danger btn-sm btn-action"
                                            title="Hapus"
                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->nama_kelas }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    {{-- FORM TERSEMBUNYI UNTUK HAPUS --}}
                                    <form id="delete-form-{{ $item->id }}" 
                                          action="{{ route('stafkeuangan.kelas.destroy', $item->id) }}" 
                                          method="POST" 
                                          style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

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
    border-radius: 8px;
}

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

.alert {
    border-radius: 10px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id, namaKelas) {
    Swal.fire({
        title: 'Hapus Kelas?',
        html: `Anda akan menghapus kelas <strong>${namaKelas}</strong><br><br>
               <small class="text-warning">⚠️ Kelas yang memiliki siswa TIDAK BISA dihapus!</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
}

// Tooltip
document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el)
    });
});
</script>
@endpush