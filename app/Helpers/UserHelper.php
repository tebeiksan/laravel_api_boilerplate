<?php

namespace App\Helpers;

class UserHelper
{
    const USER_INACTIVE = 0;
    const USER_ACTIVE = 1;

    const ACTIVE_DESCRIPTION = [
        self::USER_INACTIVE => "Inactive",
        self::USER_ACTIVE => "Active",
    ];
}
