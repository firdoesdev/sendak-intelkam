<?php

namespace App\Enums;

enum RoleEnum
{
    //
    // $roles = ['handak', 'polsus', 'beladiri', 'olahraga'];
    case HANDAK;
     case POLSUS;
     case BELADIRI;
     case OLAHRAGA;

    public function label(): string
    {
        return match ($this) {
            self::HANDAK => 'Handak',
            self::POLSUS => 'Polsus',
            self::BELADIRI => 'Beladiri',
            self::OLAHRAGA => 'Olahraga',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return array_map(fn (self $case) => $case->label(), self::cases());
    }

    public static function options(): array
    {
        return array_combine(self::values(), self::labels());
    }
}
