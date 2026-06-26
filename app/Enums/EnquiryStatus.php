<?php

namespace App\Enums;

enum EnquiryStatus: int
{
    case New = 1;
    case Read = 2;
    case Replied = 3;
    case Closed = 4;

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Read => 'Read',
            self::Replied => 'Replied',
            self::Closed => 'Closed',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::New => 'bg-primary',
            self::Read => 'bg-info',
            self::Replied => 'bg-success',
            self::Closed => 'bg-secondary',
        };
    }
}
