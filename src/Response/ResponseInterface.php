<?php

declare(strict_types=1);

namespace App\ProcessBundle\Response;

use Throwable;

interface ResponseInterface
{
    public function setContent(mixed $content);

    public function getContent(): mixed;

    public function getStatus(): int;

    public function getCode(): string;

    public function setMessage(string $message);

    public function getMessage(): string;

    /**
     * @param string[] $errors
     */
    public function setErrors(array $errors);

    /**
     * @return string[]
     */
    public function getErrors(): array;

    public function setException(Throwable $exception);

    public function getException(): ?Throwable;
}
