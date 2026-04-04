<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Semester</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #eee; text-align: center; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .status-lunas { background-color: #28a745; color: #fff; padding: 2px 6px; border-radius: 3px; }
        .status-belum { background-color: #dc3545; color: #fff; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>

    <h3 style="text-align:center;">Laporan Pembayaran Semester {{ strtoupper(request('semester')) ?? '' }}</h3>
    <p>Tanggal Cetak: {{ now()->format('d-m-Y') }}</p>

    <table>
        <thead>
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
                    <td class="text-right">Rp {{ number_format($row['tagihan'],0,',','.') }}</td>
                    <td class="text-right">Rp {{ number_format($row['dibayar'],0,',','.') }}</td>
                    <td class="text-right">Rp {{ number_format($row['sisa'],0,',','.') }}</td>
                    <td class="text-center">
                        @if($row['status'] == 'Lunas')
                            <span class="status-lunas">Lunas</span>
                        @else
                            <span class="status-belum">Belum</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>