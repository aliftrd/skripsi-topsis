<?php

namespace App\Enums;

enum UserRoleEnums: int
{
    case SADMIN = 0;
    case ADMIN = 1;
    case HEADOFFICE = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::SADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::HEADOFFICE => 'Kepala',
        };
    }
}
