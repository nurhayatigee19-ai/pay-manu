<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran Siswa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>

    <h2>Laporan Pembayaran Siswa</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Total Tagihan</th>
                <th>Total Dibayar</th>
                <th>Sisa</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($siswa as $s)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="text-center">
                        {{ $s->nis ?? '-' }}
                    </td>

                    <td>
                        {{ $s->nama ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $s->kelas ?? '-' }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($s->total_tagihan ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($s->total_dibayar ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($s->sisa ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Tidak ada data pembayaran
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>