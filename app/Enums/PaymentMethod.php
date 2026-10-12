<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Cod = 'COD';
    case TransferManual = 'Transfer Manual';

    public function requiresProof(): bool
    {
        return $this === self::TransferManual;
    }

    public function description(): string
    {
        return match ($this) {
            self::Cod => 'Bayar langsung saat bertemu dan menerima laptop.',
            self::TransferManual => 'Transfer ke rekening toko, lalu unggah bukti transfer.',
        };
    }
}
