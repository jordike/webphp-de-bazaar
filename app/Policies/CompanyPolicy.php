<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAll(User $user)
    {
        return $user->isAdmin();
    }

    public function create(User $user)
    {
        // "Zakelijke adverteerder" or "Platform eigenaar" can create a company
        return $user->role_id != null && $user->role_id >= RoleEnum::BUSINESS_ADVERTISER->value;
    }

    public function update(User $user, Company $model)
    {
        return $user->id === $model->user_id || $user->isAdmin();
    }
}
