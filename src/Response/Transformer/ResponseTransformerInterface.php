<?php

declare(strict_types=1);

namespace App\ProcessBundle\Response\Transformer;

use App\ProcessBundle\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

interface ResponseTransformerInterface
{
    public function transform(ResponseInterface $response): Response;
}
