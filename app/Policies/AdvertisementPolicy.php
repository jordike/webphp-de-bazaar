<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Advertisement;
use App\Models\User;

class AdvertisementPolicy
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
        return $user->role_id >= RoleEnum::PRIVATE_ADVERTISER->value;
    }

    public function update(User $user, Advertisement $model)
    {
        return $user->id === $model->user_id || $user->isAdmin();
    }

    public function delete(User $user, Advertisement $model)
    {
        return $user->id === $model->user_id || $user->isAdmin();
    }
}
