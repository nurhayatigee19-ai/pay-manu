<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pembayaran</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 6px; }
        .border td, .border th { border: 1px solid #000; }
        .center { text-align: center; }
    </style>
</head>
<body>

<h3 class="center">BUKTI PEMBAYARAN SPP</h3>

<table>
    <tr>
        <td width="30%">NIS</td>
        <td>: {{ $siswa->nis }}</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>: {{ $siswa->nama }}</td>
    </tr>
    <tr>
        <td>Kelas</td>
        <td>: {{ $kelas->nama_kelas }}</td>
    </tr>
</table>

<br>

<table class="border">
    <tr>
        <th>Keterangan</th>
        <th>Periode</th>
        <th>Tanggal Bayar</th>
        <th>Jumlah</th>
    </tr>
    <tr>
        <td>{{ $pembayaran->keterangan }}</td>
        <td>{{ $pembayaran->periode }}</td>
        <td class="center">{{ $pembayaran->tanggal_bayar }}</td>
        <td class="center">
            Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
        </td>
    </tr>
</table>

<br>

<table>
    <tr>
        <td>Total Tagihan</td>
        <td>: Rp {{ number_format($totalTagihan, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Total Dibayar</td>
        <td>: Rp {{ number_format($totalDibayar, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Sisa Tagihan</td>
        <td>: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</td>
    </tr>
</table>

<br><br>

<table width="100%">
    <tr>
        <td width="60%"></td>
        <td class="center">
            Staf Keuangan<br><br><br>
            ( __________________ )
        </td>
    </tr>
</table>

</body>
</html>