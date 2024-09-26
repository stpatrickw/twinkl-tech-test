<?php

namespace App\Services\UserValidation;

use App\Entity\User;

class BlackListValidator implements UserValidatorInterface
{
    private const BLACK_LIST_IPS = [
        '192.168.0.23',
        '192.168.0.25',
        '192.168.0.26',
        '192.168.0.27',
        '192.168.65.12'
    ];

    public function validate(User $user): ValidationResult
    {
        $result = new ValidationResult();
        if (in_array($user->getLastUsedIP(), self::BLACK_LIST_IPS)) {
            $result->addError("IP address is blocked.");
        }
        return $result;
    }
}