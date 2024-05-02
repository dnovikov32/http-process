<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcessBundle\Request\Stage;

use League\Pipeline\StageInterface;
use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;
use Dnovikov32\HttpProcessBundle\Request\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ValidateApiRequest implements StageInterface
{
    public function __construct(
        readonly private ValidatorInterface $validator
    ) {
    }

    /**
     * @param ApiRequestInterface $apiRequest
     *
     * @throws ValidationException
     */
    public function __invoke(mixed $apiRequest): ApiRequestInterface
    {
        $errors = $this->validator->validate($apiRequest);

        if (count($errors) > 0) {
            throw (new ValidationException('Validation failed'))->setErrors($errors);
        }

        return $apiRequest;
    }
}
