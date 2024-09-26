<?php

namespace App\Services\UserValidation;

use App\Entity\User;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BasicValidator implements UserValidatorInterface
{
    public function __construct(private ValidatorInterface $validator) {}

    public function validate(User $user): ValidationResult
    {
        $result = new ValidationResult();
        $errors = $this->validator->validate($user);
        if ($errors->count()) {
            foreach ($errors as $error) {
                $result->addError(sprintf("%s: %s", $error->getPropertyPath(), $error->getMessage()));
            }
        }
        return $result;
    }
}