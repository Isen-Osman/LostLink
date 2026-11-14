<?php

namespace App\Enums;

enum ReportCategory: string
{
    case Phone = 'phone';
    case Wallet = 'wallet';
    case Keys = 'keys';
    case Backpack = 'backpack';
    case Documents = 'documents';
    case Electronics = 'electronics';
    case Jewelry = 'jewelry';
    case Clothing = 'clothing';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Phone => 'Телефон',
            self::Wallet => 'Паричник',
            self::Keys => 'Клучеви',
            self::Backpack => 'Ранец',
            self::Documents => 'Документи',
            self::Electronics => 'Електроника',
            self::Jewelry => 'Накит',
            self::Clothing => 'Облека',
            self::Other => 'Друго',
        };
    }
}
