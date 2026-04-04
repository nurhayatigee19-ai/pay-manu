@extends('layouts.template_default')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Data Kelas</h3>
        @if(Auth::user()->role == 'stafkeuangan')
        <a href="{{ route('kepsek.kelas.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Kelas
        </a>
        @endif
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        @if(Auth::user()->role == 'stafkeuangan')
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $k)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $k->kelas }}</td>
                        @if(Auth::user()->role == 'stafkeuangan')
                        <td class="text-center">
                            <a href="{{ route('kepsek.kelas.edit', $k->id) }}" 
                               class="btn btn-sm btn-warning me-1 text-white" 
                               data-bs-toggle="tooltip" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('kepsek.datakelas.destroy', $k->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger" 
                                        data-bs-toggle="tooltip" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada data kelas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el)
    })
});
</script>
@endsection
