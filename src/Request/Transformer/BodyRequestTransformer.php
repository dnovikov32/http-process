<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcessBundle\Request\Transformer;

use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;
use Dnovikov32\HttpProcessBundle\Request\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

final class BodyRequestTransformer implements RequestTransformerInterface
{
    public function __construct(
        readonly private SerializerInterface $serializer,
        readonly private string $type,
        readonly private string $format = JsonEncoder::FORMAT
    ) {
    }

    public function transform(Request $request): ApiRequestInterface
    {
        try {
            $payload = $this->serializer->deserialize(
                (string) $request->getContent(),
                $this->type,
                $this->format,
            );
        } catch (NotEncodableValueException) {
            throw new BadRequestException("Invalid request body, expected format is '{$this->format}'");
        }

        return $payload;
    }
}
