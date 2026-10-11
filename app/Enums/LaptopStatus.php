<?php

namespace App\Enums;

enum LaptopStatus: string
{
    case Tersedia = 'Tersedia';
    case Terbooking = 'Terbooking';
    case Terjual = 'Terjual';

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Tersedia => 'bg-green-100 text-green-800',
            self::Terbooking => 'bg-yellow-100 text-yellow-800',
            self::Terjual => 'bg-gray-200 text-gray-700',
        };
    }
}
