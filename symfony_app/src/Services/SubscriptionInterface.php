<?php

namespace App\Services;

use App\Entity\User;
use App\Exceptions\UserSubscriptionException;

interface SubscriptionInterface
{
    /**
     * @throws UserSubscriptionException
     */
    public function signup(User $user): void;
}