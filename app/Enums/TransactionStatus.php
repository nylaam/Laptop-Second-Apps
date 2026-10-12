<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case Pending = 'Pending';
    case Lunas = 'Lunas';
    case Selesai = 'Selesai';
    case Dibatalkan = 'Dibatalkan';

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Pending => 'bg-yellow-100 text-yellow-800',
            self::Lunas => 'bg-blue-100 text-blue-800',
            self::Selesai => 'bg-green-100 text-green-800',
            self::Dibatalkan => 'bg-red-100 text-red-800',
        };
    }
}
