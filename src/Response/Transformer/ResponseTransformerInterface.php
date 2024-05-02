<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcess\Response\Transformer;

use Dnovikov32\HttpProcess\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

interface ResponseTransformerInterface
{
    public function transform(ResponseInterface $response): Response;
}
