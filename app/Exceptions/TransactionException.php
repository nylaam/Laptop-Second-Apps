<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Direct saat aturan booking/transaksi nya ga sesuai.
 */
class TransactionException extends RuntimeException
{
    public static function laptopUnavailable(): self
    {
        return new self('Laptop ini sudah tidak tersedia untuk di-booking.');
    }

    public static function proofNotAllowed(): self
    {
        return new self('Bukti transfer hanya bisa diunggah untuk transaksi Transfer Manual yang masih Pending.');
    }

    public static function cannotVerify(): self
    {
        return new self('Transaksi tidak bisa diverifikasi. Pastikan metode Transfer Manual, status Pending, dan bukti sudah diunggah.');
    }

    public static function cannotComplete(): self
    {
        return new self('Hanya transaksi COD berstatus Pending yang bisa diselesaikan.');
    }

    public static function cannotCancel(): self
    {
        return new self('Hanya transaksi berstatus Pending yang bisa dibatalkan.');
    }
}
