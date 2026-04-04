@extends('layouts.template_default')

@section('title', 'Tahun Ajar')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Daftar Tahun Ajar</h4>

        <a href="{{ route('stafkeuangan.tahunajar.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Tahun Ajar
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
                        <tr class="text-center">
                            <th width="80">ID</th>
                            <th>Tahun Ajar</th>
                            <th width="150">Status</th>
                            <th width="200">Aksi</th>
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

                                {{-- tombol aktifkan --}}
                                @if(!$t->aktif)
                                <form action="{{ route('stafkeuangan.tahunajar.aktifkan', $t->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf

                                    <button type="submit" class="btn btn-success btn-sm">
                                        Aktifkan
                                    </button>
                                </form>
                                @endif

                                {{-- tombol hapus --}}
                                <form action="{{ route('stafkeuangan.tahunajar.destroy', $t->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus tahun ajar ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>

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
    background-color: #198754; /* hijau dashboard */
    color: #ffffff;
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
    border: 1px solid #dee2e6;
}
</style>
@endpush