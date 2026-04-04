<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kelas</title>
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
    <h3 style="text-align:center;">Laporan Pembayaran Kelas</h3>
    <p>Tanggal Cetak: {{ now()->format('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Total Siswa</th>
                <th>Total Tagihan</th>
                <th>Total Bayar</th>
                <th>Total Sisa</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kelasData as $row)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $row->nama_kelas }}</td>
                <td class="text-center">{{ $row->jumlah_siswa }}</td>
                <td class="text-right">Rp {{ number_format($row->total_tagihan,0,',','.') }}</td>
                <td class="text-right">Rp {{ number_format($row->total_dibayar,0,',','.') }}</td>
                <td class="text-right">Rp {{ number_format($row->sisa,0,',','.') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">Tidak ada data kelas</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>