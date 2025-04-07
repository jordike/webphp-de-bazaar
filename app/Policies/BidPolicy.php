<?php

namespace App\Policies;

use App\Models\Bid;
use App\Models\User;

class BidPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function processBid(User $user, Bid $bid)
    {
        return $user->id === $bid->advertisement->user_id || $user->isAdmin();
    }
}
