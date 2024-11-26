<?php

namespace App\Enums;

enum RekomStatusEnum
{
    //
    case DRAFT;
    case ACTIVE;
    case EXPIRED;
    case EXPIRED_SOON;

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active',
            self::EXPIRED => 'Expired',
            self::EXPIRED_SOON => 'Expired Soon',
        };
    }
    public static function from(string $value): self
    {
        return match ($value) {
            'draft' => self::DRAFT,
            'active' => self::ACTIVE,
            'expired' => self::EXPIRED,
            'expired_soon' => self::EXPIRED_SOON,
        };
    }

    public function value(): string
    {
        return match ($this) {
            self::DRAFT => 'draft',
            self::ACTIVE => 'active',
            self::EXPIRED => 'expired',
            self::EXPIRED_SOON => 'expired_soon',
        };
    }
}
