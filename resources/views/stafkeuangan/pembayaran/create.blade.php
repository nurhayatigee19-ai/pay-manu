@extends('layouts.template_default')

@section('title', 'Pembayaran SPP')

@section('content')

@php
use Illuminate\Support\Str;
@endphp

<div class="container">
    <h4 class="mb-4">Pembayaran SPP</h4>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ERROR RUNTIME --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card p-4">

        {{-- ========================= --}}
        {{-- INFO SISWA (READ ONLY) --}}
        {{-- ========================= --}}
        <table class="table table-sm mb-4">
            <tr>
                <th>Nama Siswa</th>
                <td>{{ $tagihan->siswa->nama }}</td>
            </tr>
            <tr>
                <th>Kelas</th>
                <td>{{ $tagihan->siswa->kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <th>Total Tagihan</th>
                <td>Rp {{ number_format($tagihan->nominal_tagihan,0,',','.') }}</td>
            </tr>
            <tr>
                <th>Total Dibayar</th>
                <td>Rp {{ number_format($tagihan->total_dibayar,0,',','.') }}</td>
            </tr>
            <tr>
                <th>Sisa Tagihan</th>
                <td><strong class="text-danger">Rp {{ number_format($tagihan->sisa_tagihan,0,',','.') }}</strong></td>
            </tr>
        </table>

        {{-- ========================= --}}
        {{-- FORM PEMBAYARAN --}}
        {{-- ========================= --}}
        <form method="POST" action="{{ route('stafkeuangan.pembayaran.store') }}">
            @csrf

            {{-- TOKEN ANTI DOUBLE SUBMIT --}}
            <input type="hidden" name="idempotency_key" value="{{ Str::uuid() }}">

            {{-- Hidden tagihan --}}
            <input type="hidden" name="tagihan_siswa_id" value="{{ $tagihan->id }}">

            <div class="mb-3">
                <label class="form-label">Jumlah Bayar</label>
                <input
                    type="number"
                    name="jumlah"
                    class="form-control @error('jumlah') is-invalid @enderror"
                    min="1"
                    max="{{ $tagihan->sisa_tagihan }}"
                    value="{{ old('jumlah') }}"
                    required
                    autofocus
                >
                @error('jumlah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Maksimal: Rp {{ number_format($tagihan->sisa_tagihan,0,',','.') }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button
                type="submit"
                class="btn btn-success"
                id="btn-submit"
                onclick="this.disabled=true; this.form.submit();"
            >
                Simpan Pembayaran
            </button>

            <a href="{{ route('stafkeuangan.pembayaran.index') }}" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
</div>
@endsection