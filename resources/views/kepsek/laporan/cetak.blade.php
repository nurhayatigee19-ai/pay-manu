<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran SPP</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h3 {
            margin: 0;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background-color: #eee;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            width: 100%;
        }

        .ttd {
            width: 30%;
            float: right;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- ===============================
        HEADER
    ================================ --}}
    <div class="header">
        <h3>LAPORAN PEMBAYARAN SPP</h3>
        <p>Sekolah MANU</p>
        <p>Tanggal Cetak: {{ now()->format('d-m-Y') }}</p>
    </div>

    {{-- ===============================
        TABEL DATA
    ================================ --}}
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp

            @forelse ($pembayaran as $row)
                @php $total += $row->jumlah; @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $row->created_at->format('d-m-Y') }}</td>
                    <td>{{ $row->tagihanSiswa->siswa->nis }}</td>
                    <td>{{ $row->tagihanSiswa->siswa->nama }}</td>
                    <td class="text-center">{{ $row->tagihanSiswa->siswa->kelas->nama_kelas }}</td>
                    <td class="text-right">
                        Rp {{ number_format($row->jumlah, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Tidak ada data pembayaran
                    </td>
                </tr>
            @endforelse
        </tbody>

        {{-- ===============================
            TOTAL
        ================================ --}}
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">TOTAL</th>
                <th class="text-right">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </th>
            </tr>
        </tfoot>
    </table>

    {{-- ===============================
        TANDA TANGAN
    ================================ --}}
    <div class="footer">
        <div class="ttd">
            <p>Kepala Sekolah</p>
            <br><br><br>
            <p><u>______________________</u></p>
        </div>
    </div>

</body>
</html>