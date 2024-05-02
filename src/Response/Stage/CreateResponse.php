<?php

declare(strict_types=1);

namespace HttpProcess\Response\Stage;

use HttpProcess\Response\ResponseInterface;
use League\Pipeline\StageInterface;
use HttpProcess\Response\Transformer\ResponseTransformerInterface;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class CreateResponse implements StageInterface
{
    public function __construct(
        private readonly ResponseTransformerInterface $transformer
    ) {
    }

    /**
     * @param ResponseInterface $payload
     */
    public function __invoke(mixed $payload): HttpResponse
    {
        return $this->transformer->transform($payload);
    }
}
