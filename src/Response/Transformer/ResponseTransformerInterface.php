<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcessBundle\Response\Transformer;

use Dnovikov32\HttpProcessBundle\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

interface ResponseTransformerInterface
{
    public function transform(ResponseInterface $response): Response;
}
