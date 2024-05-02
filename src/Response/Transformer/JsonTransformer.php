<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcess\Response\Transformer;

use Dnovikov32\HttpProcess\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

final class JsonTransformer implements ResponseTransformerInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer
    ) {
    }

    public function transform(ResponseInterface $response): JsonResponse
    {
        $content = $this->serializer->serialize($response->getContent(), 'json');

        return new JsonResponse(
            data: $content,
            status: $response->getStatus(),
            json: true
        );
    }
}
