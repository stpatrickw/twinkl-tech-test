<?php

namespace App\Services\UserValidation;

use App\Entity\User;

class SpecialCharsValidator implements UserValidatorInterface
{
    public function validate(User $user): ValidationResult
    {
        $result = new ValidationResult();
        foreach ($this->getUserValuesForValidation($user) as $value) {
            $regex = preg_match('/^[-a-zA-Z0-9 .@]+$/', $value);
            if (!$regex) {
                $result->addError("Special characters are not allowed.");
                break;
            }
        }
        return $result;
    }

    private function getUserValuesForValidation(User $user): array
    {
        return [
            $user->getFirstName(),
            $user->getLastName(),
            $user->getType(),
        ];
    }
}