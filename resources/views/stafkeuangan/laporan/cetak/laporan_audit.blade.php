<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Audit</title>
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
    <h3 style="text-align:center;">Laporan Audit Pembayaran</h3>
    <p>Tanggal Cetak: {{ now()->format('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Aksi</th>
                <th>Nominal</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($audit as $row)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $row->user->name }}</td>
                <td>{{ $row->aksi }}</td>
                <td class="text-right">Rp {{ number_format($row->nominal,0,',','.') }}</td>
                <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">Tidak ada data audit</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>