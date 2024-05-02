<?php

declare(strict_types=1);

namespace HttpProcess\Response\Dto;

final class ResponseContent
{
    private string $code;

    private mixed $data;

    private string $message;

    /**
     * @var string[]
     */
    private array $errors;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): ResponseContent
    {
        $this->code = $code;

        return $this;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function setData(mixed $data): ResponseContent
    {
        $this->data = $data;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): ResponseContent
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string[] $errors
     */
    public function setErrors(array $errors): ResponseContent
    {
        $this->errors = $errors;

        return $this;
    }
}
