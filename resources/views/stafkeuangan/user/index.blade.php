@extends('layouts.template_default')

@section('content')
<div class="container">

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Manajemen User</h4>

        <a href="{{ route('stafkeuangan.user.create') }}" class="btn btn-primary">
            Tambah User
        </a>
    </div>

    {{-- Card --}}
    <div class="card">
        <div class="card-body">

            <table class="table table-hover align-middle table-theme">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th width="15%">Role</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $user->name }}
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td class="text-center">
                                @if($user->role == 'stafkeuangan')
                                    <span class="badge bg-success">
                                        Staf Keuangan
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        Kepsek
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">

                                {{-- Edit --}}
                                <a href="{{ route('stafkeuangan.user.edit', $user->id) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('stafkeuangan.user.destroy', $user->id) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus user ini?')">
                                        Hapus
                                    </button>

                                </form>

                                {{-- Reset Password --}}
                                <form action="{{ route('stafkeuangan.user.reset', $user->id) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit"
                                            class="btn btn-sm btn-secondary">
                                        Reset Password
                                    </button>

                                </form>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center">
                                Tidak ada data user
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>
@push('styles')
<style>
.table-theme thead th {
    background-color: var(--bs-success) !important;
    color: #ffffff !important;
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
    border: 1px solid rgba(255,255,255,0.25) !important;
}
</style>
@endpush
@endsection

