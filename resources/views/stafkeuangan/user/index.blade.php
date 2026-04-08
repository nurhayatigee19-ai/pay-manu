@extends('layouts.template_default')

@section('content')
<div class="container">

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Manajemen User</h4>

        <a href="{{ route('stafkeuangan.user.create') }}" class="btn-add-icon">
            <i class="bi bi-person-plus"></i> Tambah User
        </a>
    </div>

    {{-- CARD --}}
    <div class="card">
        <div class="card-body">

            <table class="table table-hover align-middle table-theme">
                <thead class="text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th width="15%">Role</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                    <tr>

                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td class="text-center">
                            @if($user->role == 'stafkeuangan')
                                <span class="badge bg-success">Staf Keuangan</span>
                            @else
                                <span class="badge bg-warning text-dark">Kepsek</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="action-icons d-flex justify-content-center gap-2">

                                {{-- EDIT --}}
                                <a href="{{ route('stafkeuangan.user.edit', $user->id) }}"
                                   class="btn-icon btn-edit"
                                   title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                {{-- HAPUS (MODAL) --}}
                                <button type="button"
                                        class="btn-icon btn-delete"
                                        title="Hapus"
                                        onclick="setHapusUser('{{ route('stafkeuangan.user.destroy', $user->id) }}')">
                                    <i class="bi bi-trash"></i>
                                </button>

                                {{-- RESET PASSWORD --}}
                                <form action="{{ route('stafkeuangan.user.reset', $user->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')

                                    <button type="submit"
                                            class="btn-icon btn-reset"
                                            title="Reset Password">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            Tidak ada data user
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>

{{-- ===============================
    MODAL HAPUS USER
=============================== --}}
<div class="modal fade" id="modalHapusUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Yakin ingin menghapus user ini?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <form id="formHapusUser" method="POST">
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

{{-- ===============================
    STYLE
=============================== --}}
@push('styles')
<style>
.table-theme thead th {
    background-color: var(--bs-success) !important;
    color: #ffffff !important;
}

/* ICON BUTTON */
.btn-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
}

/* VARIASI */
.btn-edit { background: #0d6efd; color: #fff; }
.btn-delete { background: #dc3545; color: #fff; }
.btn-reset { background: #ffc107; color: #000; }

/* HOVER */
.btn-icon:hover {
    opacity: 0.9;
}
</style>
@endpush

{{-- ===============================
    SCRIPT
=============================== --}}
@push('scripts')
<script>
function setHapusUser(url) {
    document.getElementById('formHapusUser').action = url;

    let modal = new bootstrap.Modal(document.getElementById('modalHapusUser'));
    modal.show();
}
</script>
@endpush