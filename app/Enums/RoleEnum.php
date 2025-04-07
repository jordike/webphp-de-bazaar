<?php

namespace App\Enums;

enum RoleEnum: int
{
    case STANDARD = 1;
    case PRIVATE_ADVERTISER = 2;
    case BUSINESS_ADVERTISER = 3;
    case PLATFORM_OWNER = 4;
}
