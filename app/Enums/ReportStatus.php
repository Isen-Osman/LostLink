<?php

namespace App\Enums;

enum ReportStatus: string
{
    case Open = 'open';
    case Resolved = 'resolved';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Отворена',
            self::Resolved => 'Решена',
        };
    }
}
