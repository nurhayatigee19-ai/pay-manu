<?php

namespace App\Domain\Pembayaran;

final class PembayaranKeterangan
{
    public const TUNGGAKAN = 'Bayar tunggakan';

    public static function tunggakan(?string $keterangan): bool
    {
        return $keterangan === self::TUNGGAKAN;
    }
}