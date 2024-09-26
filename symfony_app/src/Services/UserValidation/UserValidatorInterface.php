<?php

namespace App\Services\UserValidation;

use App\Entity\User;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('user.validator')]
interface UserValidatorInterface
{
    public function validate(User $user): ValidationResult;
}