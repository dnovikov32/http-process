<?php

declare(strict_types=1);

namespace HttpProcess\Response\Transformer;

use HttpProcess\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

interface ResponseTransformerInterface
{
    public function transform(ResponseInterface $response): Response;
}
