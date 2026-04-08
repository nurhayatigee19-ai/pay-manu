<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Tunggakan SPP</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }

        .header { text-align: center; margin-bottom: 20px; }
        .header h3 { margin: 0; }
        .header p { margin: 2px 0; font-size: 10px; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #eee; text-align: center; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .footer { margin-top: 40px; width: 100%; }
        .ttd {
            width: 30%;
            float: right;
            text-align: center;
            margin-top: 70px; /* agar turun */
        }
    </style>
</head>

<body>

{{-- HEADER --}}
<div class="header">
    <h3>LAPORAN TUNGGAKAN SPP</h3>
    <p>MA NU YOSOWINANGUN</p>
    <p>Tanggal Cetak: {{ now()->format('d-m-Y') }}</p>
</div>

{{-- TABEL --}}
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kelas</th>
            <th>Jumlah Siswa Menunggak</th>
            <th>Total Tunggakan</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($data as $d)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $d->kelas }}</td>
                <td class="text-center">{{ $d->jumlah_siswa }}</td>
                <td class="text-right">
                    Rp {{ number_format($d->total_tunggakan, 0, ',', '.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data tunggakan</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- TANDA TANGAN --}}
<div class="footer">
    <div class="ttd">
        <p>Kepala Sekolah</p>
        <br><br><br><br>
        <p><u>______________________</u></p>
    </div>
</div>

</body>
</html>