<?php

namespace App\Policies;

use App\Models\User;

class ContractPolicy
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
        return $user->isAdmin();
    }

    public function update(User $user, Contract $model)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Contract $model)
    {
        return $user->isAdmin();
    }

    public function download(User $user, Contract $model)
    {
        return $user->isAdmin();
    }
}
