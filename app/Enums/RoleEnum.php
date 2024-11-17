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

    public function value(): string
    {
        // return array_column(self::cases(), 'value');
        return match ($this) {
            self::HANDAK => 'handak',
            self::POLSUS => 'polsus',
            self::BELADIRI => 'beladiri',
            self::OLAHRAGA => 'olahraga',
        };
    }

    

}
