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
                                    <form action="{{ route('stafkeuangan.tahun_ajar.aktifkan', $t->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-success btn-sm btn-action"
                                                title="Aktifkan">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                    @endif

                                    {{-- ⭐ TOMBOL HAPUS DENGAN SWEETALERT (DIUBAH) --}}
                                    <button type="button"
                                            class="btn btn-danger btn-sm btn-action"
                                            title="Hapus"
                                            onclick="confirmDelete({{ $t->id }}, '{{ $t->tahun }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    {{-- FORM TERSEMBUNYI UNTUK HAPUS --}}
                                    <form id="delete-form-{{ $t->id }}" 
                                          action="{{ route('stafkeuangan.tahun_ajar.destroy', $t->id) }}" 
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

.alert {
    border-radius: 10px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id, tahunAjar) {
    Swal.fire({
        title: 'Hapus Tahun Ajar?',
        html: `Anda akan menghapus tahun ajar <strong>${tahunAjar}</strong><br><br>
               <small class="text-warning">⚠️ Tahun ajar yang memiliki tagihan TIDAK BISA dihapus!</small>`,
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
</script>
@endpush