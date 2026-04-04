<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Siswa</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #eee; text-align: center; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Laporan Pembayaran Siswa</h3>
    <p>Tanggal Cetak: {{ now()->format('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Total Tagihan</th>
                <th>Total Bayar</th>
                <th>Sisa</th>
            </tr>
        </thead>
        <tbody>
        @forelse($pembayaran as $p)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $p->tagihanSiswa->siswa->nis ?? '-' }}</td>
            <td>{{ $p->tagihanSiswa->siswa->nama ?? '-' }}</td>
            <td>{{ $p->tagihanSiswa->siswa->kelas->nama_kelas ?? '-' }}</td>

            <td class="text-right">
                Rp {{ number_format($p->tagihanSiswa->nominal_tagihan ?? 0,0,',','.') }}
            </td>

            <td class="text-right">
                Rp {{ number_format($p->tagihanSiswa->total_dibayar ?? 0,0,',','.') }}
            </td>

            <td class="text-right">
                Rp {{ number_format($p->tagihanSiswa->sisa_tagihan ?? 0,0,',','.') }}
            </td>
        </tr>
        @empty
        <tr>
        <td colspan="7" class="text-center">Tidak ada data pembayaran</td>
        </tr>
        @endforelse
        </tbody>
    </table>
</body>
</html>