<?php

declare(strict_types=1);

namespace HttpProcess\Request\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends Exception
{
    private ConstraintViolationListInterface $errors;

    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }

    public function setErrors(ConstraintViolationListInterface $errors): self
    {
        $this->errors = $errors;

        return $this;
    }
}
