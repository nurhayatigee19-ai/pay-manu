<?php

namespace App\Domain\Pembayaran;

final class PembayaranStatus
{
    public const VALID = 'valid';
    public const BATAL = 'batal';

    public static function all(): array
    {
        return [
            self::VALID,
            self::BATAL,
        ];
    }
}