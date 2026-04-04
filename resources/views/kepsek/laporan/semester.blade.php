@extends('layouts.template_default')
@section('title', 'Laporan Pembayaran Semester')

@section('content')
<div class="page-heading mb-4">
    <h2 class="fw-bold">Laporan Pembayaran Per Semester</h2>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12">

            {{-- FILTER --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header fw-bold bg-light">
                    <i class="bi bi-funnel"></i> Filter Semester
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">

                        <div class="col-md-4">
                            <label class="fw-semibold">Semester</label>
                            <select name="semester" class="form-select" required>
                                <option value="">-- Pilih Semester --</option>
                                <option value="ganjil" {{ request('semester')=='ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="genap" {{ request('semester')=='genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="fw-semibold">Kelas</label>
                            <select name="kelas_id" class="form-select">
                                <option value="">-- Semua Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ request('kelas_id')==$k->id ? 'selected' : '' }}>
                                        {{ $k->kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button class="btn btn-primary">
                                <i class="bi bi-search"></i> Tampilkan
                            </button>
                            <a href="{{ url()->current() }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            {{-- RINGKASAN --}}
            @if(request('semester'))
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-success shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-success fw-bold">Sudah Lunas</h6>
                            <h3>{{ $sudahBayar }} Siswa</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-danger shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-danger fw-bold">Belum Lunas</h6>
                            <h3>{{ $belumBayar }} Siswa</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-primary shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-primary fw-bold">Total Dibayar</h6>
                            <h3>Rp {{ number_format($totalBayar,0,',','.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- TABEL DATA --}}
            @if(request('semester'))
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="bi bi-table"></i> Data Pembayaran Semester
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Tagihan</th>
                                    <th>Dibayar</th>
                                    <th>Sisa</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $row)
                                <tr>
                                    <td class="text-center">{{ $row['nis'] }}</td>
                                    <td>{{ $row['nama'] }}</td>
                                    <td class="text-center">{{ $row['kelas'] }}</td>
                                    <td class="text-end">Rp {{ number_format($row['tagihan'],0,',','.') }}</td>
                                    <td class="text-end">Rp {{ number_format($row['dibayar'],0,',','.') }}</td>
                                    <td class="text-end fw-bold text-danger">
                                        Rp {{ number_format($row['sisa'],0,',','.') }}
                                    </td>
                                    <td class="text-center">
                                        @if($row['status']=='Lunas')
                                            <span class="badge bg-success px-3 py-2">Lunas</span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2">Belum</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Tidak ada data
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </section>
</div>

<style>
.card:hover {
    transform: translateY(-3px);
    transition: .3s;
}
</style>
@endsection
