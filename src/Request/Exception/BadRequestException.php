<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcessBundle\Request\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BadRequestException extends BadRequestHttpException
{
    private array $errors = [];

    private array $data = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
