<?php

declare(strict_types=1);

namespace App\ProcessBundle\Response;

use Throwable;

final class Response implements ResponseInterface
{
    private mixed $content = null;

    /**
     * @var string[]
     */
    private array $errors = [];

    private ?Throwable $exception = null;

    public function __construct(
        private readonly int $status,
        private readonly string $code,
        private string $message = ''
    ) {
    }

    public function setContent(mixed $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): mixed
    {
        return $this->content;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string[] $errors
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setException(Throwable $exception): self
    {
        $this->exception = $exception;

        return $this;
    }

    public function getException(): ?Throwable
    {
        return $this->exception;
    }
}
