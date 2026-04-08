<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pembayaran</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }

        /* HALAMAN PDF */
        .page {
            position: relative;
            min-height: 1000px;
        }

        /* CATATAN (KIRI BAWAH) */
        .catatan {
            position: absolute;
            bottom: 40px;
            left: 0;
            width: 60%;
            font-size: 11px;
        }

        /* TANDA TANGAN (KANAN BAWAH) */
        .ttd {
            position: absolute;
            bottom: 40px;
            right: 0;
            width: 35%;
            text-align: center;
        }

        /* TABEL */
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 6px; vertical-align: top; }
        .border td, .border th { border: 1px solid #000; }
        .center { text-align: center; }
    </style>
</head>

<body>
<div class="page">

    {{-- ======================== --}}
    {{-- KOP SURAT --}}
    {{-- ======================== --}}
    <table style="border-bottom: 2px solid #000; margin-bottom: 20px;">
        <tr>
            <td width="15%">
                <img src="{{ public_path('image/logo_manu.png') }}" width="80">
            </td>

            <td width="85%" style="text-align:center;">
                <div style="font-size:18px; font-weight:bold;">MA NU YOSOWINANGUN</div>
                <div style="font-size:14px;">
                    Jl. Yosowinangun, Desa Yosowinangun, Kec. Belitang Madang Raya,
                    Kab. OKU Timur, Sumatera Selatan
                </div>
                <div style="font-size:14px;">
                    Telp: (0711) 123456 | Email: info@manuyosowinangun.sch.id
                </div>
            </td>
        </tr>
    </table>

    {{-- ======================== --}}
    {{-- JUDUL --}}
    {{-- ======================== --}}
    <h3 style="text-align:center; font-weight:bold;">
        BUKTI PEMBAYARAN SPP
    </h3>

    <br>

    {{-- ======================== --}}
    {{-- DATA SISWA --}}
    {{-- ======================== --}}
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

    {{-- ======================== --}}
    {{-- TABEL PEMBAYARAN --}}
    {{-- ======================== --}}
    <table class="border">
        <tr>
            <th>Keterangan</th>
            <th>Periode</th>
            <th class="center">Tanggal Bayar</th>
            <th class="center">Jumlah</th>
        </tr>
        <tr>
            <td>{{ $pembayaran->keterangan }}</td>
            <td>{{ $periode }}</td>
            <td class="center">{{ $pembayaran->tanggal_bayar }}</td>
            <td class="center">
                Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <br>

    {{-- ======================== --}}
    {{-- TOTAL --}}
    {{-- ======================== --}}
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

    {{-- ======================== --}}
    {{-- CATATAN KIRI BAWAH --}}
    {{-- ======================== --}}
    <div class="catatan">
        <b>Catatan:</b>
        <ol>
            <li>Jangan sampai hilang.</li>
            <li>Sebagai bukti untuk mengikuti Ujian Akhir Semester (UAS).</li>
        </ol>
    </div>

    {{-- ======================== --}}
    {{-- TTD KANAN BAWAH --}}
    {{-- ======================== --}}
    <div class="ttd">
        Staf Keuangan<br><br><br>
        ( __________________ )
    </div>

</div>
</body>
</html>