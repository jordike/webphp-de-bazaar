<?php

namespace App\Policies;

use App\Models\User;
use RoleEnum;

class CompanyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        // "Zakelijke adverteerder" or "Platform eigenaar" can create a company
        return $user->role_id != null && $user->role_id >= RoleEnum::BUSINESS_ADVERTISER;
    }
}
