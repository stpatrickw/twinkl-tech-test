<?php

namespace App\Services\UserValidation;

class ValidationResult
{
    /**
     * @var string[]
     */
    private array $errors = [];

    public function addError(string $error): void
    {
        $this->errors[] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}