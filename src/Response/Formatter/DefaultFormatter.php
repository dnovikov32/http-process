<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcess\Response\Formatter;

use Dnovikov32\HttpProcess\Response\Dto\ResponseContent;
use Dnovikov32\HttpProcess\Response\ResponseInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

final class DefaultFormatter implements FormatterInterface
{
    public function format(ResponseInterface $response): ResponseInterface
    {
        $content = (new ResponseContent())
            ->setCode($response->getCode())
            ->setData($this->getData($response))
            ->setMessage($this->getMessage($response))
            ->setErrors($this->getErrors($response));

        $response->setContent($content);

        return $response;
    }

    private function getData(ResponseInterface $response): mixed
    {
        $exception = $response->getException();

        if (!is_null($exception) && method_exists($exception, 'getData')) {
            return $exception->getData();
        }

        return $response->getContent();
    }

    private function getMessage(ResponseInterface $response): string
    {
        $exception = $response->getException();

        if (!is_null($exception)) {
            return $exception->getMessage();
        }

        return $response->getMessage();
    }

    private function getErrors(ResponseInterface $response): array
    {
        $exception = $response->getException();
        $errors = [];

        if (!is_null($exception) && method_exists($exception, 'getErrors')) {
            foreach ($exception->getErrors() as $error) {
                /** @var ConstraintViolationInterface $error */
                $propertyPath = trim($error->getPropertyPath(), '[]');
                $errors[$propertyPath] = $error->getMessage();
            }
        }

        return $errors;
    }
}
