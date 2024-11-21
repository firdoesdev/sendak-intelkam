<?php

namespace App\Enums;

enum OwnerTypeEnum
{
    //
    case INDIVIDUAL;
    case COMPANY;

    public function label(): string
    {
        return match ($this) {
            self::INDIVIDUAL => 'Individual',
            self::COMPANY => 'Company',
            
        };
    }

    public function value(): string
    {
        // return array_column(self::cases(), 'value');
        return match ($this) {
            self::INDIVIDUAL => 'individual',
            self::COMPANY => 'company',
        };
    }
}
