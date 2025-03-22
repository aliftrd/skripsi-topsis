<?php

namespace App\Enums;

enum UserRoleEnums: int
{
    case ADMIN = 1;
    case HEADOFFICE = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::HEADOFFICE => 'Kepala',
        };
    }
}
