<?php

declare(strict_types=1);

namespace App\ProcessBundle\Response\Transformer;

use App\ProcessBundle\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

final class DefaultTransformer implements ResponseTransformerInterface
{
    public function transform(ResponseInterface $response): Response
    {
        return new Response(
            content: $response->getContent(),
            status: $response->getStatus()
        );
    }
}
